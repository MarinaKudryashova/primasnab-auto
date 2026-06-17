document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("audio-float-btn");
  const audio = document.getElementById("audio-player");

  if (btn && audio) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      if (audio.paused) {
        audio.play();
        btn.classList.add("playing");
        btn.classList.remove("paused");
      } else {
        audio.pause();
        btn.classList.remove("playing");
        btn.classList.add("paused");
      }
    });

    audio.addEventListener("ended", function () {
      btn.classList.remove("playing");
      btn.classList.remove("paused");
    });
  }
});
