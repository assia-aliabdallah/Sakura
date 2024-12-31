document.addEventListener('DOMContentLoaded', () => {
    let userLink = document.getElementById('user');
    let settingsLink = document.getElementById('settings');

    let slides = [document.querySelector('.slide_a'), 
                document.querySelector('.slide_b')];

    let carousel = document.querySelector('.carousel-track');

    function moveCarousel(slideIndex) {
        slides.forEach((slide, index) => {
            slide.style.display = index === slideIndex ? 'block' : 'none';
        });

        carousel.style.height = `${slides[slideIndex].offsetHeight}px`;
    }

    userLink.addEventListener('click', () => moveCarousel(0));
    settingsLink.addEventListener('click', () => moveCarousel(1));
});