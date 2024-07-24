

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Form Mahasiswa</title>
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

        $user = new Mahasiswa($db->connection);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'tb_mahasiswa':
                        $user->tambahMahasiswa($_POST['nim'], $_POST['nama'], $_POST['prodi']);
                        break;
                    case 'cari':
                        $user->supercari($_POST['nim']);
                        break;
                    case 'hapus':
                        $user->hapus($_POST['nim']);
                        break;
                    case 'ubah':
                        $user->ubahmhs($_POST['id'],$_POST['nim'], $_POST['nama'], $_POST['prodi']);
                        break;
                }
            }
        }
    ?>
</head>
<body>
    <div class="container mt-5">
        <h1>Main Form Mahasiswa </h1>
        <form method="POST" action="" class="mb-5">
            <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <input type="text" class="form-control" id="prodi" name="prodi" required>
            </div>
            <button type="submit" name="action" value="tb_mahasiswa" class="btn btn-primary">Tambah</button>
            <button type="submit" name="action" value="cari" class="btn btn-secondary">Cari</button>
            <button type="submit" name="action" value="hapus" class="btn btn-danger">Hapus</button>
            <button type="submit" name="action" value="ubah" class="btn btn-warning">Ubah</button>
        </form>
        <h2>Data Mahasiswa</h2>
        <?php 
            $user->tampilkanMahasiswa();
        ?>
    </div>
</body>
</html>
