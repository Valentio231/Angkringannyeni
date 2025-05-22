<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbangkringan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data makanan
$makanan = [];
$resultMakanan = $conn->query("SELECT * FROM menu WHERE kategori = 'makanan'");
while ($row = $resultMakanan->fetch_assoc()) {
    $makanan[] = $row;
}

// Ambil data minuman
$minuman = [];
$resultMinuman = $conn->query("SELECT * FROM menu WHERE kategori = 'minuman'");
while ($row = $resultMinuman->fetch_assoc()) {
    $minuman[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Angkringan Nyeni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<?php include "navbar.php"; ?>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Selamat Datang di Angkringan Nyeni</h1>
        <div class="row">
            <!-- Menu Makanan -->
            <div class="col-md-6">
                <h4>Makanan</h4>
                <ul class="list-group">
                    <?php foreach ($makanan as $index => $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="images/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_menu']) ?>" 
                                     style="width:60px; height:60px; object-fit:cover; border-radius:5px; margin-right:15px;">
                                <div>
                                    <strong><?= htmlspecialchars($item['nama_menu']) ?></strong><br />
                                    <small>Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?> | Stok: <span id="stok_makanan_<?= $index ?>"><?= (int)$item['stok'] ?></span></small>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary me-1" onclick="ubahPesanan('makanan', <?= $index ?>, -1)">-</button>
                                <span id="qty_makanan_<?= $index ?>">0</span>
                                <button class="btn btn-sm btn-outline-primary ms-1" onclick="ubahPesanan('makanan', <?= $index ?>, 1)">+</button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Menu Minuman -->
            <div class="col-md-6">
                <h4>Minuman</h4>
                <ul class="list-group">
                    <?php foreach ($minuman as $index => $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="images/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_menu']) ?>" 
                                     style="width:60px; height:60px; object-fit:cover; border-radius:5px; margin-right:15px;">
                                <div>
                                    <strong><?= htmlspecialchars($item['nama_menu']) ?></strong><br />
                                    <small>Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?> | Stok: <span id="stok_minuman_<?= $index ?>"><?= (int)$item['stok'] ?></span></small>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary me-1" onclick="ubahPesanan('minuman', <?= $index ?>, -1)">-</button>
                                <span id="qty_minuman_<?= $index ?>">0</span>
                                <button class="btn btn-sm btn-outline-primary ms-1" onclick="ubahPesanan('minuman', <?= $index ?>, 1)">+</button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="mt-5">
            <h4>Ringkasan Pesanan</h4>
            <ul class="list-group" id="pesanan-list">
                <!-- Pesanan akan muncul di sini -->
            </ul>

            <!-- Form dan tombol Pesan -->
            <form id="form-pesan" action="checkout.php" method="post" style="display:none; margin-top:15px;">
                <input type="hidden" name="pesanan_json" id="pesanan_json" />
                <button type="submit" class="btn btn-success">Pesan</button>
            </form>
        </div>
    </div>

    <script>
        let pesanan = {};
        let hargaMenu = {};

        // Isi hargaMenu dari PHP supaya bisa diakses di JS
        <?php
        $allMenus = array_merge($makanan, $minuman);
        echo "hargaMenu = {";
        foreach ($allMenus as $menu) {
            $namaJS = addslashes($menu['nama_menu']);
            echo "'$namaJS': {$menu['harga']},";
        }
        echo "};";
        ?>

        function ubahPesanan(kategori, index, perubahan) {
            const id = kategori + "_" + index;
            const qtyEl = document.getElementById("qty_" + id);
            const stokEl = document.getElementById("stok_" + id);

            let qty = parseInt(qtyEl.innerText);
            let stok = parseInt(stokEl.innerText);
            const nama = stokEl.closest("li").querySelector("strong").innerText;

            if (!pesanan[nama]) pesanan[nama] = 0;

            if (perubahan === 1 && stok > 0) {
                qty++;
                stok--;
                pesanan[nama]++;
            } else if (perubahan === -1 && qty > 0) {
                qty--;
                stok++;
                pesanan[nama]--;
            }

            qtyEl.innerText = qty;
            stokEl.innerText = stok;
            updatePesanan();
        }

        function updatePesanan() {
            const list = document.getElementById("pesanan-list");
            const formPesan = document.getElementById("form-pesan");
            const pesananJsonInput = document.getElementById("pesanan_json");

            list.innerHTML = "";
            let totalHarga = 0;
            let adaPesanan = false;

            for (let item in pesanan) {
                if (pesanan[item] > 0) {
                    adaPesanan = true;
                    const hargaItem = hargaMenu[item];
                    const subTotal = hargaItem * pesanan[item];
                    totalHarga += subTotal;

                    const li = document.createElement("li");
                    li.className = "list-group-item d-flex justify-content-between align-items-center";
                    li.innerHTML = `<span>${item} x ${pesanan[item]}</span><span>Rp ${subTotal.toLocaleString('id-ID')}</span>`;
                    list.appendChild(li);
                }
            }

            if (totalHarga > 0) {
                const totalLi = document.createElement("li");
                totalLi.className = "list-group-item d-flex justify-content-between align-items-center fw-bold";
                totalLi.innerHTML = `<span>Total</span><span>Rp ${totalHarga.toLocaleString('id-ID')}</span>`;
                list.appendChild(totalLi);
            }

            if (adaPesanan) {
                formPesan.style.display = "block";
                pesananJsonInput.value = JSON.stringify(pesanan);
            } else {
                formPesan.style.display = "none";
                pesananJsonInput.value = "";
            }
        }
    </script>
</body>
</html>
