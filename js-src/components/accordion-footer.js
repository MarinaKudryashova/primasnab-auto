document.addEventListener("DOMContentLoaded", function () {
  const toggles = document.querySelectorAll(".footer-menu__toggle");
  toggles.forEach((btn) => {
    const parent = btn.closest(".footer-menu__item--has-children");
    if (!parent) return;
    const submenu = parent.querySelector(".footer-menu__submenu");
    if (!submenu) return;

    btn.addEventListener("click", (e) => {
      e.preventDefault();
      submenu.classList.toggle("open");
      btn.classList.toggle("open");
      const isOpen = submenu.classList.contains("open");
      submenu.style.display = isOpen ? "block" : "none";
      btn.setAttribute("aria-expanded", isOpen);
    });
  });
});
