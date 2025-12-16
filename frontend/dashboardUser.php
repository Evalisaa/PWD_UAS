<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/assets/index.html");
    exit();
}

require_once "../backend/config/koneksi.php";

$idUser = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT profil FROM user WHERE idUser='$idUser'");
$data = mysqli_fetch_assoc($query);

$fotoProfil = $data['profil'] ? "assets/img/profile/".$data['profil'] : "../aset/img/default.png";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>

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

    <div class="content">

        <div class="welcome-box" style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h1>Halo, <?= $_SESSION['username']; ?> 👋</h1>
                <h3>Email Anda : <?= $_SESSION['email']?></h3>
                <p>Selamat datang di Dashboard User Catatan Tugas.</p>

                <a href="../backend/auth/logout.php" class="logout-btn">Keluar</a>
            </div>

            <div>
                <img src="<?= $fotoProfil ?>" alt="Foto Profil" style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #ddd;">
            </div>
        </div>

    </div>

</body>

</html>
