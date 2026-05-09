<?php
session_start();

// 1. Memanggil koneksi database
require_once __DIR__ . '/koneksi.php';

// Cek apakah variabel $koneksi benar-benar ada setelah di-require
if (!isset($koneksi)) {
    die("Error: Variabel \$koneksi tidak ditemukan. Periksa file koneksi.php Anda.");
}

if (isset($_POST['kirim_rating'])) {
    
    // 2. Ambil data dari form dan sanitasi
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $id_wisata = mysqli_real_escape_string($koneksi, $_POST['id_wisata']);
    $rating    = mysqli_real_escape_string($koneksi, $_POST['rating']);
    $ulasan    = mysqli_real_escape_string($koneksi, $_POST['ulasan']);
    $tanggal   = date('Y-m-d H:i:s');

    // 3. Validasi sederhana
    if (empty($nama_user) || empty($id_wisata) || empty($rating)) {
        echo "<script>
                alert('Mohon isi nama, destinasi, dan rating bintang!');
                window.history.back();
              </script>";
        exit;
    }

    // 4. Query Insert
    $query = "INSERT INTO ulasan_wisata (nama_user, id_wisata, rating, ulasan, tanggal_ulasan) 
              VALUES ('$nama_user', '$id_wisata', '$rating', '$ulasan', '$tanggal')";

    // 5. Eksekusi Query
    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Terima kasih! Ulasan Anda berhasil terkirim.');
                window.location.href = 'rating.php'; 
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }

} else {
    header("Location: rating.php");
    exit;
}
?>