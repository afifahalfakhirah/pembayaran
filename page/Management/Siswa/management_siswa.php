<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Nama OrangTua</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $ambilSiswa = $koneksi->query("SELECT tb_user.name AS nama_ortu, tb_anak.name AS nama_anak, status,
                    tb_anak.nis, tb_anak.jenis_kelamin, tb_anak.tempat_lahir, tb_anak.tgl_lahir, tb_orang_tua.id AS id_ortu FROM tb_anak 
                    INNER JOIN tb_user ON tb_anak.id_user = tb_user.id
                    INNER JOIN tb_orang_tua ON tb_orang_tua.id_user = tb_anak.id_user");
                    while ($data = $ambilSiswa->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nama_anak'] ?></td>
                            <td><?php echo $data['nis'] ?></td>
                            <td><?php echo $data['jenis_kelamin'] ?></td>
                            <td><?php echo $data['tempat_lahir'] ?></td>
                            <td><?php echo $data['tgl_lahir'] ?></td>
                            <td><?php echo $data['nama_ortu'] ?></td>
                            <td><?php echo $data['status'] ?></td>
                            <td class="text-right">
                                <a href="index.php?page=managemen-siswa&aksi=lihat&id=<?= $data['id_ortu'] ?>" class="btn btn-info">
                                    <i class="fas fa-edit"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

