<?php 
require_once __DIR__ . '/koneksi.php'; 

// Data Destinasi Bromo Lengkap
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

// Inisialisasi variabel untuk modal
$show_payment = false;
$id_transaksi = "";
$final_total = 0;
$nama_pembeli = "";
$metode_dipilih = "";

if (isset($_POST['bayar_tiket'])) {
    $nama_pembeli = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $jumlah_orang = (int)$_POST['jumlah'];
    $id_wisata_array = $_POST['id_wisata'] ?? [];
    $metode_dipilih = $_POST['metode_pembayaran'];

    if (!empty($id_wisata_array)) {
        $total_harga_per_orang = 0;
        $destinasi_pilihan = [];
        
        foreach ($id_wisata_array as $index) {
            $idx = $index - 1;
            $total_harga_per_orang += $wisata_bromo[$idx]['harga'];
            $destinasi_pilihan[] = $wisata_bromo[$idx]['nama'];
        }

        $final_total = $total_harga_per_orang * $jumlah_orang;
        $id_transaksi = "TRX-" . strtoupper(substr(md5(time()), 0, 8));
        $destinasi_str = implode(", ", $destinasi_pilihan);

        // Simpan ke Database (tambahkan kolom metode_pembayaran di tabel Anda jika diperlukan)
        $query = "INSERT INTO pemesanan_tiket (id_transaksi, nama_pembeli, destinasi, jumlah_orang, total_bayar, status) 
                  VALUES ('$id_transaksi', '$nama_pembeli', '$destinasi_str', '$jumlah_orang', '$final_total', 'Menunggu Pembayaran')";
        
        if (mysqli_query($koneksi, $query)) {
            $show_payment = true; 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan & Pembayaran - BromoTrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #E8621A; --dark: #2c3e50; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; margin: 0; padding: 10px; }
        .ticket-container { width: 100%; max-width: 600px; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin: 20px auto; }
        .ticket-header { background: var(--primary); color: white; padding: 20px; text-align: center; }
        .ticket-body { padding: 25px; }
        .form-group { margin-bottom: 20px; }
        label.main-label { display: block; margin-bottom: 10px; font-weight: bold; color: #333; border-bottom: 2px solid var(--primary); padding-bottom: 5px; }
        
        /* List Style */
        .scroll-list { max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 12px; background: #fafafa; padding: 5px; }
        .check-item, .method-item { display: flex; align-items: center; padding: 12px; border-bottom: 1px solid #eee; cursor: pointer; transition: 0.2s; }
        .check-item:hover, .method-item:hover { background: #fff8f4; }
        
        /* Input Style */
        input[type="text"], input[type="number"], select { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 10px; box-sizing: border-box; }
        .price-display { background: #fff8f4; padding: 15px; border-radius: 12px; margin: 20px 0; border: 1px dashed var(--primary); text-align: center; }
        .price-display strong { font-size: 1.8rem; color: var(--dark); }
        button { width: 100%; background: var(--primary); color: white; padding: 16px; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: bold; cursor: pointer; transition: 0.3s; }

        /* MODAL PEMBAYARAN */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); display: <?= $show_payment ? 'flex' : 'none' ?>; justify-content: center; align-items: center; z-index: 1000; padding: 15px; }
        .pay-card { background: white; width: 100%; max-width: 450px; border-radius: 20px; overflow: hidden; }
        .pay-header { background: var(--dark); color: white; padding: 20px; text-align: center; }
        .pay-body { padding: 30px; text-align: center; }
        .amount-box { font-size: 2rem; color: var(--primary); font-weight: bold; margin: 15px 0; }
        .bank-info { background: #f8f9fa; border: 1px solid #eee; padding: 15px; border-radius: 12px; text-align: left; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="ticket-header">
        <h2 style="margin:0">BROMOTRACK CHECKOUT</h2>
    </div>
    
    <div class="ticket-body">
        <form action="" method="POST">
            <div class="form-group">
                <label class="main-label"><i class="bi bi-person"></i> Nama Pengunjung</label>
                <input type="text" name="nama_pembeli" placeholder="Nama sesuai KTP" required>
            </div>

            <div class="form-group">
                <label class="main-label"><i class="bi bi-geo-alt"></i> Pilih Destinasi</label>
                <div class="scroll-list">
                    <?php foreach($wisata_bromo as $index => $item): ?>
                    <div class="check-item">
                        <input type="checkbox" name="id_wisata[]" value="<?= $index + 1 ?>" data-harga="<?= $item['harga'] ?>" id="w<?= $index ?>" onchange="updatePrice()">
                        <label for="w<?= $index ?>" style="flex:1; display:flex; justify-content:space-between; margin-left:10px; cursor:pointer;">
                            <?= $item['nama'] ?> <strong>Rp <?= number_format($item['harga'], 0, ',', '.') ?></strong>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="main-label"><i class="bi bi-people"></i> Jumlah Orang</label>
                <input type="number" name="jumlah" id="jumlah" min="1" value="1" required oninput="updatePrice()">
            </div>

            <div class="form-group">
                <label class="main-label"><i class="bi bi-wallet2"></i> Metode Pembayaran</label>
                <select name="metode_pembayaran" required>
                    <option value="" disabled selected>Pilih Metode...</option>
                    <optgroup label="E-Wallet">
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO / ShopeePay</option>
                        <option value="GOPAY">GoPay</option>
                    </optgroup>
                    <optgroup label="Transfer Bank (VA)">
                        <option value="BCA">BCA Virtual Account</option>
                        <option value="MANDIRI">Mandiri Virtual Account</option>
                        <option value="BNI">BNI Virtual Account</option>
                    </optgroup>
                    <optgroup label="Kartu Debit/Kredit">
                        <option value="DEBIT">Kartu Debit Online (Visa/Mastercard)</option>
                    </optgroup>
                </select>
            </div>

            <div class="price-display">
                <span>Total Bayar:</span><br>
                <strong id="total_bayar_display">Rp 0</strong>
            </div>

            <button type="submit" name="bayar_tiket">BAYAR SEKARANG</button>
        </form>
    </div>
</div>

<div class="modal-overlay">
    <div class="pay-card">
        <div class="pay-header">
            <h3 style="margin:0">SELESAIKAN PEMBAYARAN</h3>
            <small>ID: <?= $id_transaksi ?></small>
        </div>
        <div class="pay-body">
            <p>Silakan bayar menggunakan <strong><?= $metode_dipilih ?></strong>:</p>
            <div class="amount-box">Rp <?= number_format($final_total, 0, ',', '.') ?></div>
            
            <div class="bank-info">
                <?php if(in_array($metode_dipilih, ['DANA', 'OVO', 'GOPAY'])): ?>
                    <strong>Nomor E-Wallet:</strong><br>
                    <span style="font-size:1.2rem; color:var(--primary)">0812-3456-7890</span><br>
                    <small>A/N BROMOTRACK INDONESIA</small>
                <?php elseif($metode_dipilih == 'DEBIT'): ?>
                    <strong>Link Pembayaran Kartu:</strong><br>
                    <a href="#">Klik untuk masukkan detail kartu</a>
                <?php else: ?>
                    <strong>Nomor Virtual Account:</strong><br>
                    <span style="font-size:1.2rem; color:var(--primary)">8801 0812 3456 7890</span><br>
                    <small>Berlaku selama 24 jam</small>
                <?php endif; ?>
            </div>

            <p style="font-size: 0.8rem; color: #7f8c8d;">Status otomatis berubah setelah bayar</p>
            <a href="index.php" style="display:block; background:var(--primary); color:white; padding:15px; text-decoration:none; border-radius:12px; font-weight:bold;">SAYA SUDAH BAYAR</a>
        </div>
    </div>
</div>

<script>
function updatePrice() {
    const checkboxes = document.querySelectorAll('input[name="id_wisata[]"]:checked');
    const jumlahOrang = document.getElementById('jumlah').value;
    const totalDisplay = document.getElementById('total_bayar_display');
    
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