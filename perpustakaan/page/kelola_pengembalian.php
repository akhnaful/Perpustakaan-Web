<?php
session_start();
include '../include/database.php';

$db = new Database("localhost", "root", "", "db_perpus006");
// $admin = new Admin($db->connection);

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
    <title>Kelola Pengembalian</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../aset/style.css">
</head>
<body>
<?php include "../include/nav.php" ?>

    <div class="content">
    <div class="row mt-5 justify-content-between">
        <div class="col-4">
            <h1 style="color:#D9CEAC">Pengelola Pengembalian Buku</h1>
        </div>
        <div class="col-4 ">
            <?php include "../include/time.php"; ?>
        </div>
    </div>
    <div class="row warnafont">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body ">
                    <h5 class="card-title"><i class="fas fa-book"></i> Pengembalian</h5>
                    <p class="card-text">Pengembalian Buku.</p>
                    <a href="../crud/pngb_tambah.php" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-handshake"></i> Main Form Pengembalian</h5>
                    <p class="card-text">Form utama dari data pengembalian.</p>
                    <a href="../form/form_pengembalian.php" class="btn btn-primary">Form Pengembalian</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-handshake"></i> Total Buku Yang Kembali</h5>
                <p class="card-text py-2" style="font-size: 2.5rem;"><strong>
                <?php 
                $result = $db->connection->query("SELECT COUNT(*) as total FROM tm_pengembalian ");
                if ($result) {
                    $row = $result->fetch_assoc();
                    echo $row['total'];
                } else {
                    echo "0";
                }
                ?></strong>
                </p>
            </div>
        </div>
        </div>


    <!-- list -->

    <div class="col-md-12">
    <div class="mb-4 card">
        <h3 class="px-2 py-2">Daftar Pengembalian Buku</h3>
        <div class="scrollable-table">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th>ID Peminjaman</th>
                    <th>Nama Mahasiswa</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Denda</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
            <?php
                $result = $db->connection->query("SELECT tm_peminjaman.id_peminjaman, tm_mahasiswa.nama AS nama_mahasiswa, tm_buku.judul AS judul_buku, tm_peminjaman.tanggal_pinjam, tm_peminjaman.tanggal_kembali, tm_pengembalian.tanggal_pengembalian, tm_pengembalian.denda 
                FROM tm_pengembalian
                JOIN tm_peminjaman ON tm_pengembalian.id_peminjaman = tm_peminjaman.id_peminjaman
                JOIN tm_mahasiswa ON tm_peminjaman.id_mahasiswa = tm_mahasiswa.id
                JOIN tm_buku ON tm_peminjaman.id_buku = tm_buku.id_buku");
                while ($row = $result->fetch_assoc()) {
                    $tanggal_kembali = new DateTime($row['tanggal_kembali']);
                    $tanggal_pengembalian = new DateTime($row['tanggal_pengembalian']);
                    $denda = 0;

                    if ($tanggal_pengembalian > $tanggal_kembali) {
                        $selisih_hari = $tanggal_kembali->diff($tanggal_pengembalian)->days;
                        $denda = $selisih_hari * 2000;
                    }
                    echo "<tr>";
                    echo "<td>" . $row['id_peminjaman'] . "</td>";
                    echo "<td>" . $row['nama_mahasiswa'] . "</td>";
                    echo "<td>" . $row['judul_buku'] . "</td>";
                    echo "<td>" . $row['tanggal_pinjam'] . "</td>";
                    echo "<td>" . $row['tanggal_kembali'] . "</td>";
                    echo "<td>" . $row['tanggal_pengembalian'] . "</td>";
                    echo "<td>" . $row['denda'] . "</td>";
                    echo "<td>
                        <a href='../crud/pngb_edit.php?id=" . $row['id_peminjaman'] . "' class='btn btn-sm btn-primary'>Edit</a>
                        <a href='../crud/pngb_hapus.php?id=" . $row['id_peminjaman'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin ingin menghapus pengembalian ini?');\">Hapus</a>
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
    </div>
    </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
