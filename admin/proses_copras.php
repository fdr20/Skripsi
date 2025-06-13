<?php
require_once 'config.php';
require_once 'perhitungan_copras.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$data = hitung_copras($conn);
?>

<h2 class="page-title">Proses Perhitungan COPRAS</h2>

<style>
    body {
        font-family: Arial, sans-serif;
        padding-bottom: 50px;
    }

    .page-title {
        font-size: 26px;
        font-weight: bold;
        margin-top: 20px;
        color: #2c3e50;
    }

    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin: 30px 0 10px;
        color: #34495e;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px 14px;
        text-align: center;
        font-size: 18px;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) td {
        background-color: #f7f7f7;
    }

    .highlight {
        background-color: #e8f5e9;
        font-weight: bold;
    }
</style>

<!-- Matriks Keputusan -->
<h3 class="section-title">Matriks Keputusan</h3>
<table>
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <?php foreach ($data['kriteria'] as $id => $k): ?>
                <th><?= $k['nama'] ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['karyawan'] as $id_karyawan => $kar): ?>
            <tr>
                <td><?= $kar['nama'] ?></td>
                <?php foreach ($data['kriteria'] as $id_kriteria => $k): ?>
                    <td><?= $data['matriks'][$id_karyawan][$id_kriteria] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Normalisasi Terbobot -->
<h3 class="section-title">Normalisasi Terbobot</h3>
<table>
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <?php foreach ($data['kriteria'] as $id => $k): ?>
                <th><?= $k['nama'] ?> (<?= $k['jenis'] ?>)</th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['karyawan'] as $id_karyawan => $kar): ?>
            <tr>
                <td><?= $kar['nama'] ?></td>
                <?php foreach ($data['kriteria'] as $id_kriteria => $k): ?>
                    <td><?= number_format($data['normalisasi'][$id_karyawan][$id_kriteria], 4) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- S+, S-, Q, Ranking -->
<h3 class="section-title">Hasil Perhitungan Akhir</h3>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>S+</th>
            <th>S-</th>
            <th>Q</th>
            <th>Ranking</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ranking = 1;
        foreach ($data['ranking'] as $id_karyawan => $nilai_q):
        ?>
            <tr class="<?= $ranking === 1 ? 'highlight' : '' ?>">
                <td><?= $ranking ?></td>
                <td><?= $data['karyawan'][$id_karyawan]['nama'] ?></td>
                <td><?= number_format($data['splus'][$id_karyawan], 5) ?></td>
                <td><?= number_format($data['smin'][$id_karyawan], 5) ?></td>
                <td><?= number_format($data['q'][$id_karyawan], 5) ?></td>
                <td><?= $ranking ?></td>
            </tr>
        <?php $ranking++; endforeach; ?>
    </tbody>
</table>
