<?php
include('../config/koneksi.php');
$daritanggal   = $_POST['daritanggal'];
$bulan  = date('F', strtotime($daritanggal));

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
?>
<title>Laporan SPP Paud Melati bulan <?php echo $bulan; ?></title>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    h1,
    h4 {
        text-align: center;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    @media print {
        #ngeprint {
            display: none;
        }
    }
</style>
<h1>Laporan SPP Paud Melati</h1>
<h4>Bulan <?php echo $bulan; ?></h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Nama Siswa</th>
            <th>NIS</th>
            <th>Tahun Ajaran</th>
            <th>Total Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalHarga = 0;
        $no = 1;
        $sql = $koneksi->query("SELECT p.id, p.date, t.nama, t.bayaran, a.name, a.nis FROM tb_pembayaran AS p
                                            
                                            INNER JOIN tb_tahun_ajaran AS t ON p.id_tahun_ajaran = t.id
                                            INNER JOIN tb_anak AS a ON a.id = p.id_anak
                                            INNER JOIN tb_bukti_pembayaran AS bp ON p.id = bp.id_pembayaran

                                            WHERE bp.tgl_struk LIKE '$daritanggal%' AND
                                            p.status = 'Sudah bayar'");
        while ($data = $sql->fetch_assoc()) {
            $tanggal  = date('M', strtotime($data['date']));
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $tanggal; ?></td>
                <td><?php echo $data['name']; ?></td>
                <td><?php echo $data['nis']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo rupiah($data['bayaran']); ?></td>
            </tr>
        <?php
        $totalHarga += $data['bayaran'];
        }
        ?>
    </tbody>
    <tr>
        <th colspan="5">TOTAL</th>
        <td style="font-weight:bold"><?php echo rupiah($totalHarga); ?></td>
    </tr>
</table>
<br />
<input type="button" value="Cetak" onclick="window.print();" id="ngeprint" />