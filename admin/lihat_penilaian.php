<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil parameter filter
$where = "1";
$admin_filter = "";
if (!empty($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];
    $where .= " AND users.id = '$admin_id'";
    $admin_filter = $admin_id;
}

$nama_filter = isset($_GET['nama_karyawan']) ? trim($_GET['nama_karyawan']) : '';
if ($nama_filter != '') {
    $where .= " AND karyawan.nama LIKE '%$nama_filter%'";
}

$tanggal_filter = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
if ($tanggal_filter != '') {
    $where .= " AND DATE(penilaian.tanggal) = '$tanggal_filter'";
}

?>

<h2>Lihat Detail Penilaian</h2>

<!-- Filter Form -->
<form method="get" style="margin-bottom: 20px; font-family: Arial, sans-serif;">
    <input type="hidden" name="page" value="admin/lihat_penilaian.php">
    
    <label>Filter Admin:</label>
    <select name="admin_id" style="margin-right: 20px;">
        <option value="">-- Semua Admin --</option>
        <?php
        $admins = mysqli_query($conn, "SELECT id, username FROM users WHERE role='admin'");
        while ($a = mysqli_fetch_assoc($admins)) {
            $sel = ($admin_filter == $a['id']) ? 'selected' : '';
            echo "<option value='{$a['id']}' $sel>{$a['username']}</option>";
        }
        ?>
    </select>

    <label>Nama Karyawan:</label>
    <input type="text" name="nama_karyawan" value="<?= htmlspecialchars($nama_filter) ?>" placeholder="Contoh: Beni" style="margin-right:20px;">

    <label>Tanggal:</label>
    <input type="date" name="tanggal" value="<?= htmlspecialchars($tanggal_filter) ?>" style="margin-right:20px;">

    </select>

    <button type="submit" style="margin-left: 20px;">Terapkan</button>
</form>

<!-- Table Style -->
<style>
.table-penilaian {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin-top: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
}
.table-penilaian th {
    background-color: #2e7d32;
    color: white;
    padding: 12px;
    text-align: left;
}
.table-penilaian td {
    padding: 10px 14px;
    border-bottom: 1px solid #eee;
}
.table-penilaian tr:hover {
    background-color: #f9f9f9;
}
</style>

<!-- Data Table -->
<table class="table-penilaian">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Kriteria</th>
            <th>Sub-Kriteria</th>
            <th>Bobot Sub</th>
            <th>Admin Penilai</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = mysqli_query($conn, "
            SELECT 
                karyawan.nama AS nama_karyawan,
                kriteria.nama AS nama_kriteria,
                sub_kriteria.nama AS nama_sub,
                sub_kriteria.bobot AS bobot_sub,
                users.username AS admin,
                penilaian.tanggal
            FROM penilaian
            JOIN karyawan ON penilaian.id_karyawan = karyawan.id
            JOIN sub_kriteria ON penilaian.id_sub_kriteria = sub_kriteria.id
            JOIN kriteria ON sub_kriteria.id_kriteria = kriteria.id
            JOIN users ON penilaian.id_admin = users.id
            WHERE $where
            ORDER BY penilaian.tanggal DESC
        ");

        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) {
            $tgl = date('d-m-Y H:i', strtotime($row['tanggal']));
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_karyawan']}</td>
                    <td>{$row['nama_kriteria']}</td>
                    <td>{$row['nama_sub']}</td>
                    <td>{$row['bobot_sub']}</td>
                    <td>{$row['admin']}</td>
                    <td>{$tgl}</td>
                  </tr>";
            $no++;
        }
        ?>
    </tbody>
</table>
