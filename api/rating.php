<?php 
session_start();
// Perbaikan path koneksi: asumsikan koneksi.php ada di folder yang sama
require_once __DIR__ . '/koneksi.php'; 

// Data Destinasi Bromo
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
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f4f4f4; padding: 20px; color: #333; }
        .container { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #E8621A; margin-bottom: 10px; }
        p.subtitle { text-align: center; font-size: 0.9em; color: #666; margin-bottom: 25px; }
        
        .rating-wrapper { display: flex; flex-direction: row-reverse; justify-content: center; margin-bottom: 25px; gap: 5px; }
        .rating-wrapper input { display: none; }
        .rating-wrapper label { cursor: pointer; width: 45px; height: 45px; background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ccc"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>'); background-repeat: no-repeat; background-position: center; transition: 0.2s; }
        
        .rating-wrapper input:checked ~ label,
        .rating-wrapper label:hover,
        .rating-wrapper label:hover ~ label { background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23f39c12"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>'); transform: scale(1.1); }

        .form-group { margin-bottom: 20px; }
        label.title { font-weight: bold; display: block; margin-bottom: 8px; font-size: 0.95em; }
        input[type="text"], textarea, select { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; box-sizing: border-box; font-size: 14px; transition: 0.3s; }
        
        button { width: 100%; padding: 15px; background: #E8621A; border: none; color: white; font-weight: bold; border-radius: 8px; cursor: pointer; font-size: 16px; transition: 0.3s; }
        button:hover { background: #d35400; }
    </style>
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
        <a href="landingpage.php" style="display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none; font-size: 14px; font-weight: bold; transition: 0.3s;" onmouseover="this.style.color='#E8621A'" onmouseout="this.style.color='#777'">
        &larr; Kembali ke Beranda
    </a>
    </form>
</div>

</body>
</html>