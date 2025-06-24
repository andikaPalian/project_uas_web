<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'umkm';

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_error) {
    die('Gagal koneksi ke database: ' . $conn->connect_error);
}
?>