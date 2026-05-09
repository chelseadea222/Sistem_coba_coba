<?php 
require_once __DIR__ . '/koneksi.php'; 

// Data Destinasi Bromo Lengkap sesuai daftar Anda
$wisata_bromo = [
    ["nama" => "Penanjakan 1", "harga" => 220000],
    ["nama" => "Kawah Bromo", "harga" => 150000],
    ["nama" => "Pasir Berbisik", "harga" => 75000],
    ["nama" => "Bukit Teletubbies", "harga" => 50000],
    ["nama" => "Pura Luhur Poten", "harga" => 50000],
    ["nama" => "Bukit Kingkong", "harga" => 120000],
    ["nama" => "Bukit Cinta", "harga" => 100000],
    ["nama" => "Gunung Widodaren", "harga" => 100000],
    ["nama" => "Seruni Point", "harga" => 150000],
    ["nama" => "Padang Savana", "harga" => 50000],
    ["nama" => "Air Terjun Madakaripura", "harga" => 45000]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket Bromo - BromoTrack</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; margin: 0; padding: 10px; display: flex; justify-content: center; min-height: 100vh; }
        .ticket-container { width: 100%; max-width: 600px; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin: 20px auto; }
        .ticket-header { background: #E8621A; color: white; padding: 20px; text-align: center; }
        .ticket-header h2 { margin: 0; font-size: 1.5rem; text-transform: uppercase; }
        .ticket-body { padding: 25px; }
        .form-group { margin-bottom: 20px; }
        label.main-label { display: block; margin-bottom: 10px; font-weight: bold; color: #333; border-bottom: 2px solid #E8621A; padding-bottom: 5px; }
        .destinasi-list { max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 12px; background: #fafafa; }
        .check-item { display: flex; align-items: center; padding: 12px; border-bottom: 1px solid #eee; transition: 0.2s; cursor: pointer; }
        .check-item:hover { background: #fff8f4; }
        .check-item input { width: 20px; height: 20px; margin-right: 15px; accent-color: #E8621A; }
        .check-item label { flex: 1; display: flex; justify-content: space-between; font-size: 0.95rem; cursor: pointer; }
        .price-tag { font-weight: bold; color: #E8621A; }
        input[type="text"], input[type="number"] { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; box-sizing: border-box; font-size: 1rem; }
        .price-display { background: #fff8f4; padding: 15px; border-radius: 12px; margin: 20px 0; border: 1px dashed #E8621A; text-align: center; }
        .price-display strong { font-size: 1.8rem; color: #2c3e50; }
        button { width: 100%; background: #E8621A; color: white; padding: 16px; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background: #d15616; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="ticket-header">
        <h2>E-TICKET BROMO</h2>
        <p>Custom Trip Exploration</p>
    </div>
    
    <div class="ticket-body">
        <form action="proses_beli_tiket.php" method="POST">
            <div class="form-group">
                <label class="main-label">Nama Pengunjung</label>
                <input type="text" name="nama_pembeli" placeholder="Nama Lengkap sesuai KTP" required>
            </div>

            <div class="form-group">
                <label class="main-label">Pilih Destinasi Wisata</label>
                <div class="destinasi-list">
                    <?php foreach($wisata_bromo as $index => $item): ?>
                    <div class="check-item">
                        <input type="checkbox" name="id_wisata[]" value="<?= $index + 1 ?>" data-harga="<?= $item['harga'] ?>" id="w<?= $index ?>" onchange="updatePrice()">
                        <label for="w<?= $index ?>">
                            <?= $item['nama'] ?> 
                            <span class="price-tag">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="main-label">Jumlah Orang</label>
                <input type="number" name="jumlah" id="jumlah" min="1" value="1" required oninput="updatePrice()">
            </div>

            <div class="price-display">
                <span>Total Estimasi Bayar:</span>
                <strong id="total_bayar">Rp 0</strong>
            </div>

            <button type="submit" name="bayar_tiket">KONFIRMASI PEMESANAN</button>
        </form>
    </div>
</div>

<script>
function updatePrice() {
    const checkboxes = document.querySelectorAll('input[name="id_wisata[]"]:checked');
    const jumlahOrang = document.getElementById('jumlah').value;
    const totalDisplay = document.getElementById('total_bayar');
    
    let totalHargaPerOrang = 0;
    checkboxes.forEach((cb) => {
        totalHargaPerOrang += parseInt(cb.getAttribute('data-harga'));
    });

    const totalAkhir = totalHargaPerOrang * jumlahOrang;
    totalDisplay.innerText = "Rp " + totalAkhir.toLocaleString('id-ID');
}
updatePrice();
</script>
</body>
</html>