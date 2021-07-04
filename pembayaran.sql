-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 04 Jul 2021 pada 16.46
-- Versi server: 5.7.24
-- Versi PHP: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pembayaran`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_anak`
--

CREATE TABLE `tb_anak` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(25) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_anak`
--

INSERT INTO `tb_anak` (`id`, `id_user`, `name`, `nis`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `status`) VALUES
(1, 55, 'Almaira Rachel Hidayat', '21220001', 'P', 'Tangerang', '2016-03-02', 'Aktif'),
(2, 56, 'Azka Faturrahman Nst', '21220002', 'L', 'Tangerang', '2016-06-12', 'Aktif'),
(3, 57, 'Arsya Ardiya Putra', '21220003', 'L', 'Tangerang', '2016-11-04', 'Aktif'),
(4, 58, 'Dafiya Myesha Jaelani', '21220004', 'P', 'Tangerang', '2016-10-05', 'Aktif'),
(5, 59, 'Kirana Sekar Ayudia', '21220005', 'P', 'Tangerang', '2018-06-30', 'Aktif'),
(6, 60, 'Farel Al Fadhil', '21220006', 'L', 'Tangerang', '2016-07-21', 'Aktif'),
(7, 61, 'Karlaisha Ananda Rahman', '21220007', 'P', 'Tangerang', '2017-03-28', 'Aktif'),
(8, 62, 'Assyauqie Khairy Al Nabil', '21220008', 'L', 'Tangerang', '2015-07-28', 'Aktif'),
(9, 63, 'Annis Maulida', '21220009', 'P', 'Tangerang', '2016-12-12', 'Aktif'),
(10, 64, 'Anindyta Triana Zahra', '21220010', 'P', 'Tangerang', '2016-02-12', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bukti_pembayaran`
--

