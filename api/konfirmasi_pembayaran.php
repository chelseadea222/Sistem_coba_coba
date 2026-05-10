<?php
require_once 'koneksi.php';

if (isset($_POST['upload_bukti'])) {
    $id_trx = mysqli_real_escape_string($koneksi, $_POST['id_transaksi']);
    $foto = $_FILES['bukti']['name'];
    $tmp = $_FILES['bukti']['tmp_name'];
    
    // Pastikan folder uploads sudah ada
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }
    
    // Penamaan file unik untuk menghindari bentrok nama file
    $ekstensi = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_baru = "BUKTI_" . $id_trx . "_" . time() . "." . $ekstensi;
    $path = "uploads/" . $nama_baru;
    
    if (move_uploaded_file($tmp, $path)) {
        // Update database (menggunakan variabel $nama_baru)
        $query = "UPDATE pemesanan_tiket SET bukti_pembayaran='$nama_baru', status='Diproses' WHERE id_transaksi='$id_trx'";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Bukti berhasil dikirim! Mohon tunggu verifikasi admin.'); window.location='landingpage.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data di sistem.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - BromoTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #E8621A; --dark: #2c3e50; }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .upload-container { max-width: 500px; margin: 60px auto; }
        .card-upload { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
        .card-header-custom { background: var(--dark); color: white; padding: 25px; text-align: center; }
        .card-header-custom i { font-size: 2.5rem; color: var(--primary); }
        .btn-confirm { background: var(--primary); color: white; border: none; padding: 12px; border-radius: 12px; font-weight: bold; transition: 0.3s; }
        .btn-confirm:hover { background: #d15616; transform: translateY(-2px); color: white; }
        .preview-area { width: 100%; height: 200px; border: 2px dashed #ddd; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #fafafa; margin-bottom: 15px; }
        .preview-area img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .instruction-text { font-size: 0.85rem; color: #6c757d; }
    </style>
</head>
<body>

<div class="container upload-container">
    <div class="card card-upload">
        <div class="card-header-custom">
            <i class="bi bi-cloud-arrow-up-fill"></i>
            <h4 class="mt-2 mb-0">KONFIRMASI PEMBAYARAN</h4>
            <p class="small opacity-75 mb-0">Kirimkan bukti transfer untuk aktivasi tiket</p>
        </div>
        <div class="card-body p-4">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase">ID Transaksi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-hash text-primary"></i></span>
                        <input type="text" name="id_transaksi" class="form-control bg-light border-start-0" 
                               placeholder="Contoh: TRX-123456" required>
                    </div>
                    <div class="instruction-text mt-1 italic">Dapat dilihat di layar setelah pemesanan</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-uppercase">Bukti Transfer (Foto/Screenshot)</label>
                    <div class="preview-area" id="imagePreview">
                        <span class="text-muted small" id="previewText">Belum ada foto dipilih</span>
                    </div>
                    <input type="file" name="bukti" id="buktiInput" class="form-control" accept="image/*" required>
                </div>

                <div class="alert alert-warning border-0 small mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i> Pastikan foto bukti terlihat jelas (Nama pengirim & Nominal).
                </div>

                <button type="submit" name="upload_bukti" class="btn btn-confirm w-100 mb-3">
                    <i class="bi bi-send-check-fill me-2"></i> KIRIM KONFIRMASI
                </button>
                
                <a href="landingpage.php" class="btn btn-outline-secondary w-100 border-0 btn-sm">
                    Kembali ke Beranda
                </a>
            </form>
        </div>
    </div>
    <p class="text-center mt-4 small text-muted">© 2026 BromoTrack Management System</p>
</div>
<div class="container upload-container">
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Berhasil!</strong> Bukti pembayaran telah terkirim. Mohon tunggu verifikasi admin.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card card-upload">
        ```

### Skenario 2: Mengubah Pesan untuk Admin (Halaman Verifikasi)
Jika kodingan yang Anda maksud adalah file yang mengubah status menjadi **Lunas** (file yang Anda tanyakan sebelumnya), maka notifikasi tersebut sebaiknya ditaruh di **`dashboard_admin.php`**.

Sebab, alur prosesnya adalah:
1. Admin klik tombol "Konfirmasi Lunas" di Dashboard.
2. Sistem menjalankan file proses verifikasi.
3. Sistem melempar kembali (redirect) ke Dashboard sambil membawa pesan `?pesan=berhasil`.

### Tips Tambahan
Agar desain notifikasi selaras dengan tema **BromoTrack** yang sedang Anda buat, Anda bisa sedikit memodifikasinya agar lebih cantik:

```php
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil'): ?>
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
        <i class="bi bi-patch-check-fill fs-4 me-3"></i>
        <div>
            <h6 class="mb-0 fw-bold">Update Berhasil!</h6>
            <small>Status tiket telah diperbarui dan sistem telah mencatat pembayaran tersebut.</small>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<script>
    const buktiInput = document.getElementById('buktiInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewText = document.getElementById('previewText');

    buktiInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            previewText.style.display = "none";
            reader.addEventListener('load', function() {
                imagePreview.innerHTML = '<img src="' + this.result + '">';
            });
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>