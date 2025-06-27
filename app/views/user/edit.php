<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Pengguna</h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="card shadow-sm border-0" style="max-width: 600px; margin: auto;">
        <div class="card-header bg-white">
            <h5 class="card-title m-0 fw-bold">Edit Pengguna</h5>
        </div>
        <div class="card-body">
            <!-- Pesan Error -->
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>
            
            <form action="?page=user_update&id=<?= $user['id'] ?>" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="kasir" <?= $user['role'] === 'kasir' ? 'selected' : '' ?>>Kasir</option>
                    </select>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=user" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</main>