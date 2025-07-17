<?php
// koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";    // sesuaikan
$db = "dbangkringan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// FOLDER UPLOAD
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) mkdir($uploadDir);

// Proses Tambah Data
if (isset($_POST['submit_tambah'])) {
    $nama_menu = $conn->real_escape_string($_POST['nama_menu']);
    $kategori = $_POST['kategori']; // makanan / minuman
    $stok = (int)$_POST['stok'];
    $harga = (float)$_POST['harga'];

    // Upload gambar jika ada
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $fileName = basename($_FILES['gambar']['name']);
        $targetFile = $uploadDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            $gambar = $conn->real_escape_string($targetFile);
        }
    }

    $sql = "INSERT INTO menu (nama_menu, kategori, stok, harga, gambar) VALUES ('$nama_menu', '$kategori', $stok, $harga, " . ($gambar ? "'$gambar'" : "NULL") . ")";
    $conn->query($sql);
    header("Location: menuadmin.php");
    exit;
}

// Proses Edit Data
if (isset($_POST['submit_edit'])) {
    $id_menu = (int)$_POST['id_menu'];
    $nama_menu = $conn->real_escape_string($_POST['nama_menu']);
    $kategori = $_POST['kategori'];
    $stok = (int)$_POST['stok'];
    $harga = (float)$_POST['harga'];

    // Cek gambar lama
    $oldGambar = null;
    $resultOld = $conn->query("SELECT gambar FROM menu WHERE id_menu=$id_menu");
    if ($resultOld && $rowOld = $resultOld->fetch_assoc()) {
        $oldGambar = $rowOld['gambar'];
    }

    // Upload gambar baru jika ada
    $gambar = $oldGambar;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $fileName = basename($_FILES['gambar']['name']);
        $targetFile = $uploadDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            $gambar = $conn->real_escape_string($targetFile);
            // hapus file lama jika ada
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

// Ambil data menu untuk ditampilkan
$result = $conn->query("SELECT * FROM menu ORDER BY kategori, nama_menu");

// Jika ada parameter edit id, ambil data satu menu untuk form edit
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
<html lang="en">

<head>
    <title>Menu Admin Angkringan Nyeni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Menu Admin</h2>

        <!-- FORM TAMBAH / EDIT -->
        <div class="card mb-5">
            <div class="card-body">
                <h4><?= $editData ? "Edit Menu" : "Tambah Menu Baru" ?></h4>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_menu" value="<?= $editData ? $editData['id_menu'] : '' ?>">

                    <div class="mb-3">
                        <label for="nama_menu" class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" required
                            value="<?= $editData ? htmlspecialchars($editData['nama_menu']) : '' ?>">
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="makanan" <?= ($editData && $editData['kategori'] == 'makanan') ? 'selected' : '' ?>>Makanan</option>
                            <option value="minuman" <?= ($editData && $editData['kategori'] == 'minuman') ? 'selected' : '' ?>>Minuman</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" min="0" required
                            value="<?= $editData ? (int)$editData['stok'] : 0 ?>">
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" step="0.01" class="form-control" id="harga" name="harga" min="0" required
                            value="<?= $editData ? (float)$editData['harga'] : 0 ?>">
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar <?= $editData ? '(kosongkan jika tidak ingin ganti)' : '' ?></label>
                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                        <?php if ($editData && $editData['gambar']) : ?>
                            <img src="<?= htmlspecialchars($editData['gambar']) ?>" alt="Gambar Menu" class="mt-2" style="max-width:150px;">
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="<?= $editData ? 'submit_edit' : 'submit_tambah' ?>" class="btn btn-primary">
                        <?= $editData ? 'Update Menu' : 'Tambah Menu' ?>
                    </button>
                    <?php if ($editData): ?>
                        <a href="menuadmin.php" class="btn btn-secondary ms-2">Batal</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- LIST MENU -->
        <h4>Daftar Menu</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_menu']) ?></td>
                            <td><?= htmlspecialchars($row['kategori']) ?></td>
                            <td><?= (int)$row['stok'] ?></td>
                            <td>Rp <?= number_format($row['harga'], 2, ',', '.') ?></td>
                            <td>
                                <?php if ($row['gambar'] && file_exists($row['gambar'])) : ?>
                                    <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar" style="max-width: 80px;">
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?edit=<?= $row['id_menu'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr><td colspan="6" class="text-center">Belum ada menu</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
