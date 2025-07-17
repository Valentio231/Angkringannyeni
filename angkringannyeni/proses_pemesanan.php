<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesanan_json'], $_POST['nama'], $_POST['telepon_user'], $_POST['no_meja'])) {
    $nama = trim($_POST['nama']);
    $telepon_user = preg_replace('/[^0-9]/', '', $_POST['telepon_user']);

    // Validasi nomor telepon minimal 8 digit
    if (strlen($telepon_user) < 8) {
        die("Nomor telepon terlalu pendek. Masukkan nomor WA yang valid tanpa 0 di depan.");
    }

    $telepon = '62' . $telepon_user;
    $no_meja = trim($_POST['no_meja']);
    $keterangan = trim($_POST['keterangan'] ?? ''); 
    $pesanan = json_decode($_POST['pesanan_json'], true);

    if (!$pesanan || count($pesanan) === 0) {
        die("Data pesanan kosong.");
    }

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

    // Simpan ke tabel pelanggan (opsional)
    $stmt_pelanggan = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, telepon, nomor_meja) VALUES (?, ?, ?)");
    $stmt_pelanggan->bind_param("sss", $nama, $telepon, $no_meja);
    if (!$stmt_pelanggan->execute()) {
        die("Gagal menyimpan data pelanggan: " . $stmt_pelanggan->error);
    }
    $stmt_pelanggan->close();

    // Siapkan statement insert ke tabel pesanan 
    $tanggal_pesan = date("Y-m-d H:i:s");
    $stmt_pesanan = $conn->prepare("INSERT INTO pesanan (nama_pelanggan, nomor_meja, nama_menu, jumlah, tanggal_pesan, status, keterangan) VALUES (?, ?, ?, ?, ?, 'baru', ?)");
    
    foreach ($pesanan as $nama_menu => $jumlah) {
        if ($jumlah <= 0) continue;

        // Cek stok menu saat ini
        $stmt_stok = $conn->prepare("SELECT stok FROM menu WHERE nama_menu = ?");
        $stmt_stok->bind_param("s", $nama_menu);
        $stmt_stok->execute();
        $result = $stmt_stok->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stok_sekarang = (int)$row['stok'];

            if ($stok_sekarang >= $jumlah) {
                // Simpan ke pesanan 
                $stmt_pesanan->bind_param("sssiss", $nama, $no_meja, $nama_menu, $jumlah, $tanggal_pesan, $keterangan);
                $stmt_pesanan->execute();

                // Kurangi stok
                $stmt_kurangi_stok = $conn->prepare("UPDATE menu SET stok = stok - ? WHERE nama_menu = ?");
                $stmt_kurangi_stok->bind_param("is", $jumlah, $nama_menu);
                $stmt_kurangi_stok->execute();
                $stmt_kurangi_stok->close();
            } else {
                echo "Stok untuk '$nama_menu' tidak mencukupi. Hanya tersisa $stok_sekarang.<br>";
            }
        }

        $stmt_stok->close();
    }

    $stmt_pesanan->close();
    $conn->close();

    // Redirect ke halaman terima kasih
    header("Location: terima_kasih.php");
    exit();
} else {
    die("Data tidak lengkap.");
}
?>
