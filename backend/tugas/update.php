<?php
require_once "../config/koneksi.php";

$idTugas = $_POST['idTugas'];
$judul = $_POST['judulTugas'];
$isi = $_POST['IsiTugas'];
$tanggal = $_POST['tanggal'];

$query = mysqli_query($conn, "
    UPDATE tugas SET 
        judulTugas='$judul',
        IsiTugas='$isi',
        tanggal='$tanggal'
    WHERE idTugas='$idTugas'
");

if ($query) {
    echo "<script>alert('Tugas berhasil diperbarui'); window.location.href='../../frontend/catatanUser.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui tugas'); window.history.back();</script>";
}
?>
