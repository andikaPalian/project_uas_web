<?php
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<style>
    .pos-layout {
        height: calc(100vh - 150px);
    }
    .product-list-container, .cart-container {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-list {
        flex-grow: 1;
        overflow-y: auto;
    }
    .cart-items {
        flex-grow: 1;
        overflow-y: auto;
    }
    .product-card {
        cursor: pointer;
        transition: transform 0.1s ease, box-shadow 0.1s ease;
    }
    .product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Point of Sale (POS)</h4>
        <div class="d-flex align-items-center">
            <a href="?page=transaksi" class="btn btn-secondary me-2"><i class="fas fa-history me-1"></i> Riwayat</a>
        </div>
    </div>
</nav>

<main class="container-fluid">
    <form action="?page=transaksi_simpan" method="POST" id="transaction-form">
        <div id="cart-hidden-inputs"></div>

        <div class="row pos-layout">
            <div class="col-md-7 h-100">
                <div class="card shadow-sm border-0 h-100 product-list-container">
                    <div class="card-header bg-white p-3">
                        <input type="text" id="product-search" class="form-control" placeholder="Cari produk...">
                    </div>
                    <div class="card-body product-list">
                        <div class="row g-3" id="product-container">
                            <?php if (empty($produk)): ?>
                                <p class="text-center text-muted mt-5">Tidak ada produk yang tersedia.</p>
                            <?php else: ?>
                                <?php foreach ($produk as $p): ?>
                                    <div class="col-6 col-lg-4 col-xl-3 product-item" data-name="<?= strtolower(htmlspecialchars($p['nama'])) ?>">
                                        <div class="card h-100 product-card" onclick="addToCart(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['nama'])) ?>', <?= $p['harga'] ?>, <?= $p['stok'] ?>)">
                                            <img src="<?= !empty($p['gambar']) ? 'uploads/produk/' . htmlspecialchars($p['gambar']) : 'https://placehold.co/300x200/eef2f5/9da5b5?text=N/A' ?>" class="card-img-top" style="height: 100px; object-fit: cover;" alt="<?= htmlspecialchars($p['nama']) ?>">
                                            <div class="card-body p-2 text-center">
                                                <div class="fw-bold small"><?= htmlspecialchars($p['nama']) ?></div>
                                                <small class="text-muted">Stok: <?= $p['stok'] ?></small><br>
                                                <strong class="text-primary small">Rp<?= number_format($p['harga'], 0, ',', '.') ?></strong>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 h-100">
                <div class="card shadow-sm border-0 h-100 cart-container">
                    <div class="card-header bg-white p-3">
                        <h5 class="m-0 fw-bold"><i class="fas fa-shopping-cart me-2"></i>Keranjang</h5>
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <div id="cart-items" class="cart-items mb-3"></div>
                        <div class="mt-auto">
                           <hr>
                           <div class="d-flex justify-content-between align-items-center">
                                <h4 class="m-0">Total:</h4>
                                <h4 class="m-0 fw-bold" id="cart-total">Rp0</h4>
                           </div>
                           <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary fw-bold" id="submit-transaction">Simpan Transaksi</button>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<script>
    const cart = {};

    function addToCart(id, name, price, stock) {
        if (stock <= 0) {
            alert(`Stok produk ${name} habis.`);
            return;
        }
        if (cart[id] && cart[id].qty >= stock) {
            alert(`Stok produk ${name} tidak mencukupi.`);
            return;
        }

        if (cart[id]) {
            cart[id].qty++;
        } else {
            cart[id] = { name, price, qty: 1, stock };
        }
        renderCart();
    }

    function updateQuantity(id, change) {
        if (cart[id]) {
            cart[id].qty += change;
            if (cart[id].qty <= 0) {
                delete cart[id];
            }
        }
        renderCart();
    }

    function renderCart() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalEl = document.getElementById('cart-total');
    const hiddenInputsContainer = document.getElementById('cart-hidden-inputs');
    const submitButton = document.getElementById('submit-transaction');

    cartItemsContainer.innerHTML = '';
    hiddenInputsContainer.innerHTML = '';
    let total = 0;

    if (Object.keys(cart).length === 0) {
        cartItemsContainer.innerHTML = `<div class="text-center text-muted mt-5"><i class="fas fa-shopping-basket fa-3x mb-2"></i><p>Keranjang masih kosong</p></div>`;
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
        for (const id in cart) {
            const item = cart[id];
            const price = Math.round(item.price); // pastikan harga integer
            const subtotal = price * item.qty;
            total += subtotal;

            const itemEl = document.createElement('div');
            itemEl.className = 'd-flex justify-content-between align-items-center mb-2';
            itemEl.innerHTML = `
                <div>
                    <div class="fw-bold">${item.name}</div>
                    <small class="text-muted">Rp${price.toLocaleString('id-ID')}</small>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${id}, -1)">-</button>
                    <span class="mx-2">${item.qty}</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${id}, 1)" ${item.qty >= item.stock ? 'disabled' : ''}>+</button>
                </div>
            `;
            cartItemsContainer.appendChild(itemEl);

            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = 'produk_id[]';
            hiddenId.value = id;

            const hiddenQty = document.createElement('input');
            hiddenQty.type = 'hidden';
            hiddenQty.name = 'jumlah[]';
            hiddenQty.value = item.qty;

            hiddenInputsContainer.appendChild(hiddenId);
            hiddenInputsContainer.appendChild(hiddenQty);
        }
    }

    cartTotalEl.innerText = `Rp${total.toLocaleString('id-ID')}`;
}
    
    document.addEventListener('DOMContentLoaded', renderCart);

    document.getElementById('product-search').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            item.style.display = item.dataset.name.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
