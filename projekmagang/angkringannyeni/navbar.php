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
            background-color: #fff;
            border-bottom: 2px solid #dab785;
        }

        /* Container navbar pakai flex */
        .navbar .container {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            flex-wrap: nowrap;
        }

        /* Brand dengan font khusus */
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #7b3f00 !important;
            font-size: 1.75rem;
            letter-spacing: 1px;
            white-space: nowrap;
            /* Penting supaya tulisan tidak pecah ke baris bawah */
        }

        /* Supaya brand bisa mengecil tapi tidak memotong teks */
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

        /* Tombol toggle hamburger selalu di kanan */
        .navbar-toggler {
            margin-left: auto;
            flex-shrink: 0;
            border: none;
        }

        /* Link navbar */
        .nav-link {
            color: #000 !important;
            margin-right: 15px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #c97c5d !important;
        }

        .dropdown-menu {
            background-color: #fff;
            border: 1px solid #dab785;
        }

        .dropdown-item:hover {
            background-color: #ffc300;
            color: #000;
        }

        .btn-custom {
            background-color: #c97c5d;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #7b3f00;
        }

        .sidebar-menu {
            background-color: #fff4e6;
            border: 2px solid #c97c5d;
            border-radius: 16px;
            padding: 30px;
            max-width: 600px;
            margin: 40px auto 20px auto;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .sidebar-menu h4 {
            font-family: 'Playfair Display', serif;
            color: #7b3f00;
            margin-bottom: 20px;
        }

        .sidebar-menu p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .sidebar {
            background-color: #f8f5f0;
            border: 1px solid #dab785;
            border-radius: 12px;
            padding: 20px;
            max-width: 300px;
            margin: 0 auto;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .sidebar h5 {
            font-family: 'Playfair Display', serif;
            color: #7b3f00;
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .sidebar li i {
            margin-right: 8px;
            color: #c97c5d;
        }

        /* Perkecil offcanvas untuk layar kecil */
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
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">ANGKRINGAN NYENI</a>
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
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'beranda') ? 'active link-light' : 'link-dark'; ?>"
                                aria-current="page" href="index.php?x=beranda">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'menu') ? 'active link-light' : 'link-dark'; ?>"
                                href="menu.php?x=menu">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'galeri') ? 'active link-light' : 'link-dark'; ?>"
                                href="galeri.php?x=galeri">Galeri</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Lainnya
                            </a>
                            <ul class="dropdown-menu <?php echo (isset($_GET['x']) && $_GET['x'] == 'lainnya') ? 'active link-light' : 'link-dark'; ?>">
                                <li><a class="dropdown-item" href="#">Tentang Kami</a></li>
                                <li><a class="dropdown-item" href="#">Kontak</a></li>
                            </ul>
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
