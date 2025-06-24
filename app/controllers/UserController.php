<?php
require_once BASE_PATH . '/app/models/User.php';
function listUser($conn) {
    $users = getAllUsers($conn);
    require_once BASE_PATH . '/app/views/user/index.php';
}

function showFormTambahUser() {
    require_once BASE_PATH . '/app/views/user/create.php';
}

function simpanUser($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'kasir';

        if (trim($username) === '' || trim($password) === '') {
            $_SESSION['error'] = "Semua field harus diisi.";
            header('Location: ?page=user_tambah');
            exit;
        }

        if (findUserByUsername($conn, $username)) {
            $_SESSION['error'] = "Username sudah digunakan.";
            header('Location: ?page=user_tambah');
            exit;
        }

        $berhasil = createUser($conn, $username, $password, $role);
        $_SESSION['success'] = $berhasil ? "User berhasil ditambahkan." : "Gagal menambahkan user.";
        header('Location: ?page=user');
        exit;
    }
}

function showFormEditUser($conn, $id) {
    $user = getUserById($conn, $id);
    if (!$user) {
        $_SESSION['error'] = "User tidak ditemukan.";
        header('Location: ?page=user');
        exit;
    }

    require_once BASE_PATH . '/app/views/user/edit.php';
}

function updateUserProses($conn, $id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? '';
    }

    $berhasil = updateUser($conn, $id, $username, $password, $role);
    $_SESSION['success'] = $berhasil ? "User berhasil diubah." : "Gagal mengubah user.";
    header("Location: ?page=user");
    exit;
}

function hapusUser($conn, $id) {
    $berhasil = deleteUser($conn, $id);
    $_SESSION['success'] = $berhasil ? "User berhasil dihapus." : "Gagal menghapus user.";
    header("Location: ?page=user");
    exit;
}
?>