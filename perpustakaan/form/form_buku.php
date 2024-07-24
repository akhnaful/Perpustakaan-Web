

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buku</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <?php
        session_start();
        include '../include/database.php';

        $db = new Database("localhost", "root", "", "db_perpus006");
        // $admin = new Admin($db->connection);

        // if (!$admin->is_logged_in()) {
        //     header('Location: login.php');
        //     exit();
        // }

        $buku = new Buku($db->connection);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            switch ($_POST['action']) {
                case 'tambah_buku':
                    $buku->tambahBuku($_POST['judul'], $_POST['penulis'], $_POST['tahun_terbit'], $_POST['status']);
                    break;
                case 'cari_buku':
                    $buku->cariBuku($_POST['judul']);
                    break;
                case 'hapus_buku':
                    $buku->hapusBuku($_POST['judul']);
                    break;
                case 'ubah_buku':
                    $buku->ubahBuku($_POST['id_buku'],$_POST['judul'], $_POST['penulis'], $_POST['tahun_terbit'], $_POST['status']);
                    break;
            }
        }
    ?>
</head>
<body>
    <div class="container mt-5">
        <h1>Form Buku</h1>
        <form method="POST" action="" class="mb-5">
            <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="form-group">
                <label for="penulis">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis" required>
            </div>
            <div class="form-group">
                <label for="tahun_terbit">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="Tersedia">Tersedia</option>
                    <option value="Dipinjam">Dipinjam</option>
                    <option value="Hilang">Hilang</option>
                </select>
            </div>
            <button type="submit" name="action" value="tambah_buku" class="btn btn-primary">Tambah</button>
            <button type="submit" name="action" value="cari_buku" class="btn btn-secondary">Cari</button>
            <button type="submit" name="action" value="hapus_buku" class="btn btn-danger">Hapus</button>
            <button type="submit" name="action" value="ubah_buku" class="btn btn-warning">Ubah</button>
        </form>
        <h2>Data Buku</h2>
        <?php 
        // Tampilkan data buku setelah setiap tindakan
        $buku->tampilkanBuku();
        ?>
    </div>
</body>
</html>
