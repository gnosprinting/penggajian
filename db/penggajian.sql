-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 08, 2019 at 02:13 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penggajian`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
CREATE TABLE IF NOT EXISTS `absensi` (
  `id_absensi` int(11) NOT NULL AUTO_INCREMENT,
  `nip` int(11) NOT NULL,
  `kehadiran` varchar(10) NOT NULL,
  `waktu_masuk` time NOT NULL,
  `waktu_keluar` time NOT NULL,
  `tgl_absensi` date NOT NULL,
  PRIMARY KEY (`id_absensi`),
  KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `nip`, `kehadiran`, `waktu_masuk`, `waktu_keluar`, `tgl_absensi`) VALUES
(1, 12345, 'Hadir', '08:00:00', '19:00:00', '2014-06-02'),
(2, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-02'),
(3, 12345, 'Hadir', '08:00:00', '19:00:00', '2014-06-03'),
(5, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-03'),
(6, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-04'),
(7, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-04'),
(8, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-05'),
(9, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-05'),
(10, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-06'),
(11, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-06'),
(12, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-07'),
(13, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-07'),
(14, 12345, 'Sakit', '08:00:00', '16:00:00', '2014-06-09'),
(15, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-09'),
(16, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-10'),
(17, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-10'),
(18, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-11'),
(19, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-11'),
(20, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-12'),
(21, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-12'),
(22, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-13'),
(23, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-13'),
(24, 12345, 'Ijin', '08:00:00', '16:00:00', '2014-06-14'),
(25, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-14'),
(26, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-16'),
(27, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-16'),
(28, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-17'),
(29, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-17'),
(30, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-18'),
(31, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-18'),
(32, 12345, '', '08:00:00', '16:00:00', '2014-06-19'),
(33, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-19'),
(34, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-20'),
(35, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-20'),
(36, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-21'),
(37, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-21'),
(38, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-22'),
(39, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-22'),
(40, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-23'),
(41, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-23'),
(42, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-24'),
(43, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-24'),
(44, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-25'),
(45, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-25'),
(46, 12345, 'Cuti', '08:00:00', '16:00:00', '2014-06-26'),
(47, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-26'),
(48, 12345, 'Cuti', '08:00:00', '16:00:00', '2014-06-27'),
(49, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-27'),
(50, 12345, 'Cuti', '08:00:00', '16:00:00', '2014-06-28'),
(51, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-28'),
(52, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-29'),
(53, 1234567, 'Hadir', '08:00:00', '16:00:00', '2014-06-30'),
(54, 12345, 'Hadir', '08:00:00', '16:00:00', '2014-06-30'),
(55, 12345, 'Hadir', '07:00:00', '20:00:00', '2014-06-30'),
(56, 12345, 'Alpha', '08:00:00', '16:00:00', '2019-08-06'),
(57, 123123, 'Hadir', '08:00:00', '16:00:00', '2019-08-06'),
(59, 1234567, 'Sakit', '08:00:00', '16:00:00', '2019-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `gaji`
--

DROP TABLE IF EXISTS `gaji`;
CREATE TABLE IF NOT EXISTS `gaji` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bulan` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `gapok` int(11) NOT NULL,
  `total_gaji` int(11) NOT NULL,
  `tgl_gaji` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gaji`
--

INSERT INTO `gaji` (`id`, `bulan`, `tahun`, `nip`, `gapok`, `total_gaji`, `tgl_gaji`) VALUES
(3, '08', 2019, '123123', 3000000, 125385, '2019-08-08 01:10:26'),
(4, '06', 2014, '12345', 5000000, 4302885, '2019-08-07 12:45:08'),
(5, '08', 2019, '12345', 5000000, 0, '2019-08-07 13:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE IF NOT EXISTS `jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(40) NOT NULL,
  `gapok` int(12) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `gapok`) VALUES
