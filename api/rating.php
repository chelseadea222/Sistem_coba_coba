<?php 
require_once __DIR__ . '/koneksi.php';  // Menggunakan koneksi dari folder api
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rating & Ulasan Wisata</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        
        /* CSS untuk Star Rating */
        .rating-wrapper { display: flex; flex-direction: row-reverse; justify-content: center; margin-bottom: 20px; }
        .rating-wrapper input { display: none; }
        .rating-wrapper label { cursor: pointer; width: 40px; height: 40px; background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="gray"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>'); background-repeat: no-repeat; background-position: center; }
        .rating-wrapper input:checked ~ label,
        .rating-wrapper label:hover,
        .rating-wrapper label:hover ~ label { background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="orange"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>'); }

        .form-group { margin-bottom: 15px; }
        label.title { font-weight: bold; display: block; margin-bottom: 5px; }
        input[type="text"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #f39c12; border: none; color: white; font-weight: bold; border-radius: 5px; cursor: pointer; }
        button:hover { background: #e67e22; }
    </style>
</head>
<body>

<div class="container">
    <h2>Beri Rating Wisata</h2>
    <form action="api/proses_rating.php" method="POST">
        <div class="form-group">
            <label class="title">Nama Pengunjung</label>
            <input type="text" name="nama_user" required placeholder="Nama Anda">
        </div>

        <div class="form-group">
            <label class="title">Pilih Destinasi</label>
            <select name="id_wisata" required>
                <option value="1">Pantai Biru</option>
                <option value="2">Gunung Pinus</option>
                <option value="3">Hutan Pinus</option>
            </select>
        </div>

        <label class="title" style="text-align:center;">Rating Bintang</label>
        <div class="rating-wrapper">
            <input type="radio" id="star5" name="rating" value="5" required/><label for="star5"></label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4"></label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3"></label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2"></label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1"></label>
        </div>

        <div class="form-group">
            <label class="title">Ulasan / Komentar</label>
            <textarea name="ulasan" rows="4" placeholder="Bagaimana pengalaman Anda?"></textarea>
        </div>

        <button type="submit" name="kirim_rating">KIRIM ULASAN</button>
    </form>
</div>

</body>
</html>