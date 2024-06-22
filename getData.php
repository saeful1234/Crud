<?php
include 'db.php'; // Pastikan db.php menginisialisasi objek PDO

header('Content-Type: application/json');

$query = "SELECT nama, gaji FROM karyawan ORDER BY gaji DESC";
$stmt = $koneksi->prepare($query);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
