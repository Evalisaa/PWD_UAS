<?php
session_start();
require_once "../config/koneksi.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND role='user'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    if (password_verify($password, $data['password'])) {

        $_SESSION['user_id'] = $data['idUser'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['profil'] = $data['profil'];

        header("Location: ../../frontend/dashboardUser.php");
        exit();

    } else {
        echo "<script>alert('Password salah!'); window.location.href='../../admin/admin_login.html';</script>";
    }
} else {
    echo "<script>alert('Akun admin tidak ditemukan!'); window.location.href='../../admin/admin_login.html';</script>";
}
?>
