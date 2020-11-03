<div class="card shadow mb-4">
    <div class="card-body">
        <div class="card-header py-3 mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                Tambah Data
            </button>
        </div>
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
                    $ambilSiswa = $koneksi->query("SELECT tb_user.name AS nama_ortu, tb_anak.name AS nama_anak,
                    tb_anak.nis, tb_anak.jenis_kelamin, tb_anak.tempat_lahir, tb_anak.tgl_lahir, tb_anak.status FROM tb_anak 
                    INNER JOIN tb_user ON tb_anak.id_user = tb_user.id");
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
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ubahModal-<?php echo $data['id']; ?>">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button type="button" class="btn btn-danger" id="hapus" data-nama="<?php echo $data['name']; ?>" data-id="<?php echo $data['id']; ?>" onclick="hapusUser(this.getAttribute('data-nama'), this.getAttribute('data-id'))">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="tambahModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambahForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="tambah" value="true">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama_anak" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="number" name="nis" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <!-- ternary -->
                            <option value="L" <?php echo $data['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>L</option>
                            <option value="P" <?php echo $data['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>P</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama OrangTua</label>
                        <input type="text" name="nama_ortu" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <!-- ternary ni -->
                            <option value="Pending" <?php echo $data['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Accepted" <?php echo $data['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$sql = $koneksi->query("SELECT tb_user.name AS nama_ortu, tb_anak.name AS nama_anak,
tb_anak.nis, tb_anak.jenis_kelamin, tb_anak.tempat_lahir, tb_anak.tgl_lahir, tb_anak.status FROM tb_anak 
INNER JOIN tb_user ON tb_anak.id_user = tb_user.id");
while ($data = $sql->fetch_assoc()) {
?>
    <div class="modal" tabindex="-1" role="dialog" id="ubahModal-<?php echo $data['id']; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ubahForm-<?php echo $data['id']; ?>" method="POST" class="ubahForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <input type="hidden" name="ubah" value="true">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama_anak" class="form-control" value="<?php echo $data['nama_anak']; ?>">
                        </div>
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="number" name="nis" class="form-control" value="<?php echo $data['nis']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <!-- ternary -->
                                <option value="L" <?php echo $data['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>L</option>
                                <option value="P" <?php echo $data['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>P</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="<?php echo $data['tempat_lahir']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" value="<?php echo $data['tgl_lahir']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama OrangTua</label>
                        <input type="text" name="nama_ortu" class="form-control" value="<?php echo $data['nama_ortu']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <!-- ternary ni -->
                            <option value="Pending" <?php echo $data['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Accepted" <?php echo $data['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
    </div>
<?php
}
?>


<script>
    // tambah data
    $('#tambahForm').submit(function(e) {
        e.preventDefault();
        let form = $(this)
        // baru ajaxnya
        $.ajax({
            type: "POST",
            url: "page/Management/Siswa/aksisiswa.php",
            data: form.serialize(),
            success(hasil) {
                location.reload();
                alert(hasil);
            }
        })
    });


    $('form[id^="ubahForm"]').each(function() {
        $(this).submit(function(e) {
            e.preventDefault();
            let form = $(this)

            $.ajax({
                type: "POST",
                url: "page/Management/Siswa/aksisiswa.php",
                data: form.serialize(),
                success(hasil) {
                    location.reload();
                    alert(hasil);
                }
            })
        });
    });


    // hapus
    async function hapusUser(nama, id) {
        let hapus = confirm(`Hapus ${nama}?`);
        if (hapus) {
            // Bikin query buat hapus 
            await $.ajax({
                type: "POST",
                url: "page/Management/Siswa/aksisiswa.php",
                data: {
                    hapus: true,
                    id: id
                },
                success(hasil) {
                    if (hasil == 1) {
                        alert(`${nama} berhasil dihapus!`);
                        location.reload();
                    } else {
                        alert(`${nama} gagal dihapus!`);
                    }
                }
            })
        }
    }