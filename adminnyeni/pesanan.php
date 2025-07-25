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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    $id_pesanan = $_POST['id_pesanan'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($id_pesanan && $action) {
        $result = $conn->query("SELECT * FROM pesanan WHERE id = " . intval($id_pesanan));
        $pesanan = $result->fetch_assoc();

        if ($pesanan) {
            $nama_pelanggan = $conn->real_escape_string($pesanan['nama_pelanggan']);
            $nomor_meja = $conn->real_escape_string($pesanan['nomor_meja']);

            $res_tel = $conn->query("SELECT telepon FROM pelanggan WHERE nama_pelanggan = '$nama_pelanggan' AND nomor_meja = '$nomor_meja' ORDER BY id DESC LIMIT 1");
            $row_tel = $res_tel->fetch_assoc();
            $telepon = $row_tel ? $row_tel['telepon'] : '';

            $res_pesanan = $conn->query("
                SELECT p.nama_menu, p.jumlah, m.harga 
                FROM pesanan p 
                JOIN menu m ON p.nama_menu = m.nama_menu 
                WHERE p.nama_pelanggan = '$nama_pelanggan' AND p.nomor_meja = '$nomor_meja'
            ");

            $keterangan_row = $conn->query("SELECT keterangan FROM pesanan WHERE nama_pelanggan = '$nama_pelanggan' AND nomor_meja = '$nomor_meja' AND keterangan IS NOT NULL AND keterangan != '' ORDER BY id DESC LIMIT 1")->fetch_assoc();
            $keterangan = $keterangan_row ? $keterangan_row['keterangan'] : '';

            $pesan_items = "";
            $total_jumlah = 0;
            $total_harga = 0;
            while ($row = $res_pesanan->fetch_assoc()) {
                $pesan_items .= "- " . $row['nama_menu'] . " x " . $row['jumlah'] . "\n";
                $total_jumlah += intval($row['jumlah']);
                $total_harga += intval($row['harga']) * intval($row['jumlah']);
            }

            if ($action === 'konfirmasi') {
                $conn->query("UPDATE pesanan SET status = 'dikonfirmasi' WHERE nama_pelanggan = '$nama_pelanggan' AND nomor_meja = '$nomor_meja' AND status = 'baru'");

                $pesan = "*Angkringan Nyeni - Konfirmasi Pesanan*\n";
                $pesan .= "Nama: $nama_pelanggan\n";
                $pesan .= "Meja: $nomor_meja\nPesanan:\n$pesan_items";
                if (!empty($keterangan)) {
                    $pesan .= "Keterangan: $keterangan\n";
                }
                $pesan .= "Total jumlah pesanan: $total_jumlah\n\n";
                $pesan .= "Terima kasih telah memesan di Angkringan Nyeni! 😊";
            } elseif ($action === 'selesai') {
                $conn->query("UPDATE pesanan SET status = 'selesai' WHERE nama_pelanggan = '$nama_pelanggan' AND nomor_meja = '$nomor_meja'");

                $pesan = "*Angkringan Nyeni - Pesanan Siap*\n";
                $pesan .= "Hai $nama_pelanggan, pesanan Anda untuk Meja $nomor_meja sudah siap diambil! 🍽️\n\n";
                $pesan .= "Detail pesanan:\n$pesan_items";
                if (!empty($keterangan)) {
                    $pesan .= "Keterangan: $keterangan\n";
                }
                $pesan .= "Total jumlah pesanan: $total_jumlah\n";
                $pesan .= "Total harga: Rp " . number_format($total_harga, 0, ',', '.') . "\n\n";
                $pesan .= "Silakan lakukan pembayaran di kasir ya. Terima kasih 🙏";
            } else {
                echo json_encode(["error" => "Aksi tidak dikenali."]);
                exit();
            }

            if ($telepon) {
                $pesan_encoded = urlencode($pesan);
                $wa_url = "https://wa.me/$telepon?text=$pesan_encoded";
                echo json_encode(["success" => true, "wa_url" => $wa_url]);
            } else {
                echo json_encode(["error" => "Nomor WhatsApp pelanggan tidak ditemukan."]);
            }
        } else {
            echo json_encode(["error" => "Data pesanan tidak ditemukan."]);
        }
    } else {
        echo json_encode(["error" => "Data tidak lengkap."]);
    }
    exit();
}

$data_pesanan = $conn->query("SELECT * FROM pesanan ORDER BY tanggal_pesan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Masuk - Angkringan Nyeni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            padding-top: 80px;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        td, th {
            word-break: break-word;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<?php include "navbar.php"; ?>
<div class="container-fluid">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="text-center mb-4">Pesanan Masuk</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-nowrap">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Meja</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ditampilkan = [];
                        while ($row = $data_pesanan->fetch_assoc()):
                            $key = $row['nama_pelanggan'] . "_" . $row['nomor_meja'];
                            if (!isset($ditampilkan[$key])) {
                                $nama = htmlspecialchars($row['nama_pelanggan']);
                                $meja = htmlspecialchars($row['nomor_meja']);
                                $statusPesanan = $row['status'];

                                echo "<tr id='pesanan-" . $row['id'] . "'>";
                                echo "<td>$nama</td><td class='text-center'>$meja</td><td>";

                                $subquery = $conn->query("SELECT nama_menu, jumlah FROM pesanan WHERE nama_pelanggan = '$nama' AND nomor_meja = '$meja'");
                                while ($item = $subquery->fetch_assoc()) {
                                    echo htmlspecialchars($item['nama_menu']) . " x " . $item['jumlah'] . "<br>";
                                }
                                echo "</td>";

                                $sumJumlah = $conn->query("SELECT SUM(jumlah) as total_jumlah FROM pesanan WHERE nama_pelanggan = '$nama' AND nomor_meja = '$meja'")->fetch_assoc()['total_jumlah'];
                                $totalHarga = $conn->query("SELECT SUM(m.harga * p.jumlah) AS total_harga FROM pesanan p JOIN menu m ON p.nama_menu = m.nama_menu WHERE p.nama_pelanggan = '$nama' AND p.nomor_meja = '$meja'")->fetch_assoc()['total_harga'];
                                $keterangan = $conn->query("SELECT keterangan FROM pesanan WHERE nama_pelanggan = '$nama' AND nomor_meja = '$meja' AND keterangan IS NOT NULL AND keterangan != '' ORDER BY id DESC LIMIT 1")->fetch_assoc()['keterangan'] ?? '';

                                echo "<td class='text-center'>" . $sumJumlah . "</td>";
                                echo "<td>Rp " . number_format($totalHarga, 0, ',', '.') . "</td>";
                                echo "<td>" . htmlspecialchars($keterangan) . "</td>";

                                $statusClass = $statusPesanan === 'baru' ? 'secondary' : ($statusPesanan === 'dikonfirmasi' ? 'warning' : 'success');
                                echo "<td class='text-center'><span class='badge bg-$statusClass text-capitalize'>" . $statusPesanan . "</span></td>";

                                echo "<td class='text-center'>";
                                if ($statusPesanan === 'baru') {
                                    echo "<button class='btn btn-sm btn-warning btn-aksi' data-id='" . $row['id'] . "' data-action='konfirmasi'><i class='bi bi-check2-square'></i> Konfirmasi</button>";
                                } elseif ($statusPesanan === 'dikonfirmasi') {
                                    echo "<button class='btn btn-sm btn-success btn-aksi' data-id='" . $row['id'] . "' data-action='selesai'><i class='bi bi-box-seam'></i> Selesai</button>";
                                } else {
                                    echo "<i class='text-muted'>-</i>";
                                }
                                echo "</td></tr>";

                                $ditampilkan[$key] = true;
                            }
                        endwhile;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-aksi').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const action = this.getAttribute('data-action');

        fetch('pesanan.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                ajax: 1,
                id_pesanan: id,
                action: action
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.open(data.wa_url, '_blank');
                location.reload();
            } else {
                alert(data.error || "Terjadi kesalahan.");
            }
        })
        .catch(err => alert("Gagal memproses: " + err));
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>