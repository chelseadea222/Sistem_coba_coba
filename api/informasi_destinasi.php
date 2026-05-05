<?php
// 1. Koneksi database dengan path absolut[cite: 1, 21]
require_once __DIR__ . '/koneksi.php'; 

// 2. Jalankan query dengan validasi[cite: 10, 16]
if (isset($koneksi)) {
    $query = mysqli_query($koneksi, "SELECT * FROM destinasi");
} else {
    die("Koneksi database tidak ditemukan."); 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplorasi Destinasi Wisata</title>
    <style>
        /* Gaya Visual Modern */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f4f8; margin: 0; padding: 40px 20px; }
        .container { max-width: 1100px; margin: auto; }
        
        h2 { text-align: center; color: #2c3e50; font-size: 2.5rem; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 2px; }

        /* Grid System untuk Kartu Wisata */
        .destinasi-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
            gap: 25px; 
        }

        /* Desain Kartu */
        .card { 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.05); 
            transition: all 0.3s ease; 
            border: 1px solid #e1e8ed;
        }
        .card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }

        .card-header { background: #3498db; color: white; padding: 20px; position: relative; }
        .card-header h3 { margin: 0; font-size: 1.4rem; }
        .card-header .location { font-size: 0.9rem; opacity: 0.9; display: block; margin-top: 5px; }

        .card-body { padding: 25px; color: #555; line-height: 1.6; min-height: 100px; }
        
        .card-footer { padding: 15px 25px; background: #f9fbff; border-top: 1px solid #eee; text-align: right; }
        .btn-detail { background: #3498db; color: white; padding: 8px 18px; border-radius: 50px; text-decoration: none; font-size: 0.85rem; transition: 0.3s; }
        .btn-detail:hover { background: #2980b9; }

        /* Notifikasi jika kosong */
        .empty-state { text-align: center; padding: 50px; background: white; border-radius: 15px; grid-column: 1 / -1; }
    </style>
</head>
<body>

<div class="container">
    <h2>Informasi Destinasi Wisata</h2>

    <div class="destinasi-grid">
        <?php 
        // 3. Loop data menggunakan fetch_array[cite: 13, 21]
        if ($query && mysqli_num_rows($query) > 0) {
            while($data = mysqli_fetch_array($query)) {
        ?>
        <div class="card">
            <div class="card-header">
                <h3><?php echo htmlspecialchars($data['nama_wisata']); ?></h3>[cite: 13, 21]
                <span class="location">📍 <?php echo htmlspecialchars($data['lokasi']); ?></span>[cite: 13, 21]
            </div>
            <div class="card-body">
                <?php echo htmlspecialchars($data['deskripsi']); ?>[cite: 13, 21]
            </div>
            <div class="card-footer">
                <a href="#" class="btn-detail">Lihat Rute</a>
            </div>
        </div>
        <?php 
            } 
        } else {
            echo "<div class='empty-state'>
                    <h3 style='color:#ccc;'>Belum ada destinasi yang terdaftar.</h3>
                    <p>Silakan hubungi admin untuk memperbarui data wisata.</p>
                  </div>";
        }
        ?>
    </div>
</div>

</body>
</html>