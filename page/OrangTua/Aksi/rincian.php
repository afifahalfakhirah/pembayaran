<h5>Rincian</h5>
<div class="card mt-3 mb-3">
    <div class="card-body">
        <table class="table table-striped">
            <?php
            $id = $_GET['id'];

            $sql = $koneksi->query("SELECT tb_anak.name, tb_anak.nis, tb_tahun_ajaran.nama, tb_pembayaran.date, tb_pembayaran.total, tb_pembayaran.status FROM tb_pembayaran
            INNER JOIN tb_anak ON tb_anak.id = tb_pembayaran.id_anak 
            INNER JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_pembayaran.id_tahun_ajaran
            WHERE tb_pembayaran.id = $id");
            $dataAnak = $sql->fetch_assoc();
            ?>

            <tr>
                <th width="30%"><strong>Nama Anak</strong></th>
                <td><?php echo $dataAnak['name']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>NIS</strong></th>
                <td><?php echo $dataAnak['nis']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Tahun Ajaran</strong></th>
                <td><?php echo $dataAnak['nama']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Bulan</strong></th>
                <td><?php echo $dataAnak['date']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Total</strong></th>
                <td><?php echo $dataAnak['total']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Status</strong></th>
                <td><?php echo $dataAnak['status']; ?></td>
            </tr>
        </table>
    </div>
</div>

<?php

$sql2 = $koneksi->query("SELECT * FROM tb_bukti_pembayaran WHERE id_pembayaran = $id");
$pembayaran = $sql2->fetch_assoc();

?>

<h5>Pembayaran</h5>
<div class="card mt-3">
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg">
                    <div class="form-group">
                        <label>Nama Pengirim</label>
                        <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="nama_pengirim" class="form-control" value="<?= $pembayaran['nama_pengirim']; ?>" <?= ($dataAnak['status'] == 'Belum bayar' || $dataAnak['status'] == 'Menunggu verifikasi') ? '' : 'disabled' ?>>
                    </div>
                    <div class="form-group">
                        <label>Nama Bank</label>
                        <select name="bank_pengirim" id="" class="form-control" <?= ($dataAnak['status'] == 'Belum bayar' || $dataAnak['status'] == 'Menunggu verifikasi') ? '' : 'disabled' ?>>
                            <option value="BNI" <?= $pembayaran['bank_pengirim'] == 'BNI' ? 'selected' : '' ?>>BNI</option>
                            <option value="BCA" <?= $pembayaran['bank_pengirim'] == 'BCA' ? 'selected' : '' ?>>BCA</option>
                            <option value="BJB" <?= $pembayaran['bank_pengirim'] == 'BJB' ? 'selected' : '' ?>>BJB</option>
                            <option value="BRI" <?= $pembayaran['bank_pengirim'] == 'BRI' ? 'selected' : '' ?>>BRI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input type="number" name="no_rek_pengirim" class="form-control" value="<?= $pembayaran['no_rek_pengirim']; ?>" <?= ($dataAnak['status'] == 'Belum bayar' || $dataAnak['status'] == 'Menunggu verifikasi') ? '' : 'disabled' ?>>
                    </div>
                    <div class="form-group">
                        <label>Rekening Tujuan</label>
                        <select name="id_rekening_tujuan" class="form-control" <?= ($dataAnak['status'] == 'Belum bayar' || $dataAnak['status'] == 'Menunggu verifikasi') ? '' : 'disabled' ?>>
                            <?php
                            $sqlRekening = $koneksi->query("SELECT * FROM tb_rekening");
                            while ($rekening = $sqlRekening->fetch_assoc()) { ?>
                                <option value="<?= $rekening['id'] ?>" <?= $pembayaran['rekening_tujuan'] == $rekening['id'] ? 'selected' : '' ?>><?= $rekening['nama_bank'] ?> a/n <?= $rekening['nama_pemilik_rek'] ?> - <?= $rekening['no_rek'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="form-group">
                        <label>Upload Struk</label>
                        <input type="file" name="struk" id="struk" class="form-control-file" <?= ($dataAnak['status'] == 'Belum bayar' || $dataAnak['status'] == 'Menunggu verifikasi') ? '' : 'disabled' ?>>
                    </div>
                    <img id="preview" src="<?= "upload/" . $pembayaran['struk_transfer'] ?>" alt="Struk" width="300" height="300" onerror="this.style.display='none'" />
                </div>
            </div>
            <?php if ($dataAnak['status'] == 'Belum bayar' || $dataAnak['status'] == 'Menunggu verifikasi') { ?>
                
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#preview').css("display","block")
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#struk").change(function() {
        readURL(this);
    });
</script>

<?php
if (isset($_POST['simpan'])) {

    $nama_pengirim = $_POST['nama_pengirim'];
    $nama_bank = $_POST['bank_pengirim'];
    $nomor_rekening = $_POST['no_rek_pengirim'];
    $rekening_tujuan = $_POST['id_rekening_tujuan'];

    // ambil data file
    $namaFile = $_FILES['struk']['name'];
    $namaSementara = $_FILES['struk']['tmp_name'];

    // tentukan lokasi file akan dipindahkan
    $dirUpload = "upload/";

    // pindahkan file
    $terupload = move_uploaded_file($namaSementara, $dirUpload . $namaFile);

    if ($terupload) {

        $simpanKeDatabase = $koneksi->query("INSERT INTO tb_bukti_pembayaran (id_pembayaran, id_rekening_tujuan, nama_pengirim, 
        no_rek_pengirim, bank_pengirim, struk_transfer) VALUES ('$id', '$rekening_tujuan', '$nama_pengirim', '$nomor_rekening', 
        '$nama_bank', '$namaFile')");

        if ($simpanKeDatabase) {

            $updateStatusPembayaran = $koneksi->query("UPDATE tb_pembayaran SET status = 'Menunggu verifikasi' WHERE id = $id");

            if ($updateStatusPembayaran) {
                ?>
                    <script>
                        alert("Berhasil menyimpan pembayaran");
                        window.location.href = "index.php?page=anak-saia&aksi=rincian&id=<?= $id ?>"
                    </script>
                <?php
            } else {
                echo "Gagal menyimpan";
            }
        } else {
            echo "Gagal menyimpan";
        }
    } else {
        echo "Upload Gagal!";
    }
}
?>

<script>
    function preventNumberInput(e) {
      var keyCode = (e.keyCode ? e.keyCode : e.which);
      if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107) {
        e.preventDefault();
      }
    }

    $(document).ready(function() {
      $('#text_field').keypress(function(e) {
        preventNumberInput(e);
      });
    })
  </script>