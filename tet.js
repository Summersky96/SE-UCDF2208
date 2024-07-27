
        ScrollReveal({
            distance: '60px',
            duration: 2500,
            delay: 400
        });

        ScrollReveal().reveal('.main-title, .section-title', { delay: 500, origin: 'left' });
        ScrollReveal().reveal('.sec-01.image, .info', { delay: 600, origin: 'bottom' });
        ScrollReveal().reveal('.text-box', { delay: 700, origin: 'right' });
        ScrollReveal().reveal('.sec-02 .image, .sec-03 .image', { delay: 500, origin: 'top' });
        ScrollReveal().reveal('.sec-info li', { delay: 500, origin: 'left', interval: 200 });
document.addEventListener('DOMContentLoaded', function() {
            ScrollReveal().reveal('.sec-01', { delay: 200 });
            ScrollReveal().reveal('.sec-02', { delay: 400 });
            ScrollReveal().reveal('.sec-03', { delay: 600 });
            ScrollReveal().reveal('.sec-04', { delay: 800 });
            ScrollReveal().reveal('.sec-05', { delay: 1000 });
        });
        