<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Username sudah dipakai!";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'admin')");
        $pesan = "Admin berhasil ditambahkan!";
    }
}
?>

<style>
.admin-form {
    max-width: 500px;
    margin: 40px auto;
    background: #e8f5e9;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 12px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
}
.admin-form h2 {
    color: #2e7d32;
    text-align: center;
    margin-bottom: 25px;
}
.admin-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.admin-form button {
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

<div class="admin-form">
    <h2>Tambah Admin Baru</h2>
    <?php if (isset($pesan)) echo "<div style='color:#1b5e20;font-weight:bold;margin-bottom:15px;'>$pesan</div>"; ?>
    <form method="post">
        <input type="text" name="username" required placeholder="Username Baru">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit" name="simpan">Simpan Admin</button>
    </form>
</div>
