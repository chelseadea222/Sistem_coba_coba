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
    
    // Penamaan file unik
    $ekstensi = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_baru = "BUKTI_" . $id_trx . "_" . time() . "." . $ekstensi;
    $path = "uploads/" . $nama_baru;
    
    if (move_uploaded_file($tmp, $path)) {
        $query = "UPDATE pemesanan_tiket SET bukti_pembayaran='$nama_baru', status='Diproses' WHERE id_transaksi='$id_trx'";
        if (mysqli_query($koneksi, $query)) {
            header("Location: konfirmasi_pembayaran.php?pesan=berhasil");
            exit;
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --accent: #E8621A; 
            --glass-dark: rgba(20, 20, 20, 0.7);
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?q=80&w=1200');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .glass-card { 
            background: var(--glass-dark); 
            backdrop-filter: blur(15px); 
            border-radius: 24px; 
            padding: 35px; 
            border: 1px solid rgba(255,255,255,0.15); 
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
            max-width: 500px;
            margin: auto;
        }

        .label-custom { 
            color: var(--accent); 
            font-weight: 600; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            margin-bottom: 10px;
            display: block;
        }

        .input-custom {
            background: rgba(255,255,255,0.1) !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px 18px;
        }

        .input-custom:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 10px rgba(232, 98, 26, 0.3) !important;
        }

        .preview-area { 
            width: 100%; 
            height: 200px; 
            border: 2px dashed rgba(255,255,255,0.2); 
            border-radius: 15px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            overflow: hidden; 
            background: rgba(255,255,255,0.03); 
            margin-bottom: 15px; 
        }
        .preview-area img { max-width: 100%; max-height: 100%; object-fit: contain; }

        .btn-confirm { 
            background-color: var(--accent); 
            color: white; 
            border: none; 
            font-weight: 700; 
            padding: 15px; 
            border-radius: 12px;
            transition: 0.3s;
            text-transform: uppercase;
            width: 100%;
            margin-top: 10px;
        }
        .btn-confirm:hover { background-color: #d15616; transform: translateY(-2px); color: white; }

        .alert-custom { 
            background: rgba(25, 135, 84, 0.2); 
            border: 1px solid #198754; 
            color: #afffdf;
            border-radius: 15px; 
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="glass-card">
        
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil'): ?>
            <div class="alert alert-custom alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-patch-check-fill fs-4 me-3"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Konfirmasi Terkirim!</h6>
                    <small>Bukti telah diterima. Mohon tunggu verifikasi admin.</small>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="text-center mb-4">
            <i class="bi bi-cloud-arrow-up text-warning" style="font-size: 3rem;"></i>
            <h3 class="fw-bold mt-2">Upload Bukti Bayar</h3>
            <p class="opacity-75 small">Kirim screenshot bukti transfer Anda di sini.</p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="label-custom">ID Transaksi</label>
                <input type="text" name="id_transaksi" class="form-control input-custom" 
                       placeholder="Contoh: TRX-123456" 
                       value="<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>" required>
            </div>

            <div class="mb-4">
                <label class="label-custom">Foto Bukti Transfer</label>
                <div class="preview-area" id="imagePreview">
                    <span class="text-white-50 small" id="previewText">Belum ada foto dipilih</span>
                </div>
                <input type="file" name="bukti" id="buktiInput" class="form-control input-custom" accept="image/*" required>
            </div>

            <div class="alert border-0 small mb-4" style="background: rgba(232, 98, 26, 0.1); color: #ffbc8f;">
                <i class="bi bi-info-circle-fill me-2"></i> Pastikan Nominal & ID Transaksi terlihat jelas.
            </div>

            <button type="submit" name="upload_bukti" class="btn btn-confirm">
                <i class="bi bi-send-fill me-2"></i> Kirim Konfirmasi
            </button>
            
            <div class="text-center mt-4">
                <a href="landingpage.php" class="text-white-50 text-decoration-none small"><i class="bi bi-house me-1"></i> Kembali ke Beranda</a>
            </div>
        </form>
    </div>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>