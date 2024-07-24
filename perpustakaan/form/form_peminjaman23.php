<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
    session_start();
    include '../include/database.php';
    $db = new Database("localhost", "root", "", "db_perpus006");
    $admin = new admin($db->connection);
    // if (!$admin->is_logged_in()) {
    // header('Location: login.php');
    // exit();
    // }

    $mahasiswa = new Mahasiswa($db->connection);
    $buku = new Buku($db->connection);
    $peminjaman = new Peminjaman($db->connection);
    ?>
    <!-- style -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>

<h1>Form Peminjaman Buku</h1>
<form method="POST" action="">
    <input type="hidden" id="action" name="action" value="tambah_peminjaman">
    ID Mahasiswa: <input type="text" id="id_mahasiswa" name="id_mahasiswa"><br/>
    ID Buku: <input type="text" id="id_buku" name="id_buku"><br/>
    Tanggal Pinjam: <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"><br/>
    <br/>
    <button type="submit">Tambah Peminjaman</button>
</form>
<?php 
if (isset($_POST['action'])) {
    $db = new Database("localhost", "root", "", "db_perpus006");
    
    switch ($_POST['action']) {
        case 'tambah_peminjaman':
            $peminjaman = new Peminjaman($db->connection);
            $peminjaman->tambahPeminjaman($_POST['id_mahasiswa'], $_POST['id_buku'], $_POST['tanggal_pinjam']);
            header('Location: ../page/kelola_peminjam.php');
            exit();
    }
}
?>
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

</body>
</html>
