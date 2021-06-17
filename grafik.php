<?php
include "./config/koneksi.php";

$daritanggal = date('Y-m-');
$sql = $koneksi->query("SELECT a.name, tgl_struk FROM tb_pembayaran AS p                                    
INNER JOIN tb_anak AS a ON a.id = p.id_anak
INNER JOIN tb_bukti_pembayaran AS bp ON p.id = bp.id_pembayaran

WHERE p.date LIKE '$daritanggal%' AND p.status = 'Sudah bayar'");

$data = [];
while ($s = $sql->fetch_assoc()):
    $data[] = date('Y-m-d', strtotime($s['tgl_struk']));
endwhile;

echo json_encode(array_count_values($data));
?>