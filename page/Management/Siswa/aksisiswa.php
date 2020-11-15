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

// apa niii lanjuin yg tadi mlmm, udh dpt logikanya? blom wkwkwwkwk
// yaudah jangan ke sana dulu lantasss
// skrng ke ortu itu, buat klik bayar sama ngirim struknya bagaimanaa


/*
    Bikin tabel lagi
    tabel rekening atau tabel bank gitu
    isinya bank yang tersedia di sekolahnya buat transfer uangnya
    truss

    bikin ini di bawah ini save nya manadah id dulu jd prmary key apalagi dah

    -   id
    -   id_pembayaran
    -   id_rekening
    -   nama_pengirim
    -   no_rekening_pengirim
    -   bank_pengirim
    -   struk_transfer => ini jadi varchar isinya nama file gambarnya yg sruk diisi apa? udah

    Trus buat tabel lagi bukti pembayaran
    isinya nama pengirim, dsb... sama struknya
    nah, id dari tabel tsb dimasukin ke tb_pembayaran bagian bukti pembayaran
    jd foreign key ini namenya isinya misal bri gitu?

    Nama bank, nama pemilik rekeningnya, no rekeningnya udh gitu? id nya mana?
    masa ga ada primary key hmmmmmm berari id_pemabyaran? id aja gitu? no reknya varchar udh trus


*/

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
