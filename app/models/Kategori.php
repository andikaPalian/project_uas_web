<?php
function getAllKategori($conn) {
    $sql = "SELECT * FROM kategori_produk";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getKategoriById($conn, $id) {
    $sql = "SELECT * FROM kategori_produk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function addKategori($conn, $nama_kategori) {
    $sql = "INSERT INTO kategori_produk (nama_kategori) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_kategori);
    return $stmt->execute();
}

function updateKategori($conn, $id, $nama_kategori) {
    $sql = "UPDATE kategori_produk SET nama_kategori = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nama_kategori, $id);
    return $stmt->execute();
}

function deleteKategori($conn, $id) {
    $sql = "DELETE FROM kategori_produk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>