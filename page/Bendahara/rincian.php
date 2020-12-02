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
                        <input type="text" name="nama_pengirim" class="form-control" value="<?= $pembayaran['nama_pengirim']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Nama Bank</label>
                        <select name="bank_pengirim" id="" class="form-control">
                            <option value="BNI" <?= $pembayaran['bank_pengirim'] == 'BNI' ? 'selected' : '' ?>>BNI</option>
                            <option value="BCA" <?= $pembayaran['bank_pengirim'] == 'BCA' ? 'selected' : '' ?>>BCA</option>
                            <option value="BJB" <?= $pembayaran['bank_pengirim'] == 'BJB' ? 'selected' : '' ?>>BJB</option>
                            <option value="BRI" <?= $pembayaran['bank_pengirim'] == 'BRI' ? 'selected' : '' ?>>BRI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input type="number" name="no_rek_pengirim" class="form-control" value="<?= $pembayaran['no_rek_pengirim']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Rekening Tujuan</label>
                        <select name="id_rekening_tujuan" class="form-control">
                            <?php
                            $sqlRekening = $koneksi->query("SELECT * FROM tb_rekening");
                            while ($rekening = $sqlRekening->fetch_assoc()) { ?>
                                <option value="<?= $rekening['id'] ?>" <?= $pembayaran['rekening_tujuan'] == $rekening['id'] ? 'selected' : '' ?>><?= $rekening['nama_bank'] ?> a/n <?= $rekening['nama_pemilik_rek'] ?> - <?= $rekening['no_rek'] ?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg">
                    <img id="preview" src="<?= "upload/" . $pembayaran['struk_transfer'] ?>" alt="your image" width="250" height="250" />

                    <div class="form-group pt-2">
                        <label>Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="Belum bayar" <?= $dataAnak['status'] == 'Belum bayar' ? 'selected' : ''  ?>>Belum bayar</option>
                            <option value="Menunggu verifikasi" <?= $dataAnak['status'] == 'Menunggu verifikasi' ? 'selected' : ''  ?>>Menunggu verifikasi</option>
                            <option value="Sudah bayar" <?= $dataAnak['status'] == 'Sudah bayar' ? 'selected' : ''  ?>>Sudah bayar</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
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

    $status = $_POST['status'];

    $simpanKeDatabase = $koneksi->query("UPDATE tb_pembayaran SET status = '$status' WHERE id = $id");
    if ($simpanKeDatabase) {
?>
        <script>
            alert("Berhasil memperbarui status");
            window.location.href = "index.php?page=transaksi";
        </script>
<?php
    } else {
        echo "Gagal menyimpan";
    }
}
?>