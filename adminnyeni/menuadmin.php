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

// Folder upload
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir);

// Tambah menu
if (isset($_POST['submit_tambah'])) {
    $nama_menu = $conn->real_escape_string($_POST['nama_menu']);
    $kategori = $_POST['kategori'];
    $stok = (int)$_POST['stok'];
    $harga = (float)$_POST['harga'];

    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $fileName = basename($_FILES['gambar']['name']);
        $targetFile = $uploadDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            $gambar = $conn->real_escape_string($targetFile);
        }
    }

    $sql = "INSERT INTO menu (nama_menu, kategori, stok, harga, gambar) 
            VALUES ('$nama_menu', '$kategori', $stok, $harga, " . ($gambar ? "'$gambar'" : "NULL") . ")";
    $conn->query($sql);
    header("Location: menuadmin.php");
    exit;
}

// Edit menu
if (isset($_POST['submit_edit'])) {
    $id_menu = (int)$_POST['id_menu'];
    $nama_menu = $conn->real_escape_string($_POST['nama_menu']);
    $kategori = $_POST['kategori'];
    $stok = (int)$_POST['stok'];
    $harga = (float)$_POST['harga'];

    $oldGambar = null;
    $resultOld = $conn->query("SELECT gambar FROM menu WHERE id_menu=$id_menu");
    if ($resultOld && $rowOld = $resultOld->fetch_assoc()) {
        $oldGambar = $rowOld['gambar'];
    }

    $gambar = $oldGambar;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $fileName = basename($_FILES['gambar']['name']);
        $targetFile = $uploadDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            $gambar = $conn->real_escape_string($targetFile);
            if ($oldGambar && file_exists($oldGambar)) unlink($oldGambar);
        }
    }

    $sql = "UPDATE menu SET 
        nama_menu='$nama_menu',
        kategori='$kategori',
        stok=$stok,
        harga=$harga,
        gambar=" . ($gambar ? "'$gambar'" : "NULL") . "
        WHERE id_menu=$id_menu";
    $conn->query($sql);
    header("Location: menuadmin.php");
    exit;
}

// Hapus menu
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    $resGambar = $conn->query("SELECT gambar FROM menu WHERE id_menu=$id_hapus");
    if ($resGambar && $rowGambar = $resGambar->fetch_assoc()) {
        if ($rowGambar['gambar'] && file_exists($rowGambar['gambar'])) {
            unlink($rowGambar['gambar']);
        }
    }
    $conn->query("DELETE FROM menu WHERE id_menu=$id_hapus");
    header("Location: menuadmin.php");
    exit;
}

// Ambil semua menu
$result = $conn->query("SELECT * FROM menu ORDER BY kategori, nama_menu");

// Jika sedang edit
$editData = null;
if (isset($_GET['edit'])) {
    $id_edit = (int)$_GET['edit'];
    $resEdit = $conn->query("SELECT * FROM menu WHERE id_menu=$id_edit");
    if ($resEdit && $resEdit->num_rows > 0) {
        $editData = $resEdit->fetch_assoc();
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin - Angkringan Nyeni</title>
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
            <h2 class="text-center border-bottom pb-2 mb-4">Menu Admin</h2>

            <!-- Form Tambah/Edit -->
            <h5 class="mb-3"><?= $editData ? "Edit Menu" : "Tambah Menu Baru" ?></h5>
            <form method="POST" enctype="multipart/form-data" class="row g-3 mb-5">
                <input type="hidden" name="id_menu" value="<?= $editData['id_menu'] ?? '' ?>">

                <div class="col-md-4">
                    <label for="nama_menu" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" name="nama_menu" id="nama_menu" required
                        value="<?= $editData['nama_menu'] ?? '' ?>">
                </div>

                <div class="col-md-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" name="kategori" id="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="makanan" <?= ($editData && $editData['kategori'] == 'makanan') ? 'selected' : '' ?>>Makanan</option>
                        <option value="minuman" <?= ($editData && $editData['kategori'] == 'minuman') ? 'selected' : '' ?>>Minuman</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" required min="0"
                        value="<?= $editData['stok'] ?? 0 ?>">
                </div>

                <div class="col-md-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" name="harga" id="harga" required min="0" step="0.01"
                        value="<?= $editData['harga'] ?? 0 ?>">
                </div>

                <div class="col-md-6">
                    <label for="gambar" class="form-label">Gambar <?= $editData ? '(kosongkan jika tidak diganti)' : '' ?></label>
                    <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
                    <?php if ($editData && $editData['gambar']): ?>
                        <img src="<?= htmlspecialchars($editData['gambar']) ?>" class="mt-2 rounded" style="max-width: 100px;">
                    <?php endif; ?>
                </div>

                <div class="col-12">
                    <button type="submit" name="<?= $editData ? 'submit_edit' : 'submit_tambah' ?>" class="btn btn-primary">
                        <?= $editData ? 'Update Menu' : 'Tambah Menu' ?>
                    </button>
                    <?php if ($editData): ?>
                        <a href="menuadmin.php" class="btn btn-secondary ms-2">Batal</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Tabel Daftar Menu -->
            <h5 class="mb-3">Daftar Menu</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama_menu']) ?></td>
                                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                                    <td><?= (int)$row['stok'] ?></td>
                                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if ($row['gambar'] && file_exists($row['gambar'])): ?>
                                            <img src="<?= htmlspecialchars($row['gambar']) ?>" style="max-width: 70px;">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="?edit=<?= $row['id_menu'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="?hapus=<?= $row['id_menu'] ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center text-muted">Belum ada menu.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
