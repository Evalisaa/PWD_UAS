<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    die("ERROR: Admin belum login");
}

require_once "../../backend/config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idTugas = $_POST['idTugas'];
    $komentar = $_POST['komentar'];
    $idUser = $_SESSION['admin_id']; 

    if (empty($komentar)) {
        die("Komentar tidak boleh kosong!");
    }

    $query = mysqli_query($conn, "
        INSERT INTO komentar (idTugas, idUser, komentar)
        VALUES ('$idTugas', '$idUser', '$komentar')
    ");

    if ($query) {
        header("Location: catatanTAdmin.php?success=1");
        exit();
    } else {
        echo "Gagal menambah komentar: " . mysqli_error($conn);
    }
}
?>
