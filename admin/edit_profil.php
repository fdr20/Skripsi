<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];
$data = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    mysqli_query($conn, "UPDATE users SET username='$username', password='$password' WHERE id='$id'");
    $_SESSION['username'] = $username;
    $_SESSION['alert'] = "Profil berhasil diperbarui!";
    header("Location: index.php?page=admin/profil_admin.php");
    exit;
}
?>

<style>
.edit-form {
    max-width: 500px;
    margin: 40px auto;
    background: #f1f8e9;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 12px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
}
.edit-form h2 {
    color: #2e7d32;
    text-align: center;
    margin-bottom: 25px;
}
.edit-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.edit-form button {
    width: 100%;
    background: #2e7d32;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}
</style>

<div class="edit-form">
    <h2>Edit Profil</h2>
    <form method="post">
        <input type="text" name="username" value="<?= $user['username']; ?>" required placeholder="Username Baru">
        <input type="password" name="password" placeholder="Password Baru (biarkan kosong jika tidak diganti)">
        <button type="submit" name="update">Simpan Perubahan</button>
    </form>
</div>
