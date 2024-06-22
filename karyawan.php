<?php
include 'db.php'; // Pastikan db.php menginisialisasi objek PDO

// Cek koneksi
try {
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses input data karyawan baru
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $koneksi->quote($_POST['nama']);
    $posisi = $koneksi->quote($_POST['posisi']);
    $gaji = $koneksi->quote($_POST['gaji']);

    $sql = "INSERT INTO karyawan (nama, posisi, gaji) VALUES ($nama, $posisi, $gaji)";
    try {
        $koneksi->exec($sql);
        echo "<div class='alert alert-success'>Karyawan baru berhasil ditambahkan!</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Gagal menambahkan karyawan: " . $e->getMessage() . "</div>";
    }
}

// Include Bootstrap CSS
echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';

// Tombol kembali ke beranda di atas sebelah kiri
echo '<div class="mt-3 ml-3">
        <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
      </div>';

// Form untuk input data karyawan
echo '<div class="container mt-5">
        <h2>Tambah Karyawan</h2>
        <form action="" method="post">
            <div class="form-group">
                Nama: <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="form-group">
                Posisi: <input type="text" class="form-control" name="posisi" required>
            </div>
            <div class="form-group">
                Gaji: <input type="number" class="form-control" step="0.01" name="gaji" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Tambah Karyawan">
        </form>
      </div>';

// Query untuk mengambil data karyawan
try {
    $sql = "SELECT id, nama, posisi, gaji FROM karyawan";
    $result = $koneksi->query($sql);

    // Cek jika hasilnya ada
    if ($result->rowCount() > 0) {
        echo '<div class="container mt-5">
                <h2>Daftar Karyawan</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th>Gaji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>';
        // output data setiap baris
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["nama"] . "</td>
                    <td>" . $row["posisi"] . "</td>
                    <td>" . $row["gaji"] . "</td>
                    <td>
                        <a href='edit_karyawan.php?id=" . $row["id"] . "' class='btn btn-info'>Edit</a>
                        <a href='hapus_karyawan.php?id=" . $row["id"] . "' class='btn btn-danger'>Hapus</a>
                    </td>
                  </tr>";
        }
        echo '</tbody>
              </table>
            </div>';
    } else {
        echo "<div class='alert alert-warning'>0 hasil</div>";
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}

// Tutup koneksi
$koneksi = null;
?>
