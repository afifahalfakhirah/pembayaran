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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tingkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $ambilUser = $koneksi->query("SELECT * FROM tb_user WHERE tingkat = 'admin' OR tingkat = 'bendahara' ");
                    while ($data = $ambilUser->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['name'] ?></td>
                            <td><?php echo $data['email'] ?></td>
                            <td><?php echo $data['tingkat'] ?></td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#gantiPassword-<?php echo $data['id']; ?>">
                                        <i class="fas fa-edit"></i> Ganti Password 
                                    </button>
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
              <!-- Kasih hidden input biar tau lagi nambahin -->
              <input type="hidden" name="tambah" value="true">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Tingkat</label>
                    <select name="tingkat"class="form-control">
                        <!-- ternary ni -->
                        <option value="admin" <?php echo $data['tingkat'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="bendahara" <?php echo $data['tingkat'] == 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
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
    $sql = $koneksi->query("SELECT * FROM tb_user WHERE tingkat = 'admin' OR tingkat = 'bendahara'"); 
    while ($data = $sql->fetch_assoc()){
?>

<div class="modal" tabindex="-1" role="dialog" id="ubahModal-<?php echo $data['id'];?>">
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
                    <input type="text" name="nama" class="form-control" value="<?php echo $data['name']; ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>">
                </div>
                <div class="form-group">
                    <label>Tingkat</label>
                    <select name="tingkat"class="form-control">
                        <!-- ternary ni -->
                        <option value="admin" <?php echo $data['tingkat'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="bendahara" <?php echo $data['tingkat'] == 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
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

<?php
    $sql = $koneksi->query("SELECT * FROM tb_user WHERE tingkat = 'admin' OR tingkat = 'bendahara'"); 
    while ($data = $sql->fetch_assoc()){
?>

<div class="modal" tabindex="-1" role="dialog" id="gantiPassword-<?php echo $data['id'];?>">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="gantiPassword-<?php echo $data['id']; ?>" method="POST" class="gantiPassword">
      <div class="modal-body">
              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
              <input type="hidden" name="gantiPassword" value="true">
                <div class="form-group">
                    <label>Ganti Password</label>
                    <input type="password" name="password" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="submit" name="gantiPassword" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
      </form>
    </div>
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
            url: "page/Management/User/aksi.php",
            data: form.serialize(),
            success(hasil) {
                if (hasil == 1){
                        alert(`Berhasil menambahkan pengguna!`);
                        location.reload();
                    } else {
                        alert(`Gagal menambahkan pengguna!`);
                    }  
            }
        })
    })

    // edit
    $('form[id^="ubahForm"]').each(function () {
    $(this).submit(function(e) {
        e.preventDefault(); 
        let form = $(this)
      
        $.ajax({
            type: "POST",
            url: "page/Management/User/aksi.php",
            data: form.serialize(),
            success(hasil) {
                if (hasil == 1){
                        alert(`Berhasil mengubah pengguna!`);
                        location.reload();
                    } else {
                        alert(`Gagal mengubah pengguna!`);
                    }  
            }
        })
    });
});


$('form[id^="gantiPassword"]').each(function () {
    $(this).submit(function(e) {
        e.preventDefault(); 
        let form = $(this)
        
        $.ajax({
            type: "POST",
            url: "page/Management/User/aksi.php",
            data: form.serialize(),
            success(hasil) {
                if (hasil == 1){
                        alert(`Berhasil mengubah password!`);
                        location.reload();
                    } else {
                        alert(`Gagal mengubah password!`);
                    }  
            }
        })
    });
});

    async function hapusUser(nama, id) {
        let hapus = confirm(`Hapus ${nama}?`);
        if (hapus) { 
            await $.ajax({
                type: "POST",
                url: "page/Management/User/aksi.php",
                data: {
                    hapus: true,
                    id: id
                },
                success(hasil) {
                    if (hasil == 1){
                        alert(`${nama} berhasil dihapus!`);
                        location.reload();
                    } else {
                        alert(`${nama} gagal dihapus!`);
                    }
                }
            })
        }
    }
</script>
