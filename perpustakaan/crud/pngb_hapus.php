<?php
session_start();
include '../include/database.php';

$db = new Database("localhost", "root", "", "db_perpus006");
// $admin = new Admin($db->connection);

// if (!$admin->is_logged_in()) {
//     header('Location: login.php');
//     exit();
// }

if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];

    // Query untuk menghapus data pengembalian berdasarkan id_peminjaman
    $query = "DELETE FROM tm_pengembalian WHERE id_peminjaman = ?";
    $stmt = $db->connection->prepare($query);
    $stmt->bind_param("i", $id_peminjaman);

    if ($stmt->execute()) {
        echo "<script>alert('Pengembalian berhasil dihapus.'); window.location.href='../page/kelola_pengembalian.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pengembalian.'); window.location.href='../page/kelola_pengembalian.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ID Peminjaman tidak ditemukan.'); window.location.href='../page/kelola_pengembalian.php';</script>";
}

$db->connection->close();
?>
