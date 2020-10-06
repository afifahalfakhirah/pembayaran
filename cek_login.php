<?php
session_start();
include('config/koneksi.php');

if(isset($_POST['masuk'])){
    $email = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $password = mysqli_real_escape_string($koneksi, trim($_POST['password']));

    // Ini query mysqlnya
    $cekUser = $koneksi->query("SELECT * FROM tb_user WHERE (email = '".$email."')");

    // Ini cuma cek ada data berdasarkan email apa nggak
    $data = $cekUser->num_rows;

    if ($data > 0){
        // Kalo ada emailnya, baru cek passwordnya
        // Hash passwordnya pake md5 tadi trus cocokin
        $row = $cekUser->fetch_assoc();

        if (md5($password) == $row['password']){
            // Sebenernya ngehash pake md5 gini doang kurang aman sih, tapi biarin aja :'v

            // Yaudah sekarang tinggal dimasukin ke session
            $_SESSION['id'] = $row['id'];
            $_SESSION['tingkat'] = $row['tingkat'];
            $_SESSION['status'] = "loggedIn";
            header("location: index.php");
        }else{
            echo "password beda";
        }

        // echo "ada usernya";
    }else {
        echo "ga ada";
    }
}
?>