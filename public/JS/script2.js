let currentIndex = 0;
const slides = document.querySelectorAll('.carousel-item');
const dots = document.querySelectorAll('.dot');

function moveToSlide(index) {
    currentIndex = index;
    document.querySelector('.carousel-inner').style.transform = `translateX(-${index * 100}%)`;
    updateDots();
}

function updateDots() {
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentIndex);
    });
}
updateDots();