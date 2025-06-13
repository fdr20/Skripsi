<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];
$data = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($data);
?>

<style>
.profil-box {
    max-width: 500px;
    margin: 40px auto;
    background: #f0fdf4;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 12px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
}
.profil-box h2 {
    color: #2e7d32;
    text-align: center;
    margin-bottom: 25px;
}
.profil-box table {
    width: 100%;
}
.profil-box td {
    padding: 8px 0;
}
</style>

<div class="profil-box">
    <h2>Profil Saya</h2>
    <table>
        <tr><td><strong>Username:</strong></td><td><?= $user['username']; ?></td></tr>
        <tr><td><strong>Role:</strong></td><td><?= ucfirst($user['role']); ?></td></tr>
    </table>
</div>
