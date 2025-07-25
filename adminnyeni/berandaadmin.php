<?php
session_start();

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

// Statistik
$totalMenu = $conn->query("SELECT COUNT(*) as total FROM menu")->fetch_assoc()['total'];
$totalMakanan = $conn->query("SELECT COUNT(*) as total FROM menu WHERE kategori='makanan'")->fetch_assoc()['total'];
$totalMinuman = $conn->query("SELECT COUNT(*) as total FROM menu WHERE kategori='minuman'")->fetch_assoc()['total'];
$totalStok = $conn->query("SELECT SUM(stok) as total FROM menu")->fetch_assoc()['total'];

// Data carousel
$carouselData = $conn->query("SELECT * FROM carousel ORDER BY posisi ASC");
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin - Angkringan Nyeni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            padding-top: 80px;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
<?php include "navbar.php"; ?>

<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="text-center border-bottom pb-2 mb-4">Beranda Admin</h2>

            <!-- Statistik -->
            <div class="row g-4 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card border-primary shadow-sm text-center">
                        <div class="card-body">
                            <i class="bi bi-list-ul fs-1 text-primary"></i>
                            <h6 class="mt-2 mb-0">Total Menu</h6>
                            <p class="fs-5 fw-bold"><?= $totalMenu ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-success shadow-sm text-center">
                        <div class="card-body">
                            <i class="bi bi-cup-hot fs-1 text-success"></i>
                            <h6 class="mt-2 mb-0">Minuman</h6>
                            <p class="fs-5 fw-bold"><?= $totalMinuman ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-warning shadow-sm text-center">
                        <div class="card-body">
                            <i class="bi bi-egg-fried fs-1 text-warning"></i>
                            <h6 class="mt-2 mb-0">Makanan</h6>
                            <p class="fs-5 fw-bold"><?= $totalMakanan ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-danger shadow-sm text-center">
                        <div class="card-body">
                            <i class="bi bi-box-seam fs-1 text-danger"></i>
                            <h6 class="mt-2 mb-0">Total Stok</h6>
                            <p class="fs-5 fw-bold"><?= $totalStok ?: 0 ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info tambahan -->
            <div class="text-center mt-5">
                <p class="text-muted">
                    Selamat datang di halaman admin <strong>Angkringan Nyeni</strong>.<br>
                    Silakan pilih menu di atas untuk mengelola data.
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
