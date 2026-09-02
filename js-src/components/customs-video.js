// ========== ВИДЕО ДЛЯ СТРАНИЦЫ "ТАМОЖЕННОЕ ОФОРМЛЕНИЕ" ==========
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-video-link]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const videoUrl = this.dataset.videoLink;
            if (!videoUrl) return;

            const wrapper = this.closest('.customs-section__video-wrapper');
            if (!wrapper) return;

            const poster = wrapper.querySelector('.customs-section__poster');
            const placeholder = wrapper.querySelector('.customs-section__placeholder');
            if (poster) poster.remove();
            if (placeholder) placeholder.remove();

            this.remove();

            const video = document.createElement('video');
            video.src = videoUrl;
            video.controls = true;
            video.autoplay = true;
            
            video.onerror = function() {
                const errorMsg = document.createElement('div');
                errorMsg.textContent = 'Не удалось загрузить видео';
                wrapper.appendChild(errorMsg);
            };

            wrapper.appendChild(video);
        });
    });
});