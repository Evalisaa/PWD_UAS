<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../user/index.html");
    exit();
}

require_once "../config/koneksi.php";

$idUser = $_SESSION['user_id'];
$judul = $_POST['judulTugas'];
$isi = $_POST['IsiTugas'];
$tanggal = $_POST['tanggal'];

$query = mysqli_query($conn, "INSERT INTO tugas (idUser, judulTugas, IsiTugas, tanggal)
                              VALUES ('$idUser', '$judul', '$isi', '$tanggal')");

if ($query) {
    echo "<script>alert('Tugas berhasil ditambahkan!');
          window.location.href='../../frontend/catatanUser.php';</script>";
} else {
    echo "<script>alert('Gagal menambahkan tugas!');
          window.location.href='../../frontend/assets/tugas/add.html';</script>";
}
?>
