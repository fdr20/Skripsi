<?php
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// STEP 1: Ambil semua karyawan
$karyawan = [];
$nilai = []; // [id_karyawan][id_kriteria] = bobot sub-kriteria
$total_kriteria = [];

// Ambil semua kriteria + bobot
$kriteria = [];
$q1 = mysqli_query($conn, "SELECT * FROM kriteria");
while ($row = mysqli_fetch_assoc($q1)) {
    $kriteria[$row['id']] = [
        'nama' => $row['nama'],
        'bobot' => $row['bobot']
    ];
    $total_kriteria[$row['id']] = 0;
}

// Ambil semua data penilaian
$q2 = mysqli_query($conn, "
    SELECT p.id_karyawan, k.nama AS nama_karyawan, k.jabatan,
           sk.id_kriteria, sk.bobot AS bobot_sub
    FROM penilaian p
    JOIN sub_kriteria sk ON p.id_sub_kriteria = sk.id
    JOIN karyawan k ON p.id_karyawan = k.id
");

// Kelompokkan dan jumlahkan
while ($row = mysqli_fetch_assoc($q2)) {
    $id_k = $row['id_karyawan'];
    $id_kr = $row['id_kriteria'];

    if (!isset($nilai[$id_k])) {
        $karyawan[$id_k] = [
            'nama' => $row['nama_karyawan'],
            'jabatan' => $row['jabatan']
        ];
        $nilai[$id_k] = [];
    }

    if (!isset($nilai[$id_k][$id_kr])) {
        $nilai[$id_k][$id_kr] = 0;
    }

    $nilai[$id_k][$id_kr] += $row['bobot_sub'];
    $total_kriteria[$id_kr] += $row['bobot_sub'];
}

// STEP 2: Normalisasi & kali bobot
$normalisasi = [];
$s_plus = [];

foreach ($nilai as $id_karyawan => $nilai_kriteria) {
    $normalisasi[$id_karyawan] = [];
    $s_total = 0;

    foreach ($kriteria as $id_kr => $kr) {
        $nilai_mentah = $nilai_kriteria[$id_kr] ?? 0;
        $total = $total_kriteria[$id_kr] ?: 1;
        $norm = $nilai_mentah / $total;
        $terbobot = $norm * $kr['bobot'];
        $normalisasi[$id_karyawan][$id_kr] = $terbobot;
        $s_total += $terbobot;
    }

    $s_plus[$id_karyawan] = $s_total;
}

arsort($s_plus);
?>

<h2 class="judul-hasil">Hasil Akhir Penilaian <span>(Metode COPRAS)</span></h2>

<style>
    * {
        font-family: Arial, sans-serif;
    }

    .judul-hasil {
        font-size: 22px;
        margin-top: 20px;
        margin-bottom: 25px;
        color: #222;
    }

    .judul-hasil span {
        font-size: 16px;
        color: #666;
    }

    .tabel-hasil {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow: 0 0 6px rgba(0,0,0,0.08);
    }

    .tabel-hasil th,
    .tabel-hasil td {
        border: 1px solid #ddd;
        padding: 10px 14px;
        text-align: center;
    }

    .tabel-hasil thead {
        background-color: #4CAF50;
        color: white;
    }

    .tabel-hasil tbody tr:first-child {
        background-color: #e8f5e9;
        font-weight: bold;
    }

    .btn-proses-copras {
        display: inline-block;
        background-color: #388e3c;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.2s ease-in-out;
    }

    .btn-proses-copras:hover {
        background-color: #2e7d32;
    }
</style>

<table class="tabel-hasil">
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Skor Akhir (Q)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $rank = 1;
        foreach ($s_plus as $id_k => $q) {
            echo "<tr>
                    <td>{$rank}</td>
                    <td>{$karyawan[$id_k]['nama']}</td>
                    <td>{$karyawan[$id_k]['jabatan']}</td>
                    <td>" . number_format($q, 4) . "</td>
                </tr>";
            $rank++;
        }
        ?>
    </tbody>
</table>

<a href="index.php?page=admin/proses_copras.php" class="btn-proses-copras">
    🔍 Lihat Proses COPRAS
</a>
<a href="admin/export/export_penilaian_pdf.php" target="_blank">
    <button>📄 Ekspor ke PDF</button>
</a>
