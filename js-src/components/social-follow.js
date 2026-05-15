document.addEventListener("DOMContentLoaded", () => {
  const RING_DURATION = 1800; // длительность звонка
  const MIN_PAUSE = 1000; // минимальная пауза
  const MAX_PAUSE = 6000; // максимальная пауза

  const bell = document.querySelector(".social-follow__bell img");
  const section = document.querySelector(".social-follow__bell");

  if (!bell || !section) return;

  let isRinging = false;
  let observerActive = true;

  function getRandomPause() {
    return Math.random() * (MAX_PAUSE - MIN_PAUSE) + MIN_PAUSE;
  }

  function ringBell() {
    if (!observerActive) return;

    bell.classList.add("bell-ring");

    setTimeout(() => {
      bell.classList.remove("bell-ring");

      const nextPause = getRandomPause();
      setTimeout(ringBell, nextPause);
    }, RING_DURATION);
  }

  new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !isRinging) {
          isRinging = true;
          observerActive = true;
          ringBell();
        } else if (!entry.isIntersecting) {
          observerActive = false;
          isRinging = false;
        }
      });
    },
    { threshold: 1 },
  ).observe(section);
});
