CREATE DATABASE manajemen_karyawan;

USE manajemen_karyawan;

CREATE TABLE karyawan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    posisi VARCHAR(50) NOT NULL,
    gaji DECIMAL(10, 2) NOT NULL
);
