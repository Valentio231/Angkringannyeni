<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Angkringan Nyeni</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet" />

    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
            padding-top: 80px; /* ruang untuk navbar fixed */
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('background.jpg') center center no-repeat;
            background-size: cover;
            opacity: 0.2;
            z-index: -1;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
            background-color: #fff;
            border-bottom: 2px solid #dab785;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar .container {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            flex-wrap: nowrap;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #7b3f00 !important;
            font-size: 1.75rem;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 400px) {
            .navbar-brand {
                font-size: 1.1rem;
            }
        }

        .navbar-toggler {
            margin-left: auto;
            flex-shrink: 0;
            border: none;
        }

        .nav-link {
            color: #000 !important;
            margin-right: 15px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #c97c5d !important;
        }

        .btn-custom {
            background-color: #c97c5d;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #7b3f00;
        }

        .offcanvas.offcanvas-md {
            width: 50% !important;
            max-width: 300px;
        }
    </style>
</head>

<body>
    <!-- Background Gambar Redup -->
    <div class="background-overlay"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">ANGKRINGAN NYENI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end offcanvas-md" tabindex="-1" id="navbarNavDropdown"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : '' ?>" href="menu.php">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= basename($_SERVER['PHP_SELF']) == 'tentangkami.php' ? 'active' : '' ?>" href="tentangkami.php">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?= basename($_SERVER['PHP_SELF']) == 'kontak.php' ? 'active' : '' ?>" href="kontak.php">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIqZfh3Rtyu7m6Wj9X9lWb7JmQOSjw7IqL+Z7MkYwhhwjaUp3jE"
        crossorigin="anonymous"></script>
</body>

</html>
