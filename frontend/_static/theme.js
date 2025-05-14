document.addEventListener("DOMContentLoaded", function () {
    // Create theme toggle button
    const themeToggle = document.createElement('button');
    themeToggle.className = 'theme-toggle';
    themeToggle.setAttribute('aria-label', 'Alternar tema');
    themeToggle.setAttribute('title', 'Alternar tema claro/escuro');
    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
    document.body.appendChild(themeToggle);

    // Detect system preference and load saved theme
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    let currentTheme = localStorage.getItem("theme") ||
        (systemPrefersDark ? "dark" : "light");

    // Apply loaded theme
    applyTheme(currentTheme);

    // Click event to toggle theme with animation
    themeToggle.addEventListener("click", function () {
        // Disable transitions during switch to prevent flickering
        disableTransitionsTemporarily();

        currentTheme = currentTheme === "dark" ? "light" : "dark";
        localStorage.setItem("theme", currentTheme);

        applyTheme(currentTheme);

        // Click effect
        this.style.transform = 'scale(0.9)';
        setTimeout(() => {
            this.style.transform = '';
        }, 200);
    });

    // Watch for system preference changes
    const colorSchemeQuery = window.matchMedia('(prefers-color-scheme: dark)');
    colorSchemeQuery.addEventListener('change', e => {
        if (!localStorage.getItem("theme")) { // Only change if user hasn't set preference
            const newTheme = e.matches ? "dark" : "light";
            applyTheme(newTheme);
        }
    });

    // Function to temporarily disable transitions
    function disableTransitionsTemporarily() {
        const elements = document.querySelectorAll('*');
        elements.forEach(el => {
            el.style.transition = 'none';
        });

        setTimeout(() => {
            elements.forEach(el => {
                el.style.transition = '';
            });
        }, 10);
    }
});

function applyTheme(theme) {
    document.body.classList.remove("light", "dark");
    document.body.classList.add(theme);
    updateThemeIcon(theme);

    // Add class for specific animations
    document.body.classList.add('theme-changing');
    setTimeout(() => {
        document.body.classList.remove('theme-changing');
    }, 400);

    // Update meta theme color
    updateMetaThemeColor(theme);
}

function updateThemeIcon(theme) {
    const icon = document.querySelector('.theme-toggle i');
    if (icon) {
        // Remove all possible icon classes
        icon.className = '';
        icon.classList.add('fas', theme === "dark" ? 'fa-sun' : 'fa-moon');

        // Add animation
        icon.style.animation = 'none';
        setTimeout(() => {
            icon.style.animation = '';
        }, 10);
    }
}

function updateMetaThemeColor(theme) {
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    if (!metaThemeColor) {
        metaThemeColor = document.createElement('meta');
        metaThemeColor.name = "theme-color";
        document.head.appendChild(metaThemeColor);
    }

    metaThemeColor.content = theme === "dark" ? '#121212' : '#ffffff';
}