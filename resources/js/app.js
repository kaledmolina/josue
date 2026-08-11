import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

// ============================================================
// Scroll: navbar compacto + auto-hide, barra de progreso, botón arriba
// ============================================================
var lastScrollY = 0;
window.addEventListener('scroll', function () {
    var navbar = document.getElementById('navbar');
    var y = window.scrollY;

    // Compactar navbar (transparente; solo la cápsula lleva el fondo oscuro)
    if (navbar) {
        if (y > 20) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');

        // Auto-hide: ocultar al bajar, mostrar al subir
        var delta = y - lastScrollY;
        if (y > 140 && delta > 5) navbar.classList.add('nav-hidden');
        else if (delta < -3 || y <= 140) navbar.classList.remove('nav-hidden');
    }
    lastScrollY = y;

    // Barra de progreso de scroll
    var bar = document.getElementById('scroll-progress');
    if (bar) {
        var max = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.width = (max > 0 ? (y / max) * 100 : 0) + '%';
    }

    // Botón volver arriba
    var btt = document.getElementById('back-to-top');
    if (btt) btt.classList.toggle('visible', y > 400);
});

document.getElementById('back-to-top')?.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
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
    var mouse = { x: null, y: null };

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

            // Repulsión suave al pasar el mouse
            if (mouse.x !== null) {
                var dx = p.x - mouse.x;
                var dy = p.y - mouse.y;
                var d2 = dx * dx + dy * dy;
                var R = 140;
                if (d2 < R * R && d2 > 0.01) {
                    var d = Math.sqrt(d2);
                    var force = ((R - d) / R) * 0.9;
                    p.x += (dx / d) * force;
                    p.y += (dy / d) * force;
                }
            }

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
    window.addEventListener('mousemove', function (e) {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });
    window.addEventListener('mouseleave', function () {
        mouse.x = null;
        mouse.y = null;
    });
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

// ============================================================
// UI/UX: indicador deslizante del menú (píldora blanca)
// ============================================================
function positionNavIndicator() {
    var ul = document.getElementById('nav-menu');
    var ind = document.getElementById('nav-indicator');
    if (!ul || !ind) return;
    var active = ul.querySelector('a[aria-current="page"]') || ul.querySelector('a.active');
    var ur = ul.getBoundingClientRect();
    if (!active) {
        ind.style.opacity = '0';
        return;
    }
    var r = active.getBoundingClientRect();
    ind.style.opacity = '1';
    ind.style.width = r.width + 'px';
    ind.style.height = r.height + 'px';
    ind.style.transform = 'translate(' + (r.left - ur.left) + 'px,' + (r.top - ur.top) + 'px)';
}

document.addEventListener('DOMContentLoaded', positionNavIndicator);
window.addEventListener('resize', positionNavIndicator);
document.addEventListener('livewire:navigated', function () {
    navCurrent = null;
    positionNavIndicator();
});

// Hover: deslizar la píldora hacia el enlace señalado (translúcida sobre enlaces no activos)
var navCurrent = null;

function setNavPill(link) {
    var ul = document.getElementById('nav-menu');
    var ind = document.getElementById('nav-indicator');
    if (!ul || !ind) return;
    if (navCurrent === link) return;
    navCurrent = link;
    if (link) {
        var ur = ul.getBoundingClientRect();
        var r = link.getBoundingClientRect();
        ind.style.opacity = '1';
        ind.style.width = r.width + 'px';
        ind.style.height = r.height + 'px';
        ind.style.transform = 'translate(' + (r.left - ur.left) + 'px,' + (r.top - ur.top) + 'px)';
        ind.classList.toggle('nav-hovering', !link.hasAttribute('aria-current'));
    } else {
        ind.classList.remove('nav-hovering');
        positionNavIndicator();
    }
}

document.addEventListener('mouseover', function (e) {
    var link = e.target.closest && e.target.closest('#nav-menu a');
    if (link) setNavPill(link);
});
document.addEventListener('mouseout', function (e) {
    var link = e.target.closest && e.target.closest('#nav-menu a');
    var ul = document.getElementById('nav-menu');
    if (link && navCurrent === link && ul && !ul.matches(':hover')) {
        setNavPill(null);
    }
});

