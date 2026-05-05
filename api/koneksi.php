<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bromo_tracking";

// Nama variabel harus tepat $koneksi (huruf kecil semua)
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>