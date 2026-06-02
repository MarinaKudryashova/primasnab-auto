// Добавьте в ваш основной JS файл
document.addEventListener("DOMContentLoaded", function () {
  const weBringSection = document.querySelector(".we-bring");
  const stickyTitle = document.querySelector(".we-bring__title");
  const weBringList = document.querySelector(".we-bring__list");

  if (!weBringSection || !stickyTitle) return;

  // Отслеживаем пересечение секции
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
        }
      });
    },
    { threshold: 0.1 },
  );

  observer.observe(weBringSection);

  // Плавное появление элементов списка при скролле
  const listItems = document.querySelectorAll(".we-bring__item");

  const itemObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
        }
      });
    },
    { threshold: 0.3, rootMargin: "0px 0px -100px 0px" },
  );

  listItems.forEach((item) => itemObserver.observe(item));
});
