<?php
// === KONFIGURASI DATABASE ===
$host = "localhost";      // host database
$user = "root";           // username database
$pass = "";               // password database
$db   = "dbweb_desa";         // ganti sesuai nama database kamu

// === PASSWORD BARU ===
$newPassword = "kades123";  // password baru yang kamu mau set

// Koneksi ke DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ Koneksi gagal: " . $conn->connect_error);
}

// Generate hash baru
$hash = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password user admin
$sql = "UPDATE users SET password='$hash' WHERE username='kades'";
if ($conn->query($sql) === TRUE) {
    echo "✅ Password berhasil direset ke: $newPassword\n";
    echo "🔑 Hash baru: $hash\n";
} else {
    echo "❌ Error: " . $conn->error;
}

$conn->close();
