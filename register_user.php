<?php
include('config/koneksi.php');
session_start();
if (isset($_POST['daftar'])) {
    $name = mysqli_real_escape_string($koneksi, trim($_POST['name']));
    $email = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $password = mysqli_real_escape_string($koneksi, trim($_POST['password']));
    $confirm_password = mysqli_real_escape_string($koneksi, trim($_POST['confirm_password']));
    $address = mysqli_real_escape_string($koneksi, trim($_POST['address']));
    $post_code = mysqli_real_escape_string($koneksi, trim($_POST['post_code']));
    $pekerjaan = mysqli_real_escape_string($koneksi, trim($_POST['pekerjaan']));
    $tingkat = "orang tua";

    $passwordHash = md5($password); // Ini hash ke md5


    // logikanya
    /*
     Tidak semua data ada di tb_user, misalnya address itu ada di tb_orang tua.
     di user ini hanya masukin nama, email, pass, lalu ambil idnya
     id yang diambil itu dimasuk lagi ke tb orang tua

     */

    // Pastikan password sama confirmnya sama 
    if ($password == $confirm_password) {
        // Kalo sudah sama
        // masukan data ke tb_user dahulu
        // langsung eksekusi

        $cekEmail = $koneksi->query("SELECT * FROM tb_user WHERE email = '$email'")->num_rows;
        if ($cekEmail) {
            // ya di sini
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['confirm_password'] = $_POST['confirm_password'];
            $_SESSION['address'] = $_POST['address'];
            $_SESSION['post_code'] = $_POST['post_code'];
            $_SESSION['pekerjaan'] = $_POST['pekerjaan'];
            
            $_SESSION['error_email'] = "Email sudah dipakai!";
            // trus redirect
            header("location: register.php");
            
        } else {

            $masukinDataKeUser = $koneksi->query("INSERT INTO tb_user (name, email, password, tingkat) VALUES('$name', '$email', '$passwordHash', '$tingkat')");

            // Ambil ID yang baru aja dimasukin
            $id_user = $koneksi->insert_id;
            // cek dahulu apa sudah masuk ke user apa belum

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
        }
    } else {
        $_SESSION['name'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['confirm_password'] = $_POST['confirm_password'];
            $_SESSION['address'] = $_POST['address'];
            $_SESSION['post_code'] = $_POST['post_code'];
            $_SESSION['pekerjaan'] = $_POST['pekerjaan'];
            $_SESSION['error_password'] = "confirm password tidak sama!";
            header("location: register.php");
    }
}
