(() => {
    const products = new Map();
    const cart = new Map();
    const cartCount = document.querySelector('[data-cart-count]');
    const drawerCount = document.querySelector('[data-drawer-count]');
    const cartTotal = document.querySelector('[data-cart-total]');
    const cartItems = document.querySelector('[data-cart-items]');
    const drawer = document.querySelector('[data-cart-drawer]');
    const backdrop = document.querySelector('[data-cart-backdrop]');
    const checkoutButton = document.querySelector('[data-checkout]');
    const menuToggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('#main-navigation');
    const currency = new Intl.NumberFormat('en-GH', {
        maximumFractionDigits: 0,
    });
    let lastFocusedElement = null;

    document.querySelectorAll('[data-add-to-cart]').forEach((button, index) => {
        products.set(String(index), {
            name: button.dataset.name,
            price: Number(button.dataset.price),
        });
    });

    function itemCount() {
        let count = 0;
        cart.forEach((quantity) => {
            count += quantity;
        });
        return count;
    }

    function showToast(message) {
        let toast = document.querySelector('[data-shop-toast]');

        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'shop-toast';
            toast.dataset.shopToast = '';
            toast.setAttribute('role', 'status');
            toast.setAttribute('aria-live', 'polite');
            document.body.append(toast);
        }

        toast.textContent = message;
        toast.classList.add('is-visible');
        window.clearTimeout(showToast.timeout);
        showToast.timeout = window.setTimeout(() => {
            toast.classList.remove('is-visible');
        }, 2400);
    }

    function renderCart() {
        const count = itemCount();
        let total = 0;

        cartCount.textContent = String(count);
        drawerCount.textContent = `(${count})`;
        cartItems.replaceChildren();

        if (count === 0) {
            const emptyMessage = document.createElement('p');
            emptyMessage.className = 'empty-cart';
            emptyMessage.textContent = 'Your cart is waiting for the right tires.';
            cartItems.append(emptyMessage);
        } else {
            cart.forEach((quantity, id) => {
                const product = products.get(id);
                if (!product) {
                    return;
                }

                total += product.price * quantity;
                const item = document.createElement('article');
                item.className = 'cart-item';

                const details = document.createElement('div');
                const name = document.createElement('p');
                name.className = 'cart-item-name';
                name.textContent = product.name;
                const price = document.createElement('p');
                price.className = 'cart-item-price';
                price.textContent = `GH₵ ${currency.format(product.price)} each`;
                details.append(name, price);

                const controls = document.createElement('div');
                controls.className = 'cart-item-controls';
                const decrease = document.createElement('button');
                decrease.type = 'button';
                decrease.dataset.cartAction = 'decrease';
                decrease.dataset.productId = id;
                decrease.setAttribute('aria-label', `Remove one ${product.name}`);
                decrease.textContent = '−';
                const quantityLabel = document.createElement('span');
                quantityLabel.textContent = String(quantity);
                const increase = document.createElement('button');
                increase.type = 'button';
                increase.dataset.cartAction = 'increase';
                increase.dataset.productId = id;
                increase.setAttribute('aria-label', `Add one ${product.name}`);
                increase.textContent = '+';
                controls.append(decrease, quantityLabel, increase);

                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'cart-item-remove';
                remove.dataset.cartAction = 'remove';
                remove.dataset.productId = id;
                remove.textContent = 'Remove';
                item.append(details, controls, remove);
                cartItems.append(item);
            });
        }

        cartTotal.textContent = `GH₵ ${currency.format(total)}`;
        checkoutButton.disabled = count === 0;
    }

    function openCart() {
        lastFocusedElement = document.activeElement;
        drawer.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        drawer.removeAttribute('inert');
        backdrop.hidden = false;
        document.body.classList.add('cart-is-open');
        drawer.querySelector('[data-close-cart]').focus();
    }

    function closeCart() {
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        drawer.setAttribute('inert', '');
        backdrop.hidden = true;
        document.body.classList.remove('cart-is-open');
        if (lastFocusedElement instanceof HTMLElement) {
            lastFocusedElement.focus();
        }
    }

    document.querySelectorAll('[data-add-to-cart]').forEach((button, index) => {
        button.addEventListener('click', () => {
            const id = String(index);
            cart.set(id, (cart.get(id) || 0) + 1);
            renderCart();
            showToast(`${products.get(id).name} added to your cart.`);
        });
    });

    document.querySelector('[data-open-cart]').addEventListener('click', openCart);
    document.querySelector('[data-close-cart]').addEventListener('click', closeCart);
    backdrop.addEventListener('click', closeCart);

    cartItems.addEventListener('click', (event) => {
        const button = event.target.closest('[data-cart-action]');
        if (!button) {
            return;
        }

        const id = button.dataset.productId;
        const quantity = cart.get(id) || 0;

        if (button.dataset.cartAction === 'increase') {
            cart.set(id, quantity + 1);
        } else if (button.dataset.cartAction === 'decrease' && quantity > 1) {
            cart.set(id, quantity - 1);
        } else {
            cart.delete(id);
        }

        renderCart();
    });

    checkoutButton.addEventListener('click', () => {
        if (cart.size === 0) {
            return;
        }

        const lines = ['Hello, I would like to order:'];
        let total = 0;
        cart.forEach((quantity, id) => {
            const product = products.get(id);
            if (product) {
                lines.push(`${quantity} x ${product.name} - GH₵ ${currency.format(product.price * quantity)}`);
                total += product.price * quantity;
            }
        });
        lines.push(`Total: GH₵ ${currency.format(total)}`);
        window.location.href = `https://wa.me/233244603485?text=${encodeURIComponent(lines.join('\n'))}`;
    });

    menuToggle.addEventListener('click', () => {
        const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
        menuToggle.setAttribute('aria-expanded', String(!isOpen));
        navigation.classList.toggle('is-open', !isOpen);
    });

    navigation.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            menuToggle.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('is-open');
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && drawer.classList.contains('is-open')) {
            closeCart();
        }
    });

    renderCart();
})();
