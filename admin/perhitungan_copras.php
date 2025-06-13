<?php
function hitung_copras($conn) {
    $data = [
        'kriteria' => [],
        'karyawan' => [],
        'matriks' => [],
        'normalisasi' => [],
        'splus' => [],
        'smin' => [],
        'q' => [],
        'ranking' => []
    ];

    // Step 1: Ambil data kriteria
    $qKriteria = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY id");
    while ($row = mysqli_fetch_assoc($qKriteria)) {
        $data['kriteria'][$row['id']] = [
            'nama' => $row['nama'],
            'bobot' => $row['bobot'],
            'jenis' => strtolower($row['jenis']) // benefit / cost
        ];
    }

    // Step 2: Ambil data karyawan
    $qKaryawan = mysqli_query($conn, "SELECT * FROM karyawan ORDER BY id");
    while ($row = mysqli_fetch_assoc($qKaryawan)) {
        $data['karyawan'][$row['id']] = $row;
    }

    // Step 3: Ambil penilaian dan buat matriks keputusan
    foreach ($data['karyawan'] as $id_karyawan => $k) {
        foreach ($data['kriteria'] as $id_kriteria => $kr) {
            $data['matriks'][$id_karyawan][$id_kriteria] = 0;
        }

        $qNilai = mysqli_query($conn, "SELECT sk.id_kriteria, sk.bobot 
            FROM penilaian p
            JOIN sub_kriteria sk ON p.id_sub_kriteria = sk.id
            WHERE p.id_karyawan = '$id_karyawan'");
        
        while ($n = mysqli_fetch_assoc($qNilai)) {
            $data['matriks'][$id_karyawan][$n['id_kriteria']] += $n['bobot'];
        }
    }

    // Step 4: Hitung total tiap kriteria untuk normalisasi
    $total_kriteria = [];
    foreach ($data['kriteria'] as $id_kriteria => $kr) {
        $total_kriteria[$id_kriteria] = 0;
        foreach ($data['karyawan'] as $id_karyawan => $k) {
            $total_kriteria[$id_kriteria] += $data['matriks'][$id_karyawan][$id_kriteria];
        }
    }

    // Step 5: Normalisasi dan pembobotan
    foreach ($data['karyawan'] as $id_karyawan => $k) {
        $data['normalisasi'][$id_karyawan] = [];
        foreach ($data['kriteria'] as $id_kriteria => $kr) {
            $nilai = $data['matriks'][$id_karyawan][$id_kriteria];
            $total = $total_kriteria[$id_kriteria] ?: 1;
            $normal = $nilai / $total;
            $bobot = $normal * $kr['bobot'];
            $data['normalisasi'][$id_karyawan][$id_kriteria] = $bobot;
        }
    }

    // Step 6: Hitung S+ dan S- (benefit & cost)
    foreach ($data['karyawan'] as $id_karyawan => $k) {
        $splus = 0;
        $smin = 0;
        foreach ($data['kriteria'] as $id_kriteria => $kr) {
            $val = $data['normalisasi'][$id_karyawan][$id_kriteria];
            if ($kr['jenis'] == 'benefit') {
                $splus += $val;
            } else {
                $smin += $val;
            }
        }
        $data['splus'][$id_karyawan] = $splus;
        $data['smin'][$id_karyawan] = $smin;
    }

    // Step 7: Hitung Q
    $min_smin = min(array_filter($data['smin'], fn($v) => $v > 0));
    foreach ($data['karyawan'] as $id_karyawan => $k) {
        $smin_k = $data['smin'][$id_karyawan] ?: 1;
        $data['q'][$id_karyawan] = $data['splus'][$id_karyawan] + ($min_smin / $smin_k);
    }

    // Step 8: Ranking
    $data['ranking'] = $data['q'];
    arsort($data['ranking']);

    return $data;
}
?>
