  // Show only the imageGallery and organize by year
  const imageGallery = document.getElementById('imageGallery');
  const textGallery = document.getElementById('textGallery');
  const imageBtn = document.getElementById('Gallery');
  const textBtn = document.getElementById('Physical Characteristics');
  
  imageBtn.addEventListener('click', () => {
    // Show the image gallery and hide the text gallery
    imageGallery.classList.remove('hidden');
    textGallery.classList.add('hidden');
  });
  
  textBtn.addEventListener('click', () => { 
    // Show the text gallery and hide the image gallery
    textGallery.classList.remove('hidden');
    imageGallery.classList.add('hidden');
  });
   
  document.addEventListener("DOMContentLoaded", () => {
    // Select the dark mode button and theme link
    const btn = document.querySelector(".darkbutton");
    const theme = document.querySelector("#theme-link");

    console.log("Script loaded!"); // Debugging log

    // Ensure both the button and theme link are present
    if (btn && theme) {
        // Add an event listener to toggle between light and dark mode
        btn.addEventListener("click", function () {
            if (theme.getAttribute("href") === "About.css") {
                theme.setAttribute("href", "AboutDark.css"); // Switch to dark mode
                console.log("Dark mode activated"); // Debugging log
            } else {
                theme.setAttribute("href", "About.css"); // Switch to light mode
                console.log("Light mode activated"); // Debugging log
            }
        });
    } else {
        console.warn("Dark mode button or theme link not found on this page.");
    }
});