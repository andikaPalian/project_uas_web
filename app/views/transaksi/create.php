<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<style>
    /* Style untuk membuat daftar produk bisa di-scroll */
    .product-list {
        max-height: 65vh;
        overflow-y: auto;
    }
    .cart-items {
        max-height: 50vh;
        overflow-y: auto;
    }
</style>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Point of Sale (POS)</h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <form action="?page=transaksi_simpan" method="POST" id="transaction-form">
        <div id="cart-hidden-inputs"></div>

        <div class="row">
            <!-- Kolom Kiri: Daftar Produk -->
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <input type="text" id="product-search" class="form-control" placeholder="Cari produk berdasarkan nama...">
                    </div>
                    <div class="card-body product-list">
                        <div class="row" id="product-container">
                            <?php if (empty($produk)): ?>
                                <p class="text-center text-muted">Tidak ada produk yang tersedia.</p>
                            <?php else: ?>
                                <?php foreach ($produk as $p): ?>
                                    <div class="col-md-4 mb-3 product-item" data-name="<?= strtolower(htmlspecialchars($p['nama'])) ?>">
                                        <button type="button" class="btn btn-outline-secondary w-100 h-100 text-start" 
                                                onclick="addToCart(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['nama'])) ?>', <?= $p['harga'] ?>, <?= $p['stok'] ?>)">
                                            <div class="fw-bold"><?= htmlspecialchars($p['nama']) ?></div>
                                            <small class="text-muted">Stok: <?= $p['stok'] ?></small><br>
                                            <strong class="text-primary">Rp<?= number_format($p['harga'], 0, ',', '.') ?></strong>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Keranjang Belanja -->
            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="m-0 fw-bold"><i class="fas fa-shopping-cart me-2"></i>Keranjang</h5>
                    </div>
                    <div class="card-body">
                        <!-- FIX: Kontainer item keranjang dikosongkan, pesan default dibuat dinamis -->
                        <div id="cart-items" class="cart-items mb-3"></div>
                        <hr>
                        <h4>Total: <span class="float-end fw-bold" id="cart-total">Rp0</span></h4>
                    </div>
                    <div class="card-footer bg-white d-grid">
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Transaksi</button>
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
        
        // Selalu kosongkan kontainer setiap kali render ulang
        cartItemsContainer.innerHTML = '';
        hiddenInputsContainer.innerHTML = ''; 
        let total = 0;

        // FIX: Cek jika keranjang kosong, lalu buat pesan secara dinamis
        if (Object.keys(cart).length === 0) {
            const emptyMsg = document.createElement('p');
            emptyMsg.className = 'text-center text-muted';
            emptyMsg.textContent = 'Keranjang masih kosong.';
            cartItemsContainer.appendChild(emptyMsg);
        } else {
            for (const id in cart) {
                const item = cart[id];
                total += item.price * item.qty;

                const itemEl = document.createElement('div');
                itemEl.className = 'd-flex justify-content-between align-items-center mb-2';
                itemEl.innerHTML = `
                    <div>
                        <div class="fw-bold">${item.name}</div>
                        <small class="text-muted">Rp${item.price.toLocaleString('id-ID')}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${id}, -1)">-</button>
                        <span class="mx-2">${item.qty}</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${id}, 1)" ${item.qty >= item.stock ? 'disabled' : ''}>+</button>
                    </div>
                `;
                cartItemsContainer.appendChild(itemEl);

                // Buat hidden inputs untuk form
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
    
    // Panggil renderCart() saat halaman pertama kali dimuat untuk menampilkan pesan "Keranjang kosong"
    document.addEventListener('DOMContentLoaded', renderCart);

    // Fungsi Search
    document.getElementById('product-search').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            if (item.dataset.name.includes(searchTerm)) {
                item.style.display = ''; 
            } else {
                item.style.display = 'none';
            }
        });
    });

</script>