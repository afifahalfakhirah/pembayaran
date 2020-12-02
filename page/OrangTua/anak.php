<div class="card shadow mb-4">
    <div class="card-body">
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
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
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
                url: "page/Management/Siswa/aksisiswa.php",
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
                    data: "id",
                    render: function(data, type, row) {
                        return "<div class='btn-group' role='group'>" +
                            "<a href='index.php?page=anak-saia&aksi=lihat&id=" + data + "' class='btn btn-danger' id='hapus'>" +
                            "<i class='fas fa-eyes'></i> Lihat" +
                            "</a>" +
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
    }

    function refreshDataTable() {
        let tabel = $('#dataTable').DataTable()
        tabel.ajax.reload();
    }

    $(document).ready(function() {
        loadDataTable();
    })

</script>