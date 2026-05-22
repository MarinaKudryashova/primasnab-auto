document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector('[data-tabs="offices-tabs"]');
  if (!container) return;

  const btns = container.querySelectorAll(".tabs__nav-btn");
  const panels = container.querySelectorAll(".tabs__panel");
  const selectOptions = container.querySelectorAll(".offices__select-option");
  const selectSelected = container.querySelector(".offices__select-selected");

  function switchTab(index) {
    btns.forEach((btn) => btn.classList.remove("tabs__nav-btn--active"));
    if (btns[index]) btns[index].classList.add("tabs__nav-btn--active");

    panels.forEach((panel) => panel.classList.remove("tabs__panel--active"));
    if (panels[index]) panels[index].classList.add("tabs__panel--active");

    if (selectOptions[index]) {
      const optionName = selectOptions[index].querySelector("span")?.innerText;
      const selectNameSpan = selectSelected?.querySelector(
        ".offices__select-name",
      );
      if (selectNameSpan && optionName) {
        selectNameSpan.innerText = optionName;
      }
    }

    selectOptions.forEach((opt, idx) => {
      if (idx === index) {
        opt.classList.add("active");
      } else {
        opt.classList.remove("active");
      }
    });
  }

  btns.forEach((btn, index) => {
    btn.addEventListener("click", () => switchTab(index));
  });

  selectOptions.forEach((option, index) => {
    option.addEventListener("click", (e) => {
      e.stopPropagation();
      switchTab(index);
      container.classList.remove("open");
    });
  });

  if (selectSelected) {
    selectSelected.addEventListener("click", (e) => {
      e.stopPropagation();
      container.classList.toggle("open");
    });

    document.addEventListener("click", () => {
      container.classList.remove("open");
    });
  }

  const hasActive = container.querySelector(".tabs__nav-btn--active");
  if (!hasActive && btns.length > 0) {
    switchTab(0);
  } else if (hasActive) {
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

  // Карты
  if (typeof ymaps !== "undefined") {
    ymaps.ready(() => {
      document.querySelectorAll(".offices__map").forEach((el, mapIndex) => {
        const center = el.dataset.center?.split(",").map(Number);
        const point = el.dataset.point?.split(",").map(Number);

        if (!center || !point || !point[0] || !point[1]) {
          console.log(`⚠️ Карта ${mapIndex}: нет point, пропускаем`);
          return;
        }

        const hintText = el.dataset.hint || "Офис";

        const map = new ymaps.Map(el, {
          center: center,
          zoom: 16,
          controls: ["zoomControl"],
        });

        const placemark = new ymaps.Placemark(point, {
          balloonContent: hintText,
        });
        map.geoObjects.add(placemark);

        function addHintDiv() {
          const mapContainer = map.container.getElement();
          if (mapContainer.querySelector(".offices__map-hint")) return;

          const hintDiv = document.createElement("div");
          hintDiv.className = "offices__map-hint";
          hintDiv.textContent = hintText;
          mapContainer.style.position = "relative";
          mapContainer.appendChild(hintDiv);
          console.log(`✅ Карта ${mapIndex}: div добавлен в левый нижний угол`);
        }

        setTimeout(addHintDiv, 500);
        setTimeout(addHintDiv, 1000);
      });
    });
  }

  console.log("✅ Табы, селект и карты готовы!");
});
