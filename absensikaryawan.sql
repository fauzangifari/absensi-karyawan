-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Apr 2024 pada 03.08
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensikaryawan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen`
--

CREATE TABLE `absen` (
  `id_absen` char(10) NOT NULL,
  `username_karyawan` char(10) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `tanggal_absen` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_keluar` time NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `alasan` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absen`
--

INSERT INTO `absen` (`id_absen`, `username_karyawan`, `nama_karyawan`, `tanggal_absen`, `jam_masuk`, `jam_keluar`, `keterangan`, `alasan`, `file`) VALUES
('ABS_1162_2', 'fauzan', 'Fauzan Gifari', '2024-04-08', '05:09:00', '16:00:00', 'Hadir', '', ''),
('ABS_4182_2', 'haykal', 'Haykal Fajjar', '2024-04-07', '17:51:38', '16:00:00', 'Izin', '', 'ano.jpg'),
('ABS_9991_2', 'fauzan', 'Fauzan Gifari', '2024-04-07', '18:01:53', '16:00:00', 'Sakit', '', 'Cover-Page-Template-6-TemplateLab.docx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `username` char(50) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`username`, `nama_admin`, `password`) VALUES
('admin', 'Fauzan Gifari', '$2a$12$pQbSj2nFVMWgNFkCh6X.hujPQMM5BhiS8q/4vUuKBUxmbMVdFPQ9K');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `username` char(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `alamat_karyawan` varchar(100) NOT NULL,
  `no_telp_karyawan` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`username`, `password`, `nama_karyawan`, `alamat_karyawan`, `no_telp_karyawan`) VALUES
('ambatron', '$2y$10$OrMildZCofbjCb7fIPDfoe24Y4p22cWXjL2so4xWoLy11/l.wd4yy', 'Professor Ambatusyam', 'Jl. Ngawii', '081239472492'),
('dinnu', '$2y$10$s3PVf3gydoJwZ1GjB3XEhOYbU43NbTugeIWA6TPla8wgNeqWf9b5q', 'Dinnuhoni Trahutomo', 'Jl. Wiragunaa', '123456789'),
('fauzan', '$2y$10$BggAnxf0T08WOKDuJ87w.e.KOJwa9JXRU4MGY5VnjlWrQCHOyCa/y', 'Fauzan Gifari', 'Jl. Juanda 4', '123456'),
('haykal', '$2y$10$UHNli44N45knfN3PznOuouhwUWQxtLDJAJddHDEevfjgsZ2JQSlnG', 'Haykal Fajjar', 'Jl. Antasari', '123456789'),
('leeway', '$2y$10$wPZkoOFj/ni4a1qn8AVufOsQ6ue1Niw.6bQPQTJTySNox3KLWb9u6', 'Abdul Rahman', 'Jl. Lempake', '12345');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manajer`
--

CREATE TABLE `manajer` (
  `username` char(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_manajer` varchar(100) NOT NULL,
  `alamat_manajer` varchar(100) NOT NULL,
  `no_telp_manajer` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manajer`
--

INSERT INTO `manajer` (`username`, `password`, `nama_manajer`, `alamat_manajer`, `no_telp_manajer`) VALUES
('mei', '$2y$10$./zhtsHrZ8I9acZEJGPdP.du8z6DDBJVxRcC7RVxghKIlUE7KSKDG', 'Mei Nagano', 'Jl. Juanda 40', '12345');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id_session` char(10) NOT NULL,
  `username` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id_session`, `username`) VALUES
('SSN_9128', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `manajer`
--
ALTER TABLE `manajer`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id_session`),
  ADD UNIQUE KEY `id_session` (`id_session`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
