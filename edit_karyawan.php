<?php
include 'db.php'; // Pastikan db.php menginisialisasi objek PDO

// Cek koneksi
try {
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses update data karyawan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $koneksi->quote($_POST['nama']);
    $posisi = $koneksi->quote($_POST['posisi']);
    $gaji = $koneksi->quote($_POST['gaji']);

    $sql = "UPDATE karyawan SET nama=$nama, posisi=$posisi, gaji=$gaji WHERE id=$id";
    try {
        $koneksi->exec($sql);
        echo "<div class='alert alert-success'>Data karyawan berhasil diperbarui!</div>";
        // Tambahkan header redirect ke karyawan.php
        header("Location: karyawan.php");
        exit;
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Gagal memperbarui data karyawan: " . $e->getMessage() . "</div>";
    }
}

// Mengambil data karyawan yang akan diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM karyawan WHERE id=$id";
    $result = $koneksi->query($sql);
    if ($result->rowCount() > 0) {
        $data = $result->fetch(PDO::FETCH_ASSOC);
    } else {
        die("Data tidak ditemukan");
    }
} else {
    die("ID tidak ditemukan");
}

// Include Bootstrap CSS
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

// Form untuk update data karyawan
echo '<div class="container mt-5">
        <h2>Edit Karyawan</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="' . $data['id'] . '">
            <div class="form-group">
                Nama: <input type="text" class="form-control" name="nama" value="' . $data['nama'] . '" required>
            </div>
            <div class="form-group">
                Posisi: <input type="text" class="form-control" name="posisi" value="' . $data['posisi'] . '" required>
            </div>
            <div class="form-group">
                Gaji: <input type="number" class="form-control" step="0.01" name="gaji" value="' . $data['gaji'] . '" required>
            </div>
            <input type="submit" class="btn btn-primary" name="update" value="Perbarui Karyawan">
        </form>
      </div>';

// Tutup koneksi
$koneksi = null;
?>
