<?php
include "../../../config/koneksi.php";
session_start();

// hapus siswa
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $hapusAnak = $koneksi->query("DELETE tb_anak, tb_pembayaran FROM tb_anak
    INNER JOIN tb_pembayaran ON tb_pembayaran.id_anak = tb_anak.id
    WHERE tb_anak.id = $id");

    if ($hapusAnak) {

        echo "Berhasil hapus";
    } else {
        echo "Gagal hapus";
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
    $status = $_POST['status'];

    $masukinDataKeSiswa = $koneksi->query("INSERT INTO tb_anak (id_user, name, nis, jenis_kelamin, tempat_lahir,
            tgl_lahir, status) VALUES('$id_user', '$name', '$nis', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir', '$status')");

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
            $tes = $koneksi->query("INSERT INTO tb_pembayaran (id_anak, date, id_tahun_ajaran, total, status) VALUES
            ('$id_anak', '$tanggal', '$id_tahun_ajaran', '$total_bayaran', 'Belum bayar')");
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
    $status = $_POST['status'];

    $ubahSiswa = $koneksi->query("UPDATE tb_anak SET name='$name', nis='$nis',  
        jenis_kelamin='$jenis_kelamin', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir', status='$status' WHERE id = $id ");

    if ($ubahSiswa) {
        echo "berhasil mengubah siswa";
    } else {
        echo "gagal mengubah siswa";
    }
}

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
if (isset($_POST['getDataById'])) {
    $id = $_POST['id'];
    $idYangLogin = $_SESSION['id'];
    $ambilAnak = $koneksi->query("SELECT * FROM tb_anak WHERE id_user = '$idYangLogin' AND id = '$id'");
    $dataAnak = [];
    while ($data = $ambilAnak->fetch_array()) {
        $dataAnak[] = $data;
    }
    echo json_encode($dataAnak);
}
