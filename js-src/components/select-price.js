document.addEventListener("DOMContentLoaded", function () {
  const selects = document.querySelectorAll(
    ".banner-price-request__custom-select",
  );
  selects.forEach((container) => {
    const selected = container.querySelector(
      ".banner-price-request__select-selected",
    );
    const options = container.querySelectorAll(
      ".banner-price-request__select-option",
    );
    const hidden = container
      .closest(".banner-price-request__field")
      ?.querySelector(".banner-price-request__select-hidden");
    const nameSpan = selected.querySelector(
      ".banner-price-request__select-name",
    );

    if (!selected) return;

    selected.addEventListener("click", (e) => {
      e.stopPropagation();
      container.classList.toggle("open");
    });

    options.forEach((opt) => {
      opt.addEventListener("click", () => {
        const value = opt.getAttribute("data-value") || opt.innerText;
        nameSpan.innerText = opt.innerText;
        if (hidden) hidden.value = value;

        options.forEach((o) => o.classList.remove("active"));
        opt.classList.add("active");

        container.classList.remove("open");
      });
    });

    document.addEventListener("click", () => {
      container.classList.remove("open");
    });
  });
});
