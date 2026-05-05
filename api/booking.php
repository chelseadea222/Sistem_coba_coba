<?php 
require_once __DIR__ . '/koneksi.php';  // Mengambil koneksi database dari folder api
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Villa & Camp</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 700px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 25px; border-bottom: 3px solid #27ae60; padding-bottom: 10px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        .full-width { grid-column: span 2; }
        
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; }
        input, select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        
        .type-selector { display: flex; gap: 15px; margin-top: 5px; }
        .type-option { flex: 1; text-align: center; padding: 15px; border: 2px solid #eee; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        .type-option:hover { border-color: #27ae60; background: #f9fffb; }
        
        button { width: 100%; background-color: #27ae60; color: white; padding: 15px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; transition: 0.3s; }
        button:hover { background-color: #219150; transform: translateY(-2px); }
        
        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
    </style>
</head>
<body>

<div class="container">
    <h2>Reservasi Penginapan</h2>
    <form action="api/proses_booking.php" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama sesuai identitas" required>
            </div>
            
            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <input type="text" name="no_hp" placeholder="Contoh: 08123456789" required>
            </div>

            <div class="form-group">
                <label>Tipe Penginapan</label>
                <select name="tipe_penginapan" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Villa">Villa (Bangunan)</option>
                    <option value="Camp">Camping Ground (Tenda)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Check-in</label>
                <input type="date" name="tgl_checkin" required>
            </div>

            <div class="form-group">
                <label>Durasi (Malam)</label>
                <input type="number" name="durasi" min="1" value="1" required>
            </div>

            <div class="form-group full-width">
                <label>Catatan Tambahan (Opsional)</label>
                <input type="text" name="catatan" placeholder="Misal: Tambah extra bed, lokasi dekat api unggun">
            </div>
        </div>

        <button type="submit" name="submit_booking">PESAN SEKARANG</button>
    </form>
</div>

</body>
</html>