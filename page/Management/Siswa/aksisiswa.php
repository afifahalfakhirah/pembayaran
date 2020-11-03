<?php
include "../../../config/koneksi.php";
session_start();

// hapus siswa
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    if ($hapusUser) {
        $hapusSiswa = $koneksi->query("DELETE FROM tb_anak WHERE id = '" . $id . "'");

        if ($hapusSiswa) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}

// tambah anak
if (isset($_POST['tambah'])) {

    $id_user = $_SESSION['id'];
    $name = $_POST['nama'];
    $nis = $_POST['nis'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $nama_ortu = $_POST['nama_ortu'];
    $status = "Pending";

    if ($masukinDataKeSiswa) {
        $masukinDataKeSiswa = $koneksi->query("INSERT INTO tb_anak (id_user, name, nis, jenis_kelamin, tempat_lahir,
            tgl_lahir, nama_ortu, status) VALUES('$id_user', '$name', '$nis', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir', '$nama_ortu', '$status')");

        if ($masukinDataKeSiswa) {
            echo "Berhasil nambahin Siswa";
        } else {
            echo "Gagal nambahin Siswa";
        }
    } else {
        echo "Gagal nambahin Siswa";
    }
}


// edit
if (isset($_POST['ubah'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $nis = $_POST['nis'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $nama_ortu = $_POST['nama_ortu'];
    $status = $_POST['status'];

        $ubahSiswa = $koneksi->query("UPDATE tb_anak SET name='$name', nis='$nis',  
        jenis_kelamin='$jenis_kelamin', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir', 
        nama_ortu='$nama_ortu', status='$status' WHERE id = '" . $id . "' ");

        if ($ubahSiswa) {
            echo "berhasil mengubah siswa";
        } else {
            echo "gagal mengubah siswa";
        }
    }
    
