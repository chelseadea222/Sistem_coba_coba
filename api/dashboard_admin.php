<?php
session_start();
require_once 'koneksi.php';

// --- 1. AMBIL DATA GRAFIK (BPS & LOKAL) ---
require_once 'api_dashboard_admin.php';   // Mengambil $bps_labels dan $bps_values
require_once 'proses_dashboard_admin.php'; // Mengambil $monthlyStats

if (!isset($bps_labels) || empty($bps_labels)) {
    $bpsData = getBpsData();
    $bps_labels = $bpsData['labels'];
    $bps_values = $bpsData['values'];
}

// Proteksi halaman: Hanya Admin yang boleh masuk
if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
    header('Location: login.php');
    exit;
}

// 2. Ambil statistik ringkas
$total_tiket = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pemesanan_tiket"))['total'];
$total_ulasan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM ulasan_wisata"))['total'];
$total_keluhan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM keluhan"))['total'];

// 3. Ambil 10 data terbaru
$result_tiket = mysqli_query($koneksi, "SELECT * FROM pemesanan_tiket ORDER BY tanggal_pesan DESC LIMIT 10");
$result_keluhan = mysqli_query($koneksi, "SELECT * FROM keluhan ORDER BY tanggal_kirim DESC LIMIT 10");
$result_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan_wisata ORDER BY tanggal_ulasan DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BromoTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --primary-dark: #2c3e50; --accent: #E8621A; --bg-light: #f4f7f6; }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; margin: 0; }
        
        nav { background: #2c3e50; padding: 12px 0; position: sticky; top: 0; z-index: 1050; box-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .nav-container { max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center; padding: 0 25px; }
        .logo { color: #fff; font-size: 1.4rem; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .logo span { color: #e67e22; }
        
        .logout-btn { background-color: #ff0000 !important; color: #000000 !important; font-weight: bold !important; padding: 8px 16px !important; border-radius: 4px !important; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; border: none !important; }

        .main-content { max-width: 1200px; margin: auto; padding: 30px 20px; }
        .card-stat { border: none; border-radius: 12px; color: white; position: relative; overflow: hidden; }
        .stat-icon { font-size: 3rem; opacity: 0.2; position: absolute; right: 15px; bottom: 5px; }
        
        .scroll-container { max-height: 350px; overflow-y: auto; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; }
        .card-table { border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 40px; background: white; }
        .card-header { background: white !important; border-bottom: 1px solid #edf2f7; padding: 18px 25px; font-weight: 700; }
        .table thead th { background: #f8fafc; color: #718096; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; position: sticky; top: 0; }
        .star-rating { color: #f6ad55; }

        /* Style khusus untuk tombol print */
        .btn-print { font-size: 0.8rem; font-weight: 600; padding: 4px 12px; }

        /* Pengaturan CSS untuk hasil Print */
        @media print {
            nav, .logout-btn, .btn-print, .btn-sm, .card-stat, canvas { display: none !important; }
            .main-content { padding: 0; margin: 0; width: 100%; }
            .card-table { box-shadow: none; border: 1px solid #ddd; page-break-inside: avoid; }
            .scroll-container { max-height: none !important; overflow: visible !important; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="nav-container">
            <a href="#" class="logo">Bromo<span>Track</span></a>
            <div class="nav-links">
                <a href="logout.php" onclick="return confirm('Yakin ingin keluar?')" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold mb-0">Ringkasan Aktivitas Admin</h2>
                <p class="text-muted small mb-0">Pantau 10 aktivitas terbaru dan cetak laporan secara cepat.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge bg-dark px-3 py-2 text-warning fs-6 shadow-sm">
                    <i class="bi bi-calendar3 me-2"></i><?= date('d M Y') ?>
                </span>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4"><div class="card card-stat bg-primary p-4 shadow-sm"><h6>Total Tiket</h6><h2><?= number_format($total_tiket) ?></h2><i class="bi bi-ticket-detailed stat-icon"></i></div></div>
            <div class="col-md-4"><div class="card card-stat bg-success p-4 shadow-sm"><h6>Ulasan Masuk</h6><h2><?= number_format($total_ulasan) ?></h2><i class="bi bi-star-fill stat-icon"></i></div></div>
            <div class="col-md-4"><div class="card card-stat bg-danger p-4 shadow-sm"><h6>Laporan Keluhan</h6><h2><?= number_format($total_keluhan) ?></h2><i class="bi bi-megaphone-fill stat-icon"></i></div></div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-table shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 small text-uppercase text-muted">Grafik Tiket Bulanan</h5>
                        <canvas id="chartLokal" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-table shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 small text-uppercase text-muted">Wisatawan Probolinggo (BPS)</h5>
                        <canvas id="chartBPS" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div id="print-tiket" class="card card-table shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-lightning-fill text-warning me-2"></i>10 Tiket Terbaru</span>
                <button onclick="window.print()" class="btn btn-sm btn-dark btn-print"><i class="bi bi-printer me-1"></i> Cetak Laporan</button>
            </div>
            <div class="scroll-container">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Pembeli</th><th>Destinasi</th><th>Tanggal</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result_tiket)): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($row['nama_pembeli']) ?></td>
                            <td><small><?= htmlspecialchars($row['destinasi']) ?></small></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_pesan'])) ?></td>
                            <td><span class="badge bg-success-subtle text-success">Lunas</span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="print-ulasan" class="card card-table shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-star-fill text-warning me-2"></i>10 Ulasan Terbaru</span>
                <button onclick="window.print()" class="btn btn-sm btn-dark btn-print"><i class="bi bi-printer me-1"></i> Cetak</button>
            </div>
            <div class="scroll-container">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Nama</th><th>Rating</th><th>Komentar</th><th>Waktu</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result_ulasan)): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($row['nama_user']) ?></td>
                            <td class="star-rating"><?= str_repeat('<i class="bi bi-star-fill"></i>', $row['rating']) ?></td>
                            <td><small class="text-muted">"<?= htmlspecialchars($row['ulasan']) ?>"</small></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_ulasan'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="print-keluhan" class="card card-table shadow-sm mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>10 Laporan Keluhan Terbaru</span>
                <button onclick="window.print()" class="btn btn-sm btn-dark btn-print"><i class="bi bi-printer me-1"></i> Cetak</button>
            </div>
            <div class="scroll-container">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Pelapor</th><th>Kategori</th><th>Pesan</th><th>Waktu</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result_keluhan)): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($row['nama_pelapor']) ?></td>
                            <td><span class="badge bg-warning-subtle text-dark border-0"><?= htmlspecialchars($row['kategori']) ?></span></td>
                            <td><small><?= htmlspecialchars(substr($row['pesan_keluhan'], 0, 80)) ?>...</small></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['tanggal_kirim'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    // --- JS GRAFIK LOKAL ---
    new Chart(document.getElementById('chartLokal'), {
        type: 'line',
        data: {
            labels: <?= json_encode(array_keys($monthlyStats)) ?>,
            datasets: [{
                label: 'Tiket',
                data: <?= json_encode(array_values($monthlyStats)) ?>,
                borderColor: '#E8621A',
                backgroundColor: 'rgba(232, 98, 26, 0.1)',
                fill: true, tension: 0.4
            }]
        }
    });

    // --- JS GRAFIK BPS ---
    new Chart(document.getElementById('chartBPS'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($bps_labels) ?>,
            datasets: [{
                label: 'Wisatawan',
                data: <?= json_encode($bps_values) ?>,
                backgroundColor: 'rgba(52, 152, 219, 0.7)',
                borderRadius: 5
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, ticks: { callback: v => v >= 1000 ? (v/1000) + 'rb' : v } } }
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>