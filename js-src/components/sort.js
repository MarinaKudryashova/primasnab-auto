document.addEventListener('DOMContentLoaded', function() {
    const wcSelect = document.querySelector('select.orderby[name="orderby"]');
    if (!wcSelect) return;

    const sortBtn = document.querySelector('[data-sort-btn]');
    const sortMenu = document.querySelector('[data-sort-menu]');
    const sortValue = document.querySelector('[data-sort-value]');
    if (!sortBtn || !sortMenu || !sortValue) return;

    const valueMap = {
        'default': 'menu_order',
        'price-asc': 'price',
        'price-desc': 'price-desc'
    };
    const reverseMap = {
        'menu_order': 'default',
        'price': 'price-asc',
        'price-desc': 'price-desc'
    };

    function updateSortText() {
        const currentValue = wcSelect.value;
        const selectedOption = wcSelect.querySelector('option[value="' + currentValue + '"]');
        if (selectedOption) {
            sortValue.textContent = selectedOption.textContent;
        } else {
            sortValue.textContent = 'По умолчанию';
        }
        const mapped = reverseMap[currentValue] || 'default';
        sortBtn.setAttribute('data-sort-value', mapped);
    }

    updateSortText();

    sortBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = sortMenu.classList.toggle('is-open');
        sortBtn.setAttribute('aria-expanded', isOpen);
        sortMenu.setAttribute('aria-hidden', !isOpen);
    });

    document.addEventListener('click', function(e) {
        if (!sortBtn.contains(e.target) && !sortMenu.contains(e.target)) {
            sortMenu.classList.remove('is-open');
            sortBtn.setAttribute('aria-expanded', 'false');
            sortMenu.setAttribute('aria-hidden', 'true');
        }
    });

    const items = sortMenu.querySelectorAll('[role="option"]');
    items.forEach(function(item) {
        item.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const text = this.textContent.trim();
            const selectValue = valueMap[value] || 'menu_order';

            sortValue.textContent = text;
            sortBtn.setAttribute('data-sort-value', value);

            sortMenu.classList.remove('is-open');
            sortBtn.setAttribute('aria-expanded', 'false');
            sortMenu.setAttribute('aria-hidden', 'true');

            const url = new URL(window.location.href);
            url.searchParams.set('orderby', selectValue);
            url.searchParams.delete('paged');
            window.location.href = url.toString();
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sortMenu.classList.contains('is-open')) {
            sortMenu.classList.remove('is-open');
            sortBtn.setAttribute('aria-expanded', 'false');
            sortMenu.setAttribute('aria-hidden', 'true');
        }
    });

    const filterItems = document.querySelectorAll('.wcapf-active-filter-item');
    filterItems.forEach(function(btn) {
        const textSpan = btn.querySelector('.wcapf-nav-item-text');
        if (textSpan && textSpan.textContent.trim().indexOf('Сортировка по:') === 0) {
            btn.remove();
        }
    });
});

// Перехватываем клик по кнопке "Сбросить фильтры"
const resetBtn = document.querySelector('.wcapf-reset-filters-btn');
if (resetBtn) {
    resetBtn.addEventListener('click', function(e) {
        const clearUrl = this.getAttribute('data-clear-filter-url');
        if (clearUrl) {
            e.preventDefault();
            const url = new URL(clearUrl, window.location.origin);
            url.searchParams.delete('orderby');
            window.location.href = url.toString();
        }
    });
}