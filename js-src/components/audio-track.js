document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("audio-float-btn");
    const audio = document.getElementById("audio-player");

    if (btn && audio) {
        // Флаг, чтобы загружать файл только один раз
        let isLoaded = false;

        btn.addEventListener("click", function (e) {
            e.preventDefault();

            // Если аудио ещё не загружено – загружаем
            if (!isLoaded) {
                audio.load();   // явно загружаем файл
                isLoaded = true;
            }

            if (audio.paused) {
                audio.play().catch(err => {
                    console.warn('Ошибка воспроизведения:', err);
                });
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