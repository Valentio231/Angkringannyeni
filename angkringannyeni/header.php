<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Galeri - Angkringan Nyeni</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 80px;
            background-color: #f8f9fa;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<?php include "navbar.php"; ?>

<?php
// Koneksi ke database langsung
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbangkringan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM galeri ORDER BY tanggal_upload DESC");
?>

<div class="container py-4">
    <h3 class="text-center mb-4">Galeri Kami</h3>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="uploads/galeri/<?= htmlspecialchars($row['nama_file']) ?>" class="card-img-top" alt="Galeri">
                        <div class="card-body">
                            <p class="card-text small"><?= htmlspecialchars($row['deskripsi']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Belum ada gambar di galeri.
        </div>
    <?php endif; ?>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
</body>
</html>
