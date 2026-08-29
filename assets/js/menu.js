document.addEventListener('DOMContentLoaded', function () {

    const button = document.querySelector('.mobile-menu-button');
    const menu = document.querySelector('.mobile-navigation');

    if (!button || !menu) {
        return;
    }

    button.addEventListener('click', function () {

        const isOpen = menu.classList.toggle('is-open');

        button.setAttribute(
            'aria-expanded',
            isOpen ? 'true' : 'false'
        );

        button.textContent = isOpen ? '×' : '☰';

    });

});