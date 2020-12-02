<div class="card shadow mb-4">
    <div class="card-body">
        <div class="card-header py-3 mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                Tambah Pengumuman
            </button>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pengumuman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $pengumuman = $koneksi->query("SELECT * FROM tb_pengumuman");
                    while ($data = $pengumuman->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['tanggal'] ?></td>
                            <td><?php echo $data['pengumuman'] ?></td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ubahModal-<?php echo $data['id']; ?>">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button type="button" class="btn btn-danger" id="hapus" data-id="<?php echo $data['id']; ?>" onclick="hapusPengumuman(this.getAttribute('data-id'))">
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
                <h5 class="modal-title">Tambah Pengumuman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambahForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="tambah" value="true">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Pengumuman</label>
                        <input type="text" name="pengumuman" class="form-control">
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
$sql = $koneksi->query("SELECT * FROM tb_pengumuman");

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
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?php echo $data['tanggal']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Pengumuman</label>
                            <input type="text" name="pengumuman" class="form-control" value="<?php echo $data['pengumuman']; ?>">
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
        // ajaxnya
        $.ajax({
            type: "POST",
            url: "Pengumum/aksipengumum.php",
            data: form.serialize(),
            success(hasil) {
                alert(hasil);
                location.reload();
            }
        })
    })

    // edit
    $('form[id^="ubahForm"]').each(function() {
        $(this).submit(function(e) {
            e.preventDefault();
            let form = $(this)

            $.ajax({
                type: "POST",
                url: "Pengumum/aksipengumum.php",
                data: form.serialize(),
                success(hasil) {
                    alert(hasil);
                    location.reload();
                }
            })
        });
    });

    // hapus
    async function hapusPengumuman(id) {
        let hapus = confirm(`Hapus ?`);
        if (hapus) {
            // Bikin query buat hapus 
            await $.ajax({
                type: "POST",
                url: "Pengumum/aksipengumum.php",
                data: {
                    hapus: true,
                    id: id
                },
                success(hasil) {
                    alert(hasil)
                    location.reload();
                }
            })
        }
    }
</script>