<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

require_once "../backend/config/koneksi.php";

$idUser = $_SESSION['user_id'];

$queryTugas = mysqli_query($conn, "
    SELECT idTugas, judulTugas, IsiTugas AS isiTugas, tanggal 
    FROM tugas 
    WHERE idUser='$idUser' 
    ORDER BY idTugas DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Catatan Tugas Saya</title>

<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:Inter,sans-serif; }
body { display:flex; min-height:100vh; background:#f4f4f9; }

.sidebar {
    width:240px; background:#1f2937; color:white; padding-top:30px;
    height:100vh; position:fixed; left:0; top:0;
}
.sidebar .menu a {
    padding:14px 24px; display:block; text-decoration:none; color:#e5e7eb; transition:0.3s;
}
.sidebar .menu a:hover { background:#374151; }

.content { flex:1; padding:30px; margin-left:240px; }

.box { background:white; padding:25px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.08); }
.box h1 { margin-bottom:15px; }

.add-btn {
    background:#10b981; padding:10px 14px; border-radius:8px; color:white;
    text-decoration:none; font-size:14px;
}

.search-input {
    padding:10px; border:1px solid #ccc; border-radius:6px; margin-left:15px; width:260px;
}

table { width:100%; margin-top:15px; border-collapse:collapse; }
th, td { padding:12px; border:1px solid #ddd; }
th { background:#6366f1; color:white; }

.action-btn {
    padding:6px 12px; border-radius:6px; color:white; font-size:13px;
    text-decoration:none; border:none; cursor:pointer; transition:0.25s;
}
.edit { background:#3b82f6; }
.edit:hover { background:#2563eb; }
.delete { background:#ef4444; }
.delete:hover { background:#b91c1c; }
.view { background:#10b981; }
.view:hover { background:#059669; }

.popup {
    position:fixed; top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.5); display:none; justify-content:center; align-items:center; padding-left:240px;
}
.popup-content {
    background:white; padding:20px; width:450px; border-radius:10px; max-height:80vh; overflow-y:auto;
}
.close { float:right; cursor:pointer; color:red; font-size:20px; }
</style>

<script>
function openKomentar(id){ document.getElementById("popup-"+id).style.display = "flex"; }
function closeKomentar(id){ document.getElementById("popup-"+id).style.display = "none"; }

function searchTugas() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.getElementById("tugasTable").getElementsByTagName("tr");
    for(let i=1;i<rows.length;i++){
        let cells = rows[i].getElementsByTagName("td");
        let found=false;
        for(let j=1;j<cells.length-1;j++){
            if(cells[j].innerText.toLowerCase().indexOf(input) > -1){ found=true; break; }
        }
        rows[i].style.display = found ? "" : "none";
    }
}
</script>

</head>
<body>

<div class="sidebar">
    <h2 style="text-align:center;">User Panel</h2>
    <div class="menu">
        <a href="dashboardUser.php">🏠 Home</a>
        <a href="catatanUser.php">📝 Catatan Tugas</a>
        <a href="profileUser.php">👤 Profile</a>
    </div>
</div>

<div class="content">
<div class="box">

<h1>Catatan Tugas Saya</h1>
<a href="assets/tugas/add.html" class="add-btn">+ Tambah Tugas</a>
<input type="text" id="searchInput" class="search-input" placeholder="Cari tugas..." onkeyup="searchTugas()">

<table id="tugasTable">
<thead>
<tr>
<th>No</th>
<th>Judul</th>
<th>Isi Tugas</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php 
$no=1;
while($row=mysqli_fetch_assoc($queryTugas)):
    $idTugas = $row['idTugas'];
    $judulTugas = $row['judulTugas'];
    $isiTugas = $row['isiTugas'];
    $tanggal = $row['tanggal'];
?>

<tr>
<td><?= $no ?></td>
<td><?= $judulTugas ?></td>
<td><?= $isiTugas ?></td>
<td><?= $tanggal ?></td>
<td>
    <a href='assets/tugas/updateTugas.php?id=<?= $idTugas ?>' class='action-btn edit'>Edit</a>
    <a href='../backend/tugas/delete.php?id=<?= $idTugas ?>' onclick="return confirm('Apakah yakin ingin menghapus?');" class='action-btn delete'>Delete</a>
    <button class='action-btn view' onclick='openKomentar(<?= $idTugas ?>)'>Komentar</button>
</td>
</tr>

<div class='popup' id='popup-<?= $idTugas ?>'>
<div class='popup-content'>
<span class='close' onclick='closeKomentar(<?= $idTugas ?>)'>✖</span>
<h3>Komentar Admin</h3>
<hr><br>

<?php
$komentarQuery = mysqli_query($conn,"
    SELECT komentar.*, user.username AS namaAdmin
    FROM komentar
    LEFT JOIN user ON komentar.idUser = user.idUser
    WHERE komentar.idTugas='$idTugas' AND user.role='admin'
    ORDER BY komentar.idKomentar DESC
");

if(mysqli_num_rows($komentarQuery)==0){
    echo "<p>❌ Belum ada komentar.</p>";
}else{
    while($komen=mysqli_fetch_assoc($komentarQuery)){
        $namaAdmin = $komen['namaAdmin'] ?? 'Admin';
        $tglKomentar = $komen['tanggalKomentar'] ?? '';
        $isiKomentar = $komen['komentar'] ?? '';

        echo "<p><b>$namaAdmin</b><br><span style='color:gray;font-size:12px;'>$tglKomentar</span><br>$isiKomentar</p><hr>";
    }
}
?>

</div>
</div>

<?php 
$no++;
endwhile; 
?>
</tbody>
</table>

</div>
</div>

</body>
</html>
