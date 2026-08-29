  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-heading">Utama</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard.index') ? '' : 'collapsed' }}" href="{{ route('dashboard.index') }}">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard & Kontrol</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">Master Data</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard.schools.*') ? '' : 'collapsed' }}" href="{{ route('dashboard.schools.index') }}">
          <i class="bi bi-mortarboard-fill"></i>
          <span>Data Sekolah</span>
        </a>
      </li><!-- End Schools Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard.users.*') ? '' : 'collapsed' }}" href="{{ route('dashboard.users.index') }}">
          <i class="bi bi-people-fill"></i>
          <span>Data Pengguna</span>
        </a>
      </li><!-- End Users Nav -->

      <li class="nav-heading">Layar Tampilan</li>

      <li class="nav-item">
        <a class="nav-link collapsed text-success" href="{{ route('beranda') }}" target="_blank">
          <i class="bi bi-display text-success"></i>
          <span>Layar Panggung (Beranda) <i class="bi bi-box-arrow-up-right ms-auto"></i></span>
        </a>
      </li>

      <li class="nav-heading">Akun</li>

      <li class="nav-item">
        <a class="nav-link collapsed text-danger" href="javascript:void(0)" onclick="confirmLogout()">
          <i class="bi bi-box-arrow-right text-danger"></i>
          <span>Keluar (Logout)</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->