<?php
// kontak.php - Halaman Kontak
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kontak - Angkringan Nyeni</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      padding-top: 80px;
      background-color: #fdfaf6;
      font-family: 'Segoe UI', sans-serif;
    }

    .section {
      max-width: 750px;
      margin: auto;
      padding: 20px;
    }

    .hubungi-card {
      background: linear-gradient(to right, #fffdfa, #fff4e6);
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      padding: 35px 30px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hubungi-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .hubungi-icon {
      font-size: 50px;
      color: #ff5722;
      margin-bottom: 10px;
    }

    .hubungi-title {
      font-size: 28px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 25px;
    }

    .hubungi-card ul li {
      font-size: 16px;
      margin-bottom: 12px;
    }

    .icon {
      margin-right: 10px;
      font-size: 18px;
    }

    .social-row {
      display: flex;
      justify-content: space-between;
      margin-top: 35px;
      padding: 0 40px;
    }

    .social-box {
      text-align: center;
      flex: 1;
    }

    .social-box a {
      text-decoration: none;
      color: #000;
    }

    .social-icon {
      font-size: 42px;
      margin-bottom: 6px;
    }

    .social-label {
      font-size: 14px;
      color: #555;
      margin-bottom: 5px;
    }

    .review-box {
      text-align: center;
      margin-top: 40px;
    }

    .review-box a {
      display: inline-block;
      background-color: #e9c46a;
      color: #000;
      font-weight: 500;
      text-decoration: none;
      padding: 12px 22px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .review-box a:hover {
      background-color: #f4d35e;
      transform: translateY(-2px);
    }

    .review-icon {
      font-size: 20px;
      margin-right: 8px;
      vertical-align: middle;
    }

    @media (max-width: 576px) {
      .social-row {
        flex-direction: column;
        gap: 25px;
        padding: 0 20px;
      }

      .review-box a {
        width: 100%;
      }
    }
  </style>
</head>

<body>
<?php include "navbar.php"; ?>

<div class="container section">
  <div class="hubungi-card text-center">
    <div class="hubungi-icon"><i class="bi bi-chat-dots-fill"></i></div>
    <div class="hubungi-title">Hubungi Kami</div>
    <ul class="list-unstyled d-inline-block text-start text-center mx-auto">
      <li><i class="bi bi-geo-alt icon"></i><strong>Alamat:</strong> Jl. Prabaan no 28 a</li>
      <li><i class="bi bi-whatsapp icon"></i><strong>WhatsApp:</strong> +62 812-3456-7890</li>
      <li><i class="bi bi-instagram icon"></i><strong>Instagram:</strong> angkringan.nyeni_</li>
      <li><i class="bi bi-clock icon"></i><strong>Jam Operasional:</strong> Setiap hari, 17.00 - 02.00</li>
    </ul>
  </div>

  <!-- WA, IG, TikTok -->
  <div class="social-row mt-4">
    <div class="social-box">
      <div class="social-label">Chatan yukk dan tanyakan semuanya</div>
      <a href="https://wa.me/6285854284248" target="_blank">
        <i class="bi bi-whatsapp social-icon text-success"></i>
      </a>
    </div>
    <div class="social-box">
      <div class="social-label">Yukk ikuti kita untuk tau berita terbaru dari kita</div>
      <a href="https://www.instagram.com/angkringan.nyeni_?igsh=MWZpd2p4MXM1ZG9zaA==" target="_blank">
        <i class="bi bi-instagram social-icon text-danger"></i>
      </a>
    </div>
    <div class="social-box">
      <div class="social-label">Lihat konten seru kita di TikTok</div>
      <a href="https://www.tiktok.com/@angkringan.nyeni?_t=ZS-8xp5NE0miQM&_r=1" target="_blank">
        <i class="bi bi-tiktok social-icon" style="color: #000;"></i>
      </a>
    </div>
  </div>

  <!-- Ulasan Google -->
  <div class="review-box">
    <p class="mt-4 mb-2">Berikan masukan dan saranmu untuk kami melalui Google Maps 💬</p>
    <a href="https://maps.app.goo.gl/HkFYtRSCVVKaRdvf7" target="_blank">
      <i class="bi bi-chat-left-heart-fill review-icon"></i> Tulis Ulasan di Google Maps
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
