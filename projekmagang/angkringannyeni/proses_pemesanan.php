<?php
// proses_pemesanan.php

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbangkringan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = trim($_POST['nama'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');
    $nomor_meja = intval($_POST['nomor_meja'] ?? 0);
    $pesananJson = $_POST['pesanan_json'] ?? '';

    // Validasi data wajib
    if (empty($nama) || empty($telepon) || $nomor_meja <= 0 || empty($pesananJson)) {
        die("Data pelanggan atau pesanan tidak lengkap.");
    }

    // Decode JSON pesanan
    $pesanan = json_decode($pesananJson, true);
    if (!$pesanan || count($pesanan) === 0) {
        die("Pesanan kosong.");
    }

    // Simpan data pelanggan ke tabel 'pelanggan'
    $stmt = $conn->prepare("INSERT INTO pelanggan (nama, telepon, nomor_meja) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nama, $telepon, $nomor_meja);
    if (!$stmt->execute()) {
        die("Gagal menyimpan data pelanggan: " . $stmt->error);
    }
    $stmt->close();

    // Simpan pesanan ke tabel 'pesanan'
    $stmt = $conn->prepare("INSERT INTO pesanan (nama_pelanggan, nomor_meja, nama_menu, jumlah, tanggal_pesan) VALUES (?, ?, ?, ?, NOW())");

    foreach ($pesanan as $namaMenu => $jumlah) {
        if ($jumlah <= 0) continue;
        $stmt->bind_param("sisi", $nama, $nomor_meja, $namaMenu, $jumlah);
        if (!$stmt->execute()) {
            die("Gagal menyimpan data pesanan: " . $stmt->error);
        }
    }
    $stmt->close();

    // Tampilkan halaman sukses
    echo "<!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Pesanan Berhasil</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container mt-5 text-center'>
            <h1>Terima kasih, pesanan Anda telah berhasil!</h1>
            <p><strong>Nama:</strong> " . htmlspecialchars($nama) . "</p>
            <p><strong>Nomor Telepon:</strong> " . htmlspecialchars($telepon) . "</p>
            <p><strong>Nomor Meja:</strong> " . htmlspecialchars($nomor_meja) . "</p>
            <a href='menu.php' class='btn btn-primary mt-3'>Kembali ke Menu</a>
        </div>
    </body>
    </html>";

} else {
    die("Akses tidak diizinkan.");
}
?>
    