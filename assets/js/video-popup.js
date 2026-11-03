(function () {

    function openVideo(videoId, title) {

        const url = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&origin=${window.location.origin}`;

        const modal = document.createElement('div');
        modal.className = 'video-modal-overlay';

        modal.innerHTML = `
            <div class="video-modal-content">
                <div class="video-modal-close">&times;</div>
                <div class="video-modal-title">${title || ''}</div>
                <div class="video-frame-wrapper">
                    <iframe src="${url}"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allow="autoplay; encrypted-media"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // close event
        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.classList.contains('video-modal-close')) {
                modal.remove();
            }
        });

    }

    // 🔥 GLOBAL HANDLER (ANTI SEMUA PLUGIN)
    document.addEventListener('click', function (e) {
        const el = e.target.closest('.video-popup');
        if (!el) return;

        e.preventDefault();
        e.stopImmediatePropagation();

        const id = el.dataset.videoId;
        const title = el.dataset.title;

        if (!id) return;

        openVideo(id, title);

    }, true);
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelector('.video-modal-overlay')?.remove();
        }
    });

})();
