let time = document.getElementById("current-time")
let date = document.getElementById("current-date")


            setInterval(() =>{
                let d = new Date();

                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                date.innerHTML = d.toLocaleDateString(undefined, options);

                time.innerHTML = d.toLocaleTimeString();
            },1000) 

            let currentSlideIndex = 0;

function showSlide(index) {
    const slides = document.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");
    
    if (index >= slides.length) {
        currentSlideIndex = 0;
    } else if (index < 0) {
        currentSlideIndex = slides.length - 1;
    } else {
        currentSlideIndex = index;
    }
    
    slides.forEach((slide) => (slide.style.display = "none"));
    dots.forEach((dot) => dot.classList.remove("active"));
    
    slides[currentSlideIndex].style.display = "block";
    dots[currentSlideIndex].classList.add("active");
}

function changeSlide(step) {
    showSlide(currentSlideIndex + step);
}

function currentSlide(index) {
    showSlide(index);
}

setInterval(() => {
    changeSlide(1);
}, 30000);

showSlide(currentSlideIndex);

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.querySelector(".darkbutton");
    const theme = document.querySelector("#theme-link");

    console.log("Dark Mode Button:", btn);
    console.log("Theme Link:", theme);

    if (btn && theme) {
        btn.addEventListener("click", function () {
            theme.href = theme.getAttribute("href") === "light.css" ? "dark.css" : "light.css";
            console.log("Theme toggled to:", theme.href);
        });
    } else {
        console.warn("Dark mode button or theme link is missing on this page.");
    }
});

// forda buttontags switcher
function showArticles(type) {
    const articlesContainer = document.getElementById('articles');
    const buttons = document.querySelectorAll('.button-tag');
    
    buttons.forEach(button => button.classList.remove('active'));
    
    const activeButton = type === 'news' ? buttons[0] : buttons[1];
    activeButton.classList.add('active');
    
    if (type === 'news') {
        articlesContainer.innerHTML = `
            <div class="fa-article">
                <img src="img/trickortits.png" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">Alimbayod Moms Celebrate Successful 2nd Halloween Trick-or-Treat!</p>
                    <p class="detail-text" style="color: #2B2A4C;">November 17, 2024</p>
                 </div>
            </div>
            <div class="fa-article">
                <img src="img/political_dynasty_moment.png" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">KaFuerte Medical Mission Brings Health Services to Barangay Dinaga</p>
                    <p class="detail-text" style="color: #2B2A4C;">June 17, 2024</p>
                </div>
            </div>
            <div class="fa-article">
                <img src="img/restorepower.png" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">5 of 24 Barangays in Canaman Restore Power Supply After Typhoon</p>
                    <p class="detail-text" style="color: #2B2A4C;">March 9, 2024</p>
                </div>
            </div>
            <div class="fa-article">
                <img src="img/bball.png" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">Basketball Inter-Color Tournament Kicks Off in Barangay Dinaga</p>
                    <p class="detail-text" style="color: #2B2A4C;">May 5, 2024</p>
                </div>
            </div>
        `;
    } else if (type === 'guides') {
        articlesContainer.innerHTML = `
            <div class="fa-article">
                <img src="img/typhoon.jpg" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">What to do In Case of a Tropical Cyclone</p>
                    <p class="detail-text" style="color: #2B2A4C;">August 5, 2024</p>
                </div>
            </div>
            <div class="fa-article">
                <img src="img/fire.jpg" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">What to do In Case of a Fire Emergency</p>
                    <p class="detail-text" style="color: #2B2A4C;">July 12, 2024</p>
                </div>
            </div>
            <div class="fa-article">
                <img src="img/quake.jpg" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">What to do In Case of an Earthquake</p>
                    <p class="detail-text" style="color: #2B2A4C;">June 14, 2024</p>
                </div>
            </div>
            <div class="fa-article">
                <img src="img/bag.jpg" alt="">
                <div class="fa-text-wrap">
                    <p class="header-text">How to Prepare an Emergency Bag</p>
                    <p class="detail-text" style="color: #2B2A4C;">April 10, 2024</p>
                </div>
            </div>
        `;
    }
}
document.addEventListener("DOMContentLoaded", () => {
    const censusCards = document.querySelectorAll(".census");

    const isInViewport = (element) => {
        const rect = element.getBoundingClientRect();
        return (
            rect.top < (window.innerHeight || document.documentElement.clientHeight) &&
            rect.bottom > 0 &&
            rect.left < (window.innerWidth || document.documentElement.clientWidth) &&
            rect.right > 0
        );
    };

    const typewriterEffect = (element) => {
        const target = +element.getAttribute("data-target");
        const speed = 70; // Adjust speed of animation
        let current = 0;

        const updateNumber = () => {
            if (current < target) {
                const increment = Math.ceil((target - current) / speed);
                current += increment;
                element.textContent = current > target ? target : current;
                requestAnimationFrame(updateNumber);
            }
        };

        updateNumber();
    };

    const handleScroll = () => {
        censusCards.forEach((card) => {
            if (isInViewport(card) && !card.classList.contains("visible")) {
                card.classList.add("visible"); // Add visible class for the card
                const numberElement = card.querySelector(".typewriter-number");
                if (numberElement && !numberElement.classList.contains("visible")) {
                    numberElement.classList.add("visible"); // Fade in number
                    typewriterEffect(numberElement); // Start typewriter effect
                }
            }
        });
    };

    const debounce = (func, delay) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), delay);
        };
    };

    window.addEventListener("scroll", debounce(handleScroll, 100));
    handleScroll(); // Trigger scroll on load to catch visible elements
});