<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbangkringan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT COUNT(DISTINCT nama_pelanggan, nomor_meja) AS jumlah FROM pesanan WHERE status = 'baru'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['jumlah'] > 0 ? 'ada' : 'tidak';
$conn->close();
?>
