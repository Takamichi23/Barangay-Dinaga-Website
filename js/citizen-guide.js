/* ==========================================================================
   Barangay Dinaga — Citizen's Guides Scripts (Tabs & Accessible Accordions)
   ========================================================================== */

document.addEventListener("DOMContentLoaded", () => {
    const docBtn = document.getElementById("documentation-btn");
    const faqBtn = document.getElementById("faq-btn");
    const docPanel = document.getElementById("documentation-content");
    const faqPanel = document.getElementById("faq-content");

    if (docBtn && faqBtn && docPanel && faqPanel) {
        function setActivePanel(panel) {
            const showDocs = panel === "docs";
            docPanel.classList.toggle("hidden", !showDocs);
            faqPanel.classList.toggle("hidden", showDocs);

            docBtn.classList.toggle("active", showDocs);
            docBtn.setAttribute("aria-selected", String(showDocs));

            faqBtn.classList.toggle("active", !showDocs);
            faqBtn.setAttribute("aria-selected", String(!showDocs));
        }

        docBtn.addEventListener("click", () => setActivePanel("docs"));
        faqBtn.addEventListener("click", () => setActivePanel("faq"));

        setActivePanel("docs");
    }

    // Accessible Collapsible Accordions
    document.querySelectorAll(".collapsible-header").forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const item = trigger.closest(".collapsible");
            if (!item) return;

            const isOpen = item.classList.toggle("open");
            trigger.setAttribute("aria-expanded", String(isOpen));
        });
    });
});
