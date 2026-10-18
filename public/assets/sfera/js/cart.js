(function () {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    /**
     * Универсальный AJAX-запрос с CSRF.
     */
    async function postForm(url, data) {
        const body = new FormData();
        for (const key in data) {
            body.append(key, data[key]);
        }

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body,
        });

        if (!response.ok) {
            const text = await response.text();
            throw new Error(text || 'Ошибка запроса');
        }

        return response.json();
    }

    /**
     * Обновить счётчик в шапке.
     */
    function updateCartBadge(count) {
        const badge = document.querySelector('.js-cart-badge');
        if (!badge) return;

        badge.textContent = count;
        badge.style.display = count > 0 ? '' : 'none';
    }

    /**
     * Показать всплывающее сообщение.
     */
    function showToast(message, type = 'success') {
        let toast = document.getElementById('cart-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'cart-toast';
            toast.className = 'cart-toast';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.className = 'cart-toast cart-toast--' + type + ' cart-toast--visible';
        setTimeout(() => {
            toast.classList.remove('cart-toast--visible');
        }, 2500);
    }

    /**
     * Добавление в корзину.
     */
    document.addEventListener('submit', async function (e) {
        const form = e.target.closest('form[action*="cart/add"], form[data-ajax-cart="add"]');
        if (!form) return;

        e.preventDefault();

        const productId = form.querySelector('input[name="product_id"]')?.value;
        if (!productId) return;

        const btn = form.querySelector('button[type="submit"]');
        const oldDisabled = btn?.disabled;
        if (btn) btn.disabled = true;

        try {
            const data = await postForm(form.action, { product_id: productId });
            updateCartBadge(data.cartCount);
            showToast(data.message || 'Добавлено');
        } catch (err) {
            showToast('Не удалось добавить', 'error');
            console.error(err);
        } finally {
            if (btn) btn.disabled = oldDisabled;
        }
    });

    /**
     * Удаление из корзины.
     */
    document.addEventListener('submit', async function (e) {
        const form = e.target.closest('form[action*="cart/remove"], form[data-ajax-cart="remove"]');
        if (!form) return;

        e.preventDefault();

        const productId = form.querySelector('input[name="product_id"]')?.value;
        const item = form.closest('.basket-item');

        try {
            const data = await postForm(form.action, { product_id: productId });
            updateCartBadge(data.cartCount);
            showToast(data.message || 'Удалено');

            if (item) item.remove();
            recalcCartTotals();

            if (data.cartCount === 0) {
                setTimeout(() => location.reload(), 400);
            }
        } catch (err) {
            showToast('Не удалось удалить', 'error');
            console.error(err);
        }
    });

    /**
     * Изменение количества +/−.
     */
    document.addEventListener('click', async function (e) {
        const btn = e.target.closest('.qty-btn');
        if (!btn) return;

        const item = btn.closest('.basket-item');
        const form = item?.querySelector('form[action*="cart/update"]');
        if (!form) return;

        e.preventDefault();

        const productId = form.querySelector('input[name="product_id"]')?.value;
        const qtyValue = item.querySelector('.qty-value');
        const currentQty = parseInt(qtyValue.textContent, 10) || 1;
        const delta = btn.classList.contains('qty-btn--plus') ? 1 : -1;
        const newQty = Math.max(1, currentQty + delta);

        if (newQty === currentQty) return;

        try {
            const data = await postForm(form.action, { product_id: productId, quantity: newQty });
            qtyValue.textContent = data.quantity;

            const sumEl = item.querySelector('.js-item-sum') || item.querySelector('.basket-item__sum');
            if (sumEl) {
                sumEl.textContent = new Intl.NumberFormat('ru-RU').format(data.sum) + ' ₽';
            }

            updateCartBadge(data.cartCount);
            recalcCartTotals();
        } catch (err) {
            showToast('Не удалось изменить количество', 'error');
            console.error(err);
        }
    });

    /**
     * Пересчёт «Товары (N)» и «Итого».
     */
    function recalcCartTotals() {
        const items = document.querySelectorAll('.basket-item');
        let totalSum = 0;
        let totalCount = 0;

        items.forEach(item => {
            const qty = parseInt(item.querySelector('.qty-value')?.textContent, 10) || 0;
            const priceUnit = parseFloat(item.dataset.price) || 0;
            totalCount += qty;
            totalSum += qty * priceUnit;
        });

        const countEl = document.querySelector('.js-total-count');
        const sumEl = document.querySelector('.js-total-sum');

        if (countEl) countEl.textContent = totalCount;
        if (sumEl) sumEl.textContent = new Intl.NumberFormat('ru-RU').format(totalSum) + ' ₽';
    }

    /**
     * Очистка корзины.
     */
    document.addEventListener('submit', async function (e) {
        const form = e.target.closest('form[action*="cart/clear"], form[data-ajax-cart="clear"]');
        if (!form) return;

        e.preventDefault();
        if (!confirm('Очистить корзину?')) return;

        try {
            const data = await postForm(form.action, {});
            updateCartBadge(0);
            showToast(data.message || 'Корзина очищена');
            setTimeout(() => location.reload(), 400);
        } catch (err) {
            showToast('Не удалось очистить', 'error');
            console.error(err);
        }
    });
})();