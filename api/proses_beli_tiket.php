<?php
include 'koneksi.php'; // Mengambil koneksi database[cite: 1]

if (isset($_POST['bayar_tiket'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $id_w   = mysqli_real_escape_string($koneksi, $_POST['id_wisata']);
    $qty    = mysqli_real_escape_string($koneksi, $_POST['jumlah']);
    $tgl    = date("Y-m-d H:i:s");
    $kode   = "TKT-" . strtoupper(substr(md5(time()), 0, 6)); // Generate kode tiket unik

    // Query simpan data tiket
    $sql = "INSERT INTO tiket_online (kode_tiket, nama_pembeli, id_wisata, jumlah_tiket, tgl_beli) 
            VALUES ('$kode', '$nama', '$id_w', '$qty', '$tgl')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Pembayaran Berhasil! Kode Tiket Anda: $kode'); 
                window.location='../beli_tiket.php';
              </script>";
    } else {
        echo "Gagal memproses tiket: " . mysqli_error($koneksi);
    }
}
?>