<?php
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'kepala') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $id_kepala = $_SESSION['user_id'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];

    for ($i = 0; $i < count($nama); $i++) {
        $n = mysqli_real_escape_string($conn, $nama[$i]);
        $j = mysqli_real_escape_string($conn, $jabatan[$i]);
        if ($n && $j) {
            mysqli_query($conn, "INSERT INTO karyawan (nama, jabatan, id_kepala) VALUES ('$n', '$j', '$id_kepala')");
        }
    }

    echo "<script>alert('Karyawan berhasil ditambahkan!');location.href='index.php?page=kepala/data_karyawan.php';</script>";
}
?>

<style>
    table.form-karyawan {
        width: 100%;
        max-width: 700px;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table.form-karyawan th,
    table.form-karyawan td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
    }
    table.form-karyawan input {
        width: 95%;
        padding: 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    .tombol-aksi {
        margin-top: 20px;
        max-width: 700px;
        display: flex;
        justify-content: space-between;
    }
    .tombol-aksi button {
        padding: 10px 18px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }
    .tambah-btn {
        background-color: #2e7d32;
        color: white;
    }
    .simpan-btn {
        background-color: #2e7d32;
        color: white;
    }
    .hapus-btn {
        background-color: #d32f2f;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }
    .hapus-btn:hover {
        background-color: #b71c1c;
    }
</style>

<h2>Tambah Beberapa Karyawan</h2>

<form method="post">
    <table class="form-karyawan" id="formTable">
        <tr style="background-color:#c8e6c9;">
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>
        <tr>
            <td><input type="text" name="nama[]" required></td>
            <td><input type="text" name="jabatan[]" required></td>
            <td><button type="button" class="hapus-btn" onclick="hapusBaris(this)" title="Hapus Baris">×</button></td>
        </tr>
    </table>

    <div class="tombol-aksi">
        <button type="button" class="tambah-btn" onclick="tambahBaris()">+ Tambah Baris</button>
        <button type="submit" name="simpan" class="simpan-btn">Simpan Semua</button>
    </div>
</form>

<script>
function tambahBaris() {
    let table = document.getElementById('formTable');
    let row = table.insertRow();
    row.innerHTML = `
        <td><input type="text" name="nama[]" required></td>
        <td><input type="text" name="jabatan[]" required></td>
        <td><button type="button" class="hapus-btn" onclick="hapusBaris(this)" title="Hapus Baris">×</button></td>
    `;
}

function hapusBaris(btn) {
    let row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
</script>
