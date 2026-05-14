export default function initDarkMode() {
    const toggle = document.getElementById('themeToggle');
    const root = document.documentElement;
    const storedTheme = localStorage.getItem('inventory-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
        root.classList.add('dark');
    }

    if (!toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isDark = root.classList.toggle('dark');
        localStorage.setItem('inventory-theme', isDark ? 'dark' : 'light');
    });
}
