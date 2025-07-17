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

$sql = "SELECT COUNT(DISTINCT nama_pelanggan, nomor_meja) AS jumlah FROM pesanan WHERE status = 'baru'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['jumlah'] > 0 ? 'ada' : 'tidak';
$conn->close();
?>
