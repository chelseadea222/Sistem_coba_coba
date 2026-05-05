<?php
session_start();
// Memanggil proses logika tiket (pastikan file ini ada di folder api)
require_once __DIR__ . '/../api/proses_tiket.php';

// Data Lengkap Destinasi Wisata Bromo Satuan
$destinasi_bromo = [
    ['id' => 'ds1', 'nama' => 'Kawah Utama Bromo', 'harga' => 150000, 'ket' => 'Mendaki 250 anak tangga'],
    ['id' => 'ds2', 'nama' => 'Pasir Berbisik', 'harga' => 75000, 'ket' => 'Lautan pasir 10 km2'],
    ['id' => 'ds3', 'nama' => 'Padang Savana (Jemplang)', 'harga' => 75000, 'ket' => 'Lembah hijau luas'],
    ['id' => 'ds4', 'nama' => 'Bukit Teletubbies', 'harga' => 50000, 'ket' => 'Gundukan bukit estetik'],
    ['id' => 'ds5', 'nama' => 'Penanjakan 1 (Sunrise)', 'harga' => 200000, 'ket' => 'Viewpoint tertinggi 2.770 mdpl'],
    ['id' => 'ds6', 'nama' => 'Bukit Kingkong (Kedaluh)', 'harga' => 120000, 'ket' => 'Alternatif sunrise & kaldera'],
    ['id' => 'ds7', 'nama' => 'Bukit Cinta', 'harga' => 100000, 'ket' => 'Spot sunrise romantis'],
    ['id' => 'ds8', 'nama' => 'Bukit Mentigen', 'harga' => 80000, 'ket' => 'Dekat Cemoro Lawang'],
    ['id' => 'ds9', 'nama' => 'Pura Luhur Poten', 'harga' => 50000, 'ket' => 'Tempat ritual Yadnya Kasada'],
    ['id' => 'ds10', 'nama' => 'Gunung Widodaren', 'harga' => 100000, 'ket' => 'Spot foto tebing curam'],
    ['id' => 'ds11', 'nama' => 'Wisata Desa Suku Tengger', 'harga' => 50000, 'ket' => 'Wisata budaya & adat istiadat']
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BROMO TRACK - Smart Custom Trip</title>                               
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/tiket.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root { --orange: #E8621A; }
        .navbar { background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); }
        .glass-card { background: rgba(255, 255, 255, 0.07); backdrop-filter: blur(15px); border-radius: 20px; padding: 30px; border: 1px solid rgba(255,255,255,0.1); }
        .accordion-button { background: rgba(232, 98, 26, 0.1) !important; color: white !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; border-radius: 12px !important; }
        .accordion-button:not(.collapsed) { background: var(--orange) !important; }
        .accordion-item { background: transparent !important; border: none !important; }
        .destinasi-item { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; transition: 0.3s; padding: 15px; }
        .destinasi-item:hover { border-color: var(--orange); background: rgba(232, 98, 26, 0.05); }
        .btn-check-rute { background: var(--orange); color: white; border: none; font-weight: 600; }
        #box_rekomendasi { background: rgba(232, 98, 26, 0.15); border: 1px solid var(--orange); display: none; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-light fs-4" href="#">
                <i class="bi bi-geo-alt-fill text-warning me-2"></i>Bromo<span class="text-warning">Ticket</span>[cite: 2]
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h1 class="fw-bold mb-1">Custom Trip Bromo Explorer</h1>
                <p class="text-light opacity-75">Rancang petualanganmu sendiri dengan destinasi favorit di kawasan Bromo.[cite: 2]</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- SISI KIRI: FORM PERJALANAN -->
            <div class="col-lg-8">
                <div class="glass-card">
                    <h4 class="fw-bold mb-4 border-bottom border-secondary pb-3 text-warning">
                        <i class="bi bi-pencil-square me-2"></i>Rencana Keberangkatan
                    </h4>
                    
                    <form method="POST" action="">
                        <!-- DATA PERSONAL -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small opacity-75">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($_SESSION['nama'] ?? '') ?>" required>[cite: 2]
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small opacity-75">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control" placeholder="08xxxx" required>[cite: 2]
                            </div>
                        </div>

                        <!-- INPUT KOTA & ANALISIS RUTE -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label small text-warning fw-bold">Kota / Kabupaten Asal</label>
                                <input type="text" id="kota_asal" name="kota_asal" class="form-control" placeholder="Contoh: Malang / Jakarta" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" class="btn btn-check-rute btn-lg w-100" onclick="cekRute()">Cek Rute</button>
                            </div>
                        </div>

                        <div id="box_rekomendasi" class="p-3 rounded-4 mb-4">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill fs-4 me-3 text-warning"></i>
                                <div>
                                    <div class="fw-bold text-white small">Rekomendasi Transportasi:</div>
                                    <div id="teks_rekomendasi" class="small text-light opacity-75 mt-1"></div>
                                </div>
                            </div>
                        </div>

                        <!-- DESTINASI WISATA (ACCORDION) -->
                        <div class="accordion mb-5" id="accordionBromo">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWisata">
                                        <i class="bi bi-map-fill me-2"></i> Pilih Destinasi Wisata Satuan (Klik untuk Muncul)
                                    </button>
                                </h2>
                                <div id="collapseWisata" class="accordion-collapse collapse" data-bs-parent="#accordionBromo">
                                    <div class="accordion-body px-0 pt-3">
                                        <div class="row g-3">
                                            <?php foreach($destinasi_bromo as $db): ?>
                                            <div class="col-md-6">
                                                <div class="destinasi-item h-100">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="wisata[]" value="<?= $db['nama'] ?>|<?= $db['harga'] ?>" id="<?= $db['id'] ?>">
                                                        <label class="form-check-label w-100" for="<?= $db['id'] ?>">
                                                            <span class="d-block fw-bold text-light"><?= $db['nama'] ?></span>
                                                            <small class="d-block text-white-50 mb-1"><?= $db['ket'] ?></small>
                                                            <span class="text-warning fw-bold small">Rp<?= number_format($db['harga'],0,',','.') ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit_tiket" class="btn btn-bromo btn-lg w-100 rounded-pill py-3 fw-bold">
                            Konfirmasi Pesanan Trip <i class="bi bi-arrow-right ms-2"></i>[cite: 2]
                        </button>
                    </form>
                </div>
            </div>

            <!-- SISI KANAN: WIDGET -->
            <div class="col-lg-4">
                <div class="glass-card mb-4 text-center">
                    <h6 class="fw-bold text-warning mb-3 text-start"><i class="bi bi-cloud-sun me-2"></i>Cuaca Bromo Hari Ini</h6>
                    <div id="weather-data">
                        <div class="weather-temp text-warning fw-bold fs-1">18&deg;</div>
                        <h5 class="text-light">Berawan</h5>[cite: 2]
                        <div class="row mt-3 text-start small">
                            <div class="col-6 opacity-75">Angin: 7.7 km/h</div>[cite: 2]
                            <div class="col-6 opacity-75">Lembap: 74%</div>[cite: 2]
                        </div>
                    </div>
                </div>

                <div class="glass-card overflow-hidden p-0">
                    <h6 class="fw-bold text-warning p-3 mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Lokasi Strategis</h6>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126432.06208573516!2d112.87979659357497!3d-7.930466465415273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd637aaab794a41%3A0xada40d36ecd2a5dd!2sGn.%20Bromo!5e0!3m2!1sid!2sid!4v1713500000000!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>[cite: 2]
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function cekRute() {
        const kota = document.getElementById('kota_asal').value.trim().toLowerCase();
        const box = document.getElementById('box_rekomendasi');
        const teks = document.getElementById('teks_rekomendasi');

        if(kota === "") return alert("Harap isi Kota/Kabupaten asal!");

        box.style.display = "block";
        
        if(kota === "probolinggo" || kota === "malang" || kota === "pasuruan") {
            teks.innerHTML = "Jarak Dekat. Disarankan menggunakan <b>Motor Pribadi</b> untuk efisiensi biaya atau <b>Mobil Pribadi</b> untuk kenyamanan.";
        } else if(kota === "surabaya" || kota === "sidoarjo") {
            teks.innerHTML = "Jarak Menengah. Disarankan menggunakan <b>Mobil via Jalur Tol</b> untuk kecepatan, atau <b>Kereta Api Lokal</b> untuk opsi termurah.";
        } else {
            teks.innerHTML = "Jarak Jauh. Disarankan menggunakan <b>Kereta Api Ekonomi</b> ke Stasiun Malang/Probolinggo, atau <b>Travel Direct</b> untuk kenyamanan perjalanan jauh.";
        }
    }
    </script>
</body>
</html>