/* ==========================================================================
   Barangay Dinaga — About Page Scripts (Gallery / Characteristics Toggle)
   ========================================================================== */

document.addEventListener("DOMContentLoaded", () => {
    const galleryPanel = document.getElementById("imageGallery");
    const characteristicsPanel = document.getElementById("textGallery");
    const galleryBtn = document.getElementById("btn-gallery");
    const characteristicsBtn = document.getElementById("btn-characteristics");

    if (!galleryPanel || !characteristicsPanel || !galleryBtn || !characteristicsBtn) {
        return;
    }

    function setActiveTab(tab) {
        const showGallery = tab === "gallery";
        galleryPanel.classList.toggle("hidden", !showGallery);
        characteristicsPanel.classList.toggle("hidden", showGallery);

        galleryBtn.classList.toggle("active", showGallery);
        galleryBtn.setAttribute("aria-selected", String(showGallery));

        characteristicsBtn.classList.toggle("active", !showGallery);
        characteristicsBtn.setAttribute("aria-selected", String(!showGallery));
    }

    galleryBtn.addEventListener("click", () => setActiveTab("gallery"));
    characteristicsBtn.addEventListener("click", () => setActiveTab("characteristics"));

    setActiveTab("gallery");
});
