<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

require_once "../../backend/config/koneksi.php";

$queryUser = mysqli_query($conn, "SELECT * FROM user WHERE role='user'");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data User</title>

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

        .box {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .box h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            background: #6366f1;
            color: white;
        }

        table th, table td {
            padding: 12px 14px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-size: 16px;
            color: #777;
        }
    </style>

</head>

<body>

    <div class="sidebar">
        <h2>Panel Admin</h2>

        <div class="menu">
            <a href="berandaAdmin.php">🏠 Home</a>
            <a href="userAdmin.php">👤 Data User</a>
            <a href="catatanTAdmin.php">📝 Catatan Tugas</a>
        </div>
    </div>

    <div class="content">
        <div class="box">
            <h1>Daftar User</h1>
            <input type="text" id="searchInput" placeholder="Cari user..." 
            style="padding:10px; width:300px; margin-bottom:15px; border:1px solid #ccc; border-radius:6px; font-size:14px;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID User</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    if (mysqli_num_rows($queryUser) > 0) {
                        while ($row = mysqli_fetch_assoc($queryUser)) {
                            echo "
                            <tr>
                                <td>$no</td>
                                <td>P{$row['idUser']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                            </tr>
                            ";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='5' class='no-data'>Tidak ada data user</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    <script src="js/searchUser.js"></script>

</body>

</html>