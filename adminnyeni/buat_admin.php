<?php
// koneksi ke database
$host = "nozomi.proxy.rlwy.net";
$port = 49953;
$user = "root";
$pass = "LuSeKzpGjWuRjKDqcGEvBOpXLajVrONE";    // sesuaikan
$db = "railway";

$conn = mysqli_connect($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT); // password: admin123
$nama_penjaga = "Pak Wawan";

$stmt = $conn->prepare("INSERT INTO admin (username, password, nama_penjaga) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $nama_penjaga);

if ($stmt->execute()) {
    echo "Admin berhasil ditambahkan.";
} else {
    echo "Gagal menambahkan admin.";
}
?>
