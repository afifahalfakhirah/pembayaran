<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>PAUD MELATI - Register</title>

  <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">
  <style>
    .card {
      background: transparent !important;
    }
  </style>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-1">Create an Account!</h1>
                <h1 class="h5 text-gray-100 mb-4">Menggunakan Data Orang Tua</h1>
              </div>
              <!-- Masukkan ke action -->
              <form class="user" action="register_user.php" method="post">
                <div class="form-group">
                  <input type="text" name="name" class="form-control form-control-user" id="exampleFirstName" placeholder="Nama" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>">
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-user <?php echo isset($_SESSION['error_email']) ? 'is-invalid' : '' ?>" id="email" placeholder="Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>">

                  <?php
                  // nah di sini dicek
                  if (isset($_SESSION['error_email'])) {
                  ?>
                    <div class="invalid-feedback d-block text-light">
                      <?php echo $_SESSION['error_email']; ?>
                    </div>
                  <?php
                  }
                  ?>
                </div>
                <div class="form-group">
                  <input type="text" name="address" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Alamat" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>">
                </div>
                <div class="form-group">
                  <input type="text" name="post_code" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Post Code" value="<?php echo isset($_SESSION['post_code']) ? $_SESSION['post_code'] : '' ?>">
                </div>
                <div class="form-group">
                  <input type="text" name="pekerjaan" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Pekerjaan" value="<?php echo isset($_SESSION['pekerjaan']) ? $_SESSION['pekerjaan'] : '' ?>">
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" value="<?php echo isset($_SESSION['password']) ? $_SESSION['password'] : '' ?>">
                    </div>
                  </div>
                  <div class="col-lg">
                    <div class="form-group">
                      <input type="password" name="confirm_password" class="form-control form-control-user <?php echo isset($_SESSION['error_password']) ? 'is-invalid' : '' ?>" id="exampleInputPassword" placeholder="Confirm Password" value="<?php echo isset($_SESSION['confirm_password']) ? $_SESSION['confirm_password'] : '' ?>">
                      <?php
                      // nah di sini dicek
                      if (isset($_SESSION['error_password'])) {
                      ?>
                        <div class="invalid-feedback d-block text-light">
                          <?php echo $_SESSION['error_password']; ?>
                        </div>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
                <button type="submit" name="daftar" class="btn btn-primary btn-user btn-block">
                  Daftar
                </button>
                <hr>
              </form>
            </div>
          </div>
        </div>

      </div>

      <!-- Bootstrap core JavaScript-->
      <script src="assets/vendor/jquery/jquery.min.js"></script>
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- Core plugin JavaScript-->
      <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

      <!-- Custom scripts for all pages-->
      <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>
<?php
session_destroy();
?>