// ============================================================
// UI/UX: cursor personalizado (punto + anillo) — solo mouse fino
// ============================================================
if (window.matchMedia && window.matchMedia('(pointer: fine)').matches) {
    var dot = document.getElementById('cursor-dot');
    var ring = document.getElementById('cursor-ring');
    if (dot && ring) {
        var mx = -100, my = -100, rx = -100, ry = -100;
        window.addEventListener('mousemove', function (e) {
            mx = e.clientX;
            my = e.clientY;
            dot.style.left = mx + 'px';
            dot.style.top = my + 'px';
        });
        (function cursorLoop() {
            rx += (mx - rx) * 0.16;
            ry += (my - ry) * 0.16;
            ring.style.left = rx + 'px';
            ring.style.top = ry + 'px';
            requestAnimationFrame(cursorLoop);
        })();
        document.addEventListener('mouseover', function (e) {
            var t = e.target.closest && e.target.closest('a, button, [role="button"], .tilt, .shine, input, textarea, select, label');
            document.body.classList.toggle('cursor-active', !!t);
        });
    }
}

// ============================================================
// UI/UX: spotlight que sigue al mouse
// ============================================================
if (window.matchMedia && window.matchMedia('(pointer: fine)').matches) {
    var spotlight = document.getElementById('spotlight');
    if (spotlight) {
        window.addEventListener('mousemove', function (e) {
            spotlight.style.left = e.clientX + 'px';
            spotlight.style.top = e.clientY + 'px';
        });
    }
}

// ============================================================
// UI/UX: tilt 3D en tarjetas
// ============================================================
if (window.matchMedia && window.matchMedia('(pointer: fine)').matches) {
    document.addEventListener('mousemove', function (e) {
        var el = e.target.closest && e.target.closest('.tilt');
        if (!el) return;
        var r = el.getBoundingClientRect();
        var px = (e.clientX - r.left) / r.width - 0.5;
        var py = (e.clientY - r.top) / r.height - 0.5;
        el.style.transform = 'translateY(-6px) perspective(900px) rotateX(' + (-py * 8) + 'deg) rotateY(' + (px * 8) + 'deg)';
    });
    document.addEventListener('mouseout', function (e) {
        var el = e.target.closest && e.target.closest('.tilt');
        if (el && !el.matches(':hover') && !el.contains(e.relatedTarget)) {
            el.style.transform = '';
        }
    });
}

// ============================================================
// UI/UX: reveal de títulos letra por letra
// ============================================================
function revealLetters(el) {
    if (el.dataset.lettersDone) return;
    el.dataset.lettersDone = '1';
    var text = el.textContent.trim();
    if (!text) return;
    el.setAttribute('aria-label', text);
    el.textContent = '';
    el.classList.add('letters');
    var delay = 0;
    text.split(' ').forEach(function (word) {
        var wspan = document.createElement('span');
        wspan.className = 'inline-block whitespace-nowrap';
        word.split('').forEach(function (ch) {
            var s = document.createElement('span');
            s.className = 'letter';
            s.style.animationDelay = delay + 'ms';
            s.textContent = ch;
            wspan.appendChild(s);
            delay += 38;
        });
        el.appendChild(wspan);
        el.appendChild(document.createTextNode(' '));
        delay += 80;
    });
}

var lettersObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
        if (entry.isIntersecting) {
            revealLetters(entry.target);
            lettersObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.4 });

function scanLetters() {
    document.querySelectorAll('[data-letters]').forEach(function (el) {
        if (!el.dataset.lettersDone) lettersObserver.observe(el);
    });
}
scanLetters();
document.addEventListener('livewire:navigated', scanLetters);

// ============================================================
// UI/UX: preloader de entrada
// ============================================================
var preloader = document.getElementById('preloader');
if (preloader) {
    function hidePreloader() {
        preloader.classList.add('done'); // queda invisible en el DOM (wire:ignore), sin reintroducirse
    }
    window.addEventListener('load', function () { setTimeout(hidePreloader, 350); });
    setTimeout(hidePreloader, 2600); // respaldo
}

// ============================================================
// UI/UX: parallax sutil en fondos de hero
// ============================================================
var parallaxTargets = document.querySelectorAll('[data-parallax]');
if (parallaxTargets.length) {
    window.addEventListener('scroll', function () {
        var y = window.scrollY;
        parallaxTargets.forEach(function (el) {
            var speed = parseFloat(el.dataset.parallax || '0.3');
            el.style.transform = 'translate3d(0,' + (y * speed) + 'px,0) scale(1.05)';
        });
    }, { passive: true });
}
