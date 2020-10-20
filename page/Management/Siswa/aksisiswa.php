<?php
include "../../../config/koneksi.php"; // salah

if (isset($_POST['hapus'])) {
    $id = $_POST['id']; // ini id ortu
    // yang lu hapus id di tb_user
    // seharusnya pake id user
    $ambilDataUser = $koneksi->query("SELECT id_user FROM tb_orang_tua WHERE id = '$id'")->fetch_assoc();
    $idUser = $ambilDataUser['id_user'];
    $hapusUser = $koneksi->query("DELETE FROM tb_user WHERE id = '" . $idUser . "'");
    // terdiam wkwkwk saia lgi lihat, seharusnya udah bisa
    if ($hapusUser) {
        $hapusOrtu = $koneksi->query("DELETE FROM tb_orang_tua WHERE id_user = '" . $id . "'");

        // 1 Maksudya true
        // 0 Maksudnya false 
        if ($hapusOrtu) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}

// tambah data
if (isset($_POST['tambah'])) {

    $name = $_POST['nama'];
    $nis = $_POST['nis'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];

        $id_user = $koneksi->insert_id;

        if ($masukinDataKeUser) {
            $masukinDataKeOrangTua = $koneksi->query("INSERT INTO tb_orang_tua (id_user, address, post_code, pekerjaan) 
        VALUES('$id_user', '$address', '$post_code', '$pekerjaan')");

            if ($masukinDataKeOrangTua) {
                echo "Berhasil nambahin siswa";
            } else {
                echo "Gagal nambahin siswa";
            }
        } else {
            echo "Gagal nambahin siswa";
        }
    }



// edit
if (isset($_POST['ubah'])) {

    $id = $_POST['id'];
    $name = $_POST['nama'];
    $nis = $_POST['nis'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $ambilDataUser = $koneksi->query("SELECT id_user FROM tb_orang_tua WHERE id = '$id'")->fetch_assoc();
    $idUser = $ambilDataUser['id_user'];
   
    $ubahUser = $koneksi->query("UPDATE tb_user SET name='$name', email='$email',  
    tingkat='$tingkat' WHERE id = '$idUser' ");

    
    if ($ubahUser) {
        $ubahOrtu = $koneksi->query("UPDATE tb_orang_tua SET address='$address', 
        post_code='$post_code', pekerjaan='$pekerjaan' WHERE id = '$id' ");
    
        if ($ubahOrtu) {
            echo "berhasil mengubah siswa";
        } else {
            echo "gagal mengubah siswa";
        }
    } else {
        echo "gagal mengubah siswa";
    }
}
