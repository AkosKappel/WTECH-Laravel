// Homepage carousel: prev/next scroll by one page and wrap around; auto-play every 5 s,
// paused while the pointer or keyboard focus is on it, and off for prefers-reduced-motion.
document.querySelectorAll('[data-carousel]').forEach(function (carousel) {
    const track = carousel.querySelector('[data-carousel-track]');
    const atEnd = () => track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
    const atStart = () => track.scrollLeft <= 4;

    function next() {
        track.scrollTo({ left: atEnd() ? 0 : track.scrollLeft + track.clientWidth });
    }

    function prev() {
        track.scrollTo({ left: atStart() ? track.scrollWidth : track.scrollLeft - track.clientWidth });
    }

    carousel.querySelector('[data-carousel-next]')?.addEventListener('click', next);
    carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', prev);
    track.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowRight') { event.preventDefault(); next(); }
        if (event.key === 'ArrowLeft') { event.preventDefault(); prev(); }
    });

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || track.scrollWidth <= track.clientWidth) {
        return;
    }

    let paused = false;
    ['mouseenter', 'focusin', 'touchstart'].forEach((type) => carousel.addEventListener(type, () => { paused = true; }, { passive: true }));
    ['mouseleave', 'focusout'].forEach((type) => carousel.addEventListener(type, () => { paused = false; }));
    setInterval(function () {
        if (!paused && !document.hidden) next();
    }, 5000);
});
