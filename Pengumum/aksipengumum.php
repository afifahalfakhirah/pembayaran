<?php
include "../config/koneksi.php";

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $hapusPengumuman = $koneksi->query("DELETE FROM tb_pengumuman WHERE id = '" . $id . "'");

    if ($hapusPengumuman) {
        echo "hapus berhasil";
    } else {
        echo "gagal menghapus";
    }
}

// tambah data
if (isset($_POST['tambah'])) {

    $tanggal = $_POST['tanggal'];
    $pengumuman = $_POST['pengumuman'];

    $masukindataPengumuman = $koneksi->query("INSERT INTO tb_pengumuman (tanggal, pengumuman) VALUES('$tanggal', '$pengumuman')");

    if ($masukindataPengumuman) {
        echo "Berhasil menambahkan pengumuman";
    } else {
        echo "Gagal menambahkan pengumuman";
    }
}

// edit
if (isset($_POST['ubah'])) {

    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $pengumuman = $_POST['pengumuman'];

    $ubahPengumuman = $koneksi->query("UPDATE tb_pengumuman SET tanggal='$tanggal', pengumuman='$pengumuman'  
     WHERE id = $id ");

    if ($ubahPengumuman) {
        echo "berhasil mengubah pengumuman";
    } else {
        echo "gagal mengubah pengumuman";
    }
}
