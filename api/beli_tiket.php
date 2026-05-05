<?php 
require_once __DIR__ . '/koneksi.php';  // Menggunakan koneksi dari folder api
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket Online</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #e9ecef; margin: 0; padding: 20px; }
        .ticket-container { max-width: 500px; margin: 40px auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .ticket-header { background: #3498db; color: white; padding: 25px; text-align: center; }
        .ticket-header h2 { margin: 0; text-transform: uppercase; letter-spacing: 2px; }
        
        .ticket-body { padding: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        
        input[type="text"], input[type="number"], select { 
            width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; box-sizing: border-box; transition: 0.3s; 
        }
        input:focus, select:focus { border-color: #3498db; outline: none; }
        
        .price-display { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #3498db; }
        .price-display span { display: block; font-size: 0.9em; color: #777; }
        .price-display strong { font-size: 1.2em; color: #2c3e50; }

        button { 
            width: 100%; background: #3498db; color: white; padding: 15px; border: none; border-radius: 8px; 
            font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; 
        }
        button:hover { background: #2980b9; transform: translateY(-2px); }
        
        .ticket-footer { background: #f1f1f1; padding: 15px; text-align: center; font-size: 0.8em; color: #999; border-top: 2px dashed #ddd; }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="ticket-header">
        <h2>E-Ticket Wisata</h2>
    </div>
    
    <div class="ticket-body">
        <form action="api/proses_beli_tiket.php" method="POST">
            <div class="form-group">
                <label>Nama Pengunjung</label>
                <input type="text" name="nama_pembeli" placeholder="Nama sesuai identitas" required>
            </div>

            <div class="form-group">
                <label>Pilih Destinasi</label>
                <select name="id_wisata" id="wisata" required onchange="updatePrice()">
                    <option value="">-- Pilih Lokasi --</option>
                    <option value="1" data-harga="15000">Pantai Biru (Rp 15.000)</option>
                    <option value="2" data-harga="25000">Gunung Pinus (Rp 25.000)</option>
                    <option value="3" data-harga="10000">Hutan Kota (Rp 10.000)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Tiket</label>
                <input type="number" name="jumlah" id="jumlah" min="1" value="1" required oninput="updatePrice()">
            </div>

            <div class="price-display">
                <span>Total Pembayaran:</span>
                <strong id="total_bayar">Rp 0</strong>
            </div>

            <button type="submit" name="bayar_tiket">KONFIRMASI PEMBAYARAN</button>
        </form>
    </div>

    <div class="ticket-footer">
        Harap tunjukkan e-ticket ini di pintu masuk wisata.
    </div>
</div>

<script>
function updatePrice() {
    const select = document.getElementById('wisata');
    const jumlah = document.getElementById('jumlah').value;
    const totalDisplay = document.getElementById('total_bayar');
    
    const selectedOption = select.options[select.selectedIndex];
    const harga = selectedOption.getAttribute('data-harga') || 0;
    
    const total = harga * jumlah;
    totalDisplay.innerText = "Rp " + total.toLocaleString('id-ID');
}
</script>

</body>
</html>