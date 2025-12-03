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


const btn = document.querySelector(".darkbutton");
const theme = document.querySelector("#theme-link");

btn.addEventListener("click", function() {
  if (theme.getAttribute("href") == "light.css") {
    theme.href = "dark.css";
  } else {
    theme.href = "light.css";
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

 
    document.addEventListener("DOMContentLoaded", () => {
        const navButtons = document.querySelectorAll(".navbutton");
        
        navButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Remove 'nav-active' class from all buttons
                navButtons.forEach((btn) => btn.classList.remove("nav-active"));
                
                // Add 'nav-active' class to the clicked button
                button.classList.add("nav-active");
            });
        });
    });

}
