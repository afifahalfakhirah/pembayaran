<?php
session_start();
include('config/koneksi.php'); // Karna dipanggil di sini

if (!isset($_SESSION['id'])) {
    return header("location: login.php");
}

// Tahu maksud ini ga? koneksi buat nyari id nya kan misalnya tingkatnya ortu nanti di web nya oru?
// Bener, tapi sebenernya nggak
// Ini ambil semua data yang login, cara tahu yang login ya dari id tadi

// Nah ini $Koneksi itu ga tiba2 ada
// gua jelas ga? iya

// GUa pake teks aja la, ngelag
// antara internet lu atau gua yaudss

// Pengen bagus tampilannya, kan? iya
// Perkenalkan, template admin bootstrap

// eh liat ni iya
$data = $koneksi->query("SELECT * FROM tb_user WHERE id = '".$_SESSION['id']."'")->fetch_assoc();

// Itu dah ambil data yg login
// skrng bikin logika
// pertama2 ambil levelnya dulu
// eh tingkatnya
$tingkat = $data['tingkat'];

// Masukin bagian2 tadi
include('layout/header.php');
?>
<!-- Page Wrapper -->
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">PAUD MELATI <sup></sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachmometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Nav Item - Management User -->
  <li class="nav-item active">
    <a class="nav-link" href="index.php?page=managemen_user">
      <i class="fas fa-fw fa-tachmometer-alt"></i>
      <span>Management User</span></a>
  </li>

  <!-- Nav Item - Management Siswa -->
  <li class="nav-item active">
    <a class="nav-link" href="index.html">
      <i class="fas fa-fw fa-tachmometer-alt"></i>
      <span>Management Siswaa</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
<!-- misalnya mau umpetin menu Interface -->
<!-- bjir salah logika, nah bener -->
<?php if ($tingkat == 'admin') {?>
  <!-- Heading -->
  <div class="sidebar-heading">
    Interface
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Custom Components:</h6>
        <a class="collapse-item" href="buttons.html">Buttons</a>
        <a class="collapse-item" href="cards.html">Cards</a>
      </div>
    </div>
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
        $page = $_GET['page'];

        if(!empty($page)){
          switch ($page){
            case 'dashboard' :
              include "page/dashboard.php";
            break;
            case 'managemen_user':
              echo "Halaman Managemen User";
            break;
          default:
            include "page/dashboard.php";
          break;
          }
        } else {
          include "page/dashboard.php";
        }

?>
</div>
<?php
include('layout/footer.php');
?>