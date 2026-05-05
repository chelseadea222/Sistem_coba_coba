<?php
include 'koneksi.php'; // Menggunakan koneksi database yang sudah ada di repo[cite: 1]

if (isset($_POST['submit_booking'])) {
    // Sanitasi input
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $no_hp     = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $tipe      = mysqli_real_escape_string($koneksi, $_POST['tipe_penginapan']);
    $tgl       = mysqli_real_escape_string($koneksi, $_POST['tgl_checkin']);
    $durasi    = mysqli_real_escape_string($koneksi, $_POST['durasi']);
    $catatan   = mysqli_real_escape_string($koneksi, $_POST['catatan']);
    $tgl_order = date("Y-m-d H:i:s");

    // Query simpan data ke tabel booking_wisata
    $query = "INSERT INTO booking_wisata (nama_lengkap, no_hp, tipe_penginapan, tgl_checkin, durasi, catatan, tgl_order) 
              VALUES ('$nama', '$no_hp', '$tipe', '$tgl', '$durasi', '$catatan', '$tgl_order')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Booking berhasil dikirim! Kami akan menghubungi Anda via WhatsApp.'); window.location='../booking_wisata.php';</script>";
    } else {
        echo "Gagal memproses booking: " . mysqli_error($koneksi);
    }
}
?>