<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

require_once "../backend/config/koneksi.php";

$idUser = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM user WHERE idUser='$idUser'");
$data = mysqli_fetch_assoc($query);

$foto = $data['profil'] ? "assets/img/profile/".$data['profil'] : "../aset/img/default.png";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f4f4f9;
        }

        .sidebar {
            width: 240px;
            background: #1f2937;
            color: #fff;
            padding-top: 32px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 22px;
        }

        .menu {
            display: flex;
            flex-direction: column;
        }

        .menu a {
            padding: 14px 24px;
            text-decoration: none;
            color: #e5e7eb;
            font-size: 16px;
            display: block;
            transition: 0.3s;
        }

        .menu a:hover {
            background: #374151;
        }

        .content {
            flex: 1;
            padding: 30px;
        }

        .welcome-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .welcome-box h1 {
            font-size: 26px;
            margin-bottom: 10px;
            color: #333;
        }

        .welcome-box p {
            font-size: 16px;
            color: #555;
        }

        .logout-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 16px;
            background: #ef4444;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #dc2626;
        }
        .container {
            width: 450px;
            background: #fff;
            padding: 25px;
            margin: 50px auto;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #ddd;
        }

        input[type="file"] {
            margin-top: 10px;
        }

        button {
            margin-top: 15px;
            padding: 10px 16px;
            background: #6366f1;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="sidebar">
        <h2>User Panel</h2>

        <div class="menu">
            <a href="dashboardUser.php">🏠 Home</a>
            <a href="catatanUser.php">📝 Catatan Tugas</a>
            <a href="profileUser.php">👤 Profile</a>
        </div>
    </div>

<div class="container">

    <h2>Profil Saya</h2>

    <?php if ($data['profil'] == NULL || $data['profil'] == "") { ?>
    
    <div style="
        width:130px;
        height:130px;
        border-radius:50%;
        background:#e5e7eb;
        display:flex;
        justify-content:center;
        align-items:center;
        font-weight:600;
        color:#555;
        margin:0 auto 15px auto;
        border:3px solid #ddd;">
        Photo Profile
    </div>

<?php } else { ?>

    <img src="<?= $foto ?>" alt="Foto Profil">

<?php } ?>


    <form action="../backend/pengguna/updateProfil.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="fotoBaru" accept="image/*" required>
        <button type="submit">Update Foto</button>
    </form>

</div>

</body>
</html>
