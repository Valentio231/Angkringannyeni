<?php
// Terima data pesanan dari form sebelumnya (via POST JSON)
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
        $conn = new mysqli("localhost", "root", "", "dbangkringan");
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $totalHarga = 0;
        foreach ($pesanan as $nama => $qty) {
            if ($qty <= 0) continue;

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
            echo "<span>Rp " . number_format($subtotal, 0, ',', '.') . "</span>";
            echo "</li>";
        }

        echo "<li class='list-group-item d-flex justify-content-between align-items-center fw-bold'>";
        echo "Total";
        echo "<span>Rp " . number_format($totalHarga, 0, ',', '.') . "</span>";
        echo "</li>";

        $conn->close();
        ?>
    </ul>

    <!-- Form data pelanggan -->
    <form action="proses_pemesanan.php" method="post" novalidate>
        <input type="hidden" name="pesanan_json" value='<?= htmlspecialchars(json_encode($pesanan), ENT_QUOTES) ?>' />

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input required type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Anda" />
        </div>

        <div class="mb-3">
            <label for="telepon_user" class="form-label">Nomor Telepon (WA)</label>
            <div class="input-group">
                <span class="input-group-text">+62</span>
                <input required type="tel" class="form-control" id="telepon_user" name="telepon_user"
                       placeholder="81234567890" pattern="[0-9]{8,}"
                       title="Masukkan nomor tanpa angka 0 di depan. Contoh: 81234567890" />
            </div>
            <small class="text-muted">Masukkan nomor tanpa 0 di depan (contoh: 81234567890)</small>
        </div>

        <div class="mb-3">
            <label for="no_meja" class="form-label">No Meja</label>
            <input required type="text" class="form-control" id="no_meja" name="no_meja" placeholder="Nomor meja Anda" />
        </div>

        <!-- Kolom keterangan tambahan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan Tambahan (opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: tanpa es, tidak pedas, bungkus, dll."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
    </form>
</div>

</body>
</html>
