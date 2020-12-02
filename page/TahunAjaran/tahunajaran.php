<?php
if (isset($_POST['transferTahunAjaran'])) {
    // Ambil semua data pembayaran
    // Ini siswa lamanya, diliat kalo masih aktif lanjut 
    $queryAmbilSemuaPembayaran = $koneksi->query("SELECT * FROM tb_pembayaran INNER JOIN tb_tahun_ajaran 
    ON tb_pembayaran.id_tahun_ajaran = tb_tahun_ajaran.id INNER JOIN tb_anak ON tb_pembayaran.id_anak = tb_anak.id 
    WHERE tb_anak.status = 'Aktif' AND tb_pembayaran.status = 'Sudah bayar'");

    $bulanSekarang = strtotime(date('F jS Y h:i:s A', strtotime('first day of ' . date('F Y'))));
    $queryTahunAjaran = $koneksi->query("SELECT * FROM tb_tahun_ajaran WHERE status = 'Aktif' ORDER BY nama LIMIT 1");
    $tahunAjaranAktif = $queryTahunAjaran->fetch_assoc();

    // Ambil stringnya
    $bulanTahunAjaran = strtotime('first day of ' . $tahunAjaranAktif['date']);
    $tahunAjaranAbis = strtotime('first day of ' . $tahunAjaranAktif['date']);

    $tahunAjaranAbis = strtotime('+1 year', $tahunAjaranAbis);
    $tahunAjaranAbis = strtotime('-1 month', $tahunAjaranAbis);

    $id_tahun_ajaran = $tahunAjaranAktif['id'];
    $total_bayaran = $tahunAjaranAktif['bayaran'];
    
    while ($dataPembayaran = $queryAmbilSemuaPembayaran->fetch_assoc()) {
        // Ambil id anak yang udah bayar selama 12 bulan
        $id_anak = $dataPembayaran['id_anak'];
        $idTahunAjaranKemarin = $dataPembayaran['id_tahun_ajaran'];
        $queryCekSudahBayarSemua = $koneksi->query("SELECT * FROM tb_pembayaran WHERE id_anak = $id_anak 
        AND status NOT IN ('Belum bayar') AND id_tahun_ajaran = $idTahunAjaranKemarin");

        $cekSudahBayarSemua = $queryCekSudahBayarSemua->num_rows;

        if ($cekSudahBayarSemua == 12) {
            $tanggal = date('Y-m-d H:i:s', $bulanTahunAjaran);
            $koneksi->query("INSERT INTO tb_pembayaran (id_anak, date, id_tahun_ajaran, total, status) VALUES
        ('$id_anak', '$tanggal', '$id_tahun_ajaran', '$total_bayaran', 'Belum bayar')");
            $bulanTahunAjaran = strtotime('+1 month', $bulanTahunAjaran);
        }
    }
    ?>
    <script>
        alert("Berhasil melakukan transfer");
        window.location.href = "index.php?page=tahun-ajaran";
    </script>
    <?php
}
?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="card-header py-3 mb-3 row">
            <div class="col-lg text-left">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                    Tambah Data
                </button>
            </div>
            <div class="col-lg text-right">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#transferModal">
                    Transfer Tahun Ajaran
                </button>
            </div>
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

    <div class="modal" tabindex="-1" role="dialog" id="transferModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Tahun Ajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <?php
                        $pembayaran = $koneksi->query("SELECT tb_tahun_ajaran.id, nama FROM tb_pembayaran INNER JOIN tb_tahun_ajaran ON 
                        tb_pembayaran.id_tahun_ajaran = tb_tahun_ajaran.id ORDER BY id DESC LIMIT 1")->fetch_assoc();

                        $tahunAjaran = $koneksi->query("SELECT id, nama FROM tb_tahun_ajaran WHERE status = 'Aktif' ORDER BY id DESC LIMIT 1")->fetch_assoc();
                        ?>
                        <table class="table table-striped">
                            <tr>
                                <th>Tahun Ajaran Saat Ini:</th>
                                <td><?= $pembayaran['nama'] ?></td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran Berikutnya:</th>
                                <td><?= $tahunAjaran['nama'] ?></td>
                            </tr>
                        </table>
                        <p>Silakan ubah status tahun ajaran menjadi <code>Aktif</code> pada tahun ajaran yang akan datang, dan ubah status menjadi <code>Nonaktif</code> pada tahun ajaran kemarin.</p>
                        <p>Pastikan semua siswa sudah membayar semua transaksi.</p>
                        Silakan klik <code>Simpan</code> untuk melakukan transfer.
                    </div>
                    <div class="modal-footer">
                        <?php
                        // jika tahun ajaran yang aktif masih sama, sembunyiin tombol simpan
                        if ($pembayaran['id'] != $tahunAjaran['id']) { ?>
                            <button type="submit" name="transferTahunAjaran" class="btn btn-primary">Simpan</button>
                        <?php  } ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
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
                        // Refresh tabelnya 
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
                        // Refresh tabelnya
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