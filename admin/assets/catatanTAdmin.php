<?php
session_start();
require_once "../../backend/config/koneksi.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: index.html");
    exit();
}

$adminId = $_SESSION['admin_id'];

$queryTugas = mysqli_query($conn, "
    SELECT tugas.*, user.username 
    FROM tugas 
    INNER JOIN user ON tugas.idUser = user.idUser
    ORDER BY tugas.idTugas DESC
");

if (isset($_POST['kirimKomentar'])) {
    $idTugas = $_POST['idTugas'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    mysqli_query($conn, "
        INSERT INTO komentar (idTugas, idUser, komentar, tanggalKomentar)
        VALUES ('$idTugas', '$adminId', '$komentar', NOW())
    ");
}

if (isset($_POST['updateKomentar'])) {
    $idKomentar = $_POST['idKomentar'];
    $komentar = mysqli_real_escape_string($conn, $_POST['komentarEdit']);

    mysqli_query($conn, "
        UPDATE komentar SET komentar='$komentar' WHERE idKomentar='$idKomentar'
    ");
}

if (isset($_GET['deleteKomentar'])) {
    $idKomentar = $_GET['deleteKomentar'];
    mysqli_query($conn, "DELETE FROM komentar WHERE idKomentar='$idKomentar'");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin - Catatan Tugas</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:Inter,sans-serif; }
body { display:flex; background:#f4f4f9; min-height:100vh; }

.sidebar {
    width:240px; background:#1f2937; color:white;
    position:fixed; top:0; left:0; height:100vh;
    padding-top:25px;
}
.sidebar h2 { text-align:center; margin-bottom:20px; }
.sidebar .menu a {
    display:block; padding:14px 24px; text-decoration:none;
    color:#e5e7eb; transition:0.25s;
}
.sidebar .menu a:hover { background:#374151; }

.content { margin-left:240px; padding:30px; flex:1; }

table { width:100%; border-collapse:collapse; }
th, td { padding:12px; border:1px solid #ddd; }
th { background:#6366f1; color:white; }

.btn { padding:6px 10px; border-radius:6px; color:white; text-decoration:none; }
.comment-btn { background:#10b981; cursor:pointer; border:none; }
.edit-btn { background:#3b82f6; border:none; cursor:pointer; }
.delete-btn { background:#ef4444; border:none; cursor:pointer; }

.popup {
    position:fixed; top:0; left:240px; width:calc(100% - 240px); height:100%;
    background:rgba(0,0,0,0.55); display:none;
    justify-content:center; align-items:center;
}
.popup-content {
    background:white; padding:20px; border-radius:10px;
    width:480px; max-height:80vh; overflow-y:auto;
}
.close { float:right; cursor:pointer; font-size:18px; color:red; }

textarea { width:100%; }
</style>

<script>
function openPopup(id){ document.getElementById("popup-"+id).style.display = "flex"; }
function closePopup(id){ document.getElementById("popup-"+id).style.display = "none"; }
</script>

</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <div class="menu">
        <a href="berandaAdmin.php">🏠 Home</a>
        <a href="userAdmin.php">👤 Data User</a>
        <a href="catatanTAdmin.php">📝 Catatan Tugas</a>
    </div>
</div>

<div class="content">

<h1>Catatan Tugas Pengguna</h1>
<br>

<table>
<tr>
    <th>No</th>
    <th>User</th>
    <th>Judul</th>
    <th>Isi</th>
    <th>Tanggal</th>
    <th>Komentar</th>
</tr>

<?php $no=1; while($tugas=mysqli_fetch_assoc($queryTugas)):
$idTugas = $tugas['idTugas'];
$judul = $tugas['judulTugas'];
$isi = $tugas['IsiTugas'] ?? $tugas['isiTugas'];
$tanggal = $tugas['tanggal'];
?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= $tugas['username'] ?></td>
    <td><?= $judul ?></td>
    <td><?= $isi ?></td>
    <td><?= $tanggal ?></td>
    <td>
        <button class="btn comment-btn" onclick="openPopup(<?= $idTugas ?>)">💬 Komentar</button>
    </td>
</tr>

<div class="popup" id="popup-<?= $idTugas ?>">
    <div class="popup-content">
        <span class="close" onclick="closePopup(<?= $idTugas ?>)">✖</span>
        <h3>Komentar untuk: <?= $judul ?></h3>
        <hr><br>

        <form method="POST">
            <input type="hidden" name="idTugas" value="<?= $idTugas ?>">
            <textarea name="komentar" rows="3" required></textarea><br><br>
            <button type="submit" name="kirimKomentar" class="btn comment-btn">Kirim</button>
        </form>

        <br><hr><br>
        <h4>Daftar Komentar:</h4>

        <?php
        $qKomentar = mysqli_query($conn, "
            SELECT komentar.*, user.username
            FROM komentar
            LEFT JOIN user ON komentar.idUser = user.idUser
            WHERE idTugas='$idTugas'
            ORDER BY idKomentar DESC
        ");
        while($k=mysqli_fetch_assoc($qKomentar)):
            $namaAdmin = $k['username'] ?? 'Admin';
        ?>

        <div style="margin-bottom:20px;">
            <b><?= $namaAdmin ?></b>
            <span style="color:gray;">(<?= $k['tanggalKomentar'] ?>)</span><br>
            <?= $k['komentar'] ?><br><br>

            <!-- EDIT KOMENTAR -->
            <form method="POST">
                <input type="hidden" name="idKomentar" value="<?= $k['idKomentar'] ?>">
                <textarea name="komentarEdit" rows="2"><?= $k['komentar'] ?></textarea>
                <button class="btn edit-btn" name="updateKomentar">Edit</button>
                <a class="btn delete-btn" href="?deleteKomentar=<?= $k['idKomentar'] ?>" onclick="return confirm('Hapus komentar ini?')">Hapus</a>
            </form>
            <hr>
        </div>

        <?php endwhile; ?>

    </div>
</div>

<?php endwhile; ?>
</table>

</div>
</body>
</html>
