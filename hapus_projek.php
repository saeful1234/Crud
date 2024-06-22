<?php
include 'db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM projek WHERE id = $id";
    if($koneksi->query($sql) === TRUE) {
        header("Location: projek.php?message=Projek berhasil dihapus");
    } else {
        header("Location: projek.php?message=Error: " . $koneksi->error);
    }
}
?>
