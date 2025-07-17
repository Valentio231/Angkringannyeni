<?php
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "dbangkringan";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success = "";
$error = "";

$username_lama = $_SESSION['admin_username'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username_baru = $_POST["username"];
    $password_lama = $_POST["password_lama"];
    $password_baru = $_POST["password_baru"];
    $konfirmasi_password = $_POST["konfirmasi_password"];

    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username_lama);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password_lama, $admin["password"])) {
            if ($password_baru === $konfirmasi_password) {
                $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE admin SET username = ?, password = ? WHERE username = ?");
                $update->bind_param("sss", $username_baru, $password_hash, $username_lama);
                if ($update->execute()) {
                    $_SESSION['admin_username'] = $username_baru;
                    $success = "Data akun berhasil diperbarui.";
                } else {
                    $error = "Gagal memperbarui data.";
                }
            } else {
                $error = "Konfirmasi password tidak cocok.";
            }
        } else {
            $error = "Password lama salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card mx-auto shadow" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="card-title mb-4">Pengaturan Akun</h4>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label>Username Baru</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($_SESSION['admin_username']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Password Lama</label>
                        <input type="password" name="password_lama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="password_baru" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="berandaadmin.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
