<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angkringan Nyeni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            max-width: 400px;
            margin: 20px auto;
        }

        .sidebar-menu {
            background-color: #e2e6ea;
            padding: 20px;
            border-radius: 15px;
            max-width: 600px;
            margin: 20px auto;
        }

        .btn-custom {
            background-color: #ff5722;
            color: white;
            border-radius: 10px;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #e64a19;
        }
    </style>
</head>

<body>

<?php include "navbar.php"; ?>

<!-- Carousel -->
<div class="container my-4">
    <div id="carouselExampleCaptions" class="carousel slide shadow rounded-4 overflow-hidden mx-auto" style="max-width: 600px;">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/Het geheim van het merguez worstje.jpeg" class="d-block w-100"
                    style="height: 250px; object-fit: cover;" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-2">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/10 Resep bakso bakar enak, sederhana, dan menggugah selera.jpeg" class="d-block w-100"
                    style="height: 250px; object-fit: cover;" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-2">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/Angkringan.jpeg" class="d-block w-100"
                    style="height: 250px; object-fit: cover;" alt="...">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 p-2">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Akhir Carousel -->

<!-- Tombol Pemesanan -->
<div class="container my-4 text-center">
    <button class="btn btn-custom px-4 py-2">Pesan</button>
</div>

<!-- Sidebar Menu Utama -->
<div class="sidebar-menu">
    <h5 class="card-header">Menu Spesial</h5>
    <div class="card-body">
        <h5 class="card-title">Sate Usus Pedas</h5>
        <p class="card-text">Sate usus dengan bumbu pedas khas angkringan, cocok disantap dengan nasi kucing dan teh panas.</p>
        <a href="#" class="btn btn-primary">Lihat Menu</a>
    </div>
</div>

<!-- Sidebar Info Angkringan -->
<div class="sidebar">
    <h5><i class="bi bi-cup-hot"></i> Info Angkringan</h5>
    <ul class="list-unstyled">
        <li><i class="bi bi-clock-history"></i> Jam Buka: 17.00 - 23.00</li>
        <li><i class="bi bi-geo-alt"></i> Jl. Kenangan No.10, Surabaya</li>
        <li><i class="bi bi-star-fill"></i> Spesial Hari Ini: Wedang Jahe + Sate Usus</li>
    </ul>
</div>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>

</body>

</html>
