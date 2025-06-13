<?php
require_once 'config.php';
session_start();

$id_admin = $_SESSION['user_id'];
$id_karyawan = $_POST['id_karyawan'];

$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM penilaian WHERE id_admin='$id_admin' AND id_karyawan='$id_karyawan'");
$result = mysqli_fetch_assoc($query);

echo json_encode(['sudah_dinilai' => $result['total'] > 0]);
?>
