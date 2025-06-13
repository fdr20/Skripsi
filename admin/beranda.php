<h2>Dashboard Admin</h2>
<p>Selamat datang, <?= $_SESSION['username']; ?>!</p>

<style>
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 30px;
    font-family: Arial, sans-serif;
}

.menu-box {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    border-radius: 12px;
    text-decoration: none;
    color: black;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: 0.2s;
}

.menu-box:hover {
    transform: translateY(-2px);
}

.menu-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
}

.menu-title {
    font-size: 17px;
    font-weight: bold;
    margin: 0;
    color: #333;
}

.menu-desc {
    font-size: 13px;
    color: #555;
    margin: 3px 0 0;
}

.green { background-color: #e8f5e9; border-left: 6px solid #2e7d32; }
.teal  { background-color: #e0f2f1; border-left: 6px solid #00796b; }
.orange { background-color: #fff3e0; border-left: 6px solid #f57c00; }
.blue { background-color: #e3f2fd; border-left: 6px solid #1976d2; }
.purple { background-color: #f3e5f5; border-left: 6px solid #7b1fa2; }
.red { background-color: #ffebee; border-left: 6px solid #d32f2f; }
</style>

<div class="menu-grid">
    <a href="index.php?page=admin/kriteria.php" class="menu-box green">
        <svg class="menu-icon" fill="#2e7d32" viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm0-4h2V7H3v2zm0 8h2v-2H3v2zm4 0h14v-2H7v2zm0-4h14v-2H7v2zm0-6v2h14V7H7z"/></svg>
        <div>
            <p class="menu-title">Kriteria</p>
            <p class="menu-desc">Kelola kriteria dan sub-kriteria penilaian.</p>
        </div>
    </a>
    <a href="index.php?page=admin/kepala_bagian.php" class="menu-box teal">
        <svg class="menu-icon" fill="#00796b" viewBox="0 0 24 24"><path d="M12 12c2.7 0 8 1.3 8 4v2H4v-2c0-2.7 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/></svg>
        <div>
            <p class="menu-title">Kepala Bagian</p>
            <p class="menu-desc">Kelola data kepala bagian perusahaan.</p>
        </div>
    </a>
    <a href="index.php?page=admin/daftar_karyawan.php" class="menu-box orange">
        <svg class="menu-icon" fill="#f57c00" viewBox="0 0 24 24"><path d="M16 11c1.7 0 4 0.8 4 2.5V17H4v-3.5C4 11.8 6.3 11 8 11h8zm-4-2a4 4 0 100-8 4 4 0 000 8z"/></svg>
        <div>
            <p class="menu-title">Karyawan</p>
            <p class="menu-desc">Lihat dan kelola data karyawan perusahaan.</p>
        </div>
    </a>
    <a href="index.php?page=admin/penilaian.php" class="menu-box blue">
        <svg class="menu-icon" fill="#1976d2" viewBox="0 0 24 24"><path d="M3 3v18h18V3H3zm16 16H5V5h14v14z"/><path d="M7 7h10v2H7zm0 4h7v2H7z"/></svg>
        <div>
            <p class="menu-title">Input Penilaian</p>
            <p class="menu-desc">Lakukan penilaian berdasarkan kriteria.</p>
        </div>
    </a>
    <a href="index.php?page=admin/lihat_penilaian.php" class="menu-box purple">
        <svg class="menu-icon" fill="#7b1fa2" viewBox="0 0 24 24"><path d="M3 5v14h18V5H3zm16 12H5V7h14v10z"/></svg>
        <div>
            <p class="menu-title">Lihat Penilaian</p>
            <p class="menu-desc">Tinjau data penilaian dari tiap admin.</p>
        </div>
    </a>
    <a href="index.php?page=admin/hasil_akhir.php" class="menu-box red">
        <svg class="menu-icon" fill="#d32f2f" viewBox="0 0 24 24"><path d="M12 6v6h6v-2h-4V6h-2zm-1 10H5v2h6v-2zM5 8h6V6H5v2zm0 4h9v-2H5v2z"/></svg>
        <div>
            <p class="menu-title">Hasil Akhir</p>
            <p class="menu-desc">Lihat hasil akhir perhitungan COPRAS.</p>
        </div>
    </a>
</div>
