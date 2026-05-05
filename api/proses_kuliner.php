<?php
include 'koneksi.php'; // Menggunakan koneksi dari folder api

if (isset($_POST['tambah_kuliner'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_makanan']);
    $harga    = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $lokasi   = mysqli_real_escape_string($koneksi, $_POST['lokasi_penjual']);

    $sql = "INSERT INTO kuliner_lokal (nama_makanan, harga, deskripsi, lokasi_penjual) 
            VALUES ('$nama', '$harga', '$deskripsi', '$lokasi')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data kuliner berhasil ditambahkan!'); window.location='../informasi_kuliner.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>