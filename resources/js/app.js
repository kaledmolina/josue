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
