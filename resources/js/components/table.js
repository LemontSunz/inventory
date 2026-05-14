export default function initTableSearch() {
    document.querySelectorAll('[data-table-search]').forEach((searchField) => {
        const tableId = searchField.dataset.tableSearch;
        const table = document.getElementById(tableId);
        if (!table) {
            return;
        }

        searchField.addEventListener('input', (event) => {
            const query = event.target.value.toLowerCase().trim();
            table.querySelectorAll('tbody tr').forEach((row) => {
                const text = row.textContent.toLowerCase();
                const tags = (row.dataset.tags || '').toLowerCase();
                row.style.display = query === '' || text.includes(query) || tags.includes(query) ? '' : 'none';
            });
        });
    });
}
