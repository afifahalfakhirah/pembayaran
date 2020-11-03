<?php
include "../../config/koneksi.php";
session_start();

// Get all data
if (isset($_POST['getData'])) {
    $idYangLogin = $_SESSION['id'];
    $ambilAnak = $koneksi->query("SELECT * FROM tb_anak WHERE id_user = '$idYangLogin'");
    $dataAnak = [];
    while ($data = $ambilAnak->fetch_array()) {
        $dataAnak[] = $data;
    }
    echo json_encode($dataAnak);
}

// Get data by ID
if (isset($_POST['getDataById'])){
    $id = $_POST['id'];
    $idYangLogin = $_SESSION['id'];
    $ambilAnak = $koneksi->query("SELECT * FROM tb_anak WHERE id_user = '$idYangLogin' AND id = '$id'");
    $dataAnak = [];
    while ($data = $ambilAnak->fetch_array()) {
        $dataAnak[] = $data;
    }
    echo json_encode($dataAnak);
}

// hapus anak
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $hapusAnak = $koneksi->query("DELETE FROM tb_anak WHERE id = '" . $id . "'");

    if ($hapusAnak) {
        echo "Berhasil hapus";
    } else {
        echo "Gagal hapus";
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
    $status = "Pending";

    $masukinDataKeAnak = $koneksi->query("INSERT INTO tb_anak (id_user, name, nis, jenis_kelamin, tempat_lahir,
            tgl_lahir, status) VALUES('$id_user', '$name', '$nis', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir', '$status')");

    if ($masukinDataKeAnak) {
        echo "Berhasil nambahin anak";
    } else {
        echo "Gagal nambahin anak";
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

    $ubahAnak = $koneksi->query("UPDATE tb_anak SET name='$name', nis='$nis',  
    jenis_kelamin='$jenis_kelamin', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir'
     WHERE id = '" . $id . "' ");

    if ($ubahAnak) {
        echo "berhasil mengubah anak";
    } else {
        echo "gagal mengubah anak";
    }
}
