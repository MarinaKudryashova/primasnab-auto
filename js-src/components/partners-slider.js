import Swiper from "./init-slider.js";

console.log('✅ partners-slider.js загружен');

const partnersSectionSliders = document.querySelectorAll("[data-id='sec-partners'] .sec-slider__content");

if (partnersSectionSliders.length) {
    partnersSectionSliders.forEach((slider) => {
        const slides = slider.querySelectorAll('.swiper-slide');
        if (slides.length <= 1) return;
        if (slider.classList.contains('swiper-initialized')) return;

        const btnNext = slider.parentNode.querySelector(".sec-slider__btn-next");
        const btnPrev = slider.parentNode.querySelector(".sec-slider__btn-prev");

        new Swiper(slider, {
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
        });
    });
}