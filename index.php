<?php
session_start();
include('config/koneksi.php'); // Karna dipanggil di sini

if (!isset($_SESSION['id'])) {
  return header("location: login.php");
}
$page = $_GET['page'];
$aksi = $_GET['aksi'];
$namaSitus = "Paud Melati";
$title = "";
//ambil data login
$data = $koneksi->query("SELECT * FROM tb_user WHERE id = '" . $_SESSION['id'] . "'")->fetch_assoc();

// Itu sudah ambil data yg login
// skrng bikin logika

// sekarang tingkatannya
$tingkat = $data['tingkat'];
if (!empty($page)) {
  if ($tingkat == 'admin') {
    switch ($page) {
      case 'Dashboard':
        $title = "Dashboard - " . $namaSitus;
        break;
      case 'managemen-user':
        $title = "Managemen User - " . $namaSitus;
        break;
      case 'managemen-orangtua':
        $title = "Management Orang Tua - " . $namaSitus;
        break;
      case 'managemen-siswa':
        $title = "Management Siswa - " . $namaSitus;
        break;
      default:
        $title = "Dashboard - " . $namaSitus;
        break;
    }
  } else if ($tingkat == 'admin' || $tingkat == 'bendahara') {
    // switch case buat halaman bendahara
    switch ($page) {
      case 'managemen-siswa':
        $title = "Manajemen Siswa - " . $namaSitus;
        break;
      case 'tahun-ajaran':
        $title = "Tahun Ajaran - " . $namaSitus;
        break;
      case 'transaksi':
        if ($aksi == 'rincian') {
          $title = "Rincian Transaksi - " . $namaSitus;
        } else {
          $title = "Transaksi - " . $namaSitus;
        }
        break;
      default:
        include "page/dashboard.php";
        break;
    }
  } else {
    // nah ini baru si ortu
    switch ($page) {
      case 'Dashboard':
        $title = "Dashboard - " . $namaSitus;
        break;
      case 'anak-saia':
        $title = "Anak Saya - " . $namaSitus;
        break;
      default:
        $title = "Dashboard - " . $namaSitus;
        break;
    }
  }
} else {
  $title = "Dashboard - " . $namaSitus;
}

// Ini ambil semua data yang login, cara tahu yang login itu dari id tadi

// ini $Koneksi itu ga tiba2 ada
//template admin bootstrap

// Masukin bagian2 tadi
include('layout/header.php');
?>
<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-child"></i>
      </div>
      <div class="sidebar-brand-text mx-4">PAUD MELATI <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="index.php">
        <i class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>


    <?php
    if ($tingkat == 'orang tua') {
    ?>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=anak-saia">
          <i class="fas fa-fw fa-tachmometer-alt"></i>
          <span>Berita</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=anak-saia">
          <i class="fas fa-tachometer-alt"></i>
          <span>Data Anak Saya</span></a>
      </li>
    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- misalnya mau umpetin menu Interface -->
    <?php if ($tingkat == 'admin' || $tingkat == 'bendahara') { ?>
      <!-- Heading -->
      <div class="sidebar-heading">
        Administrator
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Manajemen</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php if ($tingkat == 'admin') {
            ?>
              <a class="collapse-item" href="index.php?page=managemen-user">Users</a>
              <a class="collapse-item" href="index.php?page=managemen-orangtua">Orang Tua</a>
            <?php } ?>
            <a class="collapse-item" href="index.php?page=managemen-siswa">Siswa</a>
          </div>
        </div>
      </li>
      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=tahun-ajaran">
          <i class="fas fa-graduation-cap"></i>
          <span>Tahun Ajaran</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index.php?page=transaksi">
          <i class="fas fa-money-check-alt"></i>
          <span>Transaksi</span></a>
      </li>
    <?php } ?>

  </ul>
  <!-- End of Sidebar -->

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

          <!-- Nav Item - Search Dropdown (Visible Only XS) -->
          <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
              <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li>
          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hi <?php echo $data['name']; ?></span>
              <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="#">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
              </a>
              <a class="dropdown-item" href="#">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Settings
              </a>
              <a class="dropdown-item" href="#">
                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                Activity Log
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
              </a>
            </div>
          </li>

        </ul>

      </nav>
      <!-- End of Topbar -->

      <!-- Begin Page Content -->
      <div class="container">
        <?php
        if (!empty($page)) {
          if ($tingkat == 'admin') {
            switch ($page) {
              case 'dashboard':
                $title = "dashboard";
                include "page/dashboard.php";
                break;
              case 'managemen-user':
                include "page/Management/User/ManagementUser.php";
                break;
              case 'managemen-orangtua':
                if ($aksi == 'lihat') {
                  include "page/Management/Ortu/Aksi/lihat.php";
                } else {
                  include "page/Management/Ortu/management_orangtua.php";
                }
                break;
              case 'managemen-siswa':
                include "page/Management/Siswa/management_siswa.php";
                break;
              case 'tahun-ajaran':
                include "page/TahunAjaran/tahunajaran.php";
                break;
              case 'transaksi':
                if ($aksi == 'rincian') {
                  include "page/Bendahara/rincian.php";
                } else {
                  include "page/Bendahara/transaksi.php";
                }
                break;
              default:
                include "page/dashboard.php";
                break;
            }
          } else if ($tingkat == 'admin' || $tingkat == 'bendahara') {
            // switch case buat halaman bendahara
            switch ($page) {
              case 'managemen-siswa':
                include "page/Management/Siswa/management_siswa.php";
                break;
              case 'tahun-ajaran':
                include "page/TahunAjaran/tahunajaran.php";
                break;
              case 'transaksi':
                if ($aksi == 'rincian') {
                  include "page/Bendahara/rincian.php";
                } else {
                  include "page/Bendahara/transaksi.php";
                }
                break;
              default:
                include "page/dashboard.php";
                break;
            }
          } else {
            // nah ini baru si ortu
            switch ($page) {
              case 'dashboard':
                break;
              case 'anak-saia':
                if ($aksi == 'lihat') {
                  include "page/OrangTua/Aksi/lihat.php";
                } else if ($aksi == 'rincian') {
                  include "page/OrangTua/Aksi/rincian.php";
                } else {
                  include "page/OrangTua/anak.php";
                }
                break;
              default:
                include "page/dashboard.php";
                break;
            }
          }
        } else {
          include "page/dashboard.php";
        }
        ?>
      </div>
      <?php
      include('layout/footer.php');
      ?>