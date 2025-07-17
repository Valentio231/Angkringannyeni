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

// Ambil data makanan dan minuman
$makanan = [];
$resultMakanan = $conn->query("SELECT * FROM menu WHERE kategori = 'makanan'");
while ($row = $resultMakanan->fetch_assoc()) {
    $makanan[] = $row;
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #fff8f3;
            font-family: 'Segoe UI', sans-serif;
            padding-bottom: 120px; /* Dikurangi karena ringkasan lebih kecil */
        }
        .menu-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: all 0.5s ease;
            transform: translateY(0);
            opacity: 1;
        }
        .menu-card.hidden {
            transform: translateY(20px);
            opacity: 0;
        }
        .menu-card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }
        .card-body {
            background-color: #fff;
            transition: all 0.3s ease;
        }
        .btn-custom {
            background-color: #ff5722;
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #e64a19;
            transform: scale(1.02);
        }
        #ringkasan-box {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffe5d0;
            border-radius: 15px 15px 0 0;
            padding: 15px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
            transition: all 0.5s ease;
        }
        #ringkasan-box.show {
            transform: translateY(0);
        }
        #ringkasan-box.hide {
            transform: translateY(100%);
        }
        #ringkasan-box .container {
            max-width: 100%;
        }
        .compact-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .summary-item {
            text-align: center;
            flex: 1;
        }
        .summary-count {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ff5722;
        }
        .page-title {
            margin-top: 0.5rem;
            margin-bottom: 1.5rem;
            animation: fadeInDown 0.8s ease;
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .menu-item-animate {
            animation: fadeInUp 0.6s ease forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
            body {
                padding-bottom: 140px; /* Disesuaikan untuk mobile */
            }
            #ringkasan-box {
                padding: 10px;
            }
            .page-title {
                margin-top: 0.3rem;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>

<?php include "navbar.php"; ?>

<div class="container">
    <h1 class="page-title text-center">Menu Angkringan Nyeni</h1>
    
    <div class="row">
        <!-- Makanan -->
        <div class="col-md-6">
            <h4 class="mb-3">Makanan</h4>
            <?php foreach ($makanan as $index => $item): ?>
                <div class="menu-card hidden" id="makanan-<?= $index ?>">
                    <div class="card-body">
                        <h5><?= htmlspecialchars($item['nama_menu']) ?></h5>
                        <p>Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?> | Stok: <span id="stok_makanan_<?= $index ?>"><?= (int)$item['stok'] ?></span></p>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary me-2" onclick="ubahPesanan('makanan', <?= $index ?>, -1)">-</button>
                            <span id="qty_makanan_<?= $index ?>">0</span>
                            <button class="btn btn-sm btn-outline-primary ms-2" onclick="ubahPesanan('makanan', <?= $index ?>, 1)">+</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Minuman -->
        <div class="col-md-6">
            <h4 class="mb-3">Minuman</h4>
            <?php foreach ($minuman as $index => $item): ?>
                <div class="menu-card hidden" id="minuman-<?= $index ?>">
                    <div class="card-body">
                        <h5><?= htmlspecialchars($item['nama_menu']) ?></h5>
                        <p>Harga: Rp <?= number_format($item['harga'], 0, ',', '.') ?> | Stok: <span id="stok_minuman_<?= $index ?>"><?= (int)$item['stok'] ?></span></p>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary me-2" onclick="ubahPesanan('minuman', <?= $index ?>, -1)">-</button>
                            <span id="qty_minuman_<?= $index ?>">0</span>
                            <button class="btn btn-sm btn-outline-primary ms-2" onclick="ubahPesanan('minuman', <?= $index ?>, 1)">+</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Ringkasan Pesanan yang Disederhanakan -->
<div id="ringkasan-box" class="hide">
    <div class="container">
        <div class="compact-summary">
            <div class="summary-item">
                <div>Makanan</div>
                <div class="summary-count" id="total-makanan">0</div>
            </div>
            <div class="summary-item">
                <div>Minuman</div>
                <div class="summary-count" id="total-minuman">0</div>
            </div>
            <div class="summary-item">
                <div>Total</div>
                <div class="summary-count" id="total-harga">Rp 0</div>
            </div>
        </div>
        <form id="form-pesan" action="checkout.php" method="post" class="mt-3">
            <input type="hidden" name="pesanan_json" id="pesanan_json" />
            <button type="submit" class="btn btn-custom w-100">Pesan Sekarang</button>
        </form>
    </div>
</div>

<script>
    let pesanan = {};
    let hargaMenu = {};

    <?php
    $allMenus = array_merge($makanan, $minuman);
    echo "hargaMenu = {";
    foreach ($allMenus as $menu) {
        $namaJS = addslashes($menu['nama_menu']);
        echo "'$namaJS': {$menu['harga']},";
    }
    echo "};";
    ?>

    document.addEventListener('DOMContentLoaded', function() {
        // Animasikan menu makanan
        const makananItems = document.querySelectorAll('.col-md-6:first-child .menu-card');
        makananItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.remove('hidden');
                item.classList.add('menu-item-animate');
            }, 100 * index);
        });

        // Animasikan menu minuman
        const minumanItems = document.querySelectorAll('.col-md-6:last-child .menu-card');
        minumanItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.remove('hidden');
                item.classList.add('menu-item-animate');
            }, 100 * (index + makananItems.length));
        });
    });

    function ubahPesanan(kategori, index, perubahan) {
        const id = kategori + "_" + index;
        const qtyEl = document.getElementById("qty_" + id);
        const stokEl = document.getElementById("stok_" + id);

        let qty = parseInt(qtyEl.innerText);
        let stok = parseInt(stokEl.innerText);
        const nama = stokEl.closest(".card-body").querySelector("h5").innerText;

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
        const totalMakananEl = document.getElementById("total-makanan");
        const totalMinumanEl = document.getElementById("total-minuman");
        const totalHargaEl = document.getElementById("total-harga");
        const pesananJsonInput = document.getElementById("pesanan_json");
        const ringkasanBox = document.getElementById("ringkasan-box");

        let totalMakanan = 0;
        let totalMinuman = 0;
        let totalHarga = 0;
        let adaPesanan = false;

        // Hitung total makanan dan minuman
        for (let item in pesanan) {
            if (pesanan[item] > 0) {
                adaPesanan = true;
                const hargaItem = hargaMenu[item];
                const subTotal = hargaItem * pesanan[item];
                totalHarga += subTotal;

                // Cek apakah item termasuk makanan atau minuman
                const isMakanan = <?php 
                    $makananNames = array_map(function($m) { return addslashes($m['nama_menu']); }, $makanan);
                    echo '[' . implode(',', array_map(function($n) { return "'$n'"; }, $makananNames)) . ']';
                ?>.includes(item);
                
                if (isMakanan) {
                    totalMakanan += pesanan[item];
                } else {
                    totalMinuman += pesanan[item];
                }
            }
        }

        // Update tampilan
        totalMakananEl.textContent = totalMakanan;
        totalMinumanEl.textContent = totalMinuman;
        totalHargaEl.textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');

        if (adaPesanan) {
            ringkasanBox.classList.remove('hide');
            ringkasanBox.classList.add('show');
            ringkasanBox.style.display = "block";
            pesananJsonInput.value = JSON.stringify(pesanan);
        } else {
            ringkasanBox.classList.remove('show');
            ringkasanBox.classList.add('hide');
            setTimeout(() => {
                ringkasanBox.style.display = "none";
            }, 500);
            pesananJsonInput.value = "";
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>