<?php
require_once 'config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id_admin = $_SESSION['user_id'];

// Simpan atau update penilaian
if (isset($_POST['simpan'])) {
    $id_karyawan = $_POST['id_karyawan'];

    // Hapus penilaian lama dari admin ini untuk karyawan itu
    mysqli_query($conn, "DELETE FROM penilaian WHERE id_karyawan='$id_karyawan' AND id_admin='$id_admin'");

    foreach ($_POST['nilai'] as $id_kriteria => $id_sub_kriteria) {
        $get = mysqli_query($conn, "SELECT bobot FROM sub_kriteria WHERE id = '$id_sub_kriteria'");
        $sub = mysqli_fetch_assoc($get);
        $nilai = $sub['bobot'];

        mysqli_query($conn, "INSERT INTO penilaian (id_admin, id_karyawan, id_sub_kriteria, nilai, tanggal)
                             VALUES ('$id_admin', '$id_karyawan', '$id_sub_kriteria', '$nilai', NOW())");
    }

    $_SESSION['alert'] = "Penilaian berhasil disimpan!";
    header("Location: index.php?page=admin/penilaian.php");
    exit;
}
?>

<h2 style="font-family: Arial; margin-top: 20px;">Form Penilaian Karyawan</h2>
<form method="post" id="formPenilaian" style="font-family: Arial;">
    <label for="id_karyawan" style="font-weight:bold;">Pilih Karyawan:</label>
    <select name="id_karyawan" id="id_karyawan" required style="padding: 8px; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 20px;">
        <option value="">-- Pilih Karyawan --</option>
        <?php
        $karyawan = mysqli_query($conn, "SELECT * FROM karyawan");
        while ($k = mysqli_fetch_assoc($karyawan)) {
            echo "<option value='{$k['id']}'>{$k['nama']} - {$k['jabatan']}</option>";
        }
        ?>
    </select>

    <table style="width:100%; border-collapse: collapse; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border-radius: 8px; overflow: hidden;">
        <thead>
            <tr style="background-color:#c8e6c9;">
                <th style="padding: 10px; text-align:left;">Kriteria</th>
                <th style="padding: 10px;">Sub-Kriteria (Pilih salah satu)</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT k.id AS kriteria_id, k.nama AS nama_kriteria, s.id AS sub_id, s.nama AS nama_sub 
                  FROM kriteria k 
                  JOIN sub_kriteria s ON k.id = s.id_kriteria 
                  ORDER BY k.id";
        $result = mysqli_query($conn, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[$row['kriteria_id']]['nama'] = $row['nama_kriteria'];
            $data[$row['kriteria_id']]['sub'][] = [
                'id' => $row['sub_id'],
                'nama' => $row['nama_sub']
            ];
        }
        foreach ($data as $kriteria_id => $info) {
            echo "<tr><td style='padding:12px; font-weight:bold;'>{$info['nama']}</td><td style='padding:12px;'>";
            foreach ($info['sub'] as $sub) {
                echo "<label style='display:block; margin-bottom:6px;'>
                        <input type='radio' name='nilai[{$kriteria_id}]' value='{$sub['id']}' 
                               data-kriteria='{$info['nama']}' data-sub='{$sub['nama']}' required>
                        {$sub['nama']}
                      </label>";
            }
            echo "</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <br>
    <div style="display:flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div>
            <button type="button" onclick="previewPenilaian()" style="padding: 8px 16px; border:none; background:#2196F3; color:white; border-radius:6px;">Preview</button>
            <button type="reset" style="padding: 8px 16px; border:none; background:#9e9e9e; color:white; border-radius:6px;">Reset Form</button>
            <a href="index.php?page=admin/penilaian.php">
                <button type="button" style="padding: 8px 16px; border:none; background:#9e9e9e; color:white; border-radius:6px;">Batal</button>
            </a>
        </div>
        <button type="submit" name="simpan" style="padding: 8px 18px; background: #4CAF50; color:white; border:none; border-radius: 6px;">Simpan Penilaian</button>
    </div>

    <div id="preview-box" style="display:none; margin-top:20px; padding:15px; border:1px solid #ccc; background:#f1f8e9; border-radius:8px;">
        <h3>Preview Penilaian</h3>
        <ul id="preview-list" style="margin-left: 20px;"></ul>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('id_karyawan').addEventListener('change', function() {
    const id_karyawan = this.value;
    if (!id_karyawan) return;

    fetch('cek_penilaian.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id_karyawan=' + id_karyawan
    })
    .then(res => res.json())
    .then(data => {
        if (data.sudah_dinilai) {
            Swal.fire({
                title: 'Karyawan sudah dinilai',
                text: 'Anda sudah pernah menilai karyawan ini. Ingin mengubah nilainya?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ubah Nilai',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (!result.isConfirmed) {
                    document.getElementById('id_karyawan').value = '';
                } else {
                    fetch('get_penilaian.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id_karyawan=' + id_karyawan
                    })
                    .then(res => res.json())
                    .then(data => {
                        for (const [id_kriteria, id_sub] of Object.entries(data)) {
                            const radio = document.querySelector(`input[name='nilai[${id_kriteria}]'][value='${id_sub}']`);
                            if (radio) radio.checked = true;
                        }
                    });
                }
            });
        }
    });
});

function previewPenilaian() {
    const list = document.getElementById('preview-list');
    list.innerHTML = '';

    const radios = document.querySelectorAll('input[type=radio]:checked');
    if (radios.length === 0) {
        list.innerHTML = "<li>Belum ada sub-kriteria yang dipilih.</li>";
    } else {
        radios.forEach(radio => {
            const kriteria = radio.getAttribute('data-kriteria');
            const sub = radio.getAttribute('data-sub');
            const li = document.createElement('li');
            li.textContent = `${kriteria}: ${sub}`;
            list.appendChild(li);
        });
    }
    document.getElementById('preview-box').style.display = 'block';
}
</script>
