-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jun 2022 pada 10.39
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `month`
--

CREATE TABLE `month` (
  `month_num` int(2) NOT NULL,
  `month_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `month`
--

INSERT INTO `month` (`month_num`, `month_name`) VALUES
(1, 'Januari'),
(2, 'Februari'),
(3, 'Maret'),
(4, 'April'),
(5, 'Mei'),
(6, 'Juni'),
(7, 'Juli'),
(8, 'Agustus'),
(9, 'September'),
(10, 'Oktober'),
(11, 'November'),
(12, 'Desember');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `kode_satuan` int(11) NOT NULL,
  `satuan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `pemasukan` varchar(255) DEFAULT NULL,
  `pengeluaran` varchar(255) DEFAULT NULL,
  `stok_terakhir` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `status_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`id`, `nama_barang`, `satuan`, `pemasukan`, `pengeluaran`, `stok_terakhir`, `tanggal`, `kategori`, `status_id`) VALUES
(8, 'Salbutamol', 'Sirup', '42000', NULL, '9', '2022-06-09', 'Antioksidan', 'pembelian'),
(10, 'Adrome', 'Kapsul', NULL, '30000', '4946', '2022-06-15', 'Stimulan', 'penjualan'),
(11, 'Salbutamol', 'Sirup', NULL, '30000', '9', '2022-06-10', 'Antioksidan', 'penjualan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_cat`
--

CREATE TABLE `table_cat` (
  `id_kat` int(3) NOT NULL,
  `nama_kategori` varchar(30) NOT NULL,
  `des_kat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `table_cat`
--

INSERT INTO `table_cat` (`id_kat`, `nama_kategori`, `des_kat`) VALUES
(201, 'Anti Radang', 'Melegakan peradangan'),
(207, 'Antioksidan', 'Mencegah penuaan dini'),
(208, 'Anti Depresan', 'Mengurangi depresi'),
(209, 'Vitamin', 'Suplemen'),
(216, 'Stimulan', 'Menstimulasi hewan'),
(217, 'Antibiotik', 'bakteriostatik'),
(222, 'Hemolitika', 'Menghentikan pendarahan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_invoice`
--

CREATE TABLE `table_invoice` (
  `id_tagihan` int(5) NOT NULL,
  `ref` varchar(10) NOT NULL,
  `nama_obat` varchar(30) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `banyak` int(3) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `nama_pembeli` varchar(40) NOT NULL,
  `tgl_beli` date NOT NULL,
  `grandtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `table_invoice`
--

INSERT INTO `table_invoice` (`id_tagihan`, `ref`, `nama_obat`, `harga_jual`, `banyak`, `subtotal`, `nama_pembeli`, `tgl_beli`, `grandtotal`) VALUES
(82, 'JMBSErmmo0', 'Salbutamol', 10000, 1, 10000, 'Melinda', '2022-06-12', 29000),
(87, 'xl23Q6whsP', 'Salbutamol', 10000, 3, 30000, 'Melinda', '2018-01-10', 30000),
(91, 'fAMEjr9rA0', 'Ambroxol', 22000, 5, 110000, 'Amirullah', '2018-03-14', 110000),
(92, 'so5518T1vI', 'Salbutamol', 10000, 6, 60000, 'Doni', '2018-04-18', 60000),
(97, 'VS27jjD5Ze', 'Ambroxol', 22000, 1, 22000, 'Pitaloka', '2018-07-18', 32000),
(101, 'e7QgBweE8X', 'Adrome', 15000, 1, 15000, 'Andi', '2018-09-15', 15000),
(105, 'zPpAfLsmd7', 'Adrome', 15000, 1, 15000, 'Amila', '2018-05-16', 25000),
(106, 'zPpAfLsmd7', 'Amoxilin', 10000, 1, 10000, 'Amila', '2018-05-16', 25000),
(120, 'FfndSkUmh6', 'Vitamin E', 4000, 1, 4000, 'Alina', '2018-09-24', 12000),
(123, 'fwkNWykQzc', 'Adrome', 15000, 3, 45000, 'Ani', '2022-06-15', 45000),
(124, 'fwkNWykQzc', 'Ambroxol', 22000, 1, 22000, 'Ibe', '2022-06-15', 97000),
(126, 'HOGjFY6D4J', 'Ambroxol', 22000, 1, 22000, 'ola', '2022-06-18', 97000),
(127, 'En39eM6K4J', 'Adrome', 15000, 2, 30000, 'kiki', '2022-06-19', 30000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_med`
--

CREATE TABLE `table_med` (
  `id_obat` int(4) NOT NULL,
  `nama_obat` varchar(30) NOT NULL,
  `penyimpanan` varchar(30) NOT NULL,
  `stok` int(3) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `nama_kategori` varchar(30) NOT NULL,
  `kedaluwarsa` date NOT NULL,
  `des_obat` text NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `nama_pemasok` varchar(30) NOT NULL,
  `gambar` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `table_med`
--

INSERT INTO `table_med` (`id_obat`, `nama_obat`, `penyimpanan`, `stok`, `unit`, `nama_kategori`, `kedaluwarsa`, `des_obat`, `harga_beli`, `harga_jual`, `nama_pemasok`, `gambar`) VALUES
(1016, 'Salbutamol', 'Gudang', 9, 'Sirup', 'Antioksidan', '2024-07-20', 'Tidak ada', 6000, 10000, 'Bina Jaya Apotek', ''),
(1018, 'Adrome', 'Gudang', 115, 'Kapsul', 'Stimulan', '2023-08-20', 'Tidak untuk kucing', 12000, 15000, 'Kenanga Apotek', ''),
(1023, 'Ambroxol', 'Lemari 1', 0, 'Semprot', 'Anti Radang', '2023-08-20', '', 20000, 22000, 'Kenanga Apotek', ''),
(1025, 'Amoxilin', 'Rak 1', 4, 'Semprot', 'Anti Radang', '2025-12-14', '', 7000, 10000, 'Tina Farma', ''),
(1026, 'Cetirizen', 'Rak 1', 0, 'Tablet', 'Anti Radang', '2023-01-20', '', 2000, 3000, 'Kenanga Apotek', ''),
(1027, 'Corovit', 'Gudang', 10, 'Tablet', 'Antioksidan', '2024-09-28', '', 2000, 3000, 'Kimia Farma', ''),
(1033, 'Vitamin E', 'Rak 1', 8, 'Tablet', 'Vitamin', '2025-01-23', '', 3000, 4000, 'Bina Jaya Apotek', ''),
(1036, 'Vitamin A', 'Rak 2', 10, 'Tablet', 'Vitamin', '2023-02-20', '', 3000, 4000, 'Bina Jaya Apotek', ''),
(1037, 'tumbuh', '2000', 10, 'Sirup', 'Anti Radang', '2025-06-14', '', 1000, 2000, 'Surya Farmasi', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_purchase`
--

CREATE TABLE `table_purchase` (
  `id_pembelian` int(5) NOT NULL,
  `ref` varchar(10) NOT NULL,
  `nama_obat` varchar(30) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `banyak` int(3) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `nama_pemasok` varchar(40) NOT NULL,
  `tgl_beli` date NOT NULL,
  `grandtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `table_purchase`
--

INSERT INTO `table_purchase` (`id_pembelian`, `ref`, `nama_obat`, `harga_beli`, `banyak`, `subtotal`, `nama_pemasok`, `tgl_beli`, `grandtotal`) VALUES
(3, 'L8BvtCyFDZ', 'Salbutamol', 6000, 3, 18000, 'Bina Jaya Apotek', '2022-06-09', 24000),
(9, '96kHYMepS9', 'Salbutamol', 6000, 7, 42000, 'Bina Jaya Apotek', '2018-03-21', 42000),
(10, 'Tbb6pLVCJr', 'Ambroxol', 20000, 4, 80000, 'Bina Jaya Apotek', '2018-01-24', 80000),
(12, 'aDxtUA0rsc', 'Adrome', 12000, 6, 72000, 'Bina Jaya Apotek', '2022-06-07', 72000),
(14, 'KCZxZ1MqID', 'Ambroxol', 20000, 2, 40000, 'Bina Jaya Apotek', '2018-07-18', 40000),
(15, 'Ar9235n1ny', 'Adrome', 12000, 3, 36000, 'Kenanga Apotek', '2018-06-06', 56000),
(16, 'Ar9235n1ny', 'Ambroxol', 20000, 1, 20000, 'Kenanga Apotek', '2018-06-06', 56000),
(25, 'q8ke6ToBMo', 'Cetirizen', 2000, 3, 6000, 'Kenanga Apotek', '2018-09-24', 6000),
(26, 'g9yOWKCbls', 'Adrome', 12000, 5, 60000, 'Kenanga Apotek', '2022-06-14', 60000),
(27, 'LaJwxG0tt0', 'Salbutamol', 6000, 2, 12000, 'Bina Jaya Apotek', '2022-06-15', 12000),
(28, 'MzwjSlLzIz', 'Salbutamol', 6000, 1, 6000, 'Bina Jaya Apotek', '2022-06-08', 6000),
(29, '95zbihejsy', 'Salbutamol', 6000, 1, 6000, 'Bina Jaya Apotek', '2022-06-15', 6000),
(30, 'BBjrPpxHLZ', 'Salbutamol', 6000, 1, 6000, 'Bina Jaya Apotek', '2022-06-15', 6000),
(31, '55t4EfR4C0', 'Salbutamol', 6000, 3, 18000, 'Bina Jaya Apotek', '2022-06-09', 18000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_sup`
--

CREATE TABLE `table_sup` (
  `id_pem` int(3) NOT NULL,
  `nama_pemasok` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `table_sup`
--

INSERT INTO `table_sup` (`id_pem`, `nama_pemasok`, `alamat`, `telepon`) VALUES
(101, 'Bina Jaya Apotek', 'Jalan Kaliurang KM 7', '089693330253'),
(103, 'Kimia Farma', 'Jalan Kaliurang', '02574555'),
(104, 'Tina Farma', 'Jalan Kaliurang', '08775544'),
(105, 'Kenanga Apotek', 'Jalan Magelang', '08965555'),
(108, 'Surya Farmasi', 'Jalan Magelang KM 9', '08546677790');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_unit`
--

CREATE TABLE `table_unit` (
  `id_unit` int(2) NOT NULL,
  `unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `table_unit`
--

INSERT INTO `table_unit` (`id_unit`, `unit`) VALUES
(1, 'Kapsul'),
(5, 'kapsul12'),
(2, 'Semprot'),
(3, 'Sirup'),
(4, 'Tablet');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `level_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `pass`, `no_hp`, `level_id`) VALUES
(1, 'Sabila', 'admin', 'admin', '08522873827', 'pemilik'),
(2, 'kasir', 'kasir', 'kasir', '08582387', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `month`
--
ALTER TABLE `month`
  ADD PRIMARY KEY (`month_num`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`kode_satuan`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `table_cat`
--
ALTER TABLE `table_cat`
  ADD PRIMARY KEY (`id_kat`),
  ADD UNIQUE KEY `kategori` (`nama_kategori`);

--
-- Indeks untuk tabel `table_invoice`
--
ALTER TABLE `table_invoice`
  ADD PRIMARY KEY (`id_tagihan`);

--
-- Indeks untuk tabel `table_med`
--
ALTER TABLE `table_med`
  ADD PRIMARY KEY (`id_obat`),
  ADD UNIQUE KEY `nama_obat` (`nama_obat`),
  ADD KEY `med_unit` (`unit`),
  ADD KEY `med_cat` (`nama_kategori`),
  ADD KEY `med_sup` (`nama_pemasok`);

--
-- Indeks untuk tabel `table_purchase`
--
ALTER TABLE `table_purchase`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `table_sup`
--
ALTER TABLE `table_sup`
  ADD PRIMARY KEY (`id_pem`),
  ADD UNIQUE KEY `nama_supplier` (`nama_pemasok`);

--
-- Indeks untuk tabel `table_unit`
--
ALTER TABLE `table_unit`
  ADD PRIMARY KEY (`id_unit`),
  ADD UNIQUE KEY `unit` (`unit`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `kode_satuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `table_cat`
--
ALTER TABLE `table_cat`
  MODIFY `id_kat` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT untuk tabel `table_invoice`
--
ALTER TABLE `table_invoice`
  MODIFY `id_tagihan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT untuk tabel `table_med`
--
ALTER TABLE `table_med`
  MODIFY `id_obat` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1040;

--
-- AUTO_INCREMENT untuk tabel `table_purchase`
--
ALTER TABLE `table_purchase`
  MODIFY `id_pembelian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `table_sup`
--
ALTER TABLE `table_sup`
  MODIFY `id_pem` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT untuk tabel `table_unit`
--
ALTER TABLE `table_unit`
  MODIFY `id_unit` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `table_med`
--
ALTER TABLE `table_med`
  ADD CONSTRAINT `med_cat` FOREIGN KEY (`nama_kategori`) REFERENCES `table_cat` (`nama_kategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `med_sup` FOREIGN KEY (`nama_pemasok`) REFERENCES `table_sup` (`nama_pemasok`) ON UPDATE CASCADE,
  ADD CONSTRAINT `med_unit` FOREIGN KEY (`unit`) REFERENCES `table_unit` (`unit`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
