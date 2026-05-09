<?php
session_start();
// Memanggil koneksi database
require_once __DIR__ . '/koneksi.php'; 

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BromoTrack - Logistik Perjalanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #0f0c08; color: white; padding-top: 50px; }
        .glass-card { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(10px); 
            border-radius: 20px; 
            padding: 30px; 
            border: 1px solid rgba(255,255,255,0.1); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .btn-analisis { background-color: #E8621A; color: white; border: none; font-weight: 600; padding: 12px; }
        .btn-analisis:hover { background-color: #d15616; color: white; }
        .result-box { 
            display: none; 
            margin-top: 25px; 
            padding: 20px; 
            border-radius: 15px; 
            background: rgba(232, 98, 26, 0.1); 
            border-left: 5px solid #E8621A;
        }
        .label-custom { color: #E8621A; font-weight: 600; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="glass-card">
                <h3 class="text-center mb-4">Cek Logistik Perjalanan ke Bromo</h3>
                <p class="text-center opacity-75 small mb-5">Dapatkan rekomendasi moda transportasi, estimasi biaya (modal), dan waktu tempuh dari lokasi Anda.</p>

                <div class="mb-4">
                    <label class="form-label label-custom">Masukkan Kota / Kabupaten Asal Anda:</label>
                    <input type="text" id="input_kota" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Surabaya, Malang, Jakarta, dll">
                </div>

                <button class="btn btn-analisis w-100 rounded-pill" onclick="hitungLogistik()">Analisis Perjalanan Sekarang</button>

                <div id="hasil_analisis" class="result-box">
                    <h5 class="text-warning mb-3">Hasil Analisis Logistik:</h5>
                    <div id="konten_hasil"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function hitungLogistik() {
    const kota = document.getElementById('input_kota').value.trim().toLowerCase();
    const boxHasil = document.getElementById('hasil_analisis');
    const konten = document.getElementById('konten_hasil');

    if (kota === "") {
        alert("Mohon masukkan kota asal terlebih dahulu!");
        return;
    }

    boxHasil.style.display = "block";
    let data = "";

    // Logika pengkondisian berdasarkan wilayah
    if (kota.includes("surabaya") || kota.includes("sidoarjo")) {
        data = `
            <p><b>1. Rekomendasi Transportasi:</b><br>
               ⚡ Tercepat: Mobil Pribadi via Tol Paspro (Exit Tongas).<br>
               💰 Murah: KA Lokal (Surabaya - Probolinggo) lanjut sewa motor.</p>
            <p><b>2. Akumulasi Modal (Estimasi Biaya):</b><br>
               Bensin & Tol: ±Rp 250.000 (Mobil) | Tiket KA & Bensin: ±Rp 50.000 (Hemat).</p>
            <p><b>3. Estimasi Waktu Perjalanan:</b><br>
               Durasi: ± 2 jam 30 menit (Via Tol).</p>
        `;
    } 
    else if (kota.includes("malang")) {
        data = `
            <p><b>1. Rekomendasi Transportasi:</b><br>
               ⚡ Tercepat: Motor Pribadi via Tumpang - Jemplang.<br>
               💰 Murah: Motor Pribadi (Hemat BBM).</p>
            <p><b>2. Akumulasi Modal (Estimasi Biaya):</b><br>
               Bensin: ±Rp 30.000 (Motor) | Sewa Jeep: ±Rp 650.000/jeep.</p>
            <p><b>3. Estimasi Waktu Perjalanan:</b><br>
               Durasi: ± 1 jam 30 menit (Via Tumpang).</p>
        `;
    }
    else if (kota.includes("jakarta") || kota.includes("bandung")) {
        data = `
            <p><b>1. Rekomendasi Transportasi:</b><br>
               ⚡ Tercepat: Pesawat (Landing Surabaya/Malang) lanjut Travel.<br>
               💰 Murah: Kereta Api Ekonomi (Stasiun Malang/Probolinggo).</p>
            <p><b>2. Akumulasi Modal (Estimasi Biaya):</b><br>
               Transportasi Luar Kota: ±Rp 300.000 - Rp 1.200.000 (Tergantung moda).</p>
            <p><b>3. Estimasi Waktu Perjalanan:</b><br>
               Durasi: 12 - 15 jam (Darat) | 1.5 jam (Udara).</p>
        `;
    }
    else if (kota.includes("probolinggo") || kota.includes("pasuruan")) {
        data = `
            <p><b>1. Rekomendasi Transportasi:</b><br>
               ⚡ Tercepat: Motor/Mobil Pribadi (Rute Sukapura/Wonokitri).<br>
               💰 Murah: Motor Pribadi.</p>
            <p><b>2. Akumulasi Modal (Estimasi Biaya):</b><br>
               Bensin: ±Rp 20.000 - Rp 50.000.</p>
            <p><b>3. Estimasi Waktu Perjalanan:</b><br>
               Durasi: ± 45 menit - 1 jam.</p>
        `;
    }
    else {
        data = `
            <p><b>1. Rekomendasi Transportasi:</b><br>
               Gunakan Travel Antar Kota atau Kereta Api menuju Stasiun terdekat (Probolinggo/Malang).</p>
            <p><b>2. Akumulasi Modal (Estimasi Biaya):</b><br>
               Menyesuaikan tarif transportasi publik antar provinsi.</p>
            <p><b>3. Estimasi Waktu Perjalanan:</b><br>
               Bervariasi (Disarankan berangkat H-1 malam).</p>
        `;
    }
    // Tambahkan ini di paling bawah variabel 'data' sebelum konten.innerHTML
data += `
    <div class="mt-4 text-center">
        <hr border-secondary>
        <p class="small">Sudah siap berangkat?</p>
        <a href="beli_tiket.php" class="btn btn-primary rounded-pill w-100">Lanjut Pesan Tiket Wisata</a>
    </div>
`;

    konten.innerHTML = data;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>