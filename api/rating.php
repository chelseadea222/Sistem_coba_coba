<?php 
session_start();
require_once __DIR__ . '/koneksi.php'; 

$wisata_bromo = [
    "Penanjakan 1", "Kawah Bromo", "Pasir Berbisik", "Bukit Teletubbies", 
    "Pura Luhur Poten", "Bukit Kingkong", "Bukit Cinta", "Gunung Widodaren", 
    "Seruni Point", "Padang Savana", "Air Terjun Madakaripura"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating & Ulasan Bromo - BromoTrack</title>
    <link rel="stylesheet" href="../css/rating.css">
</head>
<body>

<div class="container">
    <h2>Beri Rating Wisata</h2>
    <p class="subtitle">Bagikan pengalaman seru Anda di Bromo!</p>

    <form action="proses_rating.php" method="POST">
        <div class="form-group">
            <label class="title">Nama Pengunjung</label>
            <input type="text" name="nama_user" required placeholder="Contoh: Budi Santoso">
        </div>

        <div class="form-group">
            <label class="title">Pilih Destinasi Wisata</label>
            <select name="id_wisata" required>
                <option value="" disabled selected>-- Pilih Lokasi Wisata --</option>
                <?php foreach ($wisata_bromo as $index => $nama): ?>
                    <option value="<?= $index + 1 ?>"><?= $nama ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <label class="title" style="text-align:center;">Seberapa puas Anda?</label>
        <div class="rating-wrapper">
            <input type="radio" id="star5" name="rating" value="5" required/><label for="star5"></label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4"></label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3"></label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2"></label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1"></label>
        </div>

        <div class="form-group">
            <label class="title">Ulasan / Komentar</label>
            <textarea name="ulasan" rows="4" placeholder="Ceritakan momen favorit Anda..."></textarea>
        </div>

        <button type="submit" name="kirim_rating">KIRIM ULASAN SEKARANG</button>
        
        <a href="landingpage.php" class="back-link">&larr; Kembali ke Beranda</a>
    </form>
</div>

</body>
</html>