<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjualan UMKM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="/umkm_app/public/assets/css/login.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="glass-card" data-aos="fade-up">
            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">
                    <i class="fas fa-store fa-3x text-white mb-3"></i>
                    <h1 class="h3 fw-bold mb-0 text-white">Selamat Datang!</h1>
                    <p class="text-white-50">Silakan masuk untuk melanjutkan</p>
                </div>

                <form action="?page=login_proses" method="POST">

                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger small py-2 text-center" role="alert">
                        <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    </div>
                    <?php endif; ?>

                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                      <label for="username"><i class="fas fa-user me-2"></i>Username</label>
                    </div>

                    <div class="form-floating mb-4">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                      <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold text-uppercase">Login</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>