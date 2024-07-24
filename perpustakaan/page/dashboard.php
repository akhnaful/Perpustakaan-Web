<?php
session_start();
include '../include/database.php';

$db = new Database("localhost", "root", "", "db_perpus006");
$admin = new Admin($db->connection);

// if (!$admin->is_logged_in()) {
//     header('Location: login.php');
//     exit();
// }

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../aset/style.css">
</head>
<body>
<?php include "../include/nav.php" ?>

<div class="content">
    <div class="col">
        <h1 class="mt-5" style="color:#D9CEAC">Dashboard Admin</h1>
        <?php  include "../include/time.php"   ?>
    </div>
    <div class="row warnafont">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body ">
                    <h5 class="card-title"><i class="fas fa-book"></i> Buku</h5>
                    <p class="card-text">Kelola buku di perpustakaan.</p>
                    <a href="kelola_buku.php" class="btn btn-primary">Kelola Buku</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-graduate"></i> Mahasiswa</h5>
                    <p class="card-text">Kelola data mahasiswa.</p>
                    <a href="kelola_mhs.php" class="btn btn-primary">Kelola Mahasiswa</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-handshake"></i> Peminjaman dan Pengembalian</h5>
                    <p class="card-text">Kelola transaksi peminjaman dan pengembalian buku.</p>
                    <a href="kelola_peminjam.php" class="btn btn-primary">Kelola Peminjaman</a>
                    <a href="kelola_pengembalian.php" class="btn btn-primary">Kelola Pengembalian</a>
                </div>
            </div>
        </div>

    </div>
    <!-- list -->
    <div class="row warnafont">
    <div class="col-md-6">
        <div class="mb-4 card">
            <h3 class="px-2 py-2">Daftar Mahasiswa</h3>
            <div class="scrollable-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No Anggota</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $db->connection->query("SELECT * FROM tm_mahasiswa");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['nim'] . "</td>";
                        echo '<td><a href="../crud/mhs_edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary">Edit</a></td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-4 card">
            <h3 class="px-2 py-2">Daftar buku</h3>
            <div class="scrollable-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Buku</th>
                        <th>Judul Buku</th>
                        <th>Nama Penulis </th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $db->connection->query("SELECT * FROM tm_buku");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_buku'] . "</td>";
                        echo "<td>" . $row['judul'] . "</td>";
                        echo "<td>" . $row['penulis'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo '<td><a href="../crud/buku_edit.php?id=' . $row['id_buku'] . '" class="btn btn-sm btn-primary">Edit</a></td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
