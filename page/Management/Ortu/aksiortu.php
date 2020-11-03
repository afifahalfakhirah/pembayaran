<?php
include "../../../config/koneksi.php"; 

if (isset($_POST['hapus'])) {
    $id = $_POST['id']; 
    
    $ambilDataUser = $koneksi->query("SELECT id_user FROM tb_orang_tua WHERE id = '$id'")->fetch_assoc();
    $idUser = $ambilDataUser['id_user'];
    $hapusUser = $koneksi->query("DELETE FROM tb_user WHERE id = '" . $idUser . "'");

    if ($hapusUser) {
        $hapusOrtu = $koneksi->query("DELETE FROM tb_orang_tua WHERE id_user = '" . $id . "'");

        
        if ($hapusOrtu) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}

// tambah data
if (isset($_POST['tambah'])) {

    $name = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $post_code = $_POST['post_code'];
    $pekerjaan = $_POST['pekerjaan'];
    $tingkat = "orang tua";

    $hashPass = md5($password);

    // Ini mulai cek dulu emailnya biar unik
    $cekEmail = $koneksi->query("SELECT * FROM tb_user WHERE email = '$email'")->num_rows;

    if ($cekEmail) {
        echo "Email udah dipake";
    } else {
        $masukinDataKeUser = $koneksi->query("INSERT INTO tb_user (name, email, password, tingkat) 
        VALUES('$name', '$email', '$hashPass', '$tingkat')");

        $id_user = $koneksi->insert_id;

        if ($masukinDataKeUser) {
            $masukinDataKeOrangTua = $koneksi->query("INSERT INTO tb_orang_tua (id_user, address, post_code, pekerjaan) 
        VALUES('$id_user', '$address', '$post_code', '$pekerjaan')");

            if ($masukinDataKeOrangTua) {
                echo "Berhasil nambahin ortu";
            } else {
                echo "Gagal nambahin ortu";
            }
        } else {
            echo "Gagal nambahin ortu";
        }
    }
}

// edit
if (isset($_POST['ubah'])) {

    $id = $_POST['id'];
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $post_code = $_POST['post_code'];
    $pekerjaan = $_POST['pekerjaan'];
    $tingkat = "orang tua";

    $ambilDataUser = $koneksi->query("SELECT id_user FROM tb_orang_tua WHERE id = '$id'")->fetch_assoc();
    $idUser = $ambilDataUser['id_user'];
   
    $ubahUser = $koneksi->query("UPDATE tb_user SET name='$name', email='$email',  
    tingkat='$tingkat' WHERE id = '$idUser' ");

    
    if ($ubahUser) {
        $ubahOrtu = $koneksi->query("UPDATE tb_orang_tua SET address='$address', 
        post_code='$post_code', pekerjaan='$pekerjaan' WHERE id = '$id' ");
    
        if ($ubahOrtu) {
            echo "berhasil mengubah ortu";
        } else {
            echo "gagal mengubah ortu";
        }
    } else {
        echo "gagal mengubah ortu";
    }
}


// ganti password
if (isset($_POST['gantiPassword'])) {
    $id = $_POST['id']; // ini id ortu
    $password = $_POST['password'];
    $hashPass = md5($password);
    
    $ambilDataUser = $koneksi->query("SELECT id_user FROM tb_orang_tua WHERE id = '$id'")->fetch_assoc();
    $idUser = $ambilDataUser['id_user'];
    $ubahUser = $koneksi->query("UPDATE tb_user SET password='$hashPass' WHERE id = '$idUser' ");
  

    if ($ubahUser) {
        echo "berhasil mengubah password";
    } else {
        echo "gagal mengubah password";
    }
}

