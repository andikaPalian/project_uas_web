<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sistem Penjualan UMKM</title>
  <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<div style="background:#333; color:white; padding:10px;">
  <span style="font-weight:bold;">Sistem Informasi Penjualan Produk UMKM</span>
  <span style="float:right;">Login sebagai: <?= $_SESSION['user']['username'] ?? 'Tamu' ?> |
    <a href="?page=logout" style="color:yellow;">Logout</a></span>
</div>

<div style="display:flex; min-height:100vh;">
