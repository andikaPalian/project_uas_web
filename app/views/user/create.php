<?php
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">
            <a href="?page=user" class="text-dark text-decoration-none">Tambah Pengguna</a>
        </h4>
    </div>
</nav>

<main class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="card-title m-0 fw-bold">Formulir Pengguna Baru</h5>
                </div>
                <div class="card-body">
                    <!-- Pesan Error -->
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    </div>
                    <?php endif; ?>

                    <form action="?page=user_simpan" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="kasir" selected>Kasir</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="?page=user" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
