function toggleContent(step) {
    const content = document.getElementById(`content-${step}`);
    const icon = document.getElementById(`icon-${step}`);
    const title = document.getElementById(`title-${step}`);
   
    // Define the original and active headings
    const headings = {
      1: { original: "Step 1 – Prepare the Requirements", active: "Prepare the Requirements" },
      2: { original: "Step 2 – Visit the Barangay Hall", active: "Visit the Barangay Hall" },
      3: { original: "Step 3 – Complete the Application Form", active: "Complete the Application Form" },
      4: { original: "Step 4 – Submit the Requirements", active: "Submit the Requirements" },
      5: { original: "Step 5 – Wait for Processing", active: "Wait for Processing" },
      6: { original: "Step 6 – Claim your Barangay Document", active: "Claim your Barangay Document" }
    };
    // Toggle visibility and icon
    if (content.style.display === "block") {
      content.style.display = "none";   // Hide content
      icon.innerHTML = "&gt;";          // Change icon back to ">"
      title.innerText = headings[step].original; // Reset to original heading
    } else {
      content.style.display = "block";  // Show content
      icon.innerHTML = "&darr;";        // Change icon to "v"
      title.innerText = headings[step].active; // Set active heading
    }
  }
  
  function toggleContentFAQ(faq){
    const contentfaq = document.getElementById(`content-faq-${faq}`);
    const iconfaq = document.getElementById(`icon-faq-${faq}`);
    const titlefaq = document.getElementById(`title-faq-${faq}`);
    // Define the original and active headings
    const headingsfaq = {
      7: { originalfaq: "What documents can I apply for?", activefaq: "What documents can I apply for?" },
      8: { originalfaq: "How long does it take to process my application?", activefaq: "How long does it take to process my application?" },
      9: { originalfaq: "Is there a fee for barangay documents?", activefaq: "Is there a fee for barangay documents?" },
      10: { originalfaq: "Can I apply for someone else?", activefaq: "Can I apply for someone else?" },
      11: { originalfaq: "How will I know when my document is ready?", activefaq: "How will I know when my document is ready?" },
      12: { originalfaq: "What should I do if I made a mistake on my application?", activefaq: "What should I do if I made a mistake on my application?" }
    };
    // Toggle visibility and icon
    if (contentfaq.style.display === "block") {
      contentfaq.style.display = "none";   // Hide content
      iconfaq.innerHTML = "&gt;";          // Change icon back to ">"
      titlefaq.innerText = headingsfaq[faq].originalfaq; // Reset to original heading
    } else {
      contentfaq.style.display = "block";  // Show content
      iconfaq.innerHTML = "&darr;";        // Change icon to "v"
      titlefaq.innerText = headingsfaq[faq].activefaq; // Set active heading
    }
  }
  
  
  
  
  // Get references to the buttons and content sections
  const documentationBtn = document.getElementById('documentation-btn');
  const faqBtn = document.getElementById('faq-btn');
  const documentationContent = document.getElementById('documentation-content');
  const faqContent = document.getElementById('faq-content');
  
  // Show documentation by default
  function showDocumentation() {
      documentationContent.classList.remove('hidden');
      faqContent.classList.add('hidden');
  }
  
  // Show FAQ
  function showFAQ() {
      faqContent.classList.remove('hidden');
      documentationContent.classList.add('hidden');
  }
  
  // Add event listeners to buttons
  documentationBtn.addEventListener('click', showDocumentation);
  faqBtn.addEventListener('click', showFAQ);
  
  // Call showDocumentation on page load to ensure default behavior
  showDocumentation();

  document.addEventListener("DOMContentLoaded", () => {
    // Select the dark mode button and theme link
    const btn = document.querySelector(".darkbutton");
    const theme = document.querySelector("#theme-link");

    console.log("Script loaded!"); // Debugging log

    // Ensure both the button and theme link are present
    if (btn && theme) {
        // Add an event listener to toggle between light and dark mode
        btn.addEventListener("click", function () {
            if (theme.getAttribute("href") === "CitizenGuide.css") {
                theme.setAttribute("href", "CitizenGuideDark.css"); // Switch to dark mode
                console.log("Dark mode activated"); // Debugging log
            } else {
                theme.setAttribute("href", "CitizenGuide.css"); // Switch to light mode
                console.log("Light mode activated"); // Debugging log
            }
        });
    } else {
        console.warn("Dark mode button or theme link not found on this page.");
    }
});