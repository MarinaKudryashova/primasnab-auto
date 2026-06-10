(function () {
  let isMobile = window.innerWidth <= 767;

  // Функция обновления состояний в зависимости от ширины
  function updateStates() {
    isMobile = window.innerWidth <= 767;
    const items = document.querySelectorAll(".footer-menu__item--has-children");
    items.forEach((item) => {
      const submenu = item.querySelector(".footer-menu__submenu");
      const toggle = item.querySelector(".footer-menu__toggle");
      if (!submenu) return;
      if (!isMobile) {
        submenu.classList.add("open");
        if (toggle) toggle.classList.add("open");
      } else {
        submenu.classList.remove("open");
        if (toggle) toggle.classList.remove("open");
      }
    });
  }

  // Делегирование: ловим клики на всей секции футера
  document.querySelector(".footer__menu")?.addEventListener("click", (e) => {
    // Находим кнопку-стрелку или ссылку, по которой кликнули
    const toggle = e.target.closest(".footer-menu__toggle");
    const link = e.target.closest(".footer-menu__link");
    if (!toggle && !link) return;

    // Находим родительский пункт меню
    const parentItem = (toggle || link).closest(
      ".footer-menu__item--has-children",
    );
    if (!parentItem) return;

    const submenu = parentItem.querySelector(".footer-menu__submenu");
    if (!submenu) return;

    // Если клик по ссылке, но её href не # – не мешаем, пусть переходит
    if (link && link.getAttribute("href") !== "#") return;

    // Предотвращаем переход по # (скролл вверх)
    e.preventDefault();

    // Переключаем классы
    submenu.classList.toggle("open");
    const toggleBtn = parentItem.querySelector(".footer-menu__toggle");
    if (toggleBtn) toggleBtn.classList.toggle("open");
  });

  // Инициализация при загрузке
  updateStates();

  // При ресайзе обновляем состояния без перезагрузки
  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(updateStates, 150);
  });
})();
