<?php
if ($tingkat == 'admin' || $tingkat == 'bendahara') {
    $bulanSekarang = date('Y-m');

?>
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Siswa</div>
                                <?php
                                $jumlahSiswa = $koneksi->query("SELECT * FROM tb_anak")->num_rows;
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlahSiswa ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-restroom fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Belum Bayar</div>
                                <?php
                                $belumBayar = $koneksi->query("SELECT * FROM tb_pembayaran WHERE status = 'Belum bayar' AND date LIKE '$bulanSekarang%'")->num_rows;
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $belumBayar ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Sudah Bayar</div>
                                <?php
                                $sudahBayar = $koneksi->query("SELECT * FROM tb_pembayaran WHERE status = 'Sudah bayar' AND date LIKE '$bulanSekarang%'")->num_rows;
                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sudahBayar ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Menunggu Verifikasi</div>
                                <?php
                                $menungguVerifikasi = $koneksi->query("SELECT * FROM tb_pembayaran WHERE status = 'Menunggu verifikasi' AND date LIKE '$bulanSekarang%'")->num_rows;

                                ?>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $menungguVerifikasi ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Transaksi</h6>

                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered table-striped" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Bulan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $ambilTransaksi = $koneksi->query("SELECT tb_pembayaran.id, tb_anak.name, tb_anak.nis, tb_pembayaran.date, 
                                    tb_tahun_ajaran.nama, tb_pembayaran.total, tb_pembayaran.status FROM tb_pembayaran INNER JOIN tb_anak 
                                    ON tb_pembayaran.id_anak = tb_anak.id INNER JOIN tb_tahun_ajaran ON tb_tahun_ajaran.id = tb_pembayaran.id_tahun_ajaran 
                                    WHERE tb_pembayaran.status = 'Belum bayar' AND tb_pembayaran.date LIKE '$bulanSekarang%'");


                                    while ($data = $ambilTransaksi->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $data['name'] ?></td>
                                            <td><?php echo date('F', strtotime($data['date'])) ?></td>
                                            <td><?php echo $data['total'] ?></td>
                                            <td><span class="badge badge-warning"><?= $data['status'] ?></span></td>
                                            <td class="text-right">
                                                <a href="index.php?page=transaksi&aksi=rincian&id=<?= $data['id']; ?>" class="btn btn-success">
                                                    <i class="fas fa-eyes"></i> Rincian
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg">
                <canvas id="myChart"></canvas>
            </div>

        </div>

    <?php } else { ?>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    NAMA SEKOLAH</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">PAUD MELATI III</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-school fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    KEPALA SEKOLAH</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">SITI ALAWIYAH,S.Pd.I</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    BENDAHARA</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">CHOIRONI</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="card shadow mb-4">
                <div class="text-center">
                    <div class="card-header py-3">
                        <div class="text-center">
                            <h6 class="h3 m-3 font-weight-bold text-info">PAUD MELATI III</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="assets/img/logo-removebg-preview.png" class="img-thumbnail" width="300px">
                            </div>
                            <div class="text-center">
                                <p>Pendidikan Anak Usia Dini Melati III</p>
                            </div>
                            <div class="text-center">
                                <p>Perum Griya Curug
                                    Kec.Legok Kab.Tangerang
                                </p>
                                <p>Izin Operasional : 421.1/048/Disdik/2013
                                    NPSN : 69801871
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/grafik.js"></script>