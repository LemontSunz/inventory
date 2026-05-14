export default function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    const open = () => {
        if (!sidebar) return;
        sidebar.classList.remove('-translate-x-full');
        sidebarBackdrop?.classList.remove('hidden');
        sidebarBackdrop?.classList.add('block');
    };

    const close = () => {
        if (!sidebar) return;
        sidebar.classList.add('-translate-x-full');
        sidebarBackdrop?.classList.add('hidden');
        sidebarBackdrop?.classList.remove('block');
    };

    sidebarToggle?.addEventListener('click', open);
    sidebarClose?.addEventListener('click', close);
    sidebarBackdrop?.addEventListener('click', close);
}
