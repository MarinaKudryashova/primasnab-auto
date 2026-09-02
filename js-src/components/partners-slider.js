import Swiper from "./init-slider.js";

const partnersSectionSliders = document.querySelectorAll("[data-id='sec-partners'] .sec-slider__content");

if (partnersSectionSliders.length) {
    partnersSectionSliders.forEach((slider) => {
        const slides = slider.querySelectorAll('.swiper-slide');
        if (slides.length <= 1) return;
        if (slider.classList.contains('swiper-initialized')) return;

        const btnNext = slider.parentNode.querySelector(".sec-slider__btn-next");
        const btnPrev = slider.parentNode.querySelector(".sec-slider__btn-prev");

        let swiperInstance = null;

        function updateArrowsVisibility() {
            if (!btnNext || !btnPrev || !swiperInstance) return;
            
            // Получаем реальное количество видимых слайдов из Swiper
            const visibleSlides = swiperInstance.params.slidesPerView;
            const totalSlides = slides.length;
            
            // Если visibleSlides === 'auto', вычисляем приблизительно
            let actualVisible = visibleSlides;
            if (visibleSlides === 'auto') {
                const containerWidth = slider.parentElement.offsetWidth;
                const slideWidth = slides[0]?.offsetWidth || 200;
                actualVisible = containerWidth / slideWidth;
            }
            
            // Показываем стрелки, если слайдов больше, чем видимых
            if (totalSlides > actualVisible) {
                btnNext.style.display = 'flex';
                btnPrev.style.display = 'flex';
                btnNext.style.opacity = '1';
                btnPrev.style.opacity = '1';
                btnNext.style.pointerEvents = 'auto';
                btnPrev.style.pointerEvents = 'auto';
                btnNext.classList.remove('swiper-button-lock');
                btnPrev.classList.remove('swiper-button-lock');
            } else {
                btnNext.style.display = 'none';
                btnPrev.style.display = 'none';
                btnNext.style.opacity = '0';
                btnPrev.style.opacity = '0';
                btnNext.style.pointerEvents = 'none';
                btnPrev.style.pointerEvents = 'none';
                btnNext.classList.add('swiper-button-lock');
                btnPrev.classList.add('swiper-button-lock');
            }
        }

        // Скрываем стрелки по умолчанию
        if (btnNext && btnPrev) {
            btnNext.style.display = 'none';
            btnPrev.style.display = 'none';
            btnNext.style.opacity = '0';
            btnPrev.style.opacity = '0';
            btnNext.style.pointerEvents = 'none';
            btnPrev.style.pointerEvents = 'none';
        }

        swiperInstance = new Swiper(slider, {
            loop: true,
            spaceBetween: 20,
            slidesPerView: 'auto',
            navigation: {
                nextEl: btnNext,
                prevEl: btnPrev,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                375: { 
                    slidesPerView: 1, 
                    spaceBetween: 0
                },
                576: { 
                    slidesPerView: 2, 
                    spaceBetween: 0
                },
                768: { 
                    slidesPerView: 3, 
                    spaceBetween: 0
                },
                992: { 
                    slidesPerView: 4, 
                    spaceBetween: 0
                },
                1400: { 
                    slidesPerView: 4, 
                    spaceBetween: 20
                },
                1600: { 
                    slidesPerView: 4,
                    spaceBetween: 20
                },
                1920: { 
                    slidesPerView: 5, 
                    spaceBetween: 20
                },
            },
            on: {
                init: function() {
                    updateArrowsVisibility();
                },
                breakpoint: function() {
                    setTimeout(updateArrowsVisibility, 50);
                },
                resize: function() {
                    setTimeout(updateArrowsVisibility, 50);
                },
                afterInit: function() {
                    setTimeout(updateArrowsVisibility, 50);
                }
            }
        });

        // Дополнительно обновляем при ресайзе окна
        window.addEventListener('resize', function() {
            setTimeout(updateArrowsVisibility, 100);
        });
    });
}

// ===== УПРАВЛЕНИЕ ТУЛТИПАМИ =====
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card-partners');
    
    cards.forEach(function(card) {
        const tooltipId = card.getAttribute('data-tooltip-id');
        if (!tooltipId) return;
        
        const tooltip = document.getElementById(tooltipId);
        if (!tooltip) return;

        // Перемещаем тултип в body
        document.body.appendChild(tooltip);

        card.addEventListener('mouseenter', function() {
            const rect = card.getBoundingClientRect();
            
            // Только позиционирование
            tooltip.style.top = (rect.bottom + 10) + 'px';
            tooltip.style.left = (rect.left + rect.width / 2) + 'px';
            
            // Показываем
            tooltip.classList.add('active');
        });

        card.addEventListener('mouseleave', function() {
            tooltip.classList.remove('active');
        });
    });
});