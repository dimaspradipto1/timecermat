  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard.index') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo UIS" style="max-height: 38px;">
        <span class="d-none d-lg-block ms-2 fw-bold text-dark fs-5">UIS Challenge</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="ms-3 d-none d-md-block">
      <a href="{{ route('beranda') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 shadow-sm">
        <i class="bi bi-display me-1"></i> Buka Layar Panggung (Beranda) <i class="bi bi-box-arrow-up-right ms-1"></i>
      </a>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 36px; height: 36px; font-size: 15px;">
              {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <span class="d-none d-md-block dropdown-toggle ps-2 fw-semibold text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
          </a><!-- End Profile Image Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header text-center">
              <h6 class="fw-bold mb-0">{{ Auth::user()->name ?? 'Administrator' }}</h6>
              <span class="badge bg-success-subtle text-success border border-success-subtle">{{ strtoupper(Auth::user()->role ?? 'ADMIN') }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('beranda') }}" target="_blank">
                <i class="bi bi-display text-primary"></i>
                <span>Layar Panggung</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <form action="{{ route('logout') }}" method="POST" id="logout-header-form">
                @csrf
                <button type="button" class="dropdown-item d-flex align-items-center text-danger" onclick="confirmLogout()">
                  <i class="bi bi-box-arrow-right text-danger"></i>
                  <span>Keluar / Logout</span>
                </button>
              </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <script>
    function confirmLogout() {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Konfirmasi Logout',
          text: 'Apakah Anda yakin ingin keluar dari sistem dashboard?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#059669',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Keluar',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById('logout-header-form').submit();
          }
        });
      } else {
        if (confirm('Apakah Anda yakin ingin keluar?')) {
          document.getElementById('logout-header-form').submit();
        }
      }
    }
  </script>