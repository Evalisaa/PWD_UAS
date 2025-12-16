<?php
require_once "../config/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM tugas WHERE idTugas='$id'");

if ($query) {
    echo "<script>
            alert('Tugas berhasil dihapus!');
            window.location.href='../../frontend/catatanUser.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus tugas!');
            window.history.back();
          </script>";
}
?>
