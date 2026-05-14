<?php 
require_once __DIR__ . '/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keluhan Pengunjung</title>
    <link rel="stylesheet" href="../css/keluhan.css">
    <style>
        
    </style>
</head>
<body>

<div class="container">
    <h2>Laporan Keluhan</h2>
    <p class="subtitle">Bantu kami meningkatkan kualitas layanan dengan melaporkan kendala Anda.</p>

    <form action="proses_keluhan.php" method="POST">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_pelapor" placeholder="Masukkan nama Anda" required>
        </div>

        <div class="form-group">
            <label>Email / No. HP</label>
            <input type="text" name="kontak_pelapor" placeholder="Email atau WhatsApp" required>
        </div>

        <div class="form-group">
            <label>Kategori Keluhan</label>
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Fasilitas">Fasilitas (Toilet, Parkir, dll)</option>
                <option value="Pelayanan">Pelayanan Petugas</option>
                <option value="Keamanan">Keamanan & Keselamatan</option>
                <option value="Kebersihan">Kebersihan Area</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label>Detail Keluhan</label>
            <textarea name="pesan_keluhan" placeholder="Ceritakan detail kendala yang Anda alami..." required></textarea>
        </div>

        <button type="submit" name="submit_keluhan" class="btn-submit">KIRIM LAPORAN SEKARANG</button>
        
        <a href="landingpage.php" class="btn-back">KEMBALI KE BERANDA</a>
    </form>

    <div class="footer-note">
        Laporan Anda akan segera diproses oleh tim manajemen wisata.
    </div>
</div>

</body>
</html>