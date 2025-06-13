<?php
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kepala') {
    header("Location: login.php");
    exit;
}

$id_kepala = $_SESSION['user_id'];

// Proses hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM karyawan WHERE id=$id AND id_kepala=$id_kepala");
    echo "<script>location.href='index.php?page=kepala/data_karyawan.php';</script>";
}

// Ambil data untuk edit
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $q = mysqli_query($conn, "SELECT * FROM karyawan WHERE id=$id AND id_kepala=$id_kepala");
    $edit = mysqli_fetch_assoc($q);
}

// Proses update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    mysqli_query($conn, "UPDATE karyawan SET nama='$nama', jabatan='$jabatan' WHERE id=$id AND id_kepala=$id_kepala");
    echo "<script>alert('Data diperbarui!');location.href='index.php?page=kepala/data_karyawan.php';</script>";
}
?>

<h2>Data Karyawan Anda</h2>

<!-- Form edit -->
<?php if ($edit): ?>
    <form method="post" style="margin-bottom: 20px;">
        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
        <input type="text" name="nama" value="<?= $edit['nama'] ?>" required>
        <input type="text" name="jabatan" value="<?= $edit['jabatan'] ?>" required>
        <button type="submit" name="update">Update</button>
        <a href="index.php?page=kepala/data_karyawan.php"><button type="button">Batal</button></a>
    </form>
<?php endif; ?>

<!-- Filter -->
<input type="text" id="searchInput" placeholder="Cari nama atau jabatan..." 
       style="padding: 8px; width: 300px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 10px;">

<!-- Tabel -->
<table id="karyawanTable" border="1" cellpadding="8" cellspacing="0" style="width: 100%; max-width: 800px;">
    <thead>
        <tr style="background-color:#c8e6c9;">
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM karyawan WHERE id_kepala = '$id_kepala' ORDER BY nama ASC");
        while ($row = mysqli_fetch_assoc($data)) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['nama']}</td>
                <td>{$row['jabatan']}</td>
                <td>
                    <a href='index.php?page=kepala/data_karyawan.php&edit={$row['id']}'>Edit</a> |
                    <a href='index.php?page=kepala/data_karyawan.php&hapus={$row['id']}' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                </td>
            </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>

<!-- Script Filter -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#karyawanTable tbody tr');

    rows.forEach(row => {
        const nama = row.cells[1].textContent.toLowerCase();
        const jabatan = row.cells[2].textContent.toLowerCase();
        row.style.display = nama.includes(filter) || jabatan.includes(filter) ? '' : 'none';
    });
});
</script>
