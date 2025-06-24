<!-- Sidebar -->
<div style="width:200px; background:#f4f4f4; padding:15px;">
  <h4>Menu</h4>
  <ul style="list-style:none; padding:0;">
    <li><a href="?page=dashboard">🏠 Dashboard</a></li>
    
    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
      <li><a href="?page=produk">📦 Kelola Produk</a></li>
      <li><a href="?page=kategori">🗂️ Kategori</a></li>
      <li><a href="?page=user">👤 Kelola User</a></li>
    <?php endif; ?>

    <?php if (in_array($_SESSION['user']['role'], ['admin', 'kasir'])): ?>
        <li><a href="?page=transaksi">🧾 Transaksi</a></li>
    <?php endif; ?>
  </ul>
</div>

<!-- Main Content Start -->
<div style="flex:1; padding:20px;">
