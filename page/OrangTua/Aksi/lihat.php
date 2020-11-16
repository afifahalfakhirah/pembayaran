<?php
$id = $_GET['id'];

$sql = $koneksi->query("SELECT * FROM tb_anak WHERE id = $id");
$dataAnak = $sql->fetch_assoc();
?>

<h5>Data Anak </h5>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th width="30%"><strong>Nama</strong></th>
                <td><?php echo $dataAnak['name']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>NIS</strong></th>
                <td><?php echo $dataAnak['nis']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Jenis Kelamin</strong></th>
                <td><?php echo $dataAnak['jenis_kelamin']; ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
$queryPembayaran = $koneksi->query("SELECT p.id, p.date, t.nama, t.bayaran, p.status FROM tb_pembayaran AS p JOIN tb_tahun_ajaran AS t ON p.id_tahun_ajaran = t.id WHERE id_anak = $id");

?>
<h5 class="pt-3">SPP</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Tahun Ajaran</th>
            <th>Total Tagihan</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($data = $queryPembayaran->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['date'] ?></td>
                <td><?= $data['nama'] ?></td>
                <td>Rp. <?= $data['bayaran']; ?></td>
                <td><span class="badge badge-<?php if ($data['status'] == 'Belum bayar') echo 'danger'?><?php if ($data['status'] == 'Menunggu verifikasi') echo 'warning'?><?php if ($data['status'] == 'Sudah bayar') echo 'success'?>"><?= $data['status'] ?></span></td>
                <td><a href="index.php?page=anak-saia&aksi=rincian&id=<?= $data['id']; ?>" class="btn btn-success">Rincian</a></td>
            </tr>
        <?php
        } ?>
    </tbody>
</table>