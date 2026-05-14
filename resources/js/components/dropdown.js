export default function initDropdowns() {
    const triggers = document.querySelectorAll('[data-dropdown-toggle]');
    const menus = document.querySelectorAll('[data-dropdown-menu]');

    triggers.forEach((button) => {
        const selector = button.dataset.dropdownToggle;
        const menu = document.querySelector(selector);
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            menus.forEach((item) => {
                if (item !== menu) {
                    item.classList.add('hidden');
                }
            });
            menu?.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('[data-dropdown-toggle]') && !event.target.closest('[data-dropdown-menu]')) {
            menus.forEach((menu) => menu.classList.add('hidden'));
        }
    });
}
