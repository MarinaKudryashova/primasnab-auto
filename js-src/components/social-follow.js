document.addEventListener("DOMContentLoaded", () => {
  const bell = document.querySelector(".social-follow__left-icon");
  const section = document.querySelector(".social-follow");

  if (!bell || !section) return;

  new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          for (let i = 0; i < 3; i++) {
            setTimeout(() => {
              bell.classList.add("bell-ring");
              setTimeout(() => bell.classList.remove("bell-ring"), 800);
            }, i * 1000);
          }
        }
      });
    },
    { threshold: 0.3 },
  ).observe(section);
});
