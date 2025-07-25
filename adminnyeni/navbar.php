<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<?php var_dump(session_status()); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="z-index: 1000;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Angkringan Nyeni</a>

    <!-- Toggle Mobile -->
    <button class="navbar-toggler position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminOffcanvas"
      aria-controls="adminOffcanvas" id="notifToggle">
      <span class="navbar-toggler-icon"></span>
      <span id="notifDot" class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle d-none">
        <span class="visually-hidden">Notifikasi</span>
      </span>
    </button>

    <!-- Menu Desktop -->
    <div class="collapse navbar-collapse justify-content-end d-none d-lg-flex">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'berandaadmin.php' ? 'active fw-bold text-warning' : 'text-white' ?>" href="berandaadmin.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'menuadmin.php' ? 'active fw-bold text-warning' : 'text-white' ?>" href="menuadmin.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pesanan.php' ? 'active fw-bold text-warning' : 'text-white' ?>" href="pesanan.php">Pesanan</a>
        </li>
        <?php if (isset($_SESSION['admin_login'])): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Akun
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="akunadmin.php"><i class="bi bi-person-gear me-2"></i>Pengaturan Akun</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Offcanvas Mobile -->
    <div class="offcanvas offcanvas-end text-bg-dark d-lg-none" tabindex="-1" id="adminOffcanvas" aria-labelledby="adminOffcanvasLabel" style="max-width: 280px;">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="adminOffcanvasLabel">Menu Admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link text-white" href="berandaadmin.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="menuadmin.php">Menu</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="pesanan.php">Pesanan</a></li>

          <?php if (isset($_SESSION['admin_login'])): ?>
          <!-- Akun dropdown di mobile -->
          <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuAkun" role="button" aria-expanded="false" aria-controls="submenuAkun">
              <span><i class="bi bi-person-circle me-1"></i> Akun</span>
              <i class="bi bi-caret-down-fill"></i>
            </a>
            <div class="collapse ps-3" id="submenuAkun">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link text-white" href="akunadmin.php"><i class="bi bi-person-gear me-1"></i> Pengaturan Akun</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                </li>
              </ul>
            </div>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Script Notifikasi Titik Merah -->
<script>
setInterval(function () {
  fetch('cek_pesanan_baru.php')
    .then(res => res.text())
    .then(res => {
      const notifDot = document.getElementById('notifDot');
      if (res.trim() === 'ada') {
        notifDot.classList.remove('d-none');
      } else {
        notifDot.classList.add('d-none');
      }
    });
}, 5000);
</script>
