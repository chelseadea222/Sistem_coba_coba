<?php
// Jangan panggil session_start() di sini jika sudah dipanggil di login.php
// Cukup pastikan session tersedia
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Email dan password wajib diisi!';
    } else {
        // PERBAIKAN: Menggunakan MySQLi ($koneksi) bukan PDO ($pdo)
        // Gunakan Prepared Statement untuk keamanan dari SQL Injection
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        // Pengecekan apakah user ditemukan
        if ($user && password_verify($password, $user['password'])) {
            
            // Normalize role
            $role = strtolower($user['role']);
            
            // Validasi role
            if ($role !== 'admin' && $role !== 'user') {
                $error = 'Role pengguna tidak valid. Hubungi administrator.';
            } else {
                // Set session data
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama']    = $user['nama'];
                $_SESSION['email']   = $user['email'];
                $_SESSION['role']    = $role;

                // Tentukan target URL
                $target_url = ($role === 'admin') ? 'dashboard_admin.php' : 'landingpage.php';
                
                // Pastikan session tersimpan
                session_write_close();
                
                // Redirect
                header("Location: " . $target_url);
                exit;
            }
        } else {
            $error = 'Email atau password salah!';
        }
        mysqli_stmt_close($stmt);
    }
}
?>