import Swiper from "./init-slider.js";

const casesSectionSliders = document.querySelectorAll("[data-id='sec-cases'] .sec-slider__content");

if (casesSectionSliders) {
  casesSectionSliders.forEach((slider) => {
    const btnNextSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-next");
    const btnPrevSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-prev");

    const swiper_currentSlider = new Swiper(slider, {
      loop: true,
      lazy: true,
      spaceBetween: 17,
      slidesPerView: 1,
      slidesPerGroup: 1,
      navigation: {
        nextEl: btnNextSectionSlider,
        prevEl: btnPrevSectionSlider,
      },
      breakpoints: {
        360: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1440: {
          slidesPerView: 2,
        },
      },
    });
  });
}

const reviewsSectionSliders = document.querySelectorAll("[data-id='sec-reviews'] .sec-slider__content");

if (reviewsSectionSliders) {
  reviewsSectionSliders.forEach((slider) => {
    const btnNextSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-next");
    const btnPrevSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-prev");

    const swiper_currentSlider = new Swiper(slider, {
      loop: true,
      lazy: true,
      spaceBetween: 20,
      slidesPerView: 1,
      slidesPerGroup: 1,
      navigation: {
        nextEl: btnNextSectionSlider,
        prevEl: btnPrevSectionSlider,
      },
      breakpoints: {
        360: {
          slidesPerView: 1,
        },
        576: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        992: {
          slidesPerView: 3,
        },
        1440: {
          slidesPerView: 3,
        },
      },
    });
  });
}

const resizableSwiper = (breakpoint, swiperClass, swiperSettings, callback) => {
  let swiper;

  breakpoint = window.matchMedia(breakpoint);

  const enableSwiper = function (className, settings) {
    swiper = new Swiper(className, settings);

    if (callback) {
      callback(swiper);
    }
  };

  const checker = function () {
    if (breakpoint.matches) {
      return enableSwiper(swiperClass, swiperSettings);
    } else {
      if (swiper !== undefined) swiper.destroy(true, true);
      return;
    }
  };

  breakpoint.addEventListener("change", checker);
  checker();
};

const mediaSlider = document.querySelectorAll("[data-id='company-media'] .sec-slider__content");
if (mediaSlider) {
  mediaSlider.forEach((slider) => {
    const btnNextSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-next");
    const btnPrevSectionSlider = slider.parentNode.querySelector(".sec-slider__btn-prev");

    resizableSwiper("(max-width: 1024px)", "[data-id='company-media'] .sec-slider__content", {
      loop: true,
      spaceBetween: 20,
      slidesPerView: 1,
      watchSlidesProgress: true,
      navigation: {
        nextEl: btnNextSectionSlider,
        prevEl: btnPrevSectionSlider,
      },
      breakpoints: {
        360: {
          slidesPerView: 1,
        },
        576: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        992: {
          slidesPerView: 3,
        },
      },
    });
  });
}
