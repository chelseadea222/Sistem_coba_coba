<?php
include 'koneksi.php'; // Menggunakan koneksi database yang sudah ada

if (isset($_POST['kirim_rating'])) {
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $id_wisata = mysqli_real_escape_string($koneksi, $_POST['id_wisata']);
    $rating    = mysqli_real_escape_string($koneksi, $_POST['rating']);
    $ulasan    = mysqli_real_escape_string($koneksi, $_POST['ulasan']);
    $tgl       = date("Y-m-d");

    // Query simpan ke database
    $sql = "INSERT INTO ulasan_wisata (id_wisata, nama_user, rating, ulasan, tgl_ulasan) 
            VALUES ('$id_wisata', '$nama_user', '$rating', '$ulasan', '$tgl')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Terima kasih! Ulasan Anda telah tersimpan.'); window.location='../ulasan_wisata.php';</script>";
    } else {
        echo "Gagal mengirim ulasan: " . mysqli_error($koneksi);
    }
}
?>