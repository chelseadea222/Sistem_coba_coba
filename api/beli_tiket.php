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
    <title>Pemesanan Tiket - BromoTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --accent: #E8621A; 
            --glass-dark: rgba(20, 20, 20, 0.7);
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?q=80&w=1200');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .glass-card { 
            background: var(--glass-dark); 
            backdrop-filter: blur(15px); 
            border-radius: 24px; 
            padding: 35px; 
            border: 1px solid rgba(255,255,255,0.15); 
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
        }

        .label-custom { 
            color: var(--accent); 
            font-weight: 600; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            margin-bottom: 10px;
            display: block;
        }

        .input-custom {
            background: rgba(255,255,255,0.1) !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px 18px;
        }

        /* Perbaikan visibilitas teks dropdown */
        .input-custom option {
            color: #333; 
            background-color: #fff; 
        }

        .input-custom:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 10px rgba(232, 98, 26, 0.3) !important;
        }

        .scroll-list { 
            max-height: 250px; 
            overflow-y: auto; 
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 15px; 
            padding: 10px; 
        }
        
        .check-item { 
            display: flex; 
            align-items: center; 
            padding: 12px; 
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
        }
        .check-item:hover { background: rgba(232, 98, 26, 0.1); }
        .check-item input { accent-color: var(--accent); width: 18px; height: 18px; }
        
        .destinasi-label { 
            flex: 1; 
            display: flex; 
            justify-content: space-between; 
            margin-left: 12px;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .price-text { color: var(--accent); font-weight: 700; }

        .btn-pay { 
            background-color: var(--accent); 
            color: white; 
            border: none; 
            font-weight: 700; 
            padding: 15px; 
            border-radius: 12px;
            transition: 0.3s;
            text-transform: uppercase;
            width: 100%;
            margin-top: 20px;
        }
        .btn-pay:hover { background-color: #d15616; transform: translateY(-2px); }

        .total-box {
            background: rgba(232, 98, 26, 0.1);
            border: 1px dashed var(--accent);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }

        .modal-overlay { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.85); 
            display: <?= $show_payment ? 'flex' : 'none' ?>; 
            justify-content: center; align-items: center; 
            z-index: 1000; padding: 20px;
        }
        .pay-card { 
            background: #1a1a1a; 
            width: 100%; max-width: 450px; 
            border-radius: 24px; border: 1px solid var(--accent);
            overflow: hidden; 
            animation: zoomIn 0.3s ease-out;
        }
        @keyframes zoomIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        
        .pay-header { background: var(--accent); padding: 20px; text-align: center; }
        .pay-body { padding: 35px; text-align: center; }
        .amount-display { font-size: 2.5rem; font-weight: 800; color: white; margin: 10px 0; }
        .bank-details { background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; text-align: left; margin: 20px 0; }
        .btn-done { display: block; background: white; color: black; padding: 15px; text-decoration: none; border-radius: 12px; font-weight: 800; margin-top: 20px; text-align: center; }
        
        .scroll-list::-webkit-scrollbar { width: 6px; }
        .scroll-list::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="glass-card">
                <div class="text-center mb-5">
                    <i class="bi bi-ticket-perforated fs-1 text-warning"></i>
                    <h2 class="fw-bold mt-2">Pesan Tiket Wisata</h2>
                    <p class="opacity-75 small">Pilih destinasi favoritmu dan dapatkan E-Ticket instan.</p>
                </div>

                <form action="" method="POST">
                    <div class="mb-4">
                        <label class="label-custom"><i class="bi bi-person me-2"></i>Nama Pengunjung</label>
                        <input type="text" name="nama_pembeli" class="form-control input-custom" placeholder="Nama Lengkap Sesuai KTP" required>
                    </div>

                    <div class="mb-4">
                        <label class="label-custom"><i class="bi bi-geo-alt me-2"></i>Pilih Destinasi</label>
                        <div class="scroll-list">
                            <?php foreach($wisata_bromo as $index => $item): ?>
                            <div class="check-item">
                                <input type="checkbox" name="id_wisata[]" value="<?= $index + 1 ?>" data-harga="<?= $item['harga'] ?>" id="w<?= $index ?>" onchange="updatePrice()">
                                <label for="w<?= $index ?>" class="destinasi-label">
                                    <span><?= $item['nama'] ?></span>
                                    <span class="price-text">Rp<?= number_format($item['harga'], 0, ',', '.') ?></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="label-custom"><i class="bi bi-people me-2"></i>Jumlah Orang</label>
                            <input type="number" name="jumlah" id="jumlah" min="1" value="1" class="form-control input-custom" required oninput="updatePrice()">
                        </div>
                        <div class="col-md-6">
                            <label class="label-custom"><i class="bi bi-wallet2 me-2"></i>Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select input-custom" required>
                                <option value="" disabled selected>Pilih Metode</option>
                                <option value="DANA">DANA</option>
                                <option value="OVO">OVO</option>
                                <option value="BCA">BCA Virtual Account</option>
                                <option value="BNI">BNI Virtual Account</option>
                            </select>
                        </div>
                    </div>

                    <div class="total-box">
                        <span class="small opacity-75">Total Bayar:</span><br>
                        <h3 class="fw-bold mb-0" id="total_bayar_display" style="color: var(--accent);">Rp 0</h3>
                    </div>

                    <button type="submit" name="bayar_tiket" class="btn-pay">Konfirmasi Pemesanan <i class="bi bi-arrow-right ms-2"></i></button>
                </form>

                <div class="text-center mt-4">
                    <a href="landingpage.php" class="text-white-50 text-decoration-none small"><i class="bi bi-house me-1"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay">
    <div class="pay-card">
        <div class="pay-header">
            <h4 class="fw-bold mb-0 text-white">Selesaikan Pembayaran</h4>
            <small class="text-white-50">ID: <?= $id_transaksi ?></small>
        </div>
        <div class="pay-body">
            <p class="text-white-50 small mb-0">Total transfer (<?= $metode_dipilih ?>):</p>
            <div class="amount-display">Rp <?= number_format($final_total, 0, ',', '.') ?></div>
            
            <div class="bank-details text-white">
                <?php if(in_array($metode_dipilih, ['DANA', 'OVO', 'GOPAY'])): ?>
                    <label class="label-custom">Nomor E-Wallet:</label>
                    <h5 class="fw-bold">0812-3456-7890</h5>
                <?php else: ?>
                    <label class="label-custom">Virtual Account:</label>
                    <h5 class="fw-bold">8801 0812 3456 7890</h5>
                <?php endif; ?>
                <p class="small text-white-50 mt-2 mb-0">A/N BROMOTRACK INDONESIA</p>
            </div>

            <p class="small text-white-50">Status akan diverifikasi manual setelah Anda mengunggah bukti bayar.</p>
            <a href="konfirmasi_pembayaran.php?id=<?= $id_transaksi ?>" class="btn-done">SAYA SUDAH BAYAR</a>
        </div>
    </div>
</div>

<script>
function updatePrice() {
    const checkboxes = document.querySelectorAll('input[name="id_wisata[]"]:checked');
    const jumlahOrang = document.getElementById('jumlah').value || 1;
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