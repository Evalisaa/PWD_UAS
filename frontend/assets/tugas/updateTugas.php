<?php
session_start();
require_once "../../../backend/config/koneksi.php";

// Pastikan menerima idTugas
if (!isset($_GET['id'])) {
    echo "ID Tugas tidak ditemukan!";
    exit();
}

$idTugas = $_GET['id'];

// Ambil data tugas berdasarkan id
$query = mysqli_query($conn, "SELECT * FROM tugas WHERE idTugas='$idTugas'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tugas tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>

    <style>
        body {
            font-family: "Inter", sans-serif;
            background: #f4f4f9;
            padding: 40px;
        }

        .container {
            background: white;
            width: 450px;
            margin: auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 14px;
            background: #6b7280;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #10b981;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #059669;
        }
    </style>
</head>

<body>

    <div class="container">

        <a class="back-btn" href="/catatanTugas/frontend/catatanUser.php">⟵ Kembali</a>

        <h2>Edit Tugas</h2>

        <form action="../../../backend/tugas/update.php" method="POST">

            <input type="hidden" name="idTugas" value="<?= $data['idTugas'] ?>">

            <label>Judul Tugas</label>
            <input type="text" name="judulTugas" value="<?= $data['judulTugas'] ?>" required>

            <label>Isi Tugas</label>
            <textarea name="IsiTugas" required><?= $data['IsiTugas'] ?></textarea>

            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>

            <button type="submit">Update Tugas</button>
        </form>

    </div>

</body>
</html>
