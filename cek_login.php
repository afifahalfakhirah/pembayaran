<?php
session_start();
include('config/koneksi.php');

if(isset($_POST['masuk'])){
    $email = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $password = mysqli_real_escape_string($koneksi, trim($_POST['password']));

    //query mysqlnya
    $cekUser = $koneksi->query("SELECT * FROM tb_user WHERE (email = '".$email."')");

    // cek ada data berdasarkan email ada apa tidak
    $data = $cekUser->num_rows;

    if ($data > 0){
        // Kalo ada emailnya, baru cek passwordnya
        // Hash passwordnya pake md5 lalu dicocokan
        $row = $cekUser->fetch_assoc();

        if (md5($password) == $row['password']){
           // hash pake md5
           
            // dimasukin ke session
            $_SESSION['id'] = $row['id'];
            $_SESSION['tingkat'] = $row['tingkat'];
            $_SESSION['status'] = "loggedIn";
            header("location: index.php");
        }else{
            echo "password beda";
        }
    }else {
        echo "tidak ada";
    }
}
?>