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
                        <th>Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
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
                            <label>Bayar</label>
                            <input type="number" name="bayaran" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status</status>
                                <select name="status" class="form-control">
                                    <!-- ternary -->
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
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

    <div class="modal" tabindex="-1" role="dialog" id="ubahModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ubahForm" method="POST">
                    <div class="modal-body">
                        <!-- Kasih hidden input biar tau lagi nambahin -->
                        <input type="hidden" name="ubah" value="true">
                        <input type="hidden" name="id" id="id" value="true">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Bayar</label>
                            <input type="number" name="bayaran" id="bayaran" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status</status>
                                <select name="status" class="form-control" id="status">
                                    <!-- ternary -->
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
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

    <script>
        $(document).ready(function() {
            loadDataTable();
        })

        function loadDataTable() {
            let tabel = $('#dataTable').DataTable({
                "ajax": {
                    type: "POST",
                    data: {
                        getData: true
                    },
                    url: "page/TahunAjaran/aksiajaran.php",
                    dataSrc: "",
                    order: [
                        [1, 'asc']
                    ],
                },
                "columns": [{
                        "data": null
                    },
                    {
                        "data": "nama"
                    },
                    {
                        "data": "bayaran"
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
            // CTRL + / owwww
            tabel.on('click', '#ubah', function() {
                let data = tabel.row($(this).parents("tr")).data();
                let id = data.id;
                $.ajax({
                    type: "POST",
                    url: "page/TahunAjaran/aksiajaran.php",
                    data: {
                        getDataByID: true,
                        id: id
                    },
                    success(hasil) {
                        const hasilParse = JSON.parse(hasil);
                        $('#ubahModal').modal('show');
                        $("#ubahModal #id").val(hasilParse[0].id);
                        $("#ubahModal #nama").val(hasilParse[0].nama);
                        $("#ubahModal #bayaran").val(hasilParse[0].bayaran);
                        $("#ubahModal #status").val(hasilParse[0].status);
                    }
                });
                $(`#ubahModal-${id}`).modal('show');
            })

            tabel.on('click', '#hapus', function() {
                var nanya = confirm("Hapus data?")

                if (nanya) {
                    let data = tabel.row($(this).parents("tr")).data();
                    let id = data.id;
                    $.ajax({
                        type: "POST",
                        url: "page/TahunAjaran/aksiajaran.php",
                        data: {
                            hapus: true,
                            id: id
                        },
                        success() {
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

        $('form[id^="tambahForm"]').each(function() {
            let tambahForm = this;
            $(this).submit(function(e) {
                e.preventDefault();
                let form = $(this)

                $.ajax({
                    type: "POST",
                    url: "page/TahunAjaran/aksiajaran.php",
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
            let ubahForm = this;
            $(this).submit(function(e) {
                e.preventDefault();
                let form = $(this)

                $.ajax({
                    type: "POST",
                    url: "page/TahunAjaran/aksiajaran.php",
                    data: form.serialize(),
                    success(hasil) {
                        alert(hasil);
                        // Refresh tabelnya aja
                        refreshDataTable();
                        // tutup modalnya
                        $('#ubahModal').modal('hide');
                        // Bersihin formnya
                        $('#ubahForm')[0].reset();
                    }
                })
            });
        });

    </script>