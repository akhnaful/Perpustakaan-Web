<?php
session_start();
include '../include/database.php';

$db = new Database("localhost", "root", "", "db_perpus006");
$admin = new Admin($db->connection);

// if (!$admin->is_logged_in()) {
//     header('Location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../aset/style.css">
</head>
<body>
<?php include "../include/nav.php" ?>

    <div class="content">
    <div class="row mt-5 justify-content-between">
        <div class="col-4">
            <h1 style="color:#D9CEAC">Pengelola Buku Perpustakaan</h1>
        </div>
        <div class="col-4 ">
            <?php include "../include/time.php"; ?>
        </div>
    </div>
    <div class="row warnafont">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body ">
                    <h5 class="card-title"><i class="fas fa-book"></i> Tambah Buku</h5>
                    <p class="card-text">Tambah buku perpustakaan.</p>
                    <a href="../crud/buku_tambah.php" class="btn btn-primary">Tambah Buku</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-graduate"></i> Main Form Buku</h5>
                    <p class="card-text">Form utama dari data buku.</p>
                    <a href="../form/form_buku.php" class="btn btn-primary">Form Buku</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-book"></i> Total Jumlah Buku</h5>
                    <p class="card-text py-2" style="font-size: 2.5rem;"><strong>
                    <?php 
                    $result = $db->connection->query("SELECT COUNT(*) as total FROM tm_buku");
                    $row = $result->fetch_assoc();
                    echo $row['total'];
                    ?></strong>
                    </p>
                </div>
            </div>
        </div>

    <!-- list -->

    <div class="col-md-12">
        <div class="mb-4 card">
            <h3 class="px-2 py-2">Daftar Buku</h3>
            <div class="scrollable-table">
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th>ID Buku</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $result = $db->connection->query("SELECT * FROM tm_buku");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_buku'] . "</td>";
                        echo "<td>" . $row['judul'] . "</td>";
                        echo "<td>" . $row['penulis'] . "</td>";
                        echo "<td>" . $row['tahun_terbit'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>
                            <a href='../crud/buku_edit.php?id=" . $row['id_buku'] . "' class='btn btn-sm btn-primary'>Edit</a>
                            <a href='../crud/buku_hapus.php?id=" . $row['id_buku'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin ingin menghapus buku ini?');\">Hapus</a>
                            </td>";
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
