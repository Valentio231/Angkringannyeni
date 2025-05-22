<?php
// Terima data pesanan dari form sebelumnya
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesanan_json'])) {
    $pesanan = json_decode($_POST['pesanan_json'], true);
    if (!$pesanan || count($pesanan) === 0) {
        die("Pesanan kosong. Silakan kembali dan pilih menu.");
    }
} else {
    die("Tidak ada data pesanan. Silakan kembali dan pilih menu.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Checkout - Angkringan Nyeni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<?php include "navbar.php"; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Konfirmasi Pesanan Anda</h1>

    <h4>Ringkasan Pesanan</h4>
    <ul class="list-group mb-3">
        <?php
        // Koneksi ke DB untuk ambil harga sesuai nama menu
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "dbangkringan";

        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $totalHarga = 0;
        foreach ($pesanan as $nama => $qty) {
            if ($qty <= 0) continue;

            // Ambil harga dari database
            $stmt = $conn->prepare("SELECT harga FROM menu WHERE nama_menu = ?");
            $stmt->bind_param("s", $nama);
            $stmt->execute();
            $stmt->bind_result($harga);
            $stmt->fetch();
            $stmt->close();

            $subtotal = $harga * $qty;
            $totalHarga += $subtotal;
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
            echo htmlspecialchars($nama) . " x " . $qty;
            echo "<span>Rp " . number_format($subtotal,0,',','.') . "</span>";
            echo "</li>";
        }
        echo "<li class='list-group-item d-flex justify-content-between align-items-center fw-bold'>";
        echo "Total";
        echo "<span>Rp " . number_format($totalHarga,0,',','.') . "</span>";
        echo "</li>";
        ?>
    </ul>

    <!-- Form data pelanggan -->
    <form action="proses_pemesanan.php" method="post">
        <input type="hidden" name="pesanan_json" value='<?= htmlspecialchars(json_encode($pesanan), ENT_QUOTES) ?>' />
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input required type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Anda" />
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Nomor Telepon (WA) </label>
            <input required type="tel" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon" />
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">No Meja</label>
            <input required type="text" class="form-control" id="no meja" name="no meja" placeholder="Nomer meja anda" />
        </div>
        <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
    </form>
</div>
</body>
</html>
