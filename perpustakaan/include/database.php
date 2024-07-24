<?php
class Database {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public $connection;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->koneksi();
    }

    private function koneksi() {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    } 

    private function mysqli_close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function __destruct() {
        $this->mysqli_close();
    }
}
class Admin {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function login($username, $password) {
        $password = md5($password); // Pastikan password dienkripsi dengan MD5
        $sql = "SELECT * FROM tm_admin WHERE username='$username' AND password='$password'";
        
        // Debugging
        echo "SQL Query: " . $sql . "<br>";

        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $username;
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_destroy();
    }

    public function is_logged_in() {
        return isset($_SESSION['username']);
    }
}


class Mahasiswa {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function tampilkanMahasiswa() {
        $sql = "SELECT * FROM tm_mahasiswa";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID Anggota = " . $row["id"] . " - NIM = ".$row["nim"]." - Nama = " . $row["nama"] . " - Prodi = " . $row["prodi"] . "<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data mahasiswa.";
        }
    }

    public function tambahMahasiswa($nim, $nama, $prodi) {
        $sql = "INSERT INTO tm_mahasiswa (nim, nama, prodi) VALUES ('$nim', '$nama', '$prodi')";
        
        if ($this->connection->query($sql) === TRUE) {
            echo "Mahasiswa berhasil ditambahkan.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }
    public function supercari($vcari){
        $sql = "SELECT * FROM tm_mahasiswa WHERE nim LIKE '%$vcari%' OR nama LIKE '%$vcari%' OR prodi LIKE '%$vcari%'";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            echo "Mahasiswa ditemukan : <br/>";
            while($row = $result->fetch_assoc()) {
                echo "NIM = " . $row["nim"] . " – NAMA = " . $row["nama"] . " – PRODI = " . $row["prodi"] ."<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data mahasiswa dengan kriteria tersebut";
            echo "<br/>";
        }
    } 
    public function ubahmhs($id,$nim, $vnama, $vprodi){
        $sql = "UPDATE tm_mahasiswa SET nim='$nim',nama='$vnama', prodi='$vprodi' WHERE id='$id'";
        if ($this->connection->query($sql) === TRUE) {
            echo "Data mahasiswa berhasil diperbarui.";
            echo "<br/> <br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }        
    }
    public function hapus($vcari){
        $sql = "DELETE FROM tm_mahasiswa WHERE nim = '$vcari'";
        if ($this->connection->query($sql) === TRUE) {
            echo "Data mahasiswa berhasil dihapus.";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }
}

class Buku {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function tambahBuku($judul, $penulis, $tahun_terbit, $status) {
        $sql = "INSERT INTO tm_buku (judul, penulis, tahun_terbit, status) VALUES ('$judul', '$penulis', '$tahun_terbit', '$status')";
        
        if ($this->connection->query($sql) === TRUE) {
            echo "Buku berhasil ditambahkan.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function tampilkanBuku() {
        $sql = "SELECT * FROM tm_buku";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Id Buku = ".$row["id_buku"]." - Judul = " . $row["judul"] . " - Penulis = " . $row["penulis"] . " - Tahun Terbit = " . $row["tahun_terbit"] . " - Status = " . $row["status"] . "<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data";
        }
    }

    public function cariBuku($vcari){
        $sql = "SELECT * FROM tm_buku WHERE id_buku LIKE '%$vcari%' OR judul LIKE '%$vcari%' OR penulis LIKE '%$vcari%'";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            echo "Buku ditemukan : <br/>";
            while($row = $result->fetch_assoc()) {
                echo "Judul = " . $row["judul"] . " - Penulis = " . $row["penulis"] . " - Tahun Terbit = " . $row["tahun_terbit"] . " - Status = " . $row["status"] . "<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data buku dengan kriteria tersebut";
            echo "<br/>";
        }       
    }

    public function ubahBuku( $id_buku,$judul, $penulis, $tahun_terbit, $status){
        $sql = "UPDATE tm_buku SET judul='$judul', penulis='$penulis', tahun_terbit='$tahun_terbit', status='$status' WHERE id_buku='$id_buku'";
        if ($this->connection->query($sql) === TRUE) {
            echo "Data buku berhasil diperbarui.";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }       
    }

    public function hapusBuku($judul){
        $sql = "DELETE FROM tm_buku WHERE judul='$judul'";
        if ($this->connection->query($sql) === TRUE) {
            echo "Data buku berhasil dihapus.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }
}


class Peminjaman {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function tambahPeminjaman($id_mahasiswa, $id_buku, $tanggal_pinjam) {
        $tanggal_kembali = date('Y-m-d', strtotime($tanggal_pinjam . ' + 5 days'));
        $sql = "INSERT INTO tm_peminjaman (id_mahasiswa, id_buku, tanggal_pinjam, tanggal_kembali) VALUES ('$id_mahasiswa', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali')";

        if ($this->connection->query($sql) === TRUE) {
            echo "Peminjaman berhasil ditambahkan.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function tampilkanPeminjaman() {
        $sql = "SELECT tm_peminjaman.id_peminjaman, tm_mahasiswa.nama AS nama_mahasiswa, tm_buku.judul AS judul_buku, tm_peminjaman.tanggal_pinjam, tm_peminjaman.tanggal_kembali 
                FROM tm_peminjaman
                JOIN tm_mahasiswa ON tm_peminjaman.id_mahasiswa = tm_mahasiswa.id
                JOIN tm_buku ON tm_peminjaman.id_buku = tm_buku.id_buku";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID Peminjaman = " . $row["id_peminjaman"] . " - Nama Mahasiswa = " . $row["nama_mahasiswa"] . " - Judul Buku = " . $row["judul_buku"] . " - Tanggal Pinjam = " . $row["tanggal_pinjam"] . " - Tanggal Kembali = " . $row["tanggal_kembali"] . "<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data peminjaman.";
        }
    }
    public function ubahPeminjaman($id_peminjaman, $id_mahasiswa, $id_buku, $tanggal_pinjam) {
        $tanggal_kembali = date('Y-m-d', strtotime($tanggal_pinjam . ' + 5 days'));
        $sql = "UPDATE tm_peminjaman 
                SET id_mahasiswa = '$id_mahasiswa', id_buku = '$id_buku', tanggal_pinjam = '$tanggal_pinjam', tanggal_kembali = '$tanggal_kembali'
                WHERE id_peminjaman = '$id_peminjaman'";

        if ($this->connection->query($sql) === TRUE) {
            echo "Peminjaman berhasil diubah.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function hapusPeminjaman($id_peminjaman) {
        $sql = "DELETE FROM tm_peminjaman WHERE id_peminjaman = '$id_peminjaman'";

        if ($this->connection->query($sql) === TRUE) {
            echo "Peminjaman berhasil dihapus.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }
    public function cariPeminjam($id_anggota = null, $id_buku = null) {
        if ($id_anggota) {
            $sql = "SELECT tm_peminjaman.id_peminjaman, tm_mahasiswa.nama AS nama_mahasiswa, tm_buku.judul AS judul_buku, tm_peminjaman.tanggal_pinjam, tm_peminjaman.tanggal_kembali 
                    FROM tm_peminjaman
                    JOIN tm_mahasiswa ON tm_peminjaman.id_mahasiswa = tm_mahasiswa.id
                    JOIN tm_buku ON tm_peminjaman.id_buku = tm_buku.id_buku
                    WHERE tm_mahasiswa.id = '$id_anggota'";
        } elseif ($id_buku) {
            $sql = "SELECT tm_peminjaman.id_peminjaman, tm_mahasiswa.nama AS nama_mahasiswa, tm_buku.judul AS judul_buku, tm_peminjaman.tanggal_pinjam, tm_peminjaman.tanggal_kembali 
                    FROM tm_peminjaman
                    JOIN tm_mahasiswa ON tm_peminjaman.id_mahasiswa = tm_mahasiswa.id
                    JOIN tm_buku ON tm_peminjaman.id_buku = tm_buku.id_buku
                    WHERE tm_buku.id_buku = '$id_buku'";
        } else {
            echo "ID anggota atau ID buku harus disediakan.<br/>";
            return;
        }

        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID Peminjaman = " . $row["id_peminjaman"] . " - Nama Mahasiswa = " . $row["nama_mahasiswa"] . " - Judul Buku = " . $row["judul_buku"] . " - Tanggal Pinjam = " . $row["tanggal_pinjam"] . " - Tanggal Kembali = " . $row["tanggal_kembali"] . "<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data peminjaman untuk ID yang diberikan.";
        }
    }
}
class Pengembalian {
    public $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function tambahPengembalian($id_peminjaman, $tanggal_pengembalian) {
        // Menghitung denda
        $denda = $this->hitungDenda($id_peminjaman, $tanggal_pengembalian);
        
        // Menambahkan pengembalian buku
        $sql = "INSERT INTO tm_pengembalian (id_peminjaman, tanggal_pengembalian, denda) VALUES ('$id_peminjaman', '$tanggal_pengembalian', '$denda')";

        if ($this->connection->query($sql) === TRUE) {
            echo "Pengembalian berhasil ditambahkan.<br/>";
            if ($denda > 0) {
                echo "Denda keterlambatan: Rp " . $denda . "<br/>";
            } else {
                echo "Tidak ada denda keterlambatan.<br/>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }

        // Memperbarui status peminjaman
        // $updateStatus = "UPDATE tm_peminjaman SET status = 'dikembalikan' WHERE id_peminjaman = '$id_peminjaman'";
        // if ($this->connection->query($updateStatus) !== TRUE) {
        //     echo "Error: " . $updateStatus . "<br>" . $this->connection->error;
        // }
    }

    public function hitungDenda($id_peminjaman, $tanggal_pengembalian) {
        $sql = "SELECT tanggal_kembali FROM tm_peminjaman WHERE id_peminjaman = '$id_peminjaman'";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $tanggal_kembali = $row['tanggal_kembali'];

            $datetime1 = new DateTime($tanggal_kembali);
            $datetime2 = new DateTime($tanggal_pengembalian);
            $interval = $datetime1->diff($datetime2);
            $hari_keterlambatan = $interval->days;

            if ($datetime2 > $datetime1) {
                return $hari_keterlambatan * 2000;
            } else {
                return 0;
            }
        } else {
            echo "Data peminjaman tidak ditemukan.<br/>";
            return 0;
        }
    }

    public function tampilkanPengembalian() {
        $sql = "SELECT tm_pengembalian.id_pengembalian, tm_peminjaman.id_peminjaman, tm_mahasiswa.nama AS nama_mahasiswa, tm_buku.judul AS judul_buku, tm_pengembalian.tanggal_pengembalian, tm_pengembalian.denda 
                FROM tm_pengembalian
                JOIN tm_peminjaman ON tm_pengembalian.id_peminjaman = tm_peminjaman.id_peminjaman
                JOIN tm_mahasiswa ON tm_peminjaman.id_mahasiswa = tm_mahasiswa.id
                JOIN tm_buku ON tm_peminjaman.id_buku = tm_buku.id_buku";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID Pengembalian = " . $row["id_pengembalian"] . " - ID Peminjaman = " . $row["id_peminjaman"] . " - Nama Mahasiswa = " . $row["nama_mahasiswa"] . " - Judul Buku = " . $row["judul_buku"] . " - Tanggal Pengembalian = " . $row["tanggal_pengembalian"] . " - Denda = Rp " . $row["denda"] . "<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data pengembalian.";
        }
    }

    public function ubahPengembalian($id_pengembalian, $id_peminjaman, $tanggal_pengembalian) {
        $denda = $this->hitungDenda($id_peminjaman, $tanggal_pengembalian);
        $sql = "UPDATE tm_pengembalian 
                SET id_peminjaman = '$id_peminjaman', tanggal_pengembalian = '$tanggal_pengembalian', denda = '$denda'
                WHERE id_pengembalian = '$id_pengembalian'";

        if ($this->connection->query($sql) === TRUE) {
            echo "Pengembalian berhasil diubah.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function hapusPengembalian($id_pengembalian) {
        $sql = "DELETE FROM tm_pengembalian WHERE id_pengembalian = '$id_pengembalian'";

        if ($this->connection->query($sql) === TRUE) {
            echo "Pengembalian berhasil dihapus.<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function cariPengembalian($id_peminjaman = null, $id_mahasiswa = null) {
        if ($id_peminjaman) {
            $sql = "SELECT tm_pengembalian.id_pengembalian, tm_peminjaman.id_peminjaman, tm_mahasiswa.nama AS nama_mahasiswa, tm_buku.judul AS judul_buku, tm_pengembalian.tanggal_pengembalian, tm_pengembalian.denda 
                    FROM tm_pengembalian
                    JOIN tm_peminjaman ON tm_pengembalian.id_peminjaman = tm_peminjaman.id_peminjaman
                    JOIN tm_mahasiswa ON tm_peminjaman.id_mahasiswa = tm_mahasiswa.id
                    JOIN tm_buku ON tm_peminjaman.id_buku = tm_buku.id_buku
                    WHERE tm_peminjaman.id_peminjaman = '$id_peminjaman'";
        } elseif ($id_mahasiswa) {
            $sql = "SELECT tm_pengembalian.id_pengembalian, tm_peminjaman.id_peminjaman, tm_mahasiswa.nama AS nama_mahasiswa, tm_buku.judul AS judul_buku, tm_pengembalian.tanggal_pengembalian, tm_pengembalian.denda 
                    FROM tm_pengembalian
                    JOIN tm_peminjaman ON tm_pengembalian.id_peminjaman = tm_peminjaman.id_peminjaman
                    JOIN tm_mahasiswa ON tm_peminjaman.id_mahasiswa = tm_mahasiswa.id
                    JOIN tm_buku ON tm_peminjaman.id_buku = tm_buku.id_buku
                    WHERE tm_mahasiswa.id = '$id_mahasiswa'";
        } else {
            echo "ID peminjaman atau ID mahasiswa harus disediakan.<br/>";
            return;
        }

        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID Pengembalian = " . $row["id_pengembalian"] . " - ID Peminjaman = " . $row["id_peminjaman"] . " - Nama Mahasiswa = " . $row["nama_mahasiswa"] . " - Judul Buku = " . $row["judul_buku"] . " - Tanggal Pengembalian = " . $row["tanggal_pengembalian"] . " - Denda = Rp " . $row["denda"] . "<br/>";
            }
            echo "<br/>";
        } else {
            echo "Tidak ada data pengembalian untuk ID yang diberikan.";
        }
    }
}



?>
