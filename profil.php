<?php

$id = $_SESSION['id'];
$sql = $koneksi->query("SELECT * FROM tb_user INNER JOIN tb_orang_tua ON tb_orang_tua.id_user = tb_user.id WHERE tb_user.id = $id ");
$tampil = $sql->fetch_assoc();

?>
<div class="card card-outline-danger">
    <div class="card-body">
        <h4 class="card-title">Profil</h4>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="text-info col-sm-2 control-label">Nama Pengguna</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?php echo $tampil['name']; ?>" />
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
                    <input type="text" name="post_code" class="form-control" value="<?php echo $tampil['post_code']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="text-success col-sm-2 control-label">Pekerjaan</label>
                <div class="col-sm-10">
                    <input type="text" name="pekerjaan" class="form-control" value="<?php echo $tampil['pekerjaan']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="text-primary col-sm-2 control-label">Foto profil</label>
                <div class="col-sm-10">
                    <img src="upload/profile/<?php echo $tampil['foto']; ?>" width="100" height="100">
                </div>
            </div>

            <div class="form-group">
                <label class="text-primary col-sm-2 control-label">Ganti foto</label>
                <div class="col-sm-10">
                    <input type="file" name="foto" />
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