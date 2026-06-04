document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("load-more-reviews");
  if (!btn) return;

  const container = document.getElementById("reviews-container");
  let visibleCount = parseInt(btn.getAttribute("data-visible"), 10);
  const total = parseInt(btn.getAttribute("data-total"), 10);

  btn.addEventListener("click", function () {
    // Находим все ещё скрытые элементы
    const hiddenItems = container.querySelectorAll(
      ".reviews-page__item--hidden",
    );
    if (hiddenItems.length === 0) {
      btn.remove();
      return;
    }

    // Показываем следующие 6 (или сколько осталось)
    let toShow = Math.min(hiddenItems.length, 6);
    for (let i = 0; i < toShow; i++) {
      hiddenItems[i].classList.remove("reviews-page__item--hidden");
    }

    visibleCount += toShow;
    btn.setAttribute("data-visible", visibleCount);

    // Если все отзывы показаны, удаляем кнопку
    if (visibleCount >= total) {
      btn.remove();
    }
  });
});
