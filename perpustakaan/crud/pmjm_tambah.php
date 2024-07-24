<?php
session_start();
include '../include/database.php';

$db = new Database("localhost", "root", "", "db_perpus006");
// $admin = new Admin($db->connection);

// if (!$admin->is_logged_in()) {
//     header('Location: login.php');
//     exit();
// }
$peminjaman = new Peminjaman($db->connection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    
    $peminjaman->tambahPeminjaman($_POST['id_mahasiswa'], $_POST['id_buku'], $_POST['tanggal_pinjam']);
    header('Location: ../page/kelola_peminjam.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjam</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../aset/style.css">
</head>
<body>
<?php include "../include/nav.php" ?>

    <div class="content">
    <div class="row mt-5 justify-content-between">
        <div class="col-4">
            <h1 style="color:#D9CEAC">Tambah Peminjam</h1>
        </div>
        <div class="col-4 ">
            <?php include "../include/time.php"; ?>
        </div>
    </div>
    <div class="row warnafont">
        <!-- content -->
        <div class="col-md-4">
            <div class="mb-4 card">
                <div class="container">
                    <form class="py-3" method="POST" action="">
                        <input type="hidden" name="id_peminjaman" value="<?php echo $row['id_peminjaman']; ?>">
                        <div class="form-group">
                            <label for="id_mahasiswa">ID Anggota:</label>
                            <input type="text" class="form-control" id="id_mahasiswa" name="id_mahasiswa" required>
                        </div>
                        <div class="form-group">
                            <label for="id_buku">ID Buku:</label>
                            <input type="text" class="form-control" id="id_buku" name="id_buku" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal Pinjam:</label>
                            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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
                        // echo "<td>" . $row['total_copies'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>
<!-- Modal -->
<div class="modal fade warnafont" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Penambahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin dengan data ini?</p>
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ID Mahasiswa</td>
                            <td id="after-id_mahasiswa"></td>
                        </tr>
                        <tr>
                            <td>ID Buku</td>
                            <td id="after-id_buku"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pinjam</td>
                            <td id="after-tanggal_pinjam"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Kembali</td>
                            <td id="after-tanggal_kembali"></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirm-btn">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah submit form langsung


        // Ambil nilai input 
        const afterIdMahasiswa = document.getElementById('id_mahasiswa').value;
        const afterIdBuku = document.getElementById('id_buku').value;
        const afterTanggalPinjam = document.getElementById('tanggal_pinjam').value;
        const afterTanggalKembali = new Date(afterTanggalPinjam);
        afterTanggalKembali.setDate(afterTanggalKembali.getDate() + 5);
        const formattedAfterTanggalKembali = afterTanggalKembali.toISOString().split('T')[0];

        // Tampilkan nilai 
        document.getElementById('after-id_mahasiswa').textContent = afterIdMahasiswa;
        document.getElementById('after-id_buku').textContent = afterIdBuku;
        document.getElementById('after-tanggal_pinjam').textContent = afterTanggalPinjam;
        document.getElementById('after-tanggal_kembali').textContent = formattedAfterTanggalKembali;

        // Tampilkan modal
        $('#confirmModal').modal('show');

        // Tangani klik tombol "Ya, Simpan" di modal
        document.getElementById('confirm-btn').addEventListener('click', function() {
            document.querySelector('form').submit(); // Submit form
        });
    });
</script>




<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
