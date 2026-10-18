(function () {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

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

    function updateFavBadge(count) {
        const link = document.querySelector('.js-fav-link');
        if (!link) return;

        let badge = link.querySelector('.js-fav-badge');
        if (count > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'header-badge js-fav-badge';
                link.appendChild(badge);
            }
            badge.textContent = count;
            badge.style.display = '';
        } else if (badge) {
            badge.style.display = 'none';
        }
    }

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
        setTimeout(() => toast.classList.remove('cart-toast--visible'), 2500);
    }

    function updateHeartIcon(btn, isFavorite) {
        if (!btn) return;

        btn.classList.toggle('active', isFavorite);
        btn.title = isFavorite ? 'Убрать из избранного' : 'В избранное';

        const svg = btn.querySelector('svg');
        if (svg) {
            svg.setAttribute('fill', isFavorite ? 'currentColor' : 'none');
        }
    }

    /**
     * Toggle избранного (добавить/убрать).
     */
    document.addEventListener('submit', async function (e) {
        const form = e.target.closest('form[action*="favorites/toggle"]');
        if (!form) return;

        e.preventDefault();

        const productId = form.querySelector('input[name="product_id"]')?.value;
        if (!productId) return;

        const btn = form.querySelector('button[type="submit"]');

        try {
            const data = await postForm(form.action, { product_id: productId });
            updateHeartIcon(btn, data.isFavorite);
            updateFavBadge(data.count);
            showToast(data.message || 'Готово');

            // На странице /favorites — убрать карточку из списка
            const favPage = form.closest('.favorites-page');
            if (favPage && !data.isFavorite) {
                const card = form.closest('.product-card');
                if (card) card.remove();

                if (data.count === 0) {
                    setTimeout(() => location.reload(), 500);
                }
            }
        } catch (err) {
            showToast('Не удалось обновить избранное', 'error');
            console.error(err);
        }
    });

    /**
     * Очистка избранного.
     */
    document.addEventListener('submit', async function (e) {
        const form = e.target.closest('form[action*="favorites/clear"]');
        if (!form) return;

        e.preventDefault();
        if (!confirm('Очистить избранное?')) return;

        try {
            const data = await postForm(form.action, {});
            updateFavBadge(0);
            showToast(data.message || 'Избранное очищено');
            setTimeout(() => location.reload(), 400);
        } catch (err) {
            showToast('Не удалось очистить', 'error');
            console.error(err);
        }
    });
})();