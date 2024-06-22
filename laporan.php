<?php
include 'db.php'; // Mengganti 'koneksi.php' dengan 'db.php'

// Query untuk mengambil data karyawan dengan gaji terbesar
$query_gaji = "SELECT nama, gaji FROM karyawan ORDER BY gaji DESC LIMIT 5";
$result_gaji = $koneksi->query($query_gaji);  // Menggunakan objek PDO untuk query

// Query untuk mengambil data projek paling baru
$query_projek = "SELECT nama_projek, tanggal_mulai FROM projek ORDER BY tanggal_mulai DESC LIMIT 5";
$result_projek = $koneksi->query($query_projek);  // Menggunakan objek PDO untuk query

// Mengumpulkan data untuk JavaScript
$data_gaji = [];
while ($row = $result_gaji->fetch(PDO::FETCH_ASSOC)) {
    $data_gaji[] = $row;
}

$data_projek = [];
while ($row = $result_projek->fetch(PDO::FETCH_ASSOC)) {
    $data_projek[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Laporan</h1>
    <div>
        <h2>Chart Karyawan dengan Gaji Terbesar</h2>
        <canvas id="salaryChart"></canvas>
    </div>
    <div>
        <h2>Chart Projek Paling Baru</h2>
        <canvas id="projectChart"></canvas>
    </div>
    <script>
        // Data dari PHP
        var dataGaji = <?php echo json_encode($data_gaji); ?>;
        var dataProjek = <?php echo json_encode($data_projek); ?>;

        // Data untuk chart gaji
        var dataSalary = {
            labels: dataGaji.map(item => item.nama),
            datasets: [{
                label: 'Gaji',
                data: dataGaji.map(item => item.gaji),
                backgroundColor: dataGaji.map(() => getRandomColor())
            }]
        };

        // Data untuk chart projek
        var dataProject = {
            labels: dataProjek.map(item => item.nama_projek),
            datasets: [{
                label: 'Tanggal Mulai',
                data: dataProjek.map(item => new Date(item.tanggal_mulai)),
                backgroundColor: dataProjek.map(() => getRandomColor())
            }]
        };

        // Opsi untuk chart
        var options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Membuat chart gaji
        var ctxSalary = document.getElementById('salaryChart').getContext('2d');
        var salaryChart = new Chart(ctxSalary, {
            type: 'bar',
            data: dataSalary,
            options: options
        });

        // Membuat chart projek
        var ctxProject = document.getElementById('projectChart').getContext('2d');
        var projectChart = new Chart(ctxProject, {
            type: 'bar',
            data: dataProject,
            options: options
        });

        // Fungsi untuk menghasilkan warna acak
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
</body>
</html>
