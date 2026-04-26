import './bootstrap';

const initHeroSpotlight = () => {
    const spotlight = document.querySelector('[data-hero-spotlight]');

    if (!spotlight) {
        return;
    }

    const slides = Array.from(spotlight.querySelectorAll('[data-hero-slide]'));
    const indicators = Array.from(spotlight.querySelectorAll('[data-hero-indicator]'));
    const prevButton = spotlight.querySelector('[data-hero-prev]');
    const nextButton = spotlight.querySelector('[data-hero-next]');

    if (slides.length <= 1) {
        return;
    }

    const intervalMs = Number(spotlight.dataset.interval || 20000);
    let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));
    let autoplayId = null;
    let isPaused = false;

    if (activeIndex < 0) {
        activeIndex = 0;
    }

    const render = () => {
        slides.forEach((slide, index) => {
            slide.classList.toggle('is-active', index === activeIndex);
        });

        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('is-active', index === activeIndex);
        });
    };

    const goTo = (index) => {
        activeIndex = (index + slides.length) % slides.length;
        render();
    };

    const next = () => {
        if (!isPaused) {
            goTo(activeIndex + 1);
        }
    };

    const prev = () => {
        goTo(activeIndex - 1);
    };

    const stopAutoplay = () => {
        if (autoplayId !== null) {
            window.clearInterval(autoplayId);
            autoplayId = null;
        }
    };

    const startAutoplay = () => {
        stopAutoplay();

        autoplayId = window.setInterval(() => {
            if (!document.hidden && !isPaused) {
                goTo(activeIndex + 1);
            }
        }, intervalMs);
    };

    nextButton?.addEventListener('click', () => {
        goTo(activeIndex + 1);
        startAutoplay();
    });

    prevButton?.addEventListener('click', () => {
        prev();
        startAutoplay();
    });

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            goTo(index);
            startAutoplay();
        });
    });

    spotlight.addEventListener('mouseenter', () => {
        isPaused = true;
    });

    spotlight.addEventListener('mouseleave', () => {
        isPaused = false;
    });

    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
            startAutoplay();
        }
    });

    render();
    startAutoplay();
};

const boot = () => {
    initHeroSpotlight();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
