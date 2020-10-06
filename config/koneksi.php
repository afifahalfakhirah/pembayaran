<?php

// class Koneksi {
//   var $host = 'localhost';
//   var $user = 'root';
//   var $pass = '';
//   var $db_name = 'pembayaran'; // nama database

//   public function __construct() {
//     $this->konek = mysqli_connect($this->host, $this->user, $this->pass, $this->db_name
//         );
    
//         if($this->konek) {
//             echo "koneksi sukses";
//         } else {
//             echo "koneksi gagal";
//         }      
//      }
// }



$host = 'localhost';
$user = 'root';
$pass = '';
$data = 'pembayaran';

$koneksi = new mysqli("$host", "$user", "$pass", "$data"); // nah dari sini ada $koneksi wkwkwkwk
if (mysqli_connect_error())
  {
  echo "Waduh error gan :( </br> " . mysqli_connect_error();
  }
  error_reporting(E_ALL & ~E_NOTICE);
?>