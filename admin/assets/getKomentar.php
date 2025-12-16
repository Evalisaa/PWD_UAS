<?php
require_once "../../backend/config/koneksi.php";

$idTugas = $_GET['id'];

$q = mysqli_query($conn, "
    SELECT komentar.*, user.username
    FROM komentar
    INNER JOIN user ON komentar.idUser = user.idUser
    WHERE komentar.idTugas = '$idTugas'
    ORDER BY komentar.idKomentar DESC
");

$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}

echo json_encode($data);
