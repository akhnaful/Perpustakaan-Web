<?php
include '../include/database.php';

header('Content-Type: application/json');

// Mengambil parameter dari query string
$id_peminjaman = $_GET['id_peminjaman'];
$tanggal_pengembalian = $_GET['tanggal_pengembalian'];

if (empty($id_peminjaman) || empty($tanggal_pengembalian)) {
    echo json_encode(['error' => 'Parameter tidak lengkap']);
    exit();
}

$db = new Database("localhost", "root", "", "db_perpus006");
$peminjaman = new Peminjaman($db->connection);

// Menghitung denda
$denda = $peminjaman->hitungDenda($id_peminjaman, $tanggal_pengembalian);

echo json_encode(['denda' => $denda]);

// Method dalam class Peminjaman untuk menghitung denda
class Peminjaman {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function hitungDenda($id_peminjaman, $tanggal_pengembalian) {
        // Fetch the peminjaman record
        $sql = "SELECT tanggal_kembali FROM tm_peminjaman WHERE id_peminjaman = '$id_peminjaman'";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $tanggal_kembali = $row['tanggal_kembali'];

            // Calculate late fee if any
            $diff = strtotime($tanggal_pengembalian) - strtotime($tanggal_kembali);
            $days_late = ceil($diff / (60 * 60 * 24));
            $fine = 0;
            if ($days_late > 0) {
                $fine = $days_late * 2000;
            }

            return $fine;
        } else {
            return 0;
        }
    }
}
?>
