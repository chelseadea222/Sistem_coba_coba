<?php 
require_once __DIR__ . '/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keluhan Pengunjung</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 30px auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #d9534f; text-align: center; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
        p.subtitle { text-align: center; color: #666; margin-bottom: 25px; font-size: 0.9em; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        textarea { resize: vertical; min-height: 120px; }
        
        /* Tombol Kirim */
        .btn-submit { width: 100%; background-color: #d9534f; color: white; padding: 14px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; transition: 0.3s; margin-bottom: 10px; }
        .btn-submit:hover { background-color: #c9302c; }
        
        /* Tombol Kembali */
        .btn-back { display: block; width: 100%; background-color: #6c757d; color: white; padding: 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: bold; text-align: center; text-decoration: none; box-sizing: border-box; transition: 0.3s; }
        .btn-back:hover { background-color: #5a6268; }

        .footer-note { margin-top: 20px; font-size: 0.8em; color: #888; text-align: center; }
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