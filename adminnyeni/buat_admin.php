<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbangkringan";

$conn = new mysqli($host, $user, $pass, $db);
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
