<?php 
require_once __DIR__ . '/koneksi.php'; 
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
        input, select { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        
        /* Style untuk box harga */
        .price-box { background: #e8f5e9; padding: 15px; border-radius: 8px; border: 1px dashed #27ae60; text-align: center; margin-top: 15px; }
        .price-box strong { font-size: 1.5rem; color: #219150; }
        
        button { width: 100%; background-color: #27ae60; color: white; padding: 15px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Reservasi Penginapan</h2>
    <form action="proses_booking.php" method="POST">
        <div class="form-grid">
            <div class="form-group full-width">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required>
            </div>
            
            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <input type="text" name="no_hp" required>
            </div>

            <div class="form-group">
                <label>Tipe Penginapan</label>
                <select name="tipe_penginapan" id="tipe_penginapan" onchange="hitungTotal()" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Villa" data-harga="750000">Villa (Rp 750.000 /malam)</option>
                    <option value="Camp" data-harga="150000">Camp (Rp 150.000 /malam)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Check-in</label>
                <input type="date" name="tgl_checkin" required>
            </div>

            <div class="form-group">
                <label>Durasi (Malam)</label>
                <input type="number" name="durasi" id="durasi" min="1" value="1" oninput="hitungTotal()" required>
            </div>

            <div class="form-group full-width">
                <div class="price-box">
                    <span>Total Estimasi Bayar:</span><br>
                    <strong id="display_total">Rp 0</strong>
                    <input type="hidden" name="total_bayar" id="input_total_bayar">
                </div>
            </div>
        </div>

        <button type="submit" name="submit_booking">PESAN SEKARANG</button>
        </form> <a href="landingpage.php" style="display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none; font-size: 14px;">
        &larr; Kembali ke Beranda
    </a>
    </form>
</div>

<script>
function hitungTotal() {
    const tipeSelect = document.getElementById('tipe_penginapan');
    const durasiInput = document.getElementById('durasi');
    const displayTotal = document.getElementById('display_total');
    const inputTotal = document.getElementById('input_total_bayar');

    // Ambil harga dari atribut data-harga pada option yang dipilih
    const selectedOption = tipeSelect.options[tipeSelect.selectedIndex];
    const hargaPerMalam = selectedOption.getAttribute('data-harga') || 0;
    const durasi = durasiInput.value || 0;

    const total = parseInt(hargaPerMalam) * parseInt(durasi);

    displayTotal.innerText = "Rp " + total.toLocaleString('id-ID');
    inputTotal.value = total;
}
</script>
</body>
</html>