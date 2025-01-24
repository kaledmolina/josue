import './bootstrap';
window.addEventListener('scroll', function () {
    var navbar = document.getElementById('navbar');
    if (window.scrollY > 20) {
        navbar.classList.add('fixed', 'bg-opacity-90', 'shadow-lg');
    } else {
        navbar.classList.remove('fixed', 'bg-opacity-90', 'shadow-lg');
    }
});