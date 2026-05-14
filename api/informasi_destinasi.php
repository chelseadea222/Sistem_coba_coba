<?php
/**
 * File: index.php
 */

$wisata_bromo = [
    ["nama" => "Penanjakan 1", "lokasi" => "Pasuruan", "img" => "https://images.unsplash.com/photo-1626074311145-2d186c3f3099?q=80&w=500", "desc" => "Titik tertinggi melihat matahari terbit dengan latar seluruh pegunungan Bromo."],
    ["nama" => "Kawah Bromo", "lokasi" => "Area Bromo", "img" => "https://images.unsplash.com/photo-1596401057633-531032215d7e?q=80&w=500", "desc" => "Kawah aktif yang menakjubkan, bisa diakses dengan menaiki 250 anak tangga."],
    ["nama" => "Pasir Berbisik", "lokasi" => "Kaldera Bromo", "img" => "https://images.unsplash.com/photo-1542451313-0949d0ca340c?q=80&w=500", "desc" => "Hamparan lautan pasir luas yang mengeluarkan suara desis saat tertiup angin."],
    ["nama" => "Bukit Teletubbies", "lokasi" => "Savana Bromo", "img" => "https://images.unsplash.com/photo-1510711789248-087061cda288?q=80&w=500", "desc" => "Bukit-bukit hijau yang cantik dan luas, mirip dengan pemandangan di film anak-anak."],
    ["nama" => "Pura Luhur Poten", "lokasi" => "Lautan Pasir", "img" => "https://images.unsplash.com/photo-1571474240337-142f1b4020a6?q=80&w=500", "desc" => "Pura sakral tempat ibadah suku Tengger yang berdiri kokoh di tengah hamparan pasir."],
    ["nama" => "Bukit Kingkong", "lokasi" => "Pasuruan", "img" => "https://images.unsplash.com/photo-1614264623707-164746f1406c?q=80&w=500", "desc" => "Spot sunrise alternatif yang menawarkan sudut pandang tebing yang unik dan gagah."],
    ["nama" => "Bukit Cinta", "lokasi" => "Pasuruan", "img" => "https://images.unsplash.com/photo-1611624838421-4f1f584e2621?q=80&w=500", "desc" => "Sering disebut Love Hill, tempat romantis untuk menikmati pemandangan kaldera."],
    ["nama" => "Gunung Widodaren", "lokasi" => "Dekat Kawah", "img" => "https://images.unsplash.com/photo-1612711812852-78be165a2d6f?q=80&w=500", "desc" => "Tebing batu yang megah, sering menjadi lokasi favorit untuk berfoto bersama Jeep."],
    ["nama" => "Seruni Point", "lokasi" => "Probolinggo", "img" => "https://images.unsplash.com/photo-1596401057633-531032215d7e?q=80&w=500", "desc" => "Puncak penanjakan ke-2 yang bisa diakses melalui tangga dari arah Probolinggo."],
    ["nama" => "Padang Savana", "lokasi" => "Selatan Bromo", "img" => "https://images.unsplash.com/photo-1510711789248-087061cda288?q=80&w=500", "desc" => "Padang rumput yang tenang dan hijau, memberikan sisi lembut dari alam Bromo."],
    ["nama" => "B-29 Argosari", "lokasi" => "Lumajang", "img" => "https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=500", "desc" => "Dikenal sebagai negeri di atas awan, menawarkan pemandangan Bromo dari sisi timur."]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Wisata Bromo - Eksplorasi Wisata Ikonik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/destinasi.css">
</head>
<body>

    <nav>
        <div class="nav-container">
            <a href="index.php" class="logo">Bromo<span>E-Wisata</span></a>
            <div class="nav-links">
                <a href="informasi_destinasi"><i class="bi bi-map"></i> Destinasi</a>
                <a href="rating.php"><i class="bi bi-star"></i> Ulasan</a>
                <a href="laporan_keluhan.php"><i class="bi bi-chat-dots"></i> Bantuan</a>
            </div>
        </div>
    </nav>

    <header class="hero">
        <h1>Jelajahi 11 Wisata Ikonik Bromo</h1>
        <p>Nikmati kemudahan eksplorasi keajaiban alam Taman Nasional Bromo Tengger Semeru dalam satu layanan terintegrasi.</p>
        <div class="hero-buttons">
            <a href="beli_tiket.php" class="btn-main btn-blue"><i class="bi bi-ticket-perforated"></i> Pesan Tiket Wisata</a>
            <a href="booking.php" class="btn-main btn-orange"><i class="bi bi-car-front"></i> Booking Penginapan</a>
            <a href="tiket.php" class="btn-main btn-blue"><i class="bi bi-truck"></i> Cek Estimasi Perjalanan</a>
        </div>
    </header>

    <div class="container" id="destinasi">
        <div class="section-title">
            <h2>Destinasi Wisata Unggulan</h2>
            <p>Geser ke samping untuk melihat detail 11 lokasi memukau</p>
            <hr>
        </div>

        <div class="scroll-wrapper">
            <?php foreach ($wisata_bromo as $w): ?>
                <div class="card">
                    <div class="card-img" style="background-image: url('<?= htmlspecialchars($w['img']); ?>');"></div>
                    <div class="card-header">
                        <h3><?= htmlspecialchars($w['nama']); ?></h3>
                        <span><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($w['lokasi']); ?></span>
                    </div>
                    <div class="card-body">
                        <p><?= htmlspecialchars($w['desc']); ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="informasi_destinasi.php?item=<?= urlencode($w['nama']) ?>" class="btn-sm">Detail Wisata <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="features-grid">
            <div class="feature-item">
                <i class="bi bi-people"></i>
                <h3>Ulasan Wisatawan</h3>
                <p>Simak pengalaman langsung dari ribuan wisatawan yang telah berkunjung.</p>
                <a href="rating.php" class="btn-sm">Baca Ulasan →</a>
            </div>
            <div class="feature-item">
                <i class="bi bi-headset"></i>
                <h3>Bantuan 24/7</h3>
                <p>Petugas kami siap membantu jika Anda menemukan kendala selama perjalanan.</p>
                <a href="laporan_keluhan.php" class="btn-sm">Lapor Kendala →</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 <strong>Manajemen Wisata Bromo</strong>. Semua Hak Dilindungi.</p>
    </footer>

</body>
</html>