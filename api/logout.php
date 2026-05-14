<?php
session_start();
// Hapus semua data session
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - BromoTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #0f0c08; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: white;
            margin: 0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            max-width: 400px;
            width: 90%;
        }
        .spinner-border {
            color: #E8621A;
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>

    <div class="glass-card">
        <i class="bi bi-box-arrow-right text-warning fs-1"></i>
        <h4 class="fw-bold mt-3">Berhasil Logout</h4>
        <p class="text-white-50 small">Anda akan diarahkan kembali ke halaman login...</p>
        
        <div class="spinner-border mt-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script>
        // Mengarahkan kembali ke login.php setelah 2 detik
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 2000);
    </script>

</body>
</html>