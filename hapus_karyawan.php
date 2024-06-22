<?php
// Menggunakan file db.php untuk koneksi database
include 'db.php';

// Cek jika ID karyawan diberikan melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mempersiapkan perintah SQL untuk menghapus karyawan
    $sql = "DELETE FROM karyawan WHERE id = :id";
    $stmt = $koneksi->prepare($sql); // Mengganti $pdo dengan $koneksi

    // Bind parameter dan eksekusi perintah SQL
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    try {
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<div class='alert alert-success'>Karyawan berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-warning'>Karyawan tidak ditemukan.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Gagal menghapus karyawan: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID karyawan tidak diberikan.</div>";
}

// Link kembali ke halaman utama
echo '<a href="karyawan.php" class="btn btn-secondary">Kembali ke Beranda</a>';

// Tutup koneksi
$koneksi = null;
?>
