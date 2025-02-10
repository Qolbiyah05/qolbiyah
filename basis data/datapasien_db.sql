-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Feb 2025 pada 20.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datapasien_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `password` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'qolbiyah', 'qolbi123'),
(2, 'fieto', 'fieto123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int(11) NOT NULL,
  `kode_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(50) NOT NULL,
  `alamat_dokter` varchar(250) NOT NULL,
  `no_telp` int(13) NOT NULL,
  `spesialis` int(50) NOT NULL,
  `foto` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_bpjs` varchar(20) DEFAULT NULL,
  `tgl_lahir` date NOT NULL,
  `nik` varchar(16) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `no_bpjs`, `tgl_lahir`, `nik`, `alamat`) VALUES
(2, 'Ani Wijaya', '2345678901234567', '1990-08-22', '3201019008220002', 'Jl. Sudirman No. 45, Bandung jawa barat'),
(3, 'ipul bagas', '234444456222', '2000-05-16', '32083456770000', 'Jln raya Ciledug- kuningan'),
(4, 'Sumiyati', '4277980000', '1996-05-02', '32022677990096', 'pabedilan-cirebon'),
(5, 'amelia putri', '22659000', '2002-07-06', '3208666670002', 'pabuaran-cirebon'),
(7, 'Widiyaningsih', '23499900', '1998-12-09', '32042281200098', 'jln. supratman no.9 dudukan, semarang'),
(11, 'ipul bagas', '329800003', '2003-07-15', '325600001', 'ciledug-cirebon'),
(14, 'keisha', '229000003', '2003-04-12', '32089000012', 'jatimulya-cidahu'),
(21, 'palih ramdani', '320890001', '2008-10-29', '32100009', 'ciledug-cirebon'),
(24, 'ibnu malik', '220100001', '1998-09-22', '320100001', 'Jln raya Ciledug- kuningan'),
(25, 'qolbiyah', '220100004', '2001-08-04', '320100004', 'Jln raya Ciledug- kuningan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_non-bpjs`
--

CREATE TABLE `pasien_non-bpjs` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `NIK` varchar(50) NOT NULL,
  `alamat` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien_non-bpjs`
--

INSERT INTO `pasien_non-bpjs` (`id`, `nama`, `tgl_lahir`, `NIK`, `alamat`) VALUES
(0, 'amira', '1999-09-22', '320100006', 'ciledug-cirebon'),
(1, 'dadang', '1983-03-11', '320008976', 'jln.pemuda no2 , babakan gebang, cirebon'),
(2, 'sumiyati', '1995-02-06', '32000001', 'pabuaran no.32 cirebon'),
(3, 'supriyanto', '1998-04-04', '32000005', 'jln.hijau no.9 cilengsi, bandung');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`),
  ADD UNIQUE KEY `id_dokter` (`id_dokter`),
  ADD UNIQUE KEY `kode_dokter` (`kode_dokter`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_bpjs` (`no_bpjs`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indeks untuk tabel `pasien_non-bpjs`
--
ALTER TABLE `pasien_non-bpjs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`),
  ADD UNIQUE KEY `NIK` (`NIK`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
