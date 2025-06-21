document.addEventListener("DOMContentLoaded", function () {
    const carouseles = document.querySelectorAll(".mini-carousel");

    carouseles.forEach(carousel => {
        let index = 0;
        const slides = carousel.querySelectorAll(".mini-slide");
        const totalSlides = slides.length;

        function cambiarSlide(dir = 1) {
            slides[index].classList.remove("active");
            index = (index + dir + totalSlides) % totalSlides;
            slides[index].classList.add("active");
        }

        // Configurar cambio automático
        setInterval(() => cambiarSlide(1), 3000);

        // Botones manuales
        carousel.querySelector(".prev").addEventListener("click", () => cambiarSlide(-1));
        carousel.querySelector(".next").addEventListener("click", () => cambiarSlide(1));
    });
});