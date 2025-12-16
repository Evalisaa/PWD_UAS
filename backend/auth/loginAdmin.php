<?php
session_start();
require_once "../config/koneksi.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND role='admin'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    if ($password === $data['password']) {

        $_SESSION['admin_id'] = $data['idUser'];
        $_SESSION['admin_nama'] = $data['username'];
        $_SESSION['admin_role'] = $data['role'];

        header("Location: ../../admin/assets/berandaAdmin.php");
        exit();

    } else {
        echo "<script>alert('Password salah!'); window.location.href='../../admin/admin_login.html';</script>";
    }
} else {
    echo "<script>alert('Akun admin tidak ditemukan!'); window.location.href='../../admin/admin_login.html';</script>";
}
?>
