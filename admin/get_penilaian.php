<?php
require_once 'config.php';
session_start();

$id_admin = $_SESSION['user_id'];
$id_karyawan = $_POST['id_karyawan'];

$data = [];
$query = mysqli_query($conn, "
    SELECT sk.id_kriteria, p.id_sub_kriteria
    FROM penilaian p
    JOIN sub_kriteria sk ON p.id_sub_kriteria = sk.id
    WHERE p.id_admin='$id_admin' AND p.id_karyawan='$id_karyawan'
");

while ($row = mysqli_fetch_assoc($query)) {
    $data[$row['id_kriteria']] = $row['id_sub_kriteria'];
}

echo json_encode($data);
?>