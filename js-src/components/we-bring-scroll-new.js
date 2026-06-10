document.addEventListener("DOMContentLoaded", function () {
  const list = document.querySelector(".we-bring__list");
  if (!list) return;

  // Проверяем, нужна ли прокрутка (контент выше контейнера)
  if (list.scrollHeight <= list.clientHeight) return;

  let direction = 1; // 1 = вниз, -1 = вверх
  let interval;

  const startAutoScroll = () => {
    if (interval) clearInterval(interval);
    interval = setInterval(() => {
      list.scrollBy({ top: 1.5, behavior: "smooth" });
      // Проверка достижения края
      if (list.scrollTop + list.clientHeight >= list.scrollHeight - 2) {
        direction = -1;
      } else if (list.scrollTop <= 2) {
        direction = 1;
      }
    }, 25);
  };

  const stopAutoScroll = () => clearInterval(interval);

  // Остановка при наведении
  list.addEventListener("mouseenter", stopAutoScroll);
  list.addEventListener("mouseleave", startAutoScroll);

  // Запуск
  startAutoScroll();
});
