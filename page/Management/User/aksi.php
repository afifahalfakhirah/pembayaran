<?php
include "../../../config/koneksi.php";
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $hapusUser = $koneksi->query("DELETE FROM tb_user WHERE id = '".$id."'");

    if ($hapusUser) {
        $hapusOrtu = $koneksi->query("DELETE FROM tb_orang_tua WHERE id_user = '".$id ."'");

        // 1 Maksudya true
        // 0 Maksudnya false 
        if ($hapusOrtu){
            echo 1;
        }else{
            echo 0;
        }
    } else {
        echo 0;
    }
}

if (isset($_POST['tambah'])){
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tingkat = $_POST['tingkat'];

    $hashPass = md5($password);

    $tambahUser = $koneksi->query("INSERT INTO tb_user (name, email, password, tingkat)
    VALUES ('$name', '$email', '$hashPass', '$tingkat')");

    if ($tambahUser){
        echo 1;
    }else{
        echo 0;
    }
}

if (isset($_POST['ubah'])){
    $id = $_POST['id'];
    $name = $_POST['nama'];
    $email = $_POST['email'];
    // $password = $_POST['password'];
    $tingkat = $_POST['tingkat'];

    $hashPass = md5($password);

    $ubahUser = $koneksi->query("UPDATE tb_user SET name='$name', email='$email',  
    tingkat='$tingkat' WHERE id = '$id' ");

    if ($ubahUser){
        echo 1;
    }else{
        echo 0;
    }
}

if (isset($_POST['gantiPaasword'])){


    $hashPass = md5($password);

    $ubahUser = $koneksi->query("UPDATE tb_user SET password='password' WHERE id = '$id' ");

    if ($gantiPassword){
        echo 1;
    }else{
        echo 0;
    }
}
?>