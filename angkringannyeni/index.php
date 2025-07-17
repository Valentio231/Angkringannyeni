<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Angkringan Nyeni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* Animasi */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .fade-in {
            animation: fadeIn 1.2s ease-in-out;
        }

        .fade-up {
            animation: fadeUp 1s ease-in-out;
        }

        .btn-custom {
            background-color: #ff5722;
            color: white;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .btn-custom:hover {
            background-color: #e64a19;
            color: white;
        }

        .section {
            padding: 60px 20px;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/Angkringan.jpeg') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero-section p {
            font-size: 1.2rem;
        }

        .card-section {
            background-color: #fefcf9;
        }

        .info-map {
            background-color: #fff3e0;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <!-- Hero Section -->
    <div class="hero-section fade-in">
        <h1>Selamat Datang di Angkringan Nyeni</h1>
        <p>Rasakan cita rasa tradisional dengan sentuhan modern</p>
        <a href="menu.php" class="btn btn-custom px-4 py-2 mt-3">Pesan Sekarang</a>
    </div>

    <!-- Carousel -->
    <div class="container my-5 fade-up">
        <div id="carouselExampleCaptions" class="carousel slide shadow rounded-4 overflow-hidden mx-auto" style="max-width: 700px;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/Het geheim van het merguez worstje.jpeg" class="d-block w-100" style="height: 300px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="assets/10 Resep bakso bakar enak, sederhana, dan menggugah selera.jpeg" class="d-block w-100" style="height: 300px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="assets/Angkringan.jpeg" class="d-block w-100" style="height: 300px; object-fit: cover;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- Tentang Angkringan -->
    <div class="container section card-section fade-in">
        <h2 class="text-center mb-4">Tentang Angkringan Nyeni</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4 border-0 shadow-sm">
                    <p><strong>Angkringan Nyeni</strong> adalah tempat kuliner tradisional khas Jawa yang menyajikan makanan ringan dan minuman hangat dengan suasana santai dan akrab.</p>
                    <p>Kami membawa semangat tradisional ke dalam era modern tanpa menghilangkan cita rasa khasnya. Setiap hidangan disajikan dengan cinta dan kehangatan, seperti suasana kampung halaman.</p>
                    <p>Ciri khas kami: nasi kucing, sate-satean, dan wedangan hangat seperti jahe. Hadir untuk semua kalangan dan usia.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="container section fade-up">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="info-map">
                    <h5><i class="bi bi-cup-hot"></i> Info Angkringan</h5>
                    <ul class="list-unstyled mt-3">
                        <li><i class="bi bi-clock-history"></i> Jam Buka: 17.00 - 02.00</li>
                        <li><i class="bi bi-geo-alt"></i> Jl. Prabanaan no 28a</li>
                        <li><i class="bi bi-star-fill"></i> Spesial Hari Ini: Wedang Jahe + Sate Usus</li>
                    </ul>
                    <hr>
                    <h6>Cari Lokasi Kami</h6>
                    <iframe src="https://maps.google.com/maps?q=https://maps.app.goo.gl/7p5XyKnW9LCBDsCm9&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
