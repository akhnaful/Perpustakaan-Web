<?php 
    include 'database.php';
    $db->connection->query("DELETE FROM tm_buku WHERE id_buku = $id_buku");
    $user->hapus($row['id']);
?>