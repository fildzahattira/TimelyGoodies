
<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar" style="background: #28a745 !important;">

<div class="container">
  <a class="navbar-brand" href="<?php echo base_url(); ?>">TimelyGoodies<span>.</span></a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsFurni">
    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
      <!-- <li class="nav-item "> -->
        <!-- <a class="nav-link" href="index.html">Home</a> -->
      <!-- </li> -->
      <!-- <li><a class="nav-link" href="shop_copy.html">Shop</a></li>-->
    </ul>

    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
    <li>
      <form action="/barang/search" method="GET" id="search-barang-bar" class="d-flex">
        <input name="search" class="form-control mr-2" type="search" placeholder="Cari Barang..." aria-label="Search"> &nbsp;
        <button class="btn" type="submit">Search</button>
      </form>
    </li>
    <?php
      if($user_data->is_log_in()){
        $asset_img_user = base_url('assets/images/user.svg');

        $url_profile = base_url('user/profile');
        $url_change_password = base_url('user/change_password');
        $url_set_alamat = base_url('user/set_alamat');

        $saldo = $user_data->get_saldo();
        $url_jadwal = base_url("jadwal");
        $url_pengantaran = base_url("pengantaran");
        $url_add_saldo = base_url("saldo/add_saldo");

        $url_signout = base_url("index/signout");

        echo <<<HTMLCODE
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{$asset_img_user}" alt="User Icon">
            </a>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
              <!-- Dropdown content goes here -->
              <a class="dropdown-item" href="{$url_profile}">Biodata</a>
              <a class="dropdown-item" href="{$url_pengantaran}">Lihat Pengantaran</a>
              <a class="dropdown-item" href="{$url_jadwal}">Lihat Jadwal</a>
              <a class="dropdown-item" href="{$url_change_password}">Ganti Password</a>
              <a class="dropdown-item" href="{$url_set_alamat}">Update Alamat</a>
              <!-- Add more menu items as needed -->
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="saldoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Rp. {$saldo}
            </a>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
              <!-- Dropdown content goes here -->
              <a class="dropdown-item" href="{$url_add_saldo}">Tambah Saldo</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{$url_signout}">Signout</a>
          </li>
        HTMLCODE;
      }
      else if($kurir_data->is_log_in()){
        $url_signout = base_url("index/kurir_signout");
        echo <<<HTMLCODE
          <li class="nav-item">
            <a class="nav-link" href="{$url_signout}">Signout</a>
          </li>
        HTMLCODE;
      }
      else{
        $url_login = base_url("index/login");

        echo <<<HTMLCODE
          <li class="nav-item">
            <a class="nav-link" href="{$url_login}">Login</a>
          </li>
        HTMLCODE;
      }
    ?>
    </ul>
  </div>
</div>
</nav>
<!-- End Header/Navigation -->