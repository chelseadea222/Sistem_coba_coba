<?php
/**
 * File: landingpage.php
 */

$wisata_bromo = [
    ["nama" => "Penanjakan 1", "lokasi" => "Pasuruan", "img" => "https://images.openai.com/static-rsc-4/y5ZEBJVzWblmPNXKXzXCpOiEMvwshGNwleMYOGKBXlCpmtz6tXKxPdIj1LQIdT37TKpqjUegA_j5IolwQ09h9tBcy2kNvwpX0rTTE7WOLBhBy5b0s_gnN3DwlN_P-8ZPu9nCzUSPXcA4jWWkLu6NeYzdnTa3oOq1vzzPem3ouQM_kTtiddDSUO8fanE5QXdV?purpose=fullsize", "desc" => "Titik tertinggi melihat matahari terbit dengan latar seluruh pegunungan Bromo."],
    ["nama" => "Kawah Bromo", "lokasi" => "Area Bromo", "img" => "https://images.openai.com/static-rsc-4/iXSoR4MlFMZ804-QF98Ce3r8YF7soR1xrdtomH9NLmRiTjjyfnU60Gahdold4FKBt-ZDlJJpMTZwqIdOEsLW8Hh6qkORumCa-GHVTI_Q6BZte--AUVeHtv1T7DPzFInL1v2gReYORAeh3uG5L2C2T9_DBJTQFyJ2-vIF7YNwWkJQXSGh64pnj7AgNKxzhO5S?purpose=fullsize", "desc" => "Kawah aktif yang menakjubkan, bisa diakses dengan menaiki 250 anak tangga."],
    ["nama" => "Pasir Berbisik", "lokasi" => "Kaldera Bromo", "img" => "https://images.openai.com/static-rsc-4/y3sZVrLT76xpXkh8xnp5Tyadjv4R6I6SuOFvHOaweNcYDqRKu6gJ1nubKxNnqioNetNqag0TzVUMJA_h8aClUhgFPHMaHetCNDk2LduPdoPggpT0FfIwBeA8ToJcBBdVtSABgp7FX04OCu4TksvoGjtlBLzzHajBTQMuxPkJUiKQjOUI6hb9t5Fl9PxeCol-?purpose=fullsize", "desc" => "Hamparan lautan pasir luas yang mengeluarkan suara desis saat tertiup angin."],
    ["nama" => "Bukit Teletubbies", "lokasi" => "Savana Bromo", "img" => "https://images.openai.com/static-rsc-4/jEJa1xbLo-r43fcp2MTmZ7fljKkZ5LbOneKf8v1yvBA95eqMCInNupKZnDchwHs_8hVcOtkpwOGF0LuXQ86b5iPdeisZp3l4WhKuKEZJzSSlMQCKkwQ_5ddDnqb1E6SsSE5q8KMQ1vea9ualrVOfuypJZ36IWvMjR3Tuy9r1es7wZCxssJ7DVnbEVidTj7KR?purpose=fullsize", "desc" => "Bukit-bukit hijau yang cantik dan luas, mirip dengan pemandangan di film anak-anak."],
    ["nama" => "Pura Luhur Poten", "lokasi" => "Lautan Pasir", "img" => "https://images.openai.com/static-rsc-4/oPQzYdndzpHq6sM9gp3QkKgKL7h16DgAfWDFZiLZeE7Hz8fbZaDNx-abRzby7LW5nJewTnbRxZ6b5myfdAngRar0FLGrjsfmscYOtLtfIpySdqifw7HsD0tiKsj8tWVX3cQLv58QDCI2anNocJvk7g2u1IVMd1FT2KUmvaWc5gK7g9C7WrU8Xr4R6XaIWOmW?purpose=fullsize", "desc" => "Pura sakral tempat ibadah suku Tengger yang berdiri kokoh di tengah hamparan pasir."],
    ["nama" => "Bukit Kingkong", "lokasi" => "Pasuruan", "img" => "https://i.pinimg.com/736x/2f/28/5a/2f285a8b97f054c551380ff67639bc00.jpg", "desc" => "Spot sunrise alternatif yang menawarkan sudut pandang tebing yang unik dan gagah."],
    ["nama" => "Bukit Cinta", "lokasi" => "Pasuruan", "img" => "https://images.openai.com/static-rsc-4/qp_xJF5WlhV9TUHR8426ntRoQy_dFJsRRzR3AnPk52Cc4i_7k3qEgyolSAqUd0PcVUb8R_jObGd8jFXwNOlFe0tK1p7HSmiWnQdeaoCTFqw3uqqqTW2sCqDA5kP5elS83DAfGRMXQVdGvd5mrps-VBPHW0aOhKH5ahGS8Ly9Uam2vJSh82K0mINCaDIv_gGB?purpose=fullsize", "desc" => "Sering disebut Love Hill, tempat romantis untuk menikmati pemandangan kaldera."],
    ["nama" => "Gunung Widodaren", "lokasi" => "Dekat Kawah", "img" => "https://i.pinimg.com/736x/c5/00/67/c500670b992fd00d635ddde1cbae3ca3.jpg", "desc" => "Tebing batu yang megah, sering menjadi lokasi favorit untuk berfoto bersama Jeep."],
    ["nama" => "Seruni Point", "lokasi" => "Probolinggo", "img" => "https://images.openai.com/static-rsc-4/DSETrAcn2a4qJMXdohJcDf2XOLywDL4q50x-mcjczVEdDxJoKbYI3Alo_PqDBhMpNbKIDVrXnUJYjBbr3TffmpHgIcpEFnVZ_ATGcan8XHcvCSdZfJ2I2Y6EsJCYOxqX6k7kn3I4Be7GqyzoeKfWG_p87H3qCHRgGFMn-p0D6yfQvDoXE3OBhxke-j41fJof?purpose=fullsize", "desc" => "Puncak penanjakan ke-2 yang bisa diakses melalui tangga dari arah Probolinggo."],
    ["nama" => "Padang Savana", "lokasi" => "Selatan Bromo", "img" => "https://images.openai.com/static-rsc-4/lA_CXuwWdaOLtCVUD4LLJN3JBguOuOT2SbtxQ7sn1AklCrru34lTrB3FXHYgwkMlXk3pcNFUEACAdS02pj_nXpLeIDrOwXegaeCo0WglgTjGrd2eQ9M0NE1YaDT8E9Hx-RcZjhX5NOEYDOblikhLpQsGHq5FfirgU5qmNf95oClGK27ZI3MnWJfggS-rRF-F?purpose=fullsize", "desc" => "Padang rumput yang tenang dan hijau, memberikan sisi lembut dari alam Bromo."],
    ["nama" => "Air Terjun Madakaripura", "lokasi" => "Lumajang", "img" => "https://images.openai.com/static-rsc-4/YPErXL49e1c41G_Pdvtgl17K8caVCpabI0PqiDujA2BsLy6VTDDrkbhFSlspCfDKByIrFN2qNRsg28AOx077UNoopVckJm_ifbww7IRgePIfVKokAmDOhV3hn6bhxqORBdoEHsGRZQqxK9ulhWdqtjbKL38j6UUjZkLATpyuVZxWW1t7fGj6tynlzR_HQ6-R?purpose=fullsize", "desc" => "Air terjun terkenal dekat kawasan Bromo.."]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Wisata Bromo - Eksplorasi Wisata Ikonik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/landingpage.css">
</head>
<body>

    <nav>
        <div class="nav-container">
            <a href="index.php" class="logo">Bromo<span>E-Wisata</span></a>
            <div class="nav-links">
                <a href="#destinasi"><i class="bi bi-map"></i> Destinasi</a>
                <a href="rating.php"><i class="bi bi-star"></i> Ulasan</a>
                <a href="laporan_keluhan.php"><i class="bi bi-chat-dots"></i> Bantuan</a>
                <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')" style="color: #e74c3c; font-weight: bold;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <header class="hero">
        <h1>Eksplorasi Bromo Tanpa Batas, Trip Kustom Sesuai Gayamu</h1>
        <p>Tak perlu bingung rute dan biaya. Pilih destinasi favoritmu, cek logistik perjalanan, dan biarkan kami yang mengurus sisanya untuk petualangan yang tak terlupakan.</p>
        <div class="hero-buttons">
            <a href="beli_tiket.php" class="btn-main btn-blue"><i class="bi bi-ticket-perforated"></i> Pesan Tiket Wisata</a>
            <a href="booking.php" class="btn-main btn-orange"><i class="bi bi-car-front"></i> Booking Penginapan</a>
            <a href="tiket.php" class="btn-main btn-blue"><i class="bi bi-truck"></i> Cek Estimasi Perjalanan</a>
        </div>
    </header>

    <div class="container" id="destinasi">
        <div class="section-title">
            <h2>Destinasi Wisata Unggulan Bromo</h2>
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