import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Navbar: al hacer scroll se compacta (el navbar siempre es transparente y fijo;
// solo la cápsula del menú lleva el fondo oscuro).
window.addEventListener('scroll', function () {
    var navbar = document.getElementById('navbar');
    if (!navbar) return;
    if (window.scrollY > 20) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Inicializar AOS una sola vez (el módulo se ejecuta después del parseo del DOM).
// No volver a llamar AOS.init() en livewire:navigated: en AOS 2.3.x un segundo init()
// resetea los elementos animados y los deja invisibles (opacity 0).
AOS.init({
    duration: 1000,
    once: true,
    offset: 100,
    easing: 'ease-out-cubic',
});

// Tras navegaciones de Livewire, refrescar posiciones/observadores sin reiniciar.
// refreshHard re-colecta los elementos [data-aos] que Livewire re-renderiza al navegar.
document.addEventListener('livewire:navigated', () => AOS.refreshHard());

// ============================================================
// Fondo ambiental: partículas flotantes (canvas, sin dependencias)
// ============================================================
function initAmbientParticles() {
    var canvas = document.getElementById('particles-canvas');
    if (!canvas || canvas.dataset.initialized) return;
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    canvas.dataset.initialized = '1';
    var ctx = canvas.getContext('2d');
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var particles = [];
    var raf = null;

    var COLORS = ['255,255,255', '214,182,107']; // blanco y dorado suave

    function count() {
        return Math.min(110, Math.floor(window.innerWidth / 14));
    }

    function spawn() {
        var w = window.innerWidth;
        var h = window.innerHeight;
        particles = [];
        for (var i = 0; i < count(); i++) {
            particles.push({
                x: Math.random() * w,
                y: Math.random() * h,
                r: 0.6 + Math.random() * 1.6,
                speedX: (Math.random() - 0.5) * 0.15,
                speedY: -(0.05 + Math.random() * 0.25),
                baseAlpha: 0.15 + Math.random() * 0.35,
                twinkle: 0.4 + Math.random() * 1.6,
                phase: Math.random() * Math.PI * 2,
                color: COLORS[Math.random() < 0.75 ? 0 : 1],
            });
        }
    }

    function resize() {
        canvas.width = window.innerWidth * dpr;
        canvas.height = window.innerHeight * dpr;
        canvas.style.width = window.innerWidth + 'px';
        canvas.style.height = window.innerHeight + 'px';
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        spawn();
    }

    function draw(t) {
        var w = window.innerWidth;
        var h = window.innerHeight;
        ctx.clearRect(0, 0, w, h);
        for (var i = 0; i < particles.length; i++) {
            var p = particles[i];
            p.x += p.speedX;
            p.y += p.speedY;
            if (p.y < -10) { p.y = h + 10; p.x = Math.random() * w; }
            if (p.x < -10) p.x = w + 10;
            if (p.x > w + 10) p.x = -10;
            var alpha = p.baseAlpha * (0.6 + 0.4 * Math.sin((t / 1000) * p.twinkle + p.phase));
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(' + p.color + ',' + alpha.toFixed(3) + ')';
            ctx.fill();
        }
        raf = requestAnimationFrame(draw);
    }

    function start() {
        if (!raf) raf = requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            cancelAnimationFrame(raf);
            raf = null;
        } else {
            start();
        }
    });

    resize();
    start();
}

initAmbientParticles();

// Si Livewire re-renderiza la página y reemplaza el canvas, reiniciar el motor.
// La función se protege con dataset.initialized, así que llamarla de nuevo es seguro.
document.addEventListener('livewire:navigated', initAmbientParticles);

// ============================================================
// Embeds de Instagram (página de videos): procesar y limpiar extras
// ============================================================
function processInstagramEmbeds() {
    if (typeof window.instgrm !== 'undefined' && window.instgrm.Embeds) {
        try {
            window.instgrm.Embeds.process();

            // Después de procesar, ocultar elementos adicionales
            setTimeout(hideInstagramExtras, 1000);
        } catch (e) {
            console.log('Instagram embed processing:', e);
        }
    } else {
        setTimeout(processInstagramEmbeds, 100);
    }
}

function hideInstagramExtras() {
    // Buscar todos los iframes de Instagram
    const instagramIframes = document.querySelectorAll('.instagram-embed-wrapper iframe');

    instagramIframes.forEach(iframe => {
        try {
            // Intentar acceder al contenido del iframe (puede fallar por CORS)
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

            if (iframeDoc) {
                // Ocultar footer, comentarios y descripción dentro del iframe
                const style = iframeDoc.createElement('style');
                style.textContent = `
                    footer,
                    [role="contentinfo"],
                    .Caption,
                    ._a9zs,
                    ._a9_1,
                    article > div:last-child {
                        display: none !important;
                    }
                    article {
                        padding-bottom: 0 !important;
                    }
                `;
                iframeDoc.head.appendChild(style);
            }
        } catch (e) {
            // CORS bloqueará esto, pero lo intentamos
            console.log('No se puede acceder al iframe de Instagram (CORS)');
        }
    });

    // Ocultar elementos fuera del iframe
    document.querySelectorAll('.instagram-embed-wrapper .instagram-media a, .instagram-embed-wrapper .instagram-media footer, .instagram-embed-wrapper .instagram-media p').forEach(el => {
        el.style.display = 'none';
        el.style.visibility = 'hidden';
        el.style.height = '0';
        el.style.overflow = 'hidden';
    });
}

// Procesar embeds al cargar y al navegar (Livewire).
document.addEventListener('livewire:initialized', () => {
    setTimeout(processInstagramEmbeds, 300);
});
document.addEventListener('livewire:navigated', () => {
    setTimeout(processInstagramEmbeds, 300);
});
