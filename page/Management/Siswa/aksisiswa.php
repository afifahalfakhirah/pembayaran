<?php
include "../../../config/koneksi.php";
session_start();

// hapus siswa
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $hapusSiswa = $koneksi->query("DELETE FROM tb_anak WHERE id = $id");
    if ($hapusSiswa) {
        echo "Berhasil hapus siswa";
    } else {
        echo "Gagal hapus siswa";
    }
}

// tambah anak
if (isset($_POST['tambah'])) {

    $id_user = $_POST['id_user'];
    $name = $_POST['name'];
    $nis = $_POST['nis'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];

    $masukinDataKeSiswa = $koneksi->query("INSERT INTO tb_anak (id_user, name, nis, jenis_kelamin, tempat_lahir,
            tgl_lahir) VALUES('$id_user', '$name', '$nis', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir')");

    $id_anak = $koneksi->insert_id;
    if ($masukinDataKeSiswa) {

        $bulanSekarang = strtotime(date('F jS Y h:i:s A', strtotime('first day of ' . date('F Y'))));
        $queryTahunAjaran = $koneksi->query("SELECT * FROM tb_tahun_ajaran WHERE status = 'Aktif'");
        $tahunAjaranAktif = $queryTahunAjaran->fetch_assoc();
        // Ambil stringnya
        $bulanTahunAjaran = strtotime('first day of ' . $tahunAjaranAktif['date']);
        $tahunAjaranAbis = strtotime('first day of ' . $tahunAjaranAktif['date']);
     

        $tahunAjaranAbis = strtotime('+1 year', $tahunAjaranAbis);
        $tahunAjaranAbis = strtotime('-1 month', $tahunAjaranAbis);
      

        $id_tahun_ajaran = $tahunAjaranAktif['id'];
        $total_bayaran = $tahunAjaranAktif['bayaran'];

        
        while ($bulanTahunAjaran <= $tahunAjaranAbis) {

            $tanggal = date('Y-m-d H:i:s', $bulanTahunAjaran);
            $tes = $koneksi->query("INSERT INTO tb_pembayaran (id_anak, date, id_tahun_ajaran, total, bukti_pembayaran, status) VALUES
            ('$id_anak', '$tanggal', '$id_tahun_ajaran', '$total_bayaran', NULL, 'Belum bayar')");
             $bulanTahunAjaran = strtotime('+1 month', $bulanTahunAjaran);
           
        }

        echo "Berhasil nambahin Siswa";
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

    $ubahSiswa = $koneksi->query("UPDATE tb_anak SET name='$name', nis='$nis',  
        jenis_kelamin='$jenis_kelamin', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir' WHERE id = $id ");

    if ($ubahSiswa) {
        echo "berhasil mengubah siswa";
    } else {
        echo "gagal mengubah siswa";
    }
}
