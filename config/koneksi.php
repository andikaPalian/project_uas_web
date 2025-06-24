<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'umkm';

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connection_error) {
    die('Gagal koneksi ke database: ' . $conn->connection_error);
}
?>