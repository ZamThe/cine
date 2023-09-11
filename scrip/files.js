 const slider = document.querySelector(".slider");
        const sliderItems = document.querySelectorAll(".slider img");
        const sliderCount = sliderItems.length;
        let currentIndex = 0;

        function nextSlide() {
            currentIndex = (currentIndex + 1) % sliderCount;
            updateSlider();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + sliderCount) % sliderCount;
            updateSlider();
        }

        function updateSlider() {
            const translateX = -currentIndex * 100;
            slider.style.transform = `translateX(${translateX}%)`;
        }

        // Agregar la función para avanzar automáticamente cada 3 segundos
        setInterval(nextSlide, 3000); // Cambiar de imagen cada 3 segundos