<?php
session_start();
require_once "../config/koneksi.php";

$idUser = $_SESSION['user_id'];

if (!isset($_FILES['fotoBaru'])) {
    echo "<script>alert('Tidak ada file yang diupload'); window.history.back();</script>";
    exit();
}

$foto = $_FILES['fotoBaru'];
$namaFile = $foto['name'];
$size = $foto['size'];
$tmp = $foto['tmp_name'];

$ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($ext, $allowed)) {
    echo "<script>alert('Format file tidak didukung!'); window.history.back();</script>";
    exit();
}

if ($size > 2000000) { 
    echo "<script>alert('Ukuran foto max 2MB!'); window.history.back();</script>";
    exit();
}

$namaBaru = "USR".$idUser."_".time().".".$ext;

$dest = "../../frontend/assets/img/profile/" . $namaBaru;

move_uploaded_file($tmp, $dest);

mysqli_query($conn, "
    UPDATE user 
    SET profil='$namaBaru'
    WHERE idUser='$idUser'
");

echo "<script>alert('Foto profil berhasil diperbarui!'); window.location.href='../../frontend/profileUser.php';</script>";
?>
