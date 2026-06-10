document.addEventListener("DOMContentLoaded", function () {
  const listItems = document.querySelectorAll(".how-work__item");
  const buttons = document.querySelectorAll(".how-work__btn");
  const imageItems = document.querySelectorAll(".how-work__image-item");
  const imageBlock = document.querySelector(".how-work__image");
  const listBlock = document.querySelector(".how-work__list");
  const totalItems = listItems.length;

  if (!listItems.length) return;

  let currentActiveIndex = 0;
  let ticking = false;
  let resizeTimeout;

  function setActiveItem(index) {
    if (currentActiveIndex === index) return;

    buttons.forEach((btn, i) => {
      if (parseInt(btn.dataset.index) === index) {
        btn.classList.add("active");
      } else {
        btn.classList.remove("active");
      }
    });

    imageItems.forEach((img, i) => {
      if (i === index) {
        img.classList.add("active");
      } else {
        img.classList.remove("active");
      }
    });

    currentActiveIndex = index;
  }

  function updateMobileListOffset() {
    if (!imageBlock || !listBlock || window.innerWidth >= 993) {
      if (listBlock) listBlock.style.top = "";
      return;
    }

    const imageRect = imageBlock.getBoundingClientRect();
    const imageBottom = imageRect.bottom;
    const topOffset = Math.max(20, imageBottom);

    listBlock.style.top = topOffset + "px";
  }

  function calculateProgresses(stickyPoint) {
    const progresses = [];
    let activeIndex = 0;
    let maxProgress = 0;
    const threshold = stickyPoint + 100;

    listItems.forEach((item, i) => {
      const rect = item.getBoundingClientRect();

      if (rect.top <= threshold) {
        let progress = Math.min(1, Math.max(0, (threshold - rect.top) / 150));
        progresses[i] = progress;

        if (progress > maxProgress) {
          maxProgress = progress;
          activeIndex = i;
        }
      } else {
        progresses[i] = 0;
      }
    });

    return { progresses, activeIndex };
  }

  function applyStackStyles(progresses) {
    for (let i = 0; i < totalItems; i++) {
      const item = listItems[i];
      const progress = progresses[i];

      if (progress > 0.01) {
        let scale;
        if (i === 0) scale = 1 - progress * 0.12;
        else if (i === 1) scale = 1 - progress * 0.09;
        else if (i === 2) scale = 1 - progress * 0.06;
        else scale = 1 - progress * 0.03;

        scale = Math.max(0.88, scale);

        const translateY = -progress * (5 + i * 5);
        const marginBottom = 20 - progress * 20;

        let opacity;
        if (i === totalItems - 1) {
          opacity = 1;
        } else {
          opacity = 1 - progress * (0.1 + (totalItems - i - 1) * 0.02);
        }
        opacity = Math.max(0.85, opacity);

        item.style.transform = `scale(${scale}) translateY(${translateY}px)`;
        item.style.marginBottom = marginBottom + "px";
        item.style.opacity = opacity;

        if (progress > 0.3) {
          item.style.zIndex = 100 + i;
        } else {
          item.style.zIndex = totalItems - i;
        }
      } else {
        item.style.transform = "scale(1) translateY(0px)";
        item.style.marginBottom = "20px";
        item.style.opacity = "1";
        item.style.zIndex = totalItems - i;
      }
    }
  }

  function handleStackEffect() {
    if (window.innerWidth >= 993) return;

    const stickyPoint = imageBlock ? imageBlock.getBoundingClientRect().bottom + 20 : 20;
    const { progresses, activeIndex } = calculateProgresses(stickyPoint);

    applyStackStyles(progresses);
    setActiveItem(activeIndex);
  }

  function onScroll() {
    if (!ticking && window.innerWidth < 993) {
      requestAnimationFrame(function () {
        handleStackEffect();
        ticking = false;
      });
      ticking = true;
    }
  }

  function setupDesktopHover() {
    if (window.innerWidth >= 993) {
      buttons.forEach((button) => {
        button.removeEventListener("mouseenter", handleMouseEnter);
        button.removeEventListener("focus", handleFocus);
        button.removeEventListener("mouseleave", handleMouseLeave);
        button.removeEventListener("blur", handleBlur);

        button.addEventListener("mouseenter", handleMouseEnter);
        button.addEventListener("focus", handleFocus);
        button.addEventListener("mouseleave", handleMouseLeave);
        button.addEventListener("blur", handleBlur);
      });
    }
  }

  function handleMouseEnter(e) {
    if (window.innerWidth >= 993) {
      const index = parseInt(e.currentTarget.dataset.index);
      setActiveItem(index);
    }
  }

  function handleFocus(e) {
    if (window.innerWidth >= 993) {
      const index = parseInt(e.currentTarget.dataset.index);
      setActiveItem(index);
    }
  }

  function handleMouseLeave(e) {
    if (window.innerWidth >= 993) {
      const activeButton = document.querySelector(".how-work__btn.active");
      if (activeButton) {
        const activeIndex = parseInt(activeButton.dataset.index);
        setActiveItem(activeIndex);
      } else {
        setActiveItem(0);
      }
    }
  }

  function handleBlur(e) {
    if (window.innerWidth >= 993) {
      const activeButton = document.querySelector(".how-work__btn.active");
      if (activeButton) {
        const activeIndex = parseInt(activeButton.dataset.index);
        setActiveItem(activeIndex);
      } else {
        setActiveItem(0);
      }
    }
  }

  function setupMobileClick() {
    if (window.innerWidth < 993) {
      buttons.forEach((button) => {
        button.removeEventListener("click", handleMobileClick);
        button.addEventListener("click", handleMobileClick);
      });
    }
  }

  function handleMobileClick(e) {
    if (window.innerWidth < 993) {
      e.preventDefault();
      const index = parseInt(e.currentTarget.dataset.index);
      const targetItem = listItems[index];

      if (targetItem) {
        const itemRect = targetItem.getBoundingClientRect();
        const offsetTop = itemRect.top + window.pageYOffset - 20;

        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        });

        setActiveItem(index);
      }
    }
  }

  function resetMobileStyles() {
    listItems.forEach((item) => {
      item.style.transform = "";
      item.style.marginBottom = "";
      item.style.opacity = "";
      item.style.zIndex = "";
    });
    if (listBlock) listBlock.style.top = "";
  }

  function handleResize() {
    if (window.innerWidth >= 993) {
      window.removeEventListener("scroll", onScroll);
      resetMobileStyles();
      setupDesktopHover();
      setActiveItem(0);
    } else {
      setupMobileClick();
      updateMobileListOffset();
      window.addEventListener("scroll", onScroll);
      handleStackEffect();
    }
  }

  function init() {
    updateMobileListOffset();
    setActiveItem(0);

    if (window.innerWidth >= 993) {
      setupDesktopHover();
    } else {
      setupMobileClick();
      window.addEventListener("scroll", onScroll);
      handleStackEffect();
    }

    window.addEventListener("resize", function () {
      if (resizeTimeout) clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(handleResize, 150);
    });
  }

  init();

  if (window.innerWidth < 993) {
    setTimeout(function () {
      updateMobileListOffset();
      handleStackEffect();
    }, 100);

    window.addEventListener("load", function () {
      updateMobileListOffset();
      handleStackEffect();
    });
  }
});
