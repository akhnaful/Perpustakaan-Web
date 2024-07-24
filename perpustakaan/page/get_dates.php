<?php
include 'database.php'; // Include your database connection

$idPeminjaman = $_GET['id_peminjaman'];
$sql = "SELECT tanggal_pinjam, tanggal_kembali FROM tm_peminjaman WHERE id_peminjaman = '$idPeminjaman'";
$result = $db->connection->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([]);
}
?>
