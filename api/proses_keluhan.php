<?php
require_once __DIR__ . '/koneksi.php';

if (isset($_POST['submit_keluhan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pelapor']);
    $kontak = mysqli_real_escape_string($koneksi, $_POST['kontak_pelapor']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan_keluhan']);

    $query = "INSERT INTO keluhan (nama_pelapor, kontak_pelapor, kategori, pesan_keluhan) 
              VALUES ('$nama', '$kontak', '$kategori', '$pesan')";

    if (mysqli_query($koneksi, $query)) {
        // Notifikasi JavaScript dan Pengalihan Halaman
        echo "<script>
                alert('Terima kasih! Laporan Anda telah masuk ke sistem admin dan akan segera kami tindak lanjuti.');
                window.location.href = 'laporan_keluhan.php'; 
              </script>";
    } else {
        echo "Gagal mengirim laporan: " . mysqli_error($koneksi);
    }
} else {
    header("Location: laporan_keluhan.php");
    exit;
}
?>