(1, 'Staff Keuangan', 5000000),
(2, 'Staff Personalia', 2000000),
(3, 'Staff Operator', 1500000),
(4, 'Kepala Dinas', 6000000),
(5, 'Sekretaris', 5000000),
(6, 'ob', 1000000),
(7, 'Programmer', 3000000);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_tunjangan`
--

DROP TABLE IF EXISTS `jenis_tunjangan`;
CREATE TABLE IF NOT EXISTS `jenis_tunjangan` (
  `id_jenis_tunjangan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_tunjangan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jenis_tunjangan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_tunjangan`
--

INSERT INTO `jenis_tunjangan` (`id_jenis_tunjangan`, `nama_jenis_tunjangan`) VALUES
(5, 'Hari Raya');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

DROP TABLE IF EXISTS `karyawan`;
CREATE TABLE IF NOT EXISTS `karyawan` (
  `nip` int(11) NOT NULL AUTO_INCREMENT,
  `nama_karyawan` varchar(50) NOT NULL,
  `jk` varchar(12) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `agama` varchar(10) NOT NULL,
  `alamat_karyawan` text NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  PRIMARY KEY (`nip`),
  KEY `id_jabatan` (`id_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=1234568 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nip`, `nama_karyawan`, `jk`, `tempat_lahir`, `tgl_lahir`, `agama`, `alamat_karyawan`, `telp`, `email`, `password`, `foto`, `id_jabatan`) VALUES
(12345, 'Dr. Ir. Oviyan Patra, MT.', 'Laki-laki', 'Bandung', '1965-06-06', 'Islam', '  <p>Bandung</p>    ', '0855555554', 'cheppy_sahari@yahoo.com', '202cb962ac59075b964b07152d234b70', 'file/foto_karyawan/default_user.png', 1),
(123123, 'Anjar', 'Laki-laki', 'Martapura', '1996-01-17', 'Islam', 'Al-Ichwan', '082211334545', 'anjar.hexacore@gmail.com', '4297f44b13955235245b2497399d7a93', 'file/foto_karyawan/123123.png', 7),
(321321, 'Johan Arifin', 'Laki-laki', 'Tanjung', '1965-06-06', 'Islam', '-', '0855555554', 'cheppy_sahari@yahoo.com', '3d186804534370c3c817db0563f0e461', 'file/foto_karyawan/321321.png', 4),
(1234567, 'Udin', 'Laki-laki', 'Bandung', '1985-06-02', 'Islam', '<p>Bandung</p>', '0855555555', 'cheppy_sahari@yahoo.com', 'fcea920f7412b5da7be0cf42b8c93759', 'file/foto_karyawan/1234567.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tunjangan_jabatan`
--

DROP TABLE IF EXISTS `tunjangan_jabatan`;
CREATE TABLE IF NOT EXISTS `tunjangan_jabatan` (
  `id_tunjangan_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `id_jenis_tunjangan` int(11) NOT NULL,
  `nip` int(11) NOT NULL,
  `besar_tunjangan` double NOT NULL,
  PRIMARY KEY (`id_tunjangan_jabatan`),
  KEY `nip` (`nip`),
  KEY `id_jenis_tunjangan` (`id_jenis_tunjangan`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tunjangan_jabatan`
--

INSERT INTO `tunjangan_jabatan` (`id_tunjangan_jabatan`, `id_jenis_tunjangan`, `nip`, `besar_tunjangan`) VALUES
(12, 5, 123123, 10000);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `nip` FOREIGN KEY (`nip`) REFERENCES `karyawan` (`nip`) ON UPDATE CASCADE;

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON UPDATE CASCADE;

--
-- Constraints for table `tunjangan_jabatan`
--
ALTER TABLE `tunjangan_jabatan`
  ADD CONSTRAINT `tunjangan_jabatan_ibfk_1` FOREIGN KEY (`id_jenis_tunjangan`) REFERENCES `jenis_tunjangan` (`id_jenis_tunjangan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tunjangan_jabatan_ibfk_2` FOREIGN KEY (`nip`) REFERENCES `karyawan` (`nip`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
