

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Form Peminjaman Buku</title>
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

        $mahasiswa = new Mahasiswa($db->connection);
        $buku = new Buku($db->connection);
        $peminjaman = new Peminjaman($db->connection);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'tambah_peminjaman':
                        $peminjaman->tambahPeminjaman($_POST['id_mahasiswa'], $_POST['id_buku'], $_POST['tanggal_pinjam']);
                        header('Location: form_peminjaman.php');
                        exit();
                    case 'cari_peminjam':
                        $peminjaman->cariPeminjam($_POST['id_anggota'] ?? null, $_POST['id_buku'] ?? null);
                        break;
                    case 'ubah_peminjaman':
                        $peminjaman->ubahPeminjaman($_POST['id_peminjaman'], $_POST['id_mahasiswa'], $_POST['id_buku'], $_POST['tanggal_pinjam']);
                        break;
                    case 'hapus_peminjaman':
                        $peminjaman->hapusPeminjaman($_POST['id_peminjaman']);
                        break;
                }
            }
        }
        
        
    ?>
</head>
<body>
    <div class="container mt-5">
        <h1>Main Form Peminjaman Buku </h1>
        <form method="POST" action="" class="mb-5">
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
            <button type="submit" name="action" value="tambah_peminjaman" class="btn btn-primary">Tambah</button>
            <button type="submit" name="action" value="cari_peminjam" class="btn btn-secondary">Cari</button>
            <button type="submit" name="action" value="ubah_peminjaman" class="btn btn-danger">Hapus</button>
            <button type="submit" name="action" value="hapus_peminjaman" class="btn btn-warning">Ubah</button>
        </form>
        <h1>Data Peminjaman</h1>
            <?php 
            $peminjaman->tampilkanPeminjaman();
            ?>

        <h1>Data Mahasiswa</h1>
            <?php 
            $mahasiswa->tampilkanMahasiswa();
            ?>

        <h1>Data Buku</h1>
            <?php 
            $buku->tampilkanBuku();
            ?>
    </div>
</body>
</html>
