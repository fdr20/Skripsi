<?php
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM karyawan ORDER BY nama ASC";
$result = mysqli_query($conn, $query);
?>

<h2>Data Karyawan</h2>

<!-- Styling tabel karyawan -->
<style>
.karyawan-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin-top: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
}

.karyawan-table th {
    background-color: #2e7d32;
    color: white;
    padding: 12px;
    text-align: left;
}

.karyawan-table td {
    padding: 10px 14px;
    border-bottom: 1px solid #e0e0e0;
}

.karyawan-table tr:hover {
    background-color: #f1f8e9;
}

.karyawan-table .aksi a {
    margin-right: 10px;
    color: #1976d2;
    text-decoration: none;
    font-weight: bold;
}

.karyawan-table .aksi a:hover {
    text-decoration: underline;
}
</style>

<table class="karyawan-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th class="aksi">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['jabatan']}</td>
                    <td class='aksi'>
                        <a href='index.php?page=admin/edit_karyawan.php&id={$row['id']}'>Edit</a>
                        <a href='index.php?page=admin/hapus_karyawan.php&id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus karyawan ini?')\">Hapus</a>
                    </td>
                </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>
