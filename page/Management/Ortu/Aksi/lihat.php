<?php
$id = $_GET['id'];

$sql = $koneksi->query("SELECT tb_user.name, tb_user.email, tb_user.tingkat, tb_orang_tua.address,
                    tb_orang_tua.post_code, tb_orang_tua.pekerjaan, tb_orang_tua.id_user FROM tb_orang_tua INNER JOIN tb_user ON tb_orang_tua.id_user = tb_user.id
                    WHERE tb_orang_tua.id = $id");
$dataOrtu = $sql->fetch_assoc();
$id_user = $dataOrtu['id_user'];

$sqlAnak  = $koneksi->query("SELECT * FROM tb_anak WHERE id_user = $id_user");
?>

<h5> Data Diri </h5>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th width="30%"><strong>Nama</strong></th>
                <td><?php echo $dataOrtu['name']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Email</strong></th>
                <td><?php echo $dataOrtu['email']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Alamat</strong></th>
                <td><?php echo $dataOrtu['address']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Post Code</strong></th>
                <td><?php echo $dataOrtu['post_code']; ?></td>
            </tr>
            <tr>
                <th width="30%"><strong>Pekerjaan</strong></th>
                <td><?php echo $dataOrtu['pekerjaan']; ?></td>
            </tr>
        </table>
    </div>
</div>

<h5 class="pt-3">Data anak</h5>
<div class="pb-4">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
        Tambah Data
    </button>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                No
            </th>
            <th>
                Nama
            </th>
            <th>NIS</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($anak = $sqlAnak->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $no++; ?>
                <td><?php echo $anak['name']; ?>
                <td><?php echo $anak['nis']; ?>
                <td><?php echo $anak['jenis_kelamin']; ?>
                <td><?php echo $anak['tempat_lahir']; ?>
                <td><?php echo $anak['tgl_lahir']; ?>
                <td><?php echo $anak['status']; ?>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ubahModal-<?php echo $anak['id']; ?>">
                        <i class="fas fa-edit"></i> Ubah
                    </button>
                    <button type="button" class="btn btn-danger" id="hapus" data-nama="<?php echo $anak['name']; ?>" data-id="<?php echo $anak['id']; ?>" onclick="hapusUser(this.getAttribute('data-nama'), this.getAttribute('data-id'))">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

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
                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                    <input type="hidden" name="tambah" value="true">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="name" class="form-control">
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
                        <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="tempat_lahir" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <!-- ternary -->
                            <option value="Aktif" <?php echo $data['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?php echo $data['status'] == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
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
$sql2 = $koneksi->query("SELECT * FROM tb_anak WHERE id_user = $id_user");
while ($data = $sql2->fetch_assoc()) {
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
                            <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="name" class="form-control" value="<?php echo $data['name']; ?>">
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
                            <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="tempat_lahir" class="form-control" value="<?php echo $data['tempat_lahir']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" value="<?php echo $data['tgl_lahir']; ?>">
                        </div>
                        <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Aktif" <?php echo $data['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?php echo $data['status'] == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
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
    $('#tambahForm').submit(function(e) {
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

    async function hapusUser(nama, id) {
        let hapus = confirm(`Hapus ${nama}?`);
        if (hapus) {
            
            await $.ajax({
                type: "POST",
                url: "page/Management/Siswa/aksisiswa.php",
                data: {
                    hapus: true,
                    id: id
                },
                success(hasil) {
                    alert(hasil);
                    location.reload();
                }
            })
        }
    }
</script>
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