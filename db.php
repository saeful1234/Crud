<?php
$host = 'localhost';
$dbname = 'manajemen_karyawan';
$username = 'root';  // ganti dengan username MySQL Anda
$password = '';  // ganti dengan password MySQL Anda

try {
    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);  // Ubah dari $conn menjadi $koneksi
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
