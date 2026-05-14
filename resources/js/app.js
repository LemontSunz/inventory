const sidebar = document.getElementById('sidebar');
const sidebarBackdrop = document.getElementById('sidebarBackdrop');
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebarClose = document.getElementById('sidebarClose');
const globalSearch = document.getElementById('globalSearch');
const inventoryTable = document.getElementById('inventoryTable');

function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    sidebarBackdrop.classList.remove('hidden');
    sidebarBackdrop.classList.add('block', 'opacity-100');
}

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    sidebarBackdrop.classList.add('hidden');
    sidebarBackdrop.classList.remove('block', 'opacity-100');
}

if (sidebarToggle) {
    sidebarToggle.addEventListener('click', openSidebar);
}

if (sidebarClose) {
    sidebarClose.addEventListener('click', closeSidebar);
}

if (sidebarBackdrop) {
    sidebarBackdrop.addEventListener('click', closeSidebar);
}

if (globalSearch && inventoryTable) {
    globalSearch.addEventListener('input', (event) => {
        const value = event.target.value.toLowerCase().trim();
        const rows = inventoryTable.querySelectorAll('tr');

        rows.forEach((row) => {
            const tags = row.dataset.tags || '';
            const columns = row.textContent.toLowerCase();
            const visible = value === '' || tags.includes(value) || columns.includes(value);
            row.style.display = visible ? '' : 'none';
        });
    });
}

