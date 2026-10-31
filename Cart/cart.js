document.addEventListener('DOMContentLoaded', () => {
    const cartTable = document.getElementById('cart-item');
    const subtotalResult = document.getElementById('subtotal');

    if (!subtotalResult) {
        console.error("Subtotal element not found!");
        return;
    }

    cartTable.addEventListener('click', (e) => {
        const action = e.target.dataset.action;
        if (!action) return;

        const row = e.target.closest('tr');
        const cartID = row.dataset.id;
        const price = parseFloat(row.dataset.price);
        const qtyElem = row.querySelector('.qty');
        let quantity = parseInt(qtyElem.textContent);

        if (action === 'plus') quantity++;
        else if (action === 'minus') quantity = Math.max(0, quantity - 1);
        else if (action === 'delete') quantity = 0;

        // AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'updateCart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const res = JSON.parse(xhr.responseText);
                if (res.success) {
                    if (quantity === 0) {
                        row.remove();
                    } else {
                        qtyElem.textContent = quantity;
                        row.querySelector('.total').textContent = 'RM' + (quantity * price).toFixed(2);
                    }
                    subtotalResult.textContent = 'RM' + parseFloat(res.subtotal).toFixed(2);

                    // if cart becomes empty, reload page to show "No items" message
                    if (document.querySelectorAll('#cart-item tr').length === 0) {
                        location.reload();
                    }
                } else {
                    console.error(res.message);
                    alert('Update failed!');
                }
            } else {
                console.error('Request failed');
            }
        };

        xhr.send(`cartID=${cartID}&action=${action}&quantity=${quantity}`);
    });
});
