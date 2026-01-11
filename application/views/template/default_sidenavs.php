<style>
/* ===============================
   SIDEBAR PUTIH PROFESIONAL
================================ */
.left_col {
    background: #ffffff !important;
    box-shadow: 2px 0 18px rgba(0,0,0,0.06);
}

.profile {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.site_title span {
    color: #111827;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* MENU */
.nav.side-menu > li > a {
    color: #374151 !important;
    font-size: 14px;
    font-weight: 500;
    padding: 12px 20px;
    transition: all 0.25s ease;
}

/* ICON */
.nav.side-menu > li > a i {
    color: #6b7280;
    margin-right: 10px;
    font-size: 15px;
}

/* HOVER */
.nav.side-menu > li > a:hover {
    background: #f9fafb !important;
    color: #111827 !important;
    border-left: 4px solid #2563eb;
}

/* ACTIVE */
.nav.side-menu > li.active > a {
    background: #f3f4f6 !important;
    color: #111827 !important;
    border-left: 4px solid #2563eb;
}

/* SUB MENU */
.nav.child_menu {
    background: #ffffff;
}

.nav.child_menu li a {
    color: #4b5563 !important;
    font-size: 13px;
    padding: 9px 45px;
}

.nav.child_menu li a:hover {
    color: #2563eb !important;
    background: #f9fafb;
}

/* CHEVRON */
.fa-chevron-down {
    color: #9ca3af;
}

/* LOGOUT */
.nav.side-menu > li:last-child a {
    color: #b91c1c !important;
}

.nav.side-menu > li:last-child a:hover {
    background: #fef2f2 !important;
}

/* SCROLLBAR */
.scroll-view::-webkit-scrollbar {
    width: 6px;
}
.scroll-view::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
}
</style>

<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">

    <!-- TITLE -->
    <div class="profile" style="margin-top:20px;">
      <a href="<?= base_url(); ?>" class="site_title">
        <span style="font-size:20px;">SIM Apotek Bunda</span>
      </a>
    </div>

    <div class="clearfix"></div>

    <!-- SIDEBAR MENU -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">

          <!-- BERANDA -->
          <li>
            <a href="<?= base_url(); ?>">
              <i class="fa fa-home"></i> Beranda
            </a>
          </li>

          <!-- OBAT -->
          <li>
            <a><i class="fa fa-medkit"></i> Obat <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">

              <?php if($this->session->userdata('level') == 'pemilik'): ?>
                <li><a href="<?= base_url('example/form_med'); ?>">Tambah Obat</a></li>
              <?php endif; ?>

              <li><a href="<?= base_url('example/table_med'); ?>">Lihat Obat</a></li>
              <li><a href="<?= base_url('example/table_exp'); ?>">Obat Kedaluwarsa</a></li>
              <li><a href="<?= base_url('example/table_stock'); ?>">Obat Habis</a></li>

            </ul>
          </li>

          <!-- KATEGORI & SATUAN (PEMILIK SAJA) -->
		  <li>
            <a><i class="fa fa-medkit"></i> Kategori dan Satuan <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">

              <?php if($this->session->userdata('level') == 'pemilik'): ?>
                <li><a href="<?= base_url('example/form_cat'); ?>">Tambah Kategori</a></li>
              <?php endif; ?>
              <li><a href="<?= base_url('example/table_cat'); ?>">Lihat Kategori</a></li>

              <?php if($this->session->userdata('level') == 'pemilik'): ?>
                <li><a href="<?= base_url('example/form_unit'); ?>">Tambah Satuan</a></li>
              <?php endif; ?>
              <li><a href="<?= base_url('example/table_unit'); ?>">Lihat Satuan</a></li>

            </ul>
          </li>

          <!-- PEMASOK -->
          <li>
            <a><i class="fa fa-users"></i> Pemasok <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">

              <?php if($this->session->userdata('level') == 'pemilik'): ?>
                <li><a href="<?= base_url('example/form_sup'); ?>">Tambah Pemasok</a></li>
              <?php endif; ?>

              <li><a href="<?= base_url('example/table_sup'); ?>">Lihat Pemasok</a></li>

            </ul>
          </li>

          <!-- PENJUALAN -->
          <li>
            <a><i class="fa fa-edit"></i> Penjualan <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="<?= base_url('example/form_invoice'); ?>">Tambah Penjualan</a></li>
              <li><a href="<?= base_url('example/table_invoice'); ?>">Lihat Penjualan</a></li>
            </ul>
          </li>

          <!-- PEMBELIAN -->
          <li>
            <a><i class="fa fa-shopping-cart"></i> Pembelian <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">

              <?php if($this->session->userdata('level') == 'pemilik'): ?>
                <li><a href="<?= base_url('example/form_purchase'); ?>">Tambah Pembelian</a></li>
              <?php endif; ?>

              <li><a href="<?= base_url('example/table_purchase'); ?>">Lihat Pembelian</a></li>

            </ul>
          </li>

          

          <!-- LOGOUT -->
          <li>
            <a href="<?= base_url('example/logout'); ?>">
              <i class="fa fa-arrow-left"></i> Logout
            </a>
          </li>

        </ul>
      </div>
    </div>

  </div>
</div>
