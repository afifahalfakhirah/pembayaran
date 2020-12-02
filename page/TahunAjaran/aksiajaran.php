<?php
include "../../config/koneksi.php";
session_start();

// Get all data
if (isset($_POST['getData'])) {
    $ambilAjaran= $koneksi->query("SELECT * FROM tb_tahun_ajaran");
    $dataAjaran= []; //Array
    while ($data = $ambilAjaran->fetch_array()) {
        // Looping
        // Tiap loop, dimasukin ke array
        $dataAjaran[] = $data; // data loopnya dimasukin ke variabel ini
    }
    echo json_encode($dataAjaran); //  dikirim ke javascript di tabel
}

if (isset($_POST['getDataByID'])) {
    $id = $_POST['id'];
    $ambilAjaran= $koneksi->query("SELECT * FROM tb_tahun_ajaran WHERE id = $id");
    $dataAjaran= []; //Array
    while ($data = $ambilAjaran->fetch_array()) {
        //Looping
        //Tiap loop, dimasukin ke array
        $dataAjaran[] = $data; // data loopnya dimasukin ke variabel ini
    }
    echo json_encode($dataAjaran);
}

// tambah
if (isset($_POST['tambah'])) {

    $nama = $_POST['nama'];
    $bayar = $_POST['bayaran'];
    $status = $_POST['status'];

    $masukinDataKeAjaran = $koneksi->query("INSERT INTO tb_tahun_ajaran (nama, bayaran, status) VALUES('$nama', '$bayar', '$status')");

    if ($masukinDataKeAjaran) {
        echo "Berhasil nambahin tahun ajaran";
    } else {
        echo "Gagal nambahin tahun ajaran";
    }
}

// edit
if (isset($_POST['ubah'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $bayar = $_POST['bayaran'];
    $status = $_POST['status'];
   
    $ubahAjaran = $koneksi->query("UPDATE tb_tahun_ajaran SET nama='$nama', bayaran='$bayar',  
    status='$status' WHERE id = '" . $id . "' ");

    if ($ubahAjaran) {
        echo "berhasil mengubah Ajaran";
    } else {
        echo "gagal mengubah Ajaran";
    }
}

// hapus ajaran
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $hapusAjaran = $koneksi->query("DELETE FROM tb_tahun_ajaran WHERE id = '" . $id . "'");

    if ($hapusAjaran) {
        echo "Berhasil hapus";
    } else {
        echo "Gagal hapus";
    }
}


