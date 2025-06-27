<?php
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
         <h4 class="m-0 fw-bold">
            <a href="?page=kategori" class="text-dark text-decoration-none">Edit Kategori</a>
        </h4>
    </div>
</nav>

<main class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="card-title m-0 fw-bold">Edit Kategori</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    </div>
                    <?php endif; ?>
                    
                    <form action="?page=kategori_update&id=<?= $kategori['id'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= htmlspecialchars($kategori['nama_kategori']) ?>" required autofocus>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="?page=kategori" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
