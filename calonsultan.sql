-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2022 at 07:32 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calonsultan`
--
CREATE DATABASE IF NOT EXISTS `calonsultan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `calonsultan`;

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

DROP TABLE IF EXISTS `artikel`;
CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal_rilis` date NOT NULL,
  `isi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `tanggal_rilis`, `isi`) VALUES
(1, 'Binomo Investasi Bodong?', '2022-04-28', 'Ini artikel 1'),
(2, '10 Strategi Mengatur Keuangan yang Harus Diketahui!', '2022-04-30', 'Ini artikel 2');

-- --------------------------------------------------------

--
-- Table structure for table `history_membership`
--

DROP TABLE IF EXISTS `history_membership`;
CREATE TABLE `history_membership` (
  `id` int(11) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `tanggal_beli` date NOT NULL,
  `tanggal_exp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_membership`
--

INSERT INTO `history_membership` (`id`, `email_user`, `tanggal_beli`, `tanggal_exp`) VALUES
(1, 'c@gmail.com', '2022-04-30', '2022-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tipe` int(11) NOT NULL COMMENT '0 : pemasukan\r\n1 : pengeluaran',
  `id_kelompok` int(11) NOT NULL COMMENT '1 : kebutuhan\r\n2 : keinginan\r\n3 : inves/tabungan\r\n4 : sedekah'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `tipe`, `id_kelompok`) VALUES
(5, 'Makan & Minum', 1, 1),
(6, 'Cicilan lainnya', 1, 1),
(7, 'Pendidikan', 1, 1),
(8, 'Elektronik', 1, 1),
(9, 'Fashion', 1, 1),
(10, 'Kesehatan', 1, 1),
(11, 'Pajak', 1, 1),
(12, 'Tagihan air, listrik, dll', 1, 1),
(13, 'Pernikahan', 1, 1),
(14, 'Kendaraan', 1, 1),
(15, 'Umroh', 1, 2),
(16, 'Perabotan', 1, 1),
(17, 'Rumah', 1, 1),
(18, 'Fashion', 1, 2),
(19, 'Elektronik', 1, 2),
(20, 'Makan & minum', 1, 2),
(21, 'Hobi', 1, 2),
(22, 'Shopping', 1, 2),
(23, 'Transportasi', 1, 2),
(24, 'Liburan', 1, 2),
(25, 'Saham', 1, 3),
(26, 'Obligasi', 1, 3),
(27, 'Reksadana', 1, 3),
(28, 'Crypto', 1, 3),
(29, 'NFT', 1, 3),
(30, 'Deposito', 1, 3),
(31, 'Setor Bank', 1, 3),
(32, 'Modal Bisnis', 1, 3),
(33, 'Asuransi', 1, 3),
(34, 'Panti Asuhan', 1, 4),
(35, 'Tempat Ibadah', 1, 4),
(36, 'Rumah Sakit', 1, 4),
(37, 'Zakat', 1, 4),
(38, 'Sumbangan', 1, 4),
(39, 'Lembaga Donasi', 1, 4),
(46, 'Gaji', 0, 0),
(47, 'Bonus', 0, 0),
(48, 'Tunjangan Hari Raya', 0, 0),
(49, 'Lain-lain', 1, 1),
(50, 'Lain-lain', 1, 2),
(51, 'Lain-lain', 1, 3),
(52, 'Lain-lain', 1, 4),
(53, 'Lain-lain', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `pembicara` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `tipe` int(11) NOT NULL COMMENT '1 : online\r\n2 : offline',
  `lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `tanggal_pelaksanaan`, `kapasitas`, `pembicara`, `deskripsi`, `tipe`, `lokasi`) VALUES
(1, 'Financial Management for Undergraduates', '2022-06-15', 100, 'Doddy Prayogo', 'Kelas investasi untuk para mahasiswa', 1, 'Zoom'),
(2, 'Apa itu crypto?', '2022-06-28', 150, 'Orang ahli', 'Kelas pengenalan mengenai cyrpto dan bagaimana cara melakukan investasi yang baik dan benar pada market.', 2, 'Jalan Bersama Dia No. 22, Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

DROP TABLE IF EXISTS `kelompok`;
CREATE TABLE `kelompok` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelompok`
--

INSERT INTO `kelompok` (`id`, `nama`) VALUES
(0, 'Pemasukan'),
(1, 'Kebutuhan'),
(2, 'Keinginan'),
(3, 'Investasi/Tabungan'),
(4, 'Sedekah');

-- --------------------------------------------------------

--
-- Table structure for table `limit_user`
--

DROP TABLE IF EXISTS `limit_user`;
CREATE TABLE `limit_user` (
  `id` int(11) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `jumlah_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `limit_user`
--

INSERT INTO `limit_user` (`id`, `email_user`, `id_kategori`, `jumlah_limit`) VALUES
(1, 'c@gmail.com', 7, 1000000),
(2, 'c@gmail.com', 16, 10000000);

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

DROP TABLE IF EXISTS `pemasukan`;
CREATE TABLE `pemasukan` (
  `id` int(11) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemasukan`
--

INSERT INTO `pemasukan` (`id`, `email_user`, `jumlah`, `tanggal`, `id_kategori`, `note`) VALUES
(1, 'b@gmail.com', 1500000, '2022-05-01', 47, 'THR Idul Fitri'),
(2, 'c@gmail.com', 2000000, '2022-05-02', 47, 'Nemu di jalan'),
(3, 'b@gmail.com', 30000, '2022-05-10', 47, 'bonus'),
(4, 'b@gmail.com', 100000, '2022-05-09', 47, 'bonus'),
(5, 'b@gmail.com', 5500000, '2022-03-02', 46, 'Gaji Bulanan'),
(6, 'c@gmail.com', 7650000, '2022-03-17', 46, 'Gaji Bulanan'),
(7, 'b@gmail.com', 8350000, '2022-06-01', 46, 'Gaji Bulan Mei'),
(8, 'b@gmail.com', 7560000, '2022-06-01', 53, 'Nemu di jalan'),
(9, 'b@gmail.com', 1500000, '2022-06-02', 47, 'Bonus lembur gan'),
(10, 'c@gmail.com', 6450000, '2022-06-01', 46, 'Gaji Bulan Mei'),
(12, 'c@gmail.com', 2340000, '2022-06-01', 47, 'Bonus lembur sis'),
(13, 'c@gmail.com', 4725000, '2022-06-02', 53, 'Dikasih temen');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `email_user`, `jumlah`, `tanggal`, `id_kategori`, `note`) VALUES
(1, 'b@gmail.com', 75000, '2022-02-02', 20, 'Makan bersama teman SMA'),
(2, 'c@gmail.com', 2000000, '2022-02-03', 6, 'Cicilan motor'),
(3, 'b@gmail.com', 10000000, '2022-02-06', 7, 'Bayar uang sekolah anak'),
(4, 'b@gmail.com', 2000000, '2022-03-07', 27, 'Beli reksadana saham idx30'),
(6, 'b@gmail.com', 1000000, '2022-03-08', 34, 'Beri bantuan ke panti asuhan sedekah kasih'),
(7, 'b@gmail.com', 6550000, '2022-03-30', 11, 'Bayar PBB'),
(9, 'c@gmail.com', 750000, '2022-03-22', 35, 'Beri sumbangan ke gereja'),
(10, 'c@gmail.com', 4859000, '2022-03-23', 16, 'Beli rak sepatu dan rak TV'),
(11, 'c@gmail.com', 89000, '2022-04-12', 5, NULL),
(12, 'c@gmail.com', 500000, '2022-04-19', 21, 'Beli alat memancing'),
(13, 'c@gmail.com', 5000000, '2022-05-29', 15, 'Pergi umroh sekeluarga'),
(14, 'c@gmail.com', 300000, '2022-05-28', 22, 'Shopping buat umroh'),
(15, 'b@gmail.com', 83000000, '2022-06-02', 29, 'Beli NFT pertama guys'),
(16, 'b@gmail.com', 97000, '2022-06-02', 5, 'Makan di mall'),
(17, 'b@gmail.com', 15733000, '2022-06-03', 24, 'Liburan ke antah berantah'),
(18, 'b@gmail.com', 10000000, '2022-06-03', 35, 'Beri sumbangan'),
(19, 'c@gmail.com', 2430000, '2022-06-02', 25, 'Beli saham bbca'),
(20, 'c@gmail.com', 530000, '2022-06-04', 12, 'Bayar tagihan'),
(21, 'c@gmail.com', 734999, '2022-06-04', 22, 'Shopping sis'),
(22, 'c@gmail.com', 3750000, '2022-06-04', 38, 'Kasih sumbangan');

-- --------------------------------------------------------

--
-- Table structure for table `registrasi_kelas`
--

DROP TABLE IF EXISTS `registrasi_kelas`;
CREATE TABLE `registrasi_kelas` (
  `id` int(11) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `id_kelas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registrasi_kelas`
--

INSERT INTO `registrasi_kelas` (`id`, `email_user`, `id_kelas`) VALUES
(1, 'b@gmail.com', 1),
(2, 'c@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `total` int(11) NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `id_user_voucher` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0 : pending\r\n1 : accepted\r\n2 : canceled\r\n3 : failed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `total`, `email_user`, `id_user_voucher`, `status`) VALUES
(1, '2022-04-30', 120000, 'c@gmail.com', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `email` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(150) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `status` int(1) NOT NULL COMMENT '-1 : Belum verifikasi\r\n0 : admin\r\n1 : basic\r\n2 : premium',
  `exp_sub` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `nama`, `tanggal_lahir`, `status`, `exp_sub`) VALUES
('a@gmail.com', '$2y$10$15ZlKpYEdxATj8VjTBlHIu2kq6zFkbslEAihhq7eyM78l/l1CQBla', 'Aaaa Aaaa', '1997-05-14', 0, '1945-01-01'),
('akundqlabid@gmail.com', '$2y$10$Tp39I.hRzvtMhFYrx.Hrhu2d8UJ77FClYpeORUoNz.rbp.iwYyu8S', 'Michael Kevin Wijaya', '2000-01-28', -1, '0000-00-00'),
('b@gmail.com', '$2y$10$15ZlKpYEdxATj8VjTBlHIu2kq6zFkbslEAihhq7eyM78l/l1CQBla', 'Bbbb Bbbb', '1992-09-12', 1, '1945-08-17'),
('c@gmail.com', '$2y$10$15ZlKpYEdxATj8VjTBlHIu2kq6zFkbslEAihhq7eyM78l/l1CQBla', 'Cccc Cccc', '1982-05-29', 2, '2022-05-03'),
('d@gmail.com', '$2y$10$15ZlKpYEdxATj8VjTBlHIu2kq6zFkbslEAihhq7eyM78l/l1CQBla', 'Dddd Dddd', '1992-02-21', -1, '1945-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `user_validation`
--

DROP TABLE IF EXISTS `user_validation`;
CREATE TABLE `user_validation` (
  `kode` text NOT NULL,
  `email_user` varchar(150) NOT NULL,
  `waktu_exp` datetime NOT NULL,
  `tipe` int(11) NOT NULL COMMENT '0 : registrasi\r\n1 : forget password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_validation`
--

INSERT INTO `user_validation` (`kode`, `email_user`, `waktu_exp`, `tipe`) VALUES
('UAxrZiBfMuaCtYuXJgze', 'akundqlabid@gmail.com', '2022-05-29 13:46:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_voucher`
--

DROP TABLE IF EXISTS `user_voucher`;
CREATE TABLE `user_voucher` (
  `email_user` int(11) NOT NULL,
  `id_voucher` int(11) NOT NULL,
  `exp_date` date NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 : available\r\n1 : terpakai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

DROP TABLE IF EXISTS `voucher`;
CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `masa_berlaku` int(11) NOT NULL COMMENT 'dalam bulan',
  `batas_pemakaian` date NOT NULL,
  `potongan` int(11) NOT NULL COMMENT 'jika <= 100 berarti persen, jika > 100 berarti satuan ribu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id`, `nama`, `masa_berlaku`, `batas_pemakaian`, `potongan`) VALUES
(1, 'Voucher Lebaran 2022', 1, '2022-05-31', 40000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_membership`
--
ALTER TABLE `history_membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `limit_user`
--
ALTER TABLE `limit_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrasi_kelas`
--
ALTER TABLE `registrasi_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `history_membership`
--
ALTER TABLE `history_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `limit_user`
--
ALTER TABLE `limit_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `registrasi_kelas`
--
ALTER TABLE `registrasi_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
