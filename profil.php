<?php

$id = $_SESSION['id'];
$sql = $koneksi->query("SELECT * FROM tb_user INNER JOIN tb_orang_tua ON tb_orang_tua.id_user = tb_user.id WHERE tb_user.id = $id ");
$tampil = $sql->fetch_assoc();

$admin = $koneksi->query("SELECT * FROM tb_user WHERE id = $id")->fetch_array();

if ($admin['tingkat'] == 'admin' || $admin['tingkat'] == 'bendahara') {
?>
    <div class="card card-outline-danger">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <h4 class="card-title">Profil</h4>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Pratinjau Foto</label>
                            <img id="img-preview" src="http://localhost/pembayaran-paud-melati/upload/profile/<?= $admin['foto']; ?>" class="rounded img-responsive" width="250" height="250" id="img-preview">
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <label class="float-right">
                                <a href="#" data-toggle="tooltip" title="Klik untuk menghapus foto yang sudah dipilih" style="display:none" id="img-reset">
                                    <code class="text-right">Hapus Foto</code>
                                </a>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-file-image"></i>
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" id="img-file">
                                    <label class="custom-file-label" id="img-name">Pilih Foto</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg">
                        <div class="form-group">
                            <label class="text-info">Nama Pengguna</label>
                            <div class="col-sm-10">
                                <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="name" class="form-control" value="<?php echo $admin['name']; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-primary">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" value="<?php echo $admin['email']; ?>" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <div class="buttons">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#gantiPassword"> Ganti Password </button>
                    <button type="submit" name="simpan_admin" class="btn btn-primary"> Simpan </button>
                </div>
            </div>
        </form>
    </div>


    <div class="modal fade" id="gantiPassword" tabindex="-1" role="dialog" aria-labelledby="gantiPasswordLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gantiPasswordLabel">Ganti Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="ganti_password">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php

    if (isset($_POST['ganti_password'])) {
        $passwordLama = $_POST['password_lama'];
        $passwordBaru = $_POST['password_baru'];

        $passfix        = md5($passwordBaru);

        if (md5($passwordLama) == $admin['password']) {
            $koneksi->query("UPDATE tb_user SET password='$passfix' WHERE id='$id'");
            echo "<script type='text/javascript'>alert('Berhasil ganti password!'); window.location.href='index.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('Password lama ga cocok!');</script>";
        }
    }

    if (isset($_POST['simpan_admin'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Untuk foto
        $foto     = $_FILES['foto']['name'];
        $file     = $_FILES['foto']['tmp_name'];
        $size     = $_FILES['foto']['size'];
        $tipe     = $_FILES['foto']['type'];
        $folder   = "upload/profile/";
        $saring   = array('gif', 'png', 'jpg');
        $ext      = pathinfo($foto, PATHINFO_EXTENSION);

        if (strlen($foto)) {
            // Cek format foto.
            $ext = pathinfo($foto, PATHINFO_EXTENSION);
            if (in_array($ext, $saring)) {
                // Cek ukurannya.
                // 5242880 = 5MB.
                if ($size < 5242880) {
                    $img     = sha1($foto);
                    // Jika Mencoba upload & jika berhasil di upload
                    if (move_uploaded_file($file, $folder . $img)) {
                        // UPDATE tb_pengguna sesuai ID nya.
                        $koneksi->query("UPDATE tb_user SET name='$name', 
                        email='$email', foto='$img' WHERE id='$id'");
    ?>
                        <script type="text/javascript">
                            alert("Data berhasil disimpan!");
                            window.location.href = "index.php?page=profil";
                        </script>
                    <?php
                    } else {
                        // Jika gagal di upload.
                    ?>
                        <script type="text/javascript">
                            alert("Error!");
                        </script>
                    <?php
                    }
                } else {
                    // Jika gambar melebihi ukuran yang ditentukan.
                    ?>
                    <script type="text/javascript">
                        alert("Ukuran gambar terlalu besar! (Max : 5MB)");
                    </script>
                <?php
                }
            } else {
                // Jika format gambar tidak sesuai dengan $saring
                ?>
                <script type="text/javascript">
                    alert("Format gambar tidak dizinkan!");
                </script>
            <?php
            }
        } else {
            // Jika tidak upload foto, diganti dengan tanpa_foto.jpg
            $koneksi->query("UPDATE tb_user SET name='$name', 
            email='$email' WHERE id='$id'");
            ?>
            <script type="text/javascript">
                alert("Data berhasil disimpan!");
                window.location.href = "index.php";
            </script>
    <?php
        }
    }

    ?>


<?php } else { ?>
    <div class="card card-outline-danger">
        <div class="card-body">
            <h4 class="card-title">Profil</h4>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="text-info col-sm-2 control-label">Nama Pengguna</label>
                    <div class="col-sm-10">
                        <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="name" class="form-control" value="<?php echo $tampil['name']; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-primary col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" value="<?php echo $tampil['email']; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-success col-sm-2 control-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" name="address" class="form-control" value="<?php echo $tampil['address']; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-success col-sm-2 control-label">Kode Pos</label>
                    <div class="col-sm-10">
                        <input type="number" name="post_code" class="form-control" value="<?php echo $tampil['post_code']; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-success col-sm-2 control-label">Pekerjaan</label>
                    <div class="col-sm-10">
                        <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="pekerjaan" class="form-control" value="<?php echo $tampil['pekerjaan']; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-primary col-sm-2 control-label">Foto profil</label>
                    <div class="col-sm-10">
                        <img  id="img-preview" src="upload/profile/<?php echo $tampil['foto']; ?>" width="100" height="100">
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-primary col-sm-2 control-label">Ganti foto</label>
                    <div class="col-sm-10">
                        <input type="file" name="foto" id="img-file" />
                    </div>
                </div>

                <input style="float: right;" type="submit" name="simpan" value="Simpan" class="btn btn-info btn-rounded m-b-10 m-l-5">

            </form>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gantiPasswordModal">
                Ganti Password
            </button>
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="gantiPasswordModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="tambahForm" method="POST">
                        <div class="modal-body">
                            <!-- Kasih hidden input biar tau lagi nambahin -->
                            <input type="hidden" name="tambah" value="true">
                            <div class="form-group">
                                <label>Ganti Password</label>
                                <input type="password" name="gantipassword" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="konfirmasipassword" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="ganti_password" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php

        // Jika tombol simpan di klik.
        if (isset($_POST['simpan'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $kodepos = $_POST['post_code'];
            $pekerjaan = $_POST['pekerjaan'];

            // ambil data file
            $namaFile = $_FILES['foto']['name'];
            $namaSementara = $_FILES['foto']['tmp_name'];

            // tentukan lokasi file akan dipindahkan
            $dirUpload = "upload/profile/";

            // pindahkan file
            $terupload = move_uploaded_file($namaSementara, $dirUpload . $namaFile);

            // Cek mau ganti foto apa tidak
            if (empty($namaFile)) {
                // Kalo tidak ganti foto
                $simpanKeDatabase = $koneksi->query("UPDATE tb_user AS u INNER JOIN tb_orang_tua AS o ON o.id_user = u.id SET u.name = '$name', u.email ='$email', o.address = '$address', o.post_code = '$kodepos', o.pekerjaan ='$pekerjaan' WHERE u.id = $id");
                if ($simpanKeDatabase) {
        ?>
                    <script>
                        alert("Berhasil menyimpan profile")
                        window.location.href = "index.php?page=profil"
                    </script>
                <?php
                    echo "Berhasil menyimpan";
                } else {
                ?>
                    <script>
                        alert("Gagal menyimpan profile")
                        window.location.href = "index.php?page=profil"
                    </script>
                    <?php
                }
            } else {
                if ($terupload) {


                    if ($_SESSION['tingkat'] == 'admin' || $_SESSION['tingkat'] == 'bendahara') {

                        $simpanKeDatabase = $koneksi->query("UPDATE tb_user SET foto ='$namaFile' WHERE id= $id");
                    } else {
                        $simpanKeDatabase = $koneksi->query("UPDATE tb_user AS u INNER JOIN tb_orang_tua AS o ON o.id_user = u.id SET u.name = '$name', u.foto = '$namaFile', o.address = '$address', o.post_code = '$kodepos', o.pekerjaan ='$pekerjaan' WHERE u.id = $id");
                    }


                    if ($simpanKeDatabase) {
                    ?>
                        <script>
                            alert("Berhasil menyimpan profile")
                            window.location.href = "index.php?page=profil"
                        </script>
                    <?php
                        echo "Berhasil menyimpan";
                    } else {
                    ?>
                        <script>
                            alert("Gagal menyimpan profile")
                            window.location.href = "index.php?page=profil"
                        </script>
                    <?php
                    }
                } else {
                    ?>
                    <script>
                        alert("Upload gagal")
                        window.location.href = "index.php?page=profil"
                    </script>
        <?php
                }
            }
        }

        if (isset($_POST['ganti_password'])) {

            $gantipassword = $_POST['gantipassword'];
            $konfirmasipassword = $_POST['konfirmasipassword'];

            $hashPassword = md5($gantipassword);
            // hash md5

            if ($gantipassword == $konfirmasipassword) {
                // update query
                $simpanKeDatabase = $koneksi->query("UPDATE tb_user SET password='$hashPassword' WHERE id = $id");
                if ($simpanKeDatabase) {
                    echo "berhasil ganti password";
                } else {
                    echo "gagal ganti password";
                }
            } else {
                echo "password error";
            }
        }

        ?>
    <?php } ?>

    <script>
        function preventNumberInput(e) {
            var keyCode = (e.keyCode ? e.keyCode : e.which);
            if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107) {
                e.preventDefault();
            }
        }

        $(document).ready(function() {
            $('#text_field').keypress(function(e) {
                preventNumberInput(e);
            });
        })

        var originalFileSrc = "";

$('#img-file').change(function() {
    var input = this;
    var url = $(this).val();
    originalFileSrc = $('#img-preview').attr('src');
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img-name').html(input.files[0].name);
            $('#img-preview').attr('src', e.target.result);
            $('#img-reset').css("display", "block");
        }
       reader.readAsDataURL(input.files[0]);
    }
    else
    {
      $('#img-name').html("Pilih foto");
      $('#img-preview').attr('src', originalFileSrc);
      $('#img-reset').css("display", "none");
    }
})

$('#img-reset').click(function() {
  $('#img-file').val('');
  $('#img-name').html("Pilih foto");
  $('#img-preview').attr('src', originalFileSrc);
  $('#img-reset').css("display", "none");
})
    </script>