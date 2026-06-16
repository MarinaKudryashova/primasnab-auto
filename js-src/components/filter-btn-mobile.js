// кнопка "применить" для каталога в мобилке + иконка крестика

console.log("✅ filters-btn-mobile.js loaded");

document.addEventListener("DOMContentLoaded", function () {
  console.log("✅ DOMContentLoaded fired");
  const filterForm = document.querySelector(".wcapf-form");
  console.log("filterForm:", filterForm);
  if (!filterForm) {
    console.warn("❌ Форма .wcapf-form не найдена");
    return;
  }

  let applyButton = null;
  let isMobile = () => window.innerWidth <= 992;

  function isAnyFilterSelected() {
    const checkboxes = filterForm.querySelectorAll(
      'input[type="checkbox"]:checked',
    );
    if (checkboxes.length > 0) return true;

    const selects = filterForm.querySelectorAll("select:not(.wcapf-chosen)");
    for (let select of selects) {
      if (select.value && select.value !== "") return true;
    }

    const sliders = filterForm.querySelectorAll(".wcapf-noui-slider");
    for (let slider of sliders) {
      const minInput = slider.querySelector(".min-value");
      const maxInput = slider.querySelector(".max-value");
      if (minInput && maxInput) {
        const min = parseFloat(minInput.value);
        const max = parseFloat(maxInput.value);
        const originalMin = parseFloat(
          slider.getAttribute("data-range-min-value"),
        );
        const originalMax = parseFloat(
          slider.getAttribute("data-range-max-value"),
        );
        if (min !== originalMin || max !== originalMax) return true;
      }
    }
    return false;
  }

  function toggleApplyButton() {
    console.log(
      "toggleApplyButton called, isMobile:",
      isMobile(),
      "isAnyFilterSelected:",
      isAnyFilterSelected(),
    );
    if (!applyButton) {
      console.warn("Кнопка ещё не создана");
      return;
    }
    if (isMobile() && isAnyFilterSelected()) {
      applyButton.classList.add("show");
      console.log("✅ Кнопка показана");
    } else {
      applyButton.classList.remove("show");
      console.log("Кнопка скрыта");
    }
  }

  function createApplyButton() {
    if (applyButton) return;
    applyButton = document.createElement("button");
    applyButton.type = "button";
    applyButton.className = "wcapf-apply-filters-btn";
    applyButton.textContent = "Применить";
    filterForm.appendChild(applyButton);
    console.log("✅ Кнопка создана");
    applyButton.addEventListener("click", function (e) {
      e.preventDefault();
      filterForm.submit();
    });
  }

  function preventAutoSubmit(e) {
    if (isMobile()) {
      e.preventDefault();
      console.log("Автоматическая отправка предотвращена");
      return false;
    }
  }

  function initMobileFilters() {
    console.log("initMobileFilters, isMobile:", isMobile());
    if (isMobile()) {
      createApplyButton();
      filterForm.addEventListener("submit", preventAutoSubmit);
      const inputs = filterForm.querySelectorAll("input, select");
      inputs.forEach((input) => {
        input.addEventListener("change", toggleApplyButton);
      });
      const sliders = filterForm.querySelectorAll(".wcapf-noui-slider");
      sliders.forEach((slider) => {
        const minInput = slider.querySelector(".min-value");
        const maxInput = slider.querySelector(".max-value");
        if (minInput) minInput.addEventListener("change", toggleApplyButton);
        if (maxInput) maxInput.addEventListener("change", toggleApplyButton);
      });
      toggleApplyButton();
    } else {
      if (applyButton && applyButton.parentNode) {
        applyButton.remove();
        applyButton = null;
        console.log("Кнопка удалена (десктоп)");
      }
      filterForm.removeEventListener("submit", preventAutoSubmit);
    }
  }

  initMobileFilters();

  // ====== Закрытие по крестику ======
  const closeSidebarBtn = document.querySelector(".close-sidebar");
  const sidebar = document.querySelector(".catalog__sidebar");
  const filterToggleBtn = document.querySelector(".filter-toggle__btn");

  if (closeSidebarBtn && sidebar) {
    closeSidebarBtn.addEventListener("click", function (e) {
      e.preventDefault();
      sidebar.classList.remove("active");
      if (filterToggleBtn) {
        filterToggleBtn.setAttribute("aria-expanded", "false");
      }
      console.log("Сайдбар закрыт по крестику");
    });
  } else {
    console.warn("Крестик .close-sidebar не найден");
  }

  let resizeTimer;
  window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(initMobileFilters, 300);
  });
});
