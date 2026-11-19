/* ==========================================================================
   Barangay Dinaga — Shared Site Behavior (Theme Persistence & Navigation)
   ========================================================================== */

(() => {
    const THEME_KEY = "dinaga-theme";

    function getStoredTheme() {
        try {
            return localStorage.getItem(THEME_KEY);
        } catch {
            return null;
        }
    }

    function saveTheme(theme) {
        try {
            localStorage.setItem(THEME_KEY, theme);
        } catch {
            // Ignore storage errors in restricted contexts
        }
    }

    function applyTheme(theme) {
        const isDark = theme === "dark";
        if (isDark) {
            document.documentElement.setAttribute("data-theme", "dark");
        } else {
            document.documentElement.removeAttribute("data-theme");
        }

        const toggleBtn = document.querySelector(".darkbutton");
        if (toggleBtn) {
            toggleBtn.setAttribute("aria-pressed", String(isDark));
            const label = isDark ? "Switch to Light Mode" : "Switch to Dark Mode";
            toggleBtn.setAttribute("aria-label", label);
            toggleBtn.setAttribute("data-tooltip", isDark ? "Light Mode" : "Dark Mode");
            toggleBtn.setAttribute("title", label);

            const icon = toggleBtn.querySelector("i");
            if (icon) {
                icon.className = isDark ? "fi fi-rr-brightness" : "fi fi-rr-dark-mode-alt";
            }
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const stored = getStoredTheme();
        const prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
        const initialTheme = stored || (prefersDark ? "dark" : "light");
        applyTheme(initialTheme);

        const toggleBtn = document.querySelector(".darkbutton");
        if (toggleBtn) {
            toggleBtn.addEventListener("click", () => {
                const currentlyDark = document.documentElement.getAttribute("data-theme") === "dark";
                const nextTheme = currentlyDark ? "light" : "dark";
                applyTheme(nextTheme);
                saveTheme(nextTheme);
            });
        }

        // Smooth scroll to top for any back-to-top links
        document.querySelectorAll('a[href="#top"]').forEach((link) => {
            link.addEventListener("click", (event) => {
                event.preventDefault();
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
    });
})();
