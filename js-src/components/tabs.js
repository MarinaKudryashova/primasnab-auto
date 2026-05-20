// document.addEventListener('DOMContentLoaded', function() {
//     const tabsContainer = document.querySelector('[data-tabs="offices-tabs"]');
//     if (!tabsContainer) return;

//     const btns = tabsContainer.querySelectorAll('.tabs__nav-btn');
//     const panels = tabsContainer.querySelectorAll('.tabs__panel');

//     function switchTab(activeIndex) {
//         btns.forEach(btn => {
//             btn.classList.remove('tabs__nav-btn--active');
//         });

//         panels.forEach(panel => {
//             panel.classList.remove('tabs__panel--active');
//         });

//         btns[activeIndex]?.classList.add('tabs__nav-btn--active');
//         panels[activeIndex]?.classList.add('tabs__panel--active');
//     }

//     btns.forEach((btn, index) => {
//         btn.addEventListener('click', () => switchTab(index));
//     });

//     if (btns.length > 0) {
//         switchTab(0);
//     }
// });

// с выпадающим списком
// js/tabs.js

document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector('[data-tabs="offices-tabs"]');
  if (!container) return;

  // Все элементы
  const btns = container.querySelectorAll(".tabs__nav-btn");
  const panels = container.querySelectorAll(".tabs__panel");
  const selectOptions = container.querySelectorAll(".offices__select-option");
  const selectSelected = container.querySelector(".offices__select-selected");
  const customSelect = container.querySelector(".offices__custom-select");

  // Функция переключения таба
  function switchTab(index) {
    // Обновляем кнопки (десктоп)
    btns.forEach((btn) => btn.classList.remove("tabs__nav-btn--active"));
    if (btns[index]) btns[index].classList.add("tabs__nav-btn--active");

    // Обновляем панели
    panels.forEach((panel) => panel.classList.remove("tabs__panel--active"));
    if (panels[index]) panels[index].classList.add("tabs__panel--active");

    // Обновляем текст в выбранном элементе (мобильный селект)
    if (selectOptions[index]) {
      const optionName = selectOptions[index].querySelector("span")?.innerText;
      const selectNameSpan = selectSelected?.querySelector(
        ".offices__select-name",
      );
      if (selectNameSpan && optionName) {
        selectNameSpan.innerText = optionName;
      }
    }

    // Обновляем активный класс в опциях селекта
    selectOptions.forEach((opt, idx) => {
      if (idx === index) {
        opt.classList.add("active");
      } else {
        opt.classList.remove("active");
      }
    });
  }

  // Обработчики для кнопок (десктоп)
  btns.forEach((btn, index) => {
    btn.addEventListener("click", () => {
      switchTab(index);
    });
  });

  // Обработчики для опций селекта (мобилка)
  selectOptions.forEach((option, index) => {
    option.addEventListener("click", (e) => {
      e.stopPropagation();
      switchTab(index);
      // Закрываем селект после выбора
      container.classList.remove("open");
    });
  });

  // Открытие/закрытие выпадающего списка (мобилка)
  if (selectSelected) {
    selectSelected.addEventListener("click", (e) => {
      e.stopPropagation();
      container.classList.toggle("open");
    });

    // Закрытие при клике вне
    document.addEventListener("click", () => {
      container.classList.remove("open");
    });
  }

  // Активируем первый таб, если нет активного
  const hasActive = container.querySelector(".tabs__nav-btn--active");
  if (!hasActive && btns.length > 0) {
    switchTab(0);
  } else if (hasActive) {
    // Если есть активный, синхронизируем селект
    const activeIndex = Array.from(btns).findIndex((btn) =>
      btn.classList.contains("tabs__nav-btn--active"),
    );
    if (activeIndex !== -1) {
      const activeName =
        btns[activeIndex]?.querySelector(".offices__name")?.innerText;
      const selectNameSpan = selectSelected?.querySelector(
        ".offices__select-name",
      );
      if (selectNameSpan && activeName) {
        selectNameSpan.innerText = activeName;
      }
      selectOptions.forEach((opt, idx) => {
        if (idx === activeIndex) {
          opt.classList.add("active");
        } else {
          opt.classList.remove("active");
        }
      });
    }
  }

  console.log("✅ Табы и селект готовы!");
});
