/* ==========================================================================
   Barangay Dinaga — Home Page Scripts
   ========================================================================== */

document.addEventListener("DOMContentLoaded", () => {
    initClock();
    initSlideshow();
    initFeaturedArticles();
    initCensusCounters();
});

/* --------------------------------------------------------------------------
   1. Live Clock & Date
   -------------------------------------------------------------------------- */
function initClock() {
    const timeEl = document.getElementById("current-time");
    const dateEl = document.getElementById("current-date");
    if (!timeEl || !dateEl) return;

    const dateOptions = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };

    const render = () => {
        const now = new Date();
        timeEl.textContent = now.toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
        });
        dateEl.textContent = now.toLocaleDateString(undefined, dateOptions);
    };

    render();
    setInterval(render, 1000);
}

/* --------------------------------------------------------------------------
   2. Hero Slideshow
   -------------------------------------------------------------------------- */
function initSlideshow() {
    const slideshow = document.querySelector(".slideshow");
    const slides = document.querySelectorAll(".slideshow .slide");
    const dots = document.querySelectorAll(".slideshow .dot");
    const prevBtn = document.querySelector(".slideshow .prev");
    const nextBtn = document.querySelector(".slideshow .next");

    if (!slideshow || slides.length === 0) return;

    let currentIndex = 0;
    let timerId = null;
    const AUTO_INTERVAL_MS = 8000;

    function showSlide(index) {
        currentIndex = (index + slides.length) % slides.length;

        slides.forEach((slide, idx) => {
            const isActive = idx === currentIndex;
            slide.classList.toggle("active", isActive);
            slide.setAttribute("aria-hidden", String(!isActive));
        });

        dots.forEach((dot, idx) => {
            const isActive = idx === currentIndex;
            dot.classList.toggle("active", isActive);
            dot.setAttribute("aria-current", isActive ? "true" : "false");
        });
    }

    function resetTimer() {
        if (timerId) clearInterval(timerId);
        timerId = setInterval(() => showSlide(currentIndex + 1), AUTO_INTERVAL_MS);
    }

    if (prevBtn) {
        prevBtn.addEventListener("click", () => {
            showSlide(currentIndex - 1);
            resetTimer();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener("click", () => {
            showSlide(currentIndex + 1);
            resetTimer();
        });
    }

    dots.forEach((dot, idx) => {
        dot.addEventListener("click", () => {
            showSlide(idx);
            resetTimer();
        });
    });

    slideshow.addEventListener("mouseenter", () => {
        if (timerId) clearInterval(timerId);
    });

    slideshow.addEventListener("mouseleave", resetTimer);

    slideshow.addEventListener("keydown", (event) => {
        if (event.key === "ArrowLeft") {
            showSlide(currentIndex - 1);
            resetTimer();
        } else if (event.key === "ArrowRight") {
            showSlide(currentIndex + 1);
            resetTimer();
        }
    });

    showSlide(0);
    resetTimer();
}

/* --------------------------------------------------------------------------
   3. Featured Articles Switcher (Scoped to #featured-tabs)
   -------------------------------------------------------------------------- */
function initFeaturedArticles() {
    const tabGroup = document.getElementById("featured-tabs");
    const container = document.getElementById("articles");
    if (!tabGroup || !container) return;

    const buttons = tabGroup.querySelectorAll(".button-tag");

    const articleData = {
        news: [
            {
                img: "assets/images/halloween-trick-or-treat.png",
                alt: "Alimbayod Moms 2nd Halloween Trick-or-Treat",
                title: "Alimbayod Moms Celebrate Successful 2nd Halloween Trick-or-Treat!",
                date: "November 17, 2024",
                href: "pages/news.html",
            },
            {
                img: "assets/images/medical-mission.png",
                alt: "KaFuerte Medical Mission in Barangay Dinaga",
                title: "KaFuerte Medical Mission Brings Health Services to Barangay Dinaga",
                date: "June 17, 2024",
                href: "pages/news.html",
            },
            {
                img: "assets/images/restorepower.png",
                alt: "Canaman power supply restoration after typhoon",
                title: "5 of 24 Barangays in Canaman Restore Power Supply After Typhoon",
                date: "March 9, 2024",
                href: "pages/news.html",
            },
            {
                img: "assets/images/bball.png",
                alt: "Barangay Dinaga Basketball Inter-Color Tournament",
                title: "Basketball Inter-Color Tournament Kicks Off in Barangay Dinaga",
                date: "May 5, 2024",
                href: "pages/news.html",
            },
        ],
        guides: [
            {
                img: "assets/images/typhoon.jpg",
                alt: "Tropical Cyclone preparedness guide",
                title: "What to Do in Case of a Tropical Cyclone",
                date: "Emergency Guide",
                href: "pages/guides/cyclone.html",
            },
            {
                img: "assets/images/fire.jpg",
                alt: "Fire Emergency preparedness guide",
                title: "What to Do in Case of a Fire Emergency",
                date: "Emergency Guide",
                href: "pages/guides/fire.html",
            },
            {
                img: "assets/images/quake.jpg",
                alt: "Earthquake preparedness guide",
                title: "What to Do in Case of an Earthquake",
                date: "Emergency Guide",
                href: "pages/guides/earthquake.html",
            },
            {
                img: "assets/images/bag.jpg",
                alt: "Emergency Go Bag preparation guide",
                title: "How to Prepare an Emergency Go Bag",
                date: "Emergency Guide",
                href: "pages/guides/emergency-bag.html",
            },
        ],
    };

    function renderArticles(type) {
        const items = articleData[type] || articleData.news;

        buttons.forEach((btn) => {
            const isSelected = btn.dataset.category === type;
            btn.classList.toggle("active", isSelected);
            btn.setAttribute("aria-selected", String(isSelected));
        });

        container.innerHTML = items
            .map(
                (item) => `
            <a class="fa-article" href="${item.href}">
                <img class="fa-article-img" src="${item.img}" alt="${item.alt}" loading="lazy">
                <div class="fa-text-wrap">
                    <h3 class="header-text">${item.title}</h3>
                    <p class="fa-article-date">${item.date}</p>
                </div>
            </a>`
            )
            .join("");
    }

    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            renderArticles(btn.dataset.category);
        });
    });

    renderArticles("news");
}

/* --------------------------------------------------------------------------
   4. Animated Annual Census Counters (IntersectionObserver)
   -------------------------------------------------------------------------- */
function initCensusCounters() {
    const numberEls = document.querySelectorAll(".typewriter-number");
    if (numberEls.length === 0) return;

    const prefersReducedMotion =
        window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    function animateNumber(el) {
        const target = parseInt(el.dataset.target, 10) || 0;
        el.classList.add("visible");

        if (prefersReducedMotion) {
            el.textContent = target.toLocaleString();
            return;
        }

        const duration = 900;
        const startTime = performance.now();

        function step(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = Math.round(eased * target);
            el.textContent = value.toLocaleString();
            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }

        requestAnimationFrame(step);
    }

    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        animateNumber(entry.target);
                        obs.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.25 }
        );

        numberEls.forEach((el) => observer.observe(el));
    } else {
        numberEls.forEach(animateNumber);
    }
}
