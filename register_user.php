<?php
include('config/koneksi.php');

if(isset($_POST['daftar'])){
    $name = mysqli_real_escape_string($koneksi, trim($_POST['name']));
    $email = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $password = mysqli_real_escape_string($koneksi, trim($_POST['password']));
    $confirm_password = mysqli_real_escape_string($koneksi, trim($_POST['confirm_password']));
    $address = mysqli_real_escape_string($koneksi, trim($_POST['address']));
    $post_code = mysqli_real_escape_string($koneksi, trim($_POST['post_code']));
    $pekerjaan = mysqli_real_escape_string($koneksi, trim($_POST['pekerjaan']));
    $tingkat = "orang tua";

    $passwordHash = md5($password); // Ini hash ke md5


    // Jadi begini logikanya
    /*
     Kan ga semua data ada di tb_user, misalnya address itu ada di tb orang tua
     nah di user ini cuma masukin nama email pass trus ambil idnya
     id yang diambil itu dimasuk lagi ke tb orang tua
     jelas gga gua? iya
     */

     // Pastiin password sama confirmnya sama dulu
    if ($password == $confirm_password) {
        // Kalo sama
        // Nah ini masukin data ke tb_user dulu
    // yaudah tinggal eksekusi
    $masukinDataKeUser = $koneksi->query("INSERT INTO tb_user (name, email, password, tingkat) VALUES('$name', '$email', '$passwordHash', '$tingkat')");

    // Ambil ID yang baru aja dimasukin
    $id_user = $koneksi->insert_id; // keknya error ini, dah bener. coba lagi masukin data yg beda

    // ooh gini aja
    // cek dulu apa udah masuk ke user apa beloman

    if ($masukinDataKeUser) {
        $masukinDataKeOrangTua = $koneksi->query("INSERT INTO tb_orang_tua (id_user, address, post_code, pekerjaan) 
        VALUES('$id_user', '$address', '$post_code', '$pekerjaan')");
    }
   
    // Jika sudah bisa masukin ke dataorangtua, maka pindahin ke login
    if ($masukinDataKeOrangTua) {
        header("location: login.php");
    } else {
        echo "error";
    }
    }else {
        echo "confirm passwordnya ga sama";
    }

    
} 