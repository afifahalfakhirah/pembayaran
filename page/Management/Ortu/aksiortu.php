<?php
include "../../../config/koneksi.php";

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $cekAnak = $koneksi->query("SELECT * FROM tb_anak WHERE id_user = (SELECT id_user FROM tb_orang_tua WHERE id = $id)");
    $row = $cekAnak->num_rows;

    if ($row > 0) {
        $deleteOrtu = $koneksi->query("DELETE tb_user, tb_orang_tua, tb_anak FROM tb_user
    INNER JOIN tb_orang_tua ON tb_orang_tua.id_user = tb_user.id
    INNER JOIN tb_anak ON tb_anak.id_user = tb_user.id
    WHERE tb_orang_tua.id = $id");
    } else {
        $deleteOrtu = $koneksi->query("DELETE tb_user, tb_orang_tua FROM tb_user
    INNER JOIN tb_orang_tua ON tb_orang_tua.id_user = tb_user.id
    WHERE tb_orang_tua.id = $id");
    }

    if ($deleteOrtu) {
        echo "berhasil";
    } else {
        echo "gagal";
    }
}

// tambah data
if (isset($_POST['tambah'])) {

    $name = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $post_code = $_POST['post_code'];
    $pekerjaan = $_POST['pekerjaan'];
    $tingkat = "orang tua";

    $hashPass = md5($password);

    // Ini mulai cek emailnya biar unik
    $cekEmail = $koneksi->query("SELECT * FROM tb_user WHERE email = '$email'")->num_rows;

    if ($cekEmail) {
        echo "Email udah dipake";
    } else {
        $masukinDataKeUser = $koneksi->query("INSERT INTO tb_user (name, email, password, tingkat) 
        VALUES('$name', '$email', '$hashPass', '$tingkat')");

        $id_user = $koneksi->insert_id;

        if ($masukinDataKeUser) {
            $masukinDataKeOrangTua = $koneksi->query("INSERT INTO tb_orang_tua (id_user, address, post_code, pekerjaan) 
        VALUES('$id_user', '$address', '$post_code', '$pekerjaan')");

            if ($masukinDataKeOrangTua) {
                echo "Berhasil nambahin ortu";
            } else {
                echo "Gagal nambahin ortu";
            }
        } else {
            echo "Gagal nambahin ortu";
        }
    }
}

// edit
if (isset($_POST['ubah'])) {

    $id = $_POST['id'];
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $post_code = $_POST['post_code'];
    $pekerjaan = $_POST['pekerjaan'];
    $tingkat = "orang tua";

    $ambilDataUser = $koneksi->query("SELECT id_user FROM tb_orang_tua WHERE id = '$id'")->fetch_assoc();
    $idUser = $ambilDataUser['id_user'];

    $ubahUser = $koneksi->query("UPDATE tb_user SET name='$name', email='$email',  
    tingkat='$tingkat' WHERE id = '$idUser' ");


    if ($ubahUser) {
        $ubahOrtu = $koneksi->query("UPDATE tb_orang_tua SET address='$address', 
        post_code='$post_code', pekerjaan='$pekerjaan' WHERE id = '$id' ");

        if ($ubahOrtu) {
            echo "berhasil mengubah ortu";
        } else {
            echo "gagal mengubah ortu";
        }
    } else {
        echo "gagal mengubah ortu";
    }
}


// ganti password
if (isset($_POST['gantiPassword'])) {
    $id = $_POST['id']; // id ortu
    $password = $_POST['password'];
    $hashPass = md5($password);

    $ambilDataUser = $koneksi->query("SELECT id_user FROM tb_orang_tua WHERE id = '$id'")->fetch_assoc();
    $idUser = $ambilDataUser['id_user'];
    $ubahUser = $koneksi->query("UPDATE tb_user SET password='$hashPass' WHERE id = '$idUser' ");


    if ($ubahUser) {
        echo "berhasil mengubah password";
    } else {
        echo "gagal mengubah password";
    }
}
