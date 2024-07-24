<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengembalian Buku</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <?php
        session_start();
        include '../include/database.php';

        $db = new Database("localhost", "root", "", "db_perpus006");

        $mahasiswa = new Mahasiswa($db->connection);
        $buku = new Buku($db->connection);
        $pengembalian = new Pengembalian($db->connection);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'tambah_pengembalian':
                        $pengembalian->tambahPengembalian($_POST['id_peminjaman'], $_POST['tanggal_pengembalian']);
                        header('Location: form_pengembalian.php');
                        exit();
                    case 'cari_pengembalian':
                        $pengembalian->cariPengembalian($_POST['id_peminjaman'] ?? null, $_POST['id_mahasiswa'] ?? null);
                        break;
                    case 'ubah_pengembalian':
                        $pengembalian->ubahPengembalian($_POST['id_pengembalian'], $_POST['id_peminjaman'], $_POST['tanggal_pengembalian']);
                        break;
                    case 'hapus_pengembalian':
                        $pengembalian->hapusPengembalian($_POST['id_pengembalian']);
                        break;
                }
            }
        }
    ?>
</head>
<body>
    <div class="container mt-5">
        <h1>Form Pengembalian Buku</h1>
        <form method="POST" action="" class="mb-5">
            <div class="form-group">
                <label for="id_peminjaman">ID Peminjaman:</label>
                <input type="text" class="form-control" id="id_peminjaman" name="id_peminjaman" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pengembalian">Tanggal Pengembalian:</label>
                <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
            </div>
            <button type="submit" name="action" value="tambah_pengembalian" class="btn btn-primary">Tambah</button>
            <button type="submit" name="action" value="cari_pengembalian" class="btn btn-secondary">Cari</button>
            <button type="submit" name="action" value="ubah_pengembalian" class="btn btn-danger">Ubah</button>
            <button type="submit" name="action" value="hapus_pengembalian" class="btn btn-warning">Hapus</button>
        </form>
        <h1>Data Pengembalian</h1>
        <?php 
            $pengembalian->tampilkanPengembalian();
        ?>
    </div>
</body>
</html>
