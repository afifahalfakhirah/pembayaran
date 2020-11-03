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
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

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
                        <label>Nama Siswa</label>
                        <input type="text" name="nama" class="form-control">
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
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="ubahModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ubahForm" method="POST" class="ubahForm">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="number" name="nis" id="nis" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="L">L</option>
                            <option value="P">P</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control">
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

<script>
    function loadDataTable() {
        let tabel = $('#dataTable').DataTable({
            "ajax": {
                type: "POST",
                data: {
                    getData: true
                },
                url: "page/OrangTua/aksianak.php",
                dataSrc: "",
                order: [
                    [1, 'asc']
                ]
            },
            "columns": [{
                    data: null
                },
                {
                    "data": "name"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "jenis_kelamin"
                },
                {
                    "data": "tempat_lahir"
                },
                {
                    "data": "tgl_lahir"
                },
                {
                    "data": "status"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return "<div class='btn-group' role='group'>" +
                            "<button type='button' class='btn btn-info' id='ubah'>" +
                            "<i class='fas fa-edit'></i> Ubah" +
                            "</button>" +
                            "<button type='button' class='btn btn-danger' id='hapus'>" +
                            "<i class='fas fa-trash'></i> Hapus" +
                            "</button>" +
                            "</div>";
                    }
                }
            ]
        });

        tabel.on('order.dt search.dt', function() {
            tabel.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // Klik tombol ubah
        tabel.on('click', '#ubah', function() {
            let data = tabel.row($(this).parents("tr")).data();
            let id = data.id;
            $.ajax({
                type: "POST",
                url: "page/OrangTua/aksianak.php",
                data: {
                    getDataById: true,
                    id: id
                },
                success(hasil) {
                    const hasilParse = JSON.parse(hasil);
                    $('#ubahModal').modal('show');
                    $("#ubahModal #id").val(hasilParse[0].id);
                    $("#ubahModal #name").val(hasilParse[0].name);
                    $("#ubahModal #nis").val(hasilParse[0].nis);
                    $("#ubahModal #jenis_kelamin").val(hasilParse[0].jenis_kelamin);
                    $("#ubahModal #tempat_lahir").val(hasilParse[0].tempat_lahir);
                    $("#ubahModal #tgl_lahir").val(hasilParse[0].tgl_lahir);
                }
            });
            // $(`#ubahModal-${id}`).modal('show');
        })

        // Klik tombol hapus
        tabel.on('click', '#hapus', function() {
            let data = tabel.row($(this).parents("tr")).data();
            let id = data.id;
            let nama = data.name;
            let nanya = confirm(`Hapus ${nama} ?`);

            if (nanya) {
                $.ajax({
                    type: "POST",
                    url: "page/OrangTua/aksianak.php",
                    data: {
                        hapus: true,
                        id: id
                    },
                    success(hasil) {
                        alert(hasil);
                        // Refresh tabelnya aja
                        refreshDataTable();
                    }
                });
            }
        })
    }

    function refreshDataTable() {
        let tabel = $('#dataTable').DataTable()
        tabel.ajax.reload();
    }

    $(document).ready(function() {
        loadDataTable();
    })

    $('form[id^="tambahForm"]').each(function() {
        let tambahForm = this;
        $(this).submit(function(e) {
            e.preventDefault();
            let form = $(this)

            $.ajax({
                type: "POST",
                url: "page/OrangTua/aksianak.php",
                data: form.serialize(),
                success(hasil) {
                    alert(hasil);
                    // Refresh tabelnya aja
                    refreshDataTable();
                    // tutup modalnya
                    $('#tambahModal').modal('hide');
                    // Bersihin formnya
                    $('#tambahForm')[0].reset();
                }
            })
        });
    });



    $('form[id^="ubahForm"]').each(function() {
        console.log("clicked")
        $(this).submit(function(e) {
            e.preventDefault();
            const form = $(this)
            const data = form.serializeArray();

            const isiForm = {
                ubah: true,
                id: $("#ubahModal #id").val(),
                name: $("#ubahModal #name").val(),
                nis: $("#ubahModal #nis").val(),
                jenis_kelamin: $("#ubahModal #jenis_kelamin").val(),
                tempat_lahir: $("#ubahModal #tempat_lahir").val(),
                tgl_lahir: $("#ubahModal #tgl_lahir").val(),
            }

            $.ajax({
                type: "POST",
                url: "page/OrangTua/aksianak.php",
                data: isiForm,
                success(hasil) {
                    alert(hasil);
                    // Refresh tabelnya aja
                    refreshDataTable();
                    // tutup modalnya
                    $('#ubahModal').modal('hide');
                }
            })
        });
    });
</script>