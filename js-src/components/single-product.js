document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".single-product__swiper");
  if (!container || typeof Swiper === "undefined") return;
  let swiper = new Swiper(container, {
    loop: true,
    navigation: {
      nextEl: ".sec-slider__btn-next",
      prevEl: ".sec-slider__btn-prev",
    },
    pagination: false,
  });
  // При ресайзе обновляем Swiper, чтобы пересчитать ширину слайдов
  window.addEventListener("resize", function () {
    setTimeout(() => {
      if (swiper) swiper.update();
    }, 100);
  });
});
