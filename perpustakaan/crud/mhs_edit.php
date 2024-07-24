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
            <h1 style="color:#D9CEAC">Edit Mahasiswa</h1>
        </div>
        <div class="col-4 ">
            <?php include "../include/time.php"; ?>
        </div>
    </div>
    <div class="row warnafont">

    <!-- content -->
    <?php 
    $mahasiswa = new Mahasiswa($db->connection);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $nim = $_POST['nim'];
        $nama = $_POST['nama'];
        $prodi = $_POST['prodi'];
    
        $mahasiswa->ubahmhs($id, $nim, $nama, $prodi);
        header('Location: ../page/dashboard.php');
        exit();
    }
    
    $id = $_GET['id'];
    $result = $db->connection->query("SELECT * FROM tm_mahasiswa WHERE id = $id");
    $row = $result->fetch_assoc();
    ?>
    <div class="col-md-12">
        <div class="mb-4 card">
            <div class="container">
                <form class="py-3" method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="nim">NIM:</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $row['nim']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Program Studi:</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" value="<?php echo $row['prodi']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
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
                                    <td>NIM</td>
                                    <td id="before-nim"></td>
                                    <td id="after-nim"></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td id="before-nama"></td>
                                    <td id="after-nama"></td>
                                </tr>
                                <tr>
                                    <td>Prodi</td>
                                    <td id="before-prodi"></td>
                                    <td id="after-prodi"></td>
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
            const beforeNim = '<?php echo $row['nim']; ?>';
            const beforeNama = '<?php echo $row['nama']; ?>';
            const beforeProdi = '<?php echo $row['prodi']; ?>';

            // Ambil nilai input setelah perubahan
            const afterNim = document.getElementById('nim').value;
            const afterNama = document.getElementById('nama').value;
            const afterProdi = document.getElementById('prodi').value;

            // Tampilkan nilai sebelum dan sesudah perubahan di modal
            document.getElementById('before-nim').textContent = beforeNim;
            document.getElementById('before-nama').textContent = beforeNama;
            document.getElementById('before-prodi').textContent = beforeProdi;

            document.getElementById('after-nim').textContent = afterNim;
            document.getElementById('after-nama').textContent = afterNama;
            document.getElementById('after-prodi').textContent = afterProdi;

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
