// кнопка "фильтры" для каталога

document.addEventListener("DOMContentLoaded", function () {
  const filterBtn = document.querySelector(".filter-toggle__btn");
  const sidebar = document.querySelector(".catalog__sidebar");
  if (!filterBtn || !sidebar) return;

  filterBtn.addEventListener("click", (e) => {
    e.preventDefault();
    sidebar.classList.toggle("active"); // переключаем класс
  });
});
