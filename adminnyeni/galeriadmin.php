<?php
// Koneksi langsung
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbangkringan";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Proses Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gambar'])) {
    $namaFile = $_FILES['gambar']['name'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    $deskripsi = $_POST['deskripsi'] ?? '';
    $folder = "uploads/galeri/";

    if (!file_exists($folder)) mkdir($folder, 0777, true);

    // Amankan nama file
    $namaBaru = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $namaFile);
    $path = $folder . $namaBaru;

    if (move_uploaded_file($tmpName, $path)) {
        $stmt = $conn->prepare("INSERT INTO galeri (nama_file, deskripsi) VALUES (?, ?)");
        $stmt->bind_param("ss", $namaBaru, $deskripsi);
        $stmt->execute();
    }
}

// Hapus gambar
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $result = $conn->query("SELECT nama_file FROM galeri WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $filePath = "uploads/galeri/" . $row['nama_file'];
        if (file_exists($filePath)) unlink($filePath);
        $conn->query("DELETE FROM galeri WHERE id = $id");
    }
}

// Ambil data galeri
$result = $conn->query("SELECT * FROM galeri ORDER BY tanggal_upload DESC");
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Galeri Admin - Angkringan Nyeni</title>
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

<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="text-center border-bottom pb-2 mb-4">Galeri Admin</h3>

            <!-- Form Upload -->
            <form method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="mb-3">
                    <label for="gambar" class="form-label">Pilih Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Upload Gambar</button>
            </form>

            <!-- Galeri -->
            <?php if ($result->num_rows > 0): ?>
                <div class="row">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100">
                                <img src="uploads/galeri/<?= htmlspecialchars($row['nama_file']) ?>" class="card-img-top" alt="Galeri">
                                <div class="card-body">
                                    <p class="card-text small"><?= htmlspecialchars($row['deskripsi']) ?></p>
                                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger w-100" onclick="return confirm('Hapus gambar ini?')">Hapus</a>
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
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
