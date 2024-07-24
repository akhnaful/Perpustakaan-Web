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
$fine = null;
$message = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
    
    $result = $peminjaman->kembalikanBuku($id_peminjaman, $tanggal_pengembalian);
    $message = $result['message'];
    $fine = $result['fine'];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengembalian Buku</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../aset/style.css">
</head>
<body>
<?php include "../include/nav.php" ?>

    <div class="content">
    <div class="row mt-5 justify-content-between">
        <div class="col-4">
            <h1 style="color:#D9CEAC">Tambah Pengembalian Buku</h1>
        </div>
        <div class="col-4 ">
            <?php include "../include/time.php"; ?>
        </div>
    </div>
    <div class="row warnafont">
    <!-- content -->
    <div class="col-md-12">
        <div class="mb-4 card">
            <div class="container">
                <form class="py-3" method="POST" action="">
                    <div class="form-group">
                        <label for="id_peminjaman">ID Peminjaman:</label>
                        <select class="form-control" id="id_peminjaman" name="id_peminjaman" required>
                            <option value="">Pilih ID Peminjaman</option>
                            <?php
                            $result = $db->connection->query("SELECT id_peminjaman FROM tm_peminjaman WHERE tanggal_pengembalian IS NULL");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id_peminjaman'] . "'>" . $row['id_peminjaman'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pengembalian">Tanggal Pengembalian:</label>
                        <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- list -->
<div class="row warnafont">
    <div class="col-md-12">
        <div class="mb-4 card">
            <h3 class="px-2 py-2">Daftar Peminjaman</h3>
            <div class="scrollable-table">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Peminjaman</th>
                            <th>ID Mahasiswa</th>
                            <th>ID Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->connection->query("SELECT * FROM tm_peminjaman WHERE tanggal_pengembalian IS NULL");
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id_peminjaman'] . "</td>";
                            echo "<td>" . $row['id_mahasiswa'] . "</td>";
                            echo "<td>" . $row['id_buku'] . "</td>";
                            echo "<td>" . $row['tanggal_pinjam'] . "</td>";
                            echo "<td>" . $row['tanggal_kembali'] . "</td>";
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
                                <td>ID Peminjaman</td>
                                <td id="after-id_peminjaman"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengembalian</td>
                                <td id="after-tanggal_pengembalian"></td>
                            </tr>
                            <tr>
                                <td>Denda</td>
                                <td id="after-denda"></td>
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

    const idPeminjaman = document.querySelector('select[name="id_peminjaman"]').value;
    const tanggalPengembalian = document.getElementById('tanggal_pengembalian').value;

    // Fetch the borrow and return dates from the server
    fetch('get_dates.php?id_peminjaman=' + idPeminjaman)
        .then(response => response.json())
        .then(data => {
            const tanggalKembali = new Date(data.tanggal_kembali);
            const selisih = (new Date(tanggalPengembalian) - tanggalKembali) / (1000 * 60 * 60 * 24);
            const hariTerlambat = Math.max(0, Math.ceil(selisih));
            const denda = hariTerlambat * 2000;

            // Tampilkan nilai 
            document.getElementById('after-id_peminjaman').textContent = idPeminjaman;
            document.getElementById('after-tanggal_pengembalian').textContent = tanggalPengembalian;
            document.getElementById('after-denda').textContent = denda > 0 ? 'Rp ' + denda.toLocaleString('id-ID') : 'Tidak ada denda';

            // Tampilkan modal
            $('#confirmModal').modal('show');

            // Tangani klik tombol "Ya, Simpan" di modal
            document.getElementById('confirm-btn').addEventListener('click', function() {
                // Allow the form to submit
                document.querySelector('form').submit(); // Submit form
            });
        });
});
</script>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
