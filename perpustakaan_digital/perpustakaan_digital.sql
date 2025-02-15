-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 07 Feb 2025 pada 16.55
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
-- Database: `perpustakaan_digital`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` int(11) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `tersedia` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `jumlah`, `tersedia`, `foto`) VALUES
(2, 'Matematika Diskrit', 'Eko Subagja', 'erlangga', 2020, 15, 14, 'ARSITEK.jpg'),
(3, 'Logika Matematika', 'jong jack siang', 'Andi Yogyakarta', 2013, 23, 22, 'logika metematika.jpeg'),
(4, 'Mesin Hybrid', 'Wahyudi, S.Pd., M.Eng Rizki Setiadi, S.Pd., M.T. Dr. Wirawan Sumbodo, M.T. Febrian Arif Budiman, M.P', 'pendidikan deepublish', 2020, 12, 11, 'mesin hybrid.jpeg'),
(7, 'Autodeks inventori prefossional 2014', 'Muas , A.M,Anzarih,Ahmad', 'April Surabaya', 2021, 5, 4, 'autodeks inventori professional 2014.jpeg'),
(8, 'Matematika Teknik', 'AGUS PRIJONO, HERI ANDRIANTO, M JIMMY HASUGIAN, RATNADEWI', 'Rekayasa Sains', 2019, 9, 9, 'matematika teknik.jpeg'),
(9, 'Aplikasi Komputer', 'Dwi Kribiantoro ,M.Kom', 'erlangga', 2023, 23, 22, 'aplikasi komputer.jpeg'),
(11, 'Dasar Listik dan Elektronika', 'jong jack siang', 'pendidikan deepublish', 2022, 8, 8, 'dasar listik & elektronika.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `aktivitas` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT 'dipinjam',
  `status_keterlambatan` enum('tepat_waktu','terlambat') DEFAULT 'tepat_waktu',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user_id`, `buku_id`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `status_keterlambatan`, `denda`) VALUES
(10, 3, 2, '2025-02-06', '2025-02-13', 'dikembalikan', 'tepat_waktu', 0),
(11, 3, 2, '2025-02-06', '2025-02-13', 'dipinjam', 'tepat_waktu', 0),
(12, 3, 7, '2025-02-06', '2025-02-13', 'dipinjam', 'tepat_waktu', 0),
(13, 4, 9, '2025-02-07', '2025-02-14', 'dipinjam', 'tepat_waktu', 0),
(14, 4, 4, '2025-02-07', '2025-02-14', 'dipinjam', 'tepat_waktu', 0),
(15, 4, 2, '2025-02-07', '2025-02-14', 'dipinjam', 'tepat_waktu', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nim` int(12) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('anggota','petugas','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nim`, `nama`, `jurusan`, `email`, `password`, `role`) VALUES
(1, NULL, 'qolbiyah', '', 'qolbi@gmail.com', '$2y$10$GipZf72obYM6c6nHDvuDXOe0Xa.4UnFfkxO3ww3gZgTYWe/PdZcjq', 'admin'),
(3, 220500003, 'pakih ramdani', 'teknik informatika', 'pakih@gmail.com', '$2y$10$DT/./17mmzDP4kAOn8cQ3ugUk3yhYgRJdJIse57RIlklZpNxz8zb.', 'anggota'),
(4, 220100001, 'amelia putri', 'teknik industri', 'amelia@gmail.com', '$2y$10$tF45hFQ4hVsPnZN7ajPoC.N7TTW12V0qQ4dMVgp63/EVWFUNYdhgS', 'anggota'),
(5, 220500002, 'fatimah azzahra', 'teknik informatika', 'fatimah@gmail.com', '', 'anggota'),
(8, 42, 'ibnu', 'www', 'ibnu@gmail.com', '$2y$10$nW4oHD/OJ7hyFOwYiL7Jge0F3W.t8mR387c2e.PufOmeHArZYrysa', 'petugas'),
(10, 220500004, 'Khaerunisa', 'teknik industri', 'nisa@gmail.com', '', 'anggota');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
