<?php
session_start();
require_once "../config/koneksi.php";

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo "<script>alert('Konfirmasi password tidak cocok!'); window.location.href='../../frontend/assets/daftar.html';</script>";
    exit();
}

$cekUsername = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
if (mysqli_num_rows($cekUsername) > 0) {
    echo "<script>alert('Username sudah digunakan!'); window.location.href='../../frontend/assets/daftar.html';</script>";
    exit();
}

$cekEmail = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
if (mysqli_num_rows($cekEmail) > 0) {
    echo "<script>alert('Email sudah digunakan!'); window.location.href='../../frontend/assets/daftar.html';</script>";
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$query = mysqli_query($conn, "
    INSERT INTO user (username, email, password, role)
    VALUES ('$username', '$email', '$hashedPassword', 'user')
");

if ($query) {
    echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location.href='../../frontend/assets/index.html';
          </script>";
    exit();
} else {
    echo "<script>
            alert('Terjadi kesalahan saat registrasi!');
            window.location.href='../../frontend/assets/daftar.html';
          </script>";
    exit();
}
?>
