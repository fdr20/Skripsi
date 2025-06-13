<?php
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$edit_data = null;

// Tambah kepala bagian
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO kepala_bagian (nama, username, password) VALUES ('$nama', '$username', '$password')");
    echo "<script>alert('Data berhasil ditambahkan');location.href='index.php?page=admin/kepala_bagian.php';</script>";
}

// Hapus kepala bagian
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM kepala_bagian WHERE id=$id";
    mysqli_query($conn, $query);
    $_SESSION['alert'] = 'Data kepala bagian berhasil dihapus.';
    echo "<script>window.location='index.php?page=admin/kepala_bagian.php';</script>";
    exit;
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM kepala_bagian WHERE id=$id");
    $edit_data = mysqli_fetch_assoc($result);
}

// Update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE kepala_bagian SET nama='$nama', username='$username', password='$hash' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE kepala_bagian SET nama='$nama', username='$username' WHERE id=$id");
    }

    echo "<script>alert('Data berhasil diperbarui');location.href='index.php?page=admin/kepala_bagian.php';</script>";
}
?>

<h2 class="page-title">Kelola Kepala Bagian</h2>

<style>
    * { font-family: Arial, sans-serif; }

    .form-kepala {
        margin-top: 20px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .form-kepala input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        min-width: 200px;
    }

    .form-kepala button {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
        font-weight: bold;
    }

    .form-kepala button:hover {
        background-color: #388E3C;
    }

    .form-kepala a button {
        background-color: #9e9e9e;
    }

    .form-kepala a button:hover {
        background-color: #757575;
    }

    .table-kepala {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .table-kepala th,
    .table-kepala td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        text-align: center;
    }

    .table-kepala th {
        background-color: #4CAF50;
        color: white;
    }

    .page-title {
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0;
        color: #333;
    }

    .link-aksi {
        color: #1976d2;
        text-decoration: none;
        margin-right: 6px;
        font-weight: bold;
    }

    .link-aksi:last-child {
        margin-right: 0;
    }

    .link-aksi:hover {
        text-decoration: underline;
    }
</style>

<form method="post" class="form-kepala">
    <?php if ($edit_data): ?>
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <input type="text" name="nama" placeholder="Nama Lengkap" value="<?= $edit_data['nama'] ?>" required>
        <input type="text" name="username" placeholder="Username" value="<?= $edit_data['username'] ?>" required>
        <input type="password" name="password" placeholder="Password Baru (kosongkan jika tidak diganti)">
        <button type="submit" name="update">Update</button>
        <a href="index.php?page=admin/kepala_bagian.php"><button type="button">Batal</button></a>
    <?php else: ?>
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="tambah">Tambah Kepala Bagian</button>
    <?php endif; ?>
</form>

<table class="table-kepala">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM kepala_bagian");
        while ($row = mysqli_fetch_assoc($data)) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['nama']}</td>
                <td>{$row['username']}</td>
                <td>
                    <a href='index.php?page=admin/kepala_bagian.php&edit={$row['id']}' class='link-aksi'>Edit</a>
                    <a href='index.php?page=admin/kepala_bagian.php&hapus={$row['id']}' class='link-aksi' onclick=\"return confirm('Yakin ingin menghapus?')\">Hapus</a>
                </td>
            </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>
