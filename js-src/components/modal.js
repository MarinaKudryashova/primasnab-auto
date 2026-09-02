import GraphModal from "graph-modal";

function initFormHandlers() {
  const modal = new GraphModal();
  let modals = document.querySelectorAll("[data-graph-target]");

  function closeAllModals() {
    modals.forEach((mod) => {
      mod.classList.remove("graph-modal-open");
      mod.classList.remove("animate-open");
    });
    modal.close();
  }

  document.addEventListener(
    "wpcf7mailsent",
    function (response) {
      const formElement = response.target;

      if (formElement.closest("[data-graph-target]")) {
        closeAllModals();
      }

      setTimeout(() => {
        new GraphModal().open("modal-send");
      }, 300);
    },
    false,
  );

  document.addEventListener(
    "wpcf7mailfailed",
    "wpcf7invalid",
    function (response) {
      const formElement = response.target;

      if (formElement.closest("[data-graph-target]")) {
        closeAllModals();
      }

      setTimeout(() => {
        new GraphModal().open("modal-failed");
      }, 300);
    },
    false,
  );
}

// Универсальный запуск
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initFormHandlers);
} else {
  initFormHandlers();
}
