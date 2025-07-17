<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'], $_POST['id'])) {
    $aksi = $_POST['aksi'];
    $id = intval($_POST['id']);

    $conn = new mysqli("localhost", "root", "", "dbangkringan");
    if ($conn->connect_error) {
        http_response_code(500);
        echo "Koneksi gagal: " . $conn->connect_error;
        exit;
    }

    // Cek data pesanan berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM pesanan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo "Pesanan tidak ditemukan.";
        exit;
    }
    $pesanan = $result->fetch_assoc();
    $stmt->close();

    // Tentukan status baru berdasarkan aksi
    if ($aksi === 'konfirmasi' && $pesanan['status'] === 'baru') {
        $status_baru = 'terproses';
    } elseif ($aksi === 'selesai' && $pesanan['status'] === 'terproses') {
        $status_baru = 'selesai';
    } else {
        http_response_code(400);
        echo "Aksi tidak valid atau status tidak cocok.";
        exit;
    }

    // Update status pesanan
    $stmt_update = $conn->prepare("UPDATE pesanan SET status = ? WHERE id = ?");
    $stmt_update->bind_param("si", $status_baru, $id);
    if ($stmt_update->execute()) {
        echo "Status berhasil diperbarui ke '$status_baru'.";
    } else {
        http_response_code(500);
        echo "Gagal update status: " . $stmt_update->error;
    }
    $stmt_update->close();
    $conn->close();
} else {
    http_response_code(400);
    echo "Data tidak lengkap.";
}
?>
