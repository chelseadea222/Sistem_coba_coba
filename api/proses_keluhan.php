<?php
include 'koneksi.php'; // Mengambil koneksi database[cite: 1]

if (isset($_POST['submit_keluhan'])) {
    // Mengambil data dari form
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pelapor']);
    $kontak = mysqli_real_escape_string($koneksi, $_POST['kontak_pelapor']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan_keluhan']);
    $tanggal = date("Y-m-d H:i:s");

    // Query untuk memasukkan data ke tabel (Pastikan tabel 'laporan_keluhan' sudah ada)
    $query = "INSERT INTO laporan_keluhan (nama, kontak, kategori, pesan, tgl_laporan) 
              VALUES ('$nama', '$kontak', '$kategori', '$pesan', '$tanggal')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Laporan berhasil dikirim. Terima kasih atas masukan Anda.'); window.location='../laporan_keluhan.php';</script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>