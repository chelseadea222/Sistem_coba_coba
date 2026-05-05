<?php 
// 1. Matikan error reporting sementara untuk melihat pesan manual jika diperlukan
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Panggil koneksi dengan path absolut
// Karena informasi_kuliner.php ada di folder 'api', 
// maka koneksi.php juga harus ada di folder yang sama.
require_once __DIR__ . '/koneksi.php'; 

// 3. Cek apakah variabel $koneksi benar-benar ada setelah di-require
if (!isset($koneksi)) {
    die("Error: Variabel \$koneksi tidak ditemukan. Periksa file koneksi.php Anda!");
}

session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner Lokal Wisata</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: auto; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; text-transform: uppercase; }
        
        /* Grid System untuk Kartu Kuliner */
        .kuliner-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        
        .card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .card:hover { transform: translateY(-5px); }
        .card-img { width: 100%; height: 200px; background-color: #ddd; object-fit: cover; }
        
        .card-content { padding: 20px; }
        .card-content h3 { margin: 0 0 10px 0; color: #e67e22; }
        .price { font-weight: bold; color: #27ae60; font-size: 1.1em; margin-bottom: 10px; display: block; }
        .desc { color: #666; font-size: 0.9em; line-height: 1.5; margin-bottom: 15px; }
        
        .btn-lokasi { display: inline-block; padding: 8px 15px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; font-size: 0.8em; }
        .btn-lokasi:hover { background: #2980b9; }

        /* Form Tambah Kuliner Sederhana (Admin) */
        .admin-section { background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 40px; border-left: 5px solid #e67e22; }
    </style>
</head>
<body>

<div class="container">
    <h1>Eksplorasi Kuliner Lokal</h1>

    <!-- Tampilan Daftar Kuliner -->
    <div class="kuliner-grid">
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM kuliner ORDER BY id_kuliner DESC");
        if(mysqli_num_rows($query) > 0) {
            while($data = mysqli_fetch_array($query)) {
        ?>
        <div class="card">
            <div class="card-content">
                <h3><?php echo $data['nama_makanan']; ?></h3>
                <span class="price">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></span>
                <p class="desc"><?php echo $data['deskripsi']; ?></p>
                <small>📍 Lokasi: <?php echo $data['lokasi_penjual']; ?></small>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<p style='text-align:center;'>Belum ada data kuliner.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>