CREATE TABLE `tb_bukti_pembayaran` (
  `id` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `id_rekening_tujuan` int(11) NOT NULL,
  `nama_pengirim` varchar(30) NOT NULL,
  `no_rek_pengirim` varchar(30) NOT NULL,
  `bank_pengirim` varchar(30) NOT NULL,
  `struk_transfer` varchar(128) NOT NULL,
  `tgl_struk` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_bukti_pembayaran`
--

INSERT INTO `tb_bukti_pembayaran` (`id`, `id_pembayaran`, `id_rekening_tujuan`, `nama_pengirim`, `no_rek_pengirim`, `bank_pengirim`, `struk_transfer`, `tgl_struk`) VALUES
(1, 1, 1, 'Octavia Kusumawati', '0311034179', 'BCA', 'bukti1.jpg', '2021-07-04 20:52:05'),
(2, 13, 2, 'Irma Suryani', '0018972918', 'BNI', 'bukti2.jpg', '2021-07-04 21:01:47'),
(3, 109, 1, 'Siti Umi Julaikah', '0398156721', 'BCA', 'bukti4.jpg', '2021-07-04 21:06:29'),
(4, 97, 1, 'Hustinawati', '1928192617', 'BNI', 'bukti1.jpg', '2021-07-04 22:06:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_orang_tua`
--

CREATE TABLE `tb_orang_tua` (
  `id` int(11) NOT NULL,
  `id_user` int(25) NOT NULL,
  `address` varchar(100) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_orang_tua`
--

INSERT INTO `tb_orang_tua` (`id`, `id_user`, `address`, `post_code`, `pekerjaan`) VALUES
(1, 55, 'Kp.Rancagong Rt.04/11', '15820', 'Karyawan Swasta'),
(2, 56, 'Kp.Ciangir Rt.03/04', '15820', 'Wiraswasta'),
(3, 57, 'Kp.Kebon Pala Rt.02/06', '15850', 'Karyawan Swasta'),
(4, 58, 'Perum Griya Curug Rt.11/11', '15820', ''),
(5, 59, 'Kp.Rancagong Rt.02/07', '15820', 'Karyawan Swasta'),
(6, 60, 'Kp.Rancagong Rt.02/07', '15820', 'Karyawan Swasta'),
(7, 61, 'Kp.Rancagong Rt.02/07', '15820', 'Karyawan Swasta'),
(8, 62, 'Kp.Rancagong Rt.02/08', '15820', 'Karyawan Swasta'),
(9, 63, 'Perum Griya Curug Rt.06/11', '15820', 'Karyawan Swasta'),
(10, 64, 'Kp.Rancagong Rt.01/10', '15820', 'Karyawan Swasta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id` int(11) NOT NULL,
  `id_anak` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_tahun_ajaran` int(11) NOT NULL,
  `total` varchar(25) NOT NULL,
  `status` enum('Belum bayar','Menunggu verifikasi','Sudah bayar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id`, `id_anak`, `date`, `id_tahun_ajaran`, `total`, `status`) VALUES
(1, 1, '2021-07-01', 9, '50000', 'Sudah bayar'),
(2, 1, '2021-08-01', 9, '50000', 'Belum bayar'),
(3, 1, '2021-09-01', 9, '50000', 'Belum bayar'),
(4, 1, '2021-10-01', 9, '50000', 'Belum bayar'),
(5, 1, '2021-11-01', 9, '50000', 'Belum bayar'),
(6, 1, '2021-12-01', 9, '50000', 'Belum bayar'),
(7, 1, '2022-01-01', 9, '50000', 'Belum bayar'),
(8, 1, '2022-02-01', 9, '50000', 'Belum bayar'),
(9, 1, '2022-03-01', 9, '50000', 'Belum bayar'),
(10, 1, '2022-04-01', 9, '50000', 'Belum bayar'),
(11, 1, '2022-05-01', 9, '50000', 'Belum bayar'),
(12, 1, '2022-06-01', 9, '50000', 'Belum bayar'),
(13, 2, '2021-07-01', 9, '50000', 'Menunggu verifikasi'),
(14, 2, '2021-08-01', 9, '50000', 'Belum bayar'),
(15, 2, '2021-09-01', 9, '50000', 'Belum bayar'),
(16, 2, '2021-10-01', 9, '50000', 'Belum bayar'),
(17, 2, '2021-11-01', 9, '50000', 'Belum bayar'),
(18, 2, '2021-12-01', 9, '50000', 'Belum bayar'),
(19, 2, '2022-01-01', 9, '50000', 'Belum bayar'),
(20, 2, '2022-02-01', 9, '50000', 'Belum bayar'),
(21, 2, '2022-03-01', 9, '50000', 'Belum bayar'),
(22, 2, '2022-04-01', 9, '50000', 'Belum bayar'),
(23, 2, '2022-05-01', 9, '50000', 'Belum bayar'),
(24, 2, '2022-06-01', 9, '50000', 'Belum bayar'),
(25, 3, '2021-07-01', 9, '50000', 'Belum bayar'),
(26, 3, '2021-08-01', 9, '50000', 'Belum bayar'),
(27, 3, '2021-09-01', 9, '50000', 'Belum bayar'),
(28, 3, '2021-10-01', 9, '50000', 'Belum bayar'),
(29, 3, '2021-11-01', 9, '50000', 'Belum bayar'),
(30, 3, '2021-12-01', 9, '50000', 'Belum bayar'),
(31, 3, '2022-01-01', 9, '50000', 'Belum bayar'),
(32, 3, '2022-02-01', 9, '50000', 'Belum bayar'),
(33, 3, '2022-03-01', 9, '50000', 'Belum bayar'),
(34, 3, '2022-04-01', 9, '50000', 'Belum bayar'),
(35, 3, '2022-05-01', 9, '50000', 'Belum bayar'),
(36, 3, '2022-06-01', 9, '50000', 'Belum bayar'),
(37, 4, '2021-07-01', 9, '50000', 'Belum bayar'),
(38, 4, '2021-08-01', 9, '50000', 'Belum bayar'),
(39, 4, '2021-09-01', 9, '50000', 'Belum bayar'),
(40, 4, '2021-10-01', 9, '50000', 'Belum bayar'),
(41, 4, '2021-11-01', 9, '50000', 'Belum bayar'),
(42, 4, '2021-12-01', 9, '50000', 'Belum bayar'),
(43, 4, '2022-01-01', 9, '50000', 'Belum bayar'),
(44, 4, '2022-02-01', 9, '50000', 'Belum bayar'),
(45, 4, '2022-03-01', 9, '50000', 'Belum bayar'),
(46, 4, '2022-04-01', 9, '50000', 'Belum bayar'),
(47, 4, '2022-05-01', 9, '50000', 'Belum bayar'),
(48, 4, '2022-06-01', 9, '50000', 'Belum bayar'),
(49, 5, '2021-07-01', 9, '50000', 'Belum bayar'),
(50, 5, '2021-08-01', 9, '50000', 'Belum bayar'),
(51, 5, '2021-09-01', 9, '50000', 'Belum bayar'),
(52, 5, '2021-10-01', 9, '50000', 'Belum bayar'),
(53, 5, '2021-11-01', 9, '50000', 'Belum bayar'),
(54, 5, '2021-12-01', 9, '50000', 'Belum bayar'),
(55, 5, '2022-01-01', 9, '50000', 'Belum bayar'),
(56, 5, '2022-02-01', 9, '50000', 'Belum bayar'),
(57, 5, '2022-03-01', 9, '50000', 'Belum bayar'),
(58, 5, '2022-04-01', 9, '50000', 'Belum bayar'),
(59, 5, '2022-05-01', 9, '50000', 'Belum bayar'),
(60, 5, '2022-06-01', 9, '50000', 'Belum bayar'),
(61, 6, '2021-07-01', 9, '50000', 'Belum bayar'),
(62, 6, '2021-08-01', 9, '50000', 'Belum bayar'),
(63, 6, '2021-09-01', 9, '50000', 'Belum bayar'),
(64, 6, '2021-10-01', 9, '50000', 'Belum bayar'),
(65, 6, '2021-11-01', 9, '50000', 'Belum bayar'),
(66, 6, '2021-12-01', 9, '50000', 'Belum bayar'),
(67, 6, '2022-01-01', 9, '50000', 'Belum bayar'),
(68, 6, '2022-02-01', 9, '50000', 'Belum bayar'),
(69, 6, '2022-03-01', 9, '50000', 'Belum bayar'),
(70, 6, '2022-04-01', 9, '50000', 'Belum bayar'),
(71, 6, '2022-05-01', 9, '50000', 'Belum bayar'),
(72, 6, '2022-06-01', 9, '50000', 'Belum bayar'),
(73, 7, '2021-07-01', 9, '50000', 'Belum bayar'),
(74, 7, '2021-08-01', 9, '50000', 'Belum bayar'),
(75, 7, '2021-09-01', 9, '50000', 'Belum bayar'),
(76, 7, '2021-10-01', 9, '50000', 'Belum bayar'),
(77, 7, '2021-11-01', 9, '50000', 'Belum bayar'),
(78, 7, '2021-12-01', 9, '50000', 'Belum bayar'),
(79, 7, '2022-01-01', 9, '50000', 'Belum bayar'),
(80, 7, '2022-02-01', 9, '50000', 'Belum bayar'),
(81, 7, '2022-03-01', 9, '50000', 'Belum bayar'),
(82, 7, '2022-04-01', 9, '50000', 'Belum bayar'),
(83, 7, '2022-05-01', 9, '50000', 'Belum bayar'),
(84, 7, '2022-06-01', 9, '50000', 'Belum bayar'),
(85, 8, '2021-07-01', 9, '50000', 'Belum bayar'),
(86, 8, '2021-08-01', 9, '50000', 'Belum bayar'),
(87, 8, '2021-09-01', 9, '50000', 'Belum bayar'),
(88, 8, '2021-10-01', 9, '50000', 'Belum bayar'),
(89, 8, '2021-11-01', 9, '50000', 'Belum bayar'),
(90, 8, '2021-12-01', 9, '50000', 'Belum bayar'),
(91, 8, '2022-01-01', 9, '50000', 'Belum bayar'),
(92, 8, '2022-02-01', 9, '50000', 'Belum bayar'),
(93, 8, '2022-03-01', 9, '50000', 'Belum bayar'),
(94, 8, '2022-04-01', 9, '50000', 'Belum bayar'),
(95, 8, '2022-05-01', 9, '50000', 'Belum bayar'),
(96, 8, '2022-06-01', 9, '50000', 'Belum bayar'),
(97, 9, '2021-07-01', 9, '50000', 'Sudah bayar'),
(98, 9, '2021-08-01', 9, '50000', 'Belum bayar'),
(99, 9, '2021-09-01', 9, '50000', 'Belum bayar'),
(100, 9, '2021-10-01', 9, '50000', 'Belum bayar'),
(101, 9, '2021-11-01', 9, '50000', 'Belum bayar'),
(102, 9, '2021-12-01', 9, '50000', 'Belum bayar'),
(103, 9, '2022-01-01', 9, '50000', 'Belum bayar'),
(104, 9, '2022-02-01', 9, '50000', 'Belum bayar'),
(105, 9, '2022-03-01', 9, '50000', 'Belum bayar'),
(106, 9, '2022-04-01', 9, '50000', 'Belum bayar'),
(107, 9, '2022-05-01', 9, '50000', 'Belum bayar'),
(108, 9, '2022-06-01', 9, '50000', 'Belum bayar'),
(109, 10, '2021-07-01', 9, '50000', 'Sudah bayar'),
(110, 10, '2021-08-01', 9, '50000', 'Belum bayar'),
(111, 10, '2021-09-01', 9, '50000', 'Belum bayar'),
(112, 10, '2021-10-01', 9, '50000', 'Belum bayar'),
(113, 10, '2021-11-01', 9, '50000', 'Belum bayar'),
(114, 10, '2021-12-01', 9, '50000', 'Belum bayar'),
(115, 10, '2022-01-01', 9, '50000', 'Belum bayar'),
(116, 10, '2022-02-01', 9, '50000', 'Belum bayar'),
(117, 10, '2022-03-01', 9, '50000', 'Belum bayar'),
(118, 10, '2022-04-01', 9, '50000', 'Belum bayar'),
(119, 10, '2022-05-01', 9, '50000', 'Belum bayar'),
(120, 10, '2022-06-01', 9, '50000', 'Belum bayar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengumuman`
--

CREATE TABLE `tb_pengumuman` (
  `id` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `pengumuman` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pengumuman`
--

INSERT INTO `tb_pengumuman` (`id`, `tanggal`, `pengumuman`) VALUES
(6, '2021-07-05', 'pembayaran dilakukan paling lambat tanggal 15 Juli 2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rekening`
--

CREATE TABLE `tb_rekening` (
  `id` int(11) NOT NULL,
  `nama_bank` varchar(30) NOT NULL,
  `nama_pemilik_rek` varchar(30) NOT NULL,
  `no_rek` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_rekening`
--

INSERT INTO `tb_rekening` (`id`, `nama_bank`, `nama_pemilik_rek`, `no_rek`) VALUES
(1, 'BJB', 'MELATI III', '0071560023100'),
(2, 'BRI', 'PAUD MELATI III', '0820-01-036530-53-2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tahun_ajaran`
--

CREATE TABLE `tb_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL,
  `bayaran` varchar(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_tahun_ajaran`
--

INSERT INTO `tb_tahun_ajaran` (`id`, `nama`, `status`, `bayaran`, `date`) VALUES
(6, 'ATA 2020/2021', 'Nonaktif', '50000', '2020-07-01 00:00:00'),
(9, 'ATA 2021/2022', 'Aktif', '50000', '2021-07-01 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(12) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `tingkat` enum('bendahara','admin','orang tua','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `foto`, `name`, `email`, `password`, `tingkat`) VALUES
(1, '560d79f81a3a510cc526ea17baa3d50833111db5', 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(54, '6354eea6e3847ac5f2b45db7d7577e7c3d442b16', 'bendahara', 'bendahara@gmail.com', '392b1ca68c2e976b207289ea0483d803', 'bendahara'),
(55, 'download (3).jpg', 'Octavia Kusumawati', 'octaviakusumawati@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(56, 'fot1.jpg', 'Irma Suryani', 'irmasuryani@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(57, NULL, 'Encih', 'encih@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(58, NULL, 'Nasiah', 'nasiah@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(59, NULL, 'Puji Rahayu Ningsih', 'pujirahayuningsih@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(60, NULL, 'Siti Musawaroh', 'sitimusawaroh@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(61, NULL, 'Nurfadilah', 'nurfadilah@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(62, NULL, 'Sri Wahyu Widiarti', 'sriwahyuwidiarti@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(63, 'fot2.jpg', 'Husniawati', 'husniawati@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua'),
(64, 'fot2.jpg', 'Siti Umi Julaikah', 'sitiumijulaikah@gmail.com', '129ff0b3bbf61aadf6e4f748301c9621', 'orang tua');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_anak`
--
ALTER TABLE `tb_anak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_bukti_pembayaran`
--
ALTER TABLE `tb_bukti_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_orang_tua`
--
ALTER TABLE `tb_orang_tua`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_rekening`
--
ALTER TABLE `tb_rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_tahun_ajaran`
--
ALTER TABLE `tb_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_anak`
--
ALTER TABLE `tb_anak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_bukti_pembayaran`
--
ALTER TABLE `tb_bukti_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_orang_tua`
--
ALTER TABLE `tb_orang_tua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT untuk tabel `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_rekening`
--
ALTER TABLE `tb_rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_tahun_ajaran`
--
ALTER TABLE `tb_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
