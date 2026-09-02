document.addEventListener("DOMContentLoaded", function () {
  const isMobile = window.innerWidth <= 768;
  const list = document.querySelector(".we-bring__list");
  if (!list) return;

  if (isMobile) {
    // Мобилки: отключаем всё, плашки в потоке
    list.style.maxHeight = "none";
    list.style.overflowY = "visible";
    console.log("Мобильный режим: автопрокрутка отключена");
    return;
  }

  // Десктоп: включаем автопрокрутку, если список выше контейнера
  if (list.scrollHeight <= list.clientHeight) {
    console.log("Список не выше контейнера, автопрокрутка не нужна");
    return;
  }

  let direction = 1; // 1 = вниз, -1 = вверх
  let interval;

  const startAutoScroll = () => {
    if (interval) clearInterval(interval);
    interval = setInterval(() => {
      list.scrollBy({ top: 1.5, behavior: "smooth" });
      if (list.scrollTop + list.clientHeight >= list.scrollHeight - 2) {
        direction = -1;
      } else if (list.scrollTop <= 2) {
        direction = 1;
      }
    }, 25);
  };

  const stopAutoScroll = () => clearInterval(interval);

  list.addEventListener("mouseenter", stopAutoScroll);
  list.addEventListener("mouseleave", startAutoScroll);

  startAutoScroll();
  console.log("Десктоп: автопрокрутка запущена");
});
