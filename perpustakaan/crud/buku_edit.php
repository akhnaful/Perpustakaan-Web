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
    <title>Edit Buku</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../aset/style.css">
</head>
<body>
<?php include "../include/nav.php" ?>

    <div class="content">
    <div class="row mt-5 justify-content-between">
        <div class="col-4">
            <h1 style="color:#D9CEAC">Edit Buku</h1>
        </div>
        <div class="col-4 ">
            <?php include "../include/time.php"; ?>
        </div>
    </div>
    <div class="row warnafont">

    <!-- content -->
    <?php 
    $buku = new Buku($db->connection);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_buku = $_POST['id_buku'];
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $tahun_terbit = $_POST['tahun_terbit'];
        $status = $_POST['status'];
    
        $buku->ubahBuku($id_buku,$judul, $penulis, $tahun_terbit, $status);
        header('Location: ../page/dashboard.php');
        exit();
    }
    
    $id_buku = $_GET['id'];
    $result = $db->connection->query("SELECT * FROM tm_buku WHERE id_buku = $id_buku");
    $row = $result->fetch_assoc();
    ?>
    <div class="col-md-12">
        <div class="mb-4 card">
            <div class="container">
                <form class="py-3" method="POST" action="">
                    <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                    <div class="form-group">
                        <label for="judul">Judul Buku:</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $row['judul']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Nama Penulis:</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo $row['penulis']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit:</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?php echo $row['tahun_terbit']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Tersedia" <?php echo ($row['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="Dipinjam" <?php echo ($row['status'] == 'Dipinjam') ? 'selected' : ''; ?>>Dipinjam</option>
                            <option value="Hilang" <?php echo ($row['status'] == 'Hilang') ? 'selected' : ''; ?>>Hilang</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade warnafont" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Perubahan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin dengan perubahan ini?</p>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Sebelum</th>
                                <th>Sesudah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Judul</td>
                                <td id="before-judul"></td>
                                <td id="after-judul"></td>
                            </tr>
                            <tr>
                                <td>Penulis</td>
                                <td id="before-penulis"></td>
                                <td id="after-penulis"></td>
                            </tr>
                            <tr>
                                <td>Tahun Terbit</td>
                                <td id="before-tahun-terbit"></td>
                                <td id="after-tahun-terbit"></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td id="before-status"></td>
                                <td id="after-status"></td>
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

            // Ambil nilai input sebelum perubahan
            const beforeJudul = '<?php echo $row['judul']; ?>';
            const beforePenulis = '<?php echo $row['penulis']; ?>';
            const beforeTahunTerbit = '<?php echo $row['tahun_terbit']; ?>';
            const beforeStatus = '<?php echo $row['status']; ?>';

            // Ambil nilai input setelah perubahan
            const afterJudul = document.getElementById('judul').value;
            const afterPenulis = document.getElementById('penulis').value;
            const afterTahunTerbit = document.getElementById('tahun_terbit').value;
            const afterStatus = document.getElementById('status').value;

            // Tampilkan nilai sebelum dan sesudah perubahan di modal
            document.getElementById('before-judul').textContent = beforeJudul;
            document.getElementById('before-penulis').textContent =  beforePenulis;
            document.getElementById('before-tahun-terbit').textContent = beforeTahunTerbit;
            document.getElementById('before-status').textContent = beforeStatus;

            document.getElementById('after-judul').textContent =  afterJudul;
            document.getElementById('after-penulis').textContent = afterPenulis;
            document.getElementById('after-tahun-terbit').textContent = afterTahunTerbit;
            document.getElementById('after-status').textContent =  afterStatus;

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
