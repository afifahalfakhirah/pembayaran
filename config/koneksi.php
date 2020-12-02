<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$data = 'pembayaran';

$koneksi = new mysqli("$host", "$user", "$pass", "$data"); // dari sini ada $koneksi 
if (mysqli_connect_error())
  {
  echo "Error </br> " . mysqli_connect_error();
  }
  error_reporting(E_ALL & ~E_NOTICE);
?>