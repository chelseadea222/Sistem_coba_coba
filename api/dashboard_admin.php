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
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <thead>
                        <tr>
                            <th>Pembeli</th>
                            <th>Status</th>
                            <th>Bukti Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result_tiket)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_pembeli']) ?></td>
                            <td>
                                <?php if($row['status'] == 'Lunas'): ?>
                                    <span class="badge bg-success-subtle text-success">Lunas</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-dark"><?= $row['status'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['bukti_pembayaran']): ?>
                                    <a href="uploads/<?= $row['bukti_pembayaran'] ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-image"></i> Lihat Bukti
                                    </a>
                                <?php else: ?>
                                    <span class="text-danger small"><i class="bi bi-x-circle"></i> Belum Upload</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 'Diproses'): ?>
                                    <a href="verifikasi_tiket.php?id=<?= $row['id_transaksi'] ?>" 
                                       class="btn btn-sm btn-success" 
                                       onclick="return confirm('Konfirmasi pelunasan tiket ini?')">
                                       <i class="bi bi-check-circle"></i> Konfirmasi Lunas
                                    </a>
                                <?php elseif($row['status'] == 'Lunas'): ?>
                                    <span class="text-muted small"><i class="bi bi-patch-check-fill text-primary"></i> Terverifikasi</span>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
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