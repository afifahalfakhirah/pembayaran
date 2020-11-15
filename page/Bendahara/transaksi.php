<div class="card shadow mb-4">
    <div class="card-header">
        Menunggu Verifikasi Pembayaran
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Tanggal</th>
                        <th>Tahun Ajaran</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $ambilTransaksi = $koneksi->query("SELECT tb_pembayaran.id, tb_anak.name, tb_anak.nis, tb_pembayaran.date, tb_tahun_ajaran.nama, tb_pembayaran.total, tb_pembayaran.status FROM tb_pembayaran INNER JOIN tb_anak ON tb_pembayaran.id_anak = tb_anak.id INNER JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_pembayaran.id_tahun_ajaran WHERE tb_pembayaran.status = 'Menunggu verifikasi'");

                    while ($data = $ambilTransaksi->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['name'] ?></td>
                            <td><?php echo $data['nis'] ?></td>
                            <td><?php echo $data['date'] ?></td>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['total'] ?></td>
                            <td><span class="badge badge-warning"><?= $data['status'] ?></span></td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <a href="index.php?page=transaksi&aksi=rincian&id=<?= $data['id']; ?>" class="btn btn-success">
                                        <i class="fas fa-eyes"></i> Rincian
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        Pembayaran Selesai
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Tanggal</th>
                        <th>Tahun Ajaran</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $ambilTransaksi = $koneksi->query("SELECT tb_pembayaran.id, tb_anak.name, tb_anak.nis, tb_pembayaran.date, tb_tahun_ajaran.nama, tb_pembayaran.total, tb_pembayaran.status FROM tb_pembayaran INNER JOIN tb_anak ON tb_pembayaran.id_anak = tb_anak.id INNER JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_pembayaran.id_tahun_ajaran WHERE tb_pembayaran.status = 'Sudah bayar'");

                    while ($data = $ambilTransaksi->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['name'] ?></td>
                            <td><?php echo $data['nis'] ?></td>
                            <td><?php echo $data['date'] ?></td>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['total'] ?></td>
                            <td><span class="badge badge-success"><?= $data['status'] ?></span></td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <a href="index.php?page=transaksi&aksi=rincian&id=<?= $data['id']; ?>" class="btn btn-success">
                                        <i class="fas fa-eyes"></i> Rincian
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>