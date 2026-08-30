document.addEventListener('DOMContentLoaded', function () {

    const storageKey = 'ssi-fanzine-theme-mode';
    const themeToggle = document.querySelector('.theme-toggle');
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedMode = localStorage.getItem(storageKey);

    const setThemeMode = function (mode) {

        document.documentElement.dataset.theme = mode;

        if (!themeToggle) {
            return;
        }

        const isDark = mode === 'dark';

        themeToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
        themeToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');

    };

    setThemeMode(savedMode || (prefersDark ? 'dark' : 'light'));

    if (themeToggle) {

        themeToggle.addEventListener('click', function () {

            const currentMode = document.documentElement.dataset.theme === 'dark' ? 'dark' : 'light';
            const nextMode = currentMode === 'dark' ? 'light' : 'dark';

            localStorage.setItem(storageKey, nextMode);
            setThemeMode(nextMode);

        });

    }

    const buttons = document.querySelectorAll('.mobile-menu-button, .bottom-menu-toggle');
    const menu = document.querySelector('.mobile-navigation');

    if (!buttons.length || !menu) {
        return;
    }

    const setMenuState = function (isOpen) {

        menu.classList.toggle('is-open', isOpen);

        buttons.forEach(function (button) {

            button.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

            button.setAttribute(
                'aria-label',
                isOpen ? 'Close menu' : 'Open menu'
            );

        });

    };

    buttons.forEach(function (button) {

        button.addEventListener('click', function () {

            setMenuState(!menu.classList.contains('is-open'));

        });

    });

});
