document.addEventListener("DOMContentLoaded", () => {
    // Select the dark mode button and theme link
    const btn = document.querySelector(".darkbutton");
    const theme = document.querySelector("#theme-link");

    console.log("Script loaded!"); // Debugging log

    // Ensure both the button and theme link are present
    if (btn && theme) {
        // Add an event listener to toggle between light and dark mode
        btn.addEventListener("click", function () {
            if (theme.getAttribute("href") === "News.css") {
                theme.setAttribute("href", "NewsDark.css"); // Switch to dark mode
                console.log("Dark mode activated"); // Debugging log
            } else {
                theme.setAttribute("href", "News.css"); // Switch to light mode
                console.log("Light mode activated"); // Debugging log
            }
        });
    } else {
        console.warn("Dark mode button or theme link not found on this page.");
    }
});