<?php
include 'db.php'; // Pastikan db.php menginisialisasi objek PDO

// Cek apakah ID projek telah diberikan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data projek berdasarkan ID
    $sql = "SELECT * FROM projek WHERE id = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $projek = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$projek) {
        echo "<div class='alert alert-danger'>Projek tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID projek tidak diberikan.</div>";
    exit;
}

// Proses update data projek
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nama_projek = $_POST['nama_projek'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];

    $sqlUpdate = "UPDATE projek SET nama_projek = :nama_projek, deskripsi = :deskripsi, tanggal_mulai = :tanggal_mulai, tanggal_selesai = :tanggal_selesai WHERE id = :id";
    $stmt = $koneksi->prepare($sqlUpdate);
    $stmt->bindParam(':nama_projek', $nama_projek);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->bindParam(':tanggal_mulai', $tanggal_mulai);
    $stmt->bindParam(':tanggal_selesai', $tanggal_selesai);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Redirect ke projek.php setelah update berhasil
        header("Location: projek.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->errorInfo()[2] . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Projek</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Projek</h2>
    <form action="" method="post">
        <div class="form-group">
            Nama Projek: <input type="text" class="form-control" name="nama_projek" value="<?php echo htmlspecialchars($projek['nama_projek']); ?>" required><br>
            Deskripsi: <textarea class="form-control" name="deskripsi"><?php echo htmlspecialchars($projek['deskripsi']); ?></textarea><br>
            Tanggal Mulai: <input type="date" class="form-control" name="tanggal_mulai" value="<?php echo $projek['tanggal_mulai']; ?>"><br>
            Tanggal Selesai: <input type="date" class="form-control" name="tanggal_selesai" value="<?php echo $projek['tanggal_selesai']; ?>"><br>
        </div>
        <input type="submit" name="submit" class="btn btn-primary" value="Update">
    </form>
</div>
</body>
</html>
