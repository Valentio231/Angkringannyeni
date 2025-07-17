<?php
// tentangkami.php - Halaman Tentang Kami
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami - Angkringan Nyeni</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

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

    body {
      padding-top: 80px;
      background-color: #fdfaf6;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }

    .background-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('background.jpg') center center / cover no-repeat;
      opacity: 0.15;
      z-index: -1;
    }

    .section-box {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
      max-width: 1000px;
      margin: 40px auto;
    }

    h2.section-title {
      text-align: center;
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      font-size: 2rem;
      color: #7b3f00;
      margin-bottom: 1.5rem;
      position: relative;
    }

    h2.section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background-color: #c97c5d;
      border-radius: 4px;
    }

    p {
      font-size: 1.05rem;
      line-height: 1.8;
      margin-bottom: 1.2rem;
    }

    .highlight {
      color: #c97c5d;
      font-weight: 600;
    }

    .owner-photo {
      max-width: 250px;
      width: 100%;
      border-radius: 50%;
      object-fit: cover;
      margin: auto;
      display: block;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .owner-card {
      background-color: #fff8ef;
      border: 1px solid #e5d1b8;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      margin-top: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .owner-name {
      font-weight: bold;
      font-size: 1.1rem;
      color: #7b3f00;
    }

    .owner-role {
      font-size: 0.95rem;
      color: #555;
    }

    .owner-text h3 {
      font-family: 'Playfair Display', serif;
      font-weight: bold;
      color: #7b3f00;
      margin-bottom: 15px;
    }

    @media (max-width: 576px) {
      .section-box {
        padding: 30px 20px;
      }

      h2.section-title {
        font-size: 1.6rem;
      }

      p {
        font-size: 1rem;
      }

      .owner-photo {
        margin-bottom: 20px;
      }
    }
  </style>
</head>

<body>
  <?php include "navbar.php"; ?>
  <div class="background-overlay"></div>

  <!-- Section: Tentang Kami -->
  <div class="container section-box fade-in">
    <h2 class="section-title">Tentang Kami</h2>
    <p><strong>Angkringan Nyeni</strong> adalah tempat makan dengan konsep tradisional khas Jawa yang menyajikan makanan sederhana penuh rasa dan kenangan. Berdiri sejak <strong>Oktober 2023</strong>, kami hadir dengan semangat menjaga warisan budaya kuliner Indonesia melalui setiap sajian yang kami hidangkan.</p>
    <p>Nama "<em>Nyeni</em>" berasal dari kata <em>"Seni"</em>, yang mencerminkan keunikan, kreativitas, dan cinta yang kami tuangkan dalam setiap sajian. Kami percaya bahwa makanan bukan sekadar konsumsi, melainkan <span class="highlight">pengalaman yang menghangatkan hati</span> dan mempererat hubungan antar manusia.</p>
    <p>Dengan pelayanan yang <span class="highlight">ramah</span> dan <span class="highlight">harga yang terjangkau</span>, kami ingin menjadi <strong>tempat singgah favorit</strong> bagi siapa saja yang ingin menikmati suasana akrab dan menu angkringan autentik.</p>
  </div>

  <!-- Section: Pemilik dan Alasan -->
  <div class="container section-box fade-up">
    <div class="row align-items-center">
      <!-- Foto & Identitas Pemilik -->
      <div class="col-md-4 text-center mb-4 mb-md-0">
        <img src="Kejayaan.jpg" alt="Pemilik Angkringan Nyeni" class="owner-photo">
        <div class="owner-card">
          <div class="owner-name">Ilham Zhafran</div>
          <div class="owner-role">Pemilik Angkringan Nyeni</div>
        </div>
      </div>

      <!-- Alasan Pemilik -->
      <div class="col-md-8 owner-text">
        <h3>Kenapa Saya Mendirikan Angkringan Nyeni</h3>
        <p>
          Sejak kecil, saya tumbuh di lingkungan yang penuh dengan kehangatan angkringan—tempat orang berkumpul, bercerita, dan menikmati makanan sederhana namun kaya rasa.
        </p>
        <p>
          Saya ingin menghadirkan kembali nuansa itu di tengah masyarakat modern. <span class="highlight">Angkringan Nyeni</span> adalah wujud dari impian saya untuk menyatukan <strong>budaya lokal</strong> dengan <strong>sentuhan kekinian</strong>, agar semua orang—dari yang muda hingga tua—bisa merasakan kehangatan dan makna di balik setiap sajian.
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
