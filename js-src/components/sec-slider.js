import Swiper from "./init-slider.js";

const casesSectionSliders = document.querySelectorAll("[data-id='sec-cases'] .sec-slider__content");
console.log(document.querySelectorAll("[data-id='sec-cases'] .sec-slider__content"));

if (casesSectionSliders) {
  casesSectionSliders.forEach((slider) => {
    const btnNextSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-next");
    const btnPrevSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-prev");

    const swiper_currentSlider = new Swiper(slider, {
      loop: true,
      lazy: true,
      spaceBetween: 17,
      slidesPerView: 2,
      slidesPerGroup: 1,
      navigation: {
        nextEl: btnNextSectionSlider,
        prevEl: btnPrevSectionSlider,
      },
      breakpoints: {
        // 768: {
        //   slidesPerView: 3,
        //   slidesPerGroup: 3,
        //   spaceBetween: 16,
        // },
        1440: {
          slidesPerView: 2,
        },
      },
    });
  });
}
