<?php
session_start();
include '../include/database.php';


$db = new Database("localhost", "root", "", "db_perpus006");
// $admin = new Admin($db->connection);

// if (!$admin->is_logged_in()) {
//     header('Location: login.php');
//     exit();
// }

$id = $_GET['id'];
$db->connection->query("DELETE FROM tm_buku WHERE id_buku = $id");
header('Location: ../page/kelola_buku.php');
exit();
?>
