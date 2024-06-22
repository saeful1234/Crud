<?php
include 'db.php'; // Pastikan db.php menginisialisasi objek PDO

// Cek koneksi
try {
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses input data projek baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nama_projek = $_POST['nama_projek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $sql = "INSERT INTO projek (nama_projek, deskripsi, tanggal_mulai, tanggal_selesai) VALUES (:nama_projek, :deskripsi, :tanggal_mulai, :tanggal_selesai)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':nama_projek', $nama_projek);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':tanggal_mulai', $tanggal_mulai);
    $stmt->bindParam(':tanggal_selesai', $tanggal_selesai);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Data projek baru berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->errorInfo()[2] . "</div>";
    }
}

// Include Bootstrap CSS
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

// Tombol kembali ke beranda di atas sebelah kiri
echo '<div class="mt-3 ml-3">
        <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
      </div>';

// Form untuk input data projek
echo '<div class="container mt-5">
        <h2>Tambah Projek</h2>
        <form action="" method="post">
            <div class="form-group">
                Nama Projek: <input type="text" class="form-control" name="nama_projek" required><br>
                Deskripsi: <textarea class="form-control" name="deskripsi"></textarea><br>
                Tanggal Mulai: <input type="date" class="form-control" name="tanggal_mulai"><br>
                Tanggal Selesai: <input type="date" class="form-control" name="tanggal_selesai"><br>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        </form>
      </div>';

// Query untuk mengambil data projek
$sql = "SELECT * FROM projek";
$result = $koneksi->query($sql);

if ($result->rowCount() > 0) { // Menggunakan rowCount() untuk PDO
    echo '<div class="container mt-5">
            <h2>Daftar Projek</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Projek</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Edit</th> <!-- Kolom baru untuk edit -->
                        <th>Hapus</th> <!-- Kolom baru untuk hapus -->
                    </tr>
                </thead>
                <tbody>';
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nama_projek"] . "</td><td>" . $row["deskripsi"] . "</td><td>" . $row["tanggal_mulai"] . "</td><td>" . $row["tanggal_selesai"] . "</td>";
        echo "<td><a href='edit_projek.php?id=" . $row["id"] . "' class='btn btn-info'>Edit</a></td>"; // Tombol edit
        echo "<td><a href='hapus_projek.php?id=" . $row["id"] . "' onclick='return confirmDelete()' class='btn btn-danger'>Hapus</a></td></tr>"; // Tombol hapus dengan konfirmasi
    }
    echo '</tbody>
          </table>
        </div>';
} else {
    echo "<div class='alert alert-warning'>0 results</div>";
}

// Tidak perlu menutup koneksi secara eksplisit
// $koneksi->close(); // Hapus atau komentari baris ini

// Menampilkan pesan jika ada dan valid
if(isset($_GET['message']) && trim($_GET['message']) !== '' && $_GET['message'] !== 'Error:') {
    echo "<script>alert('" . htmlspecialchars($_GET['message']) . "');</script>";
}

?>

<script>
function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus projek ini?');
}
</script>