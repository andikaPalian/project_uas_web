<?php
require_once BASE_PATH . '/app/models/User.php';

function showLogin() {
    require_once BASE_PATH . '/app/views/auth/login.php';
}

function handleLogin($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validasi input kosong
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "username dan password harus diisi.";
            header('Location: ?page=login');
            exit();
        }

        $user = findUserByUsername($conn, $username);

        if ($user && password_verify($password, $user['password'])) {
            // Set session error
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            // Redirect sesuai role
            if ($user['role'] === 'admin') {
                header('Location: ?page=dashboard');
            } else if ($user['role'] === 'kasir') {
                header('Location: ?page=transaksi');
            } else {
                $_SESSION['error'] = "Role tidak valid.";
                header('Location: ?page=login');
            }
        } else {
            $_SESSION['error'] = "Username atau password salah!.";
            header('Location: ?page=login');
        }
    }
}

function logout() {
    session_destroy();
    header('Location: ?page=login');
}
?>