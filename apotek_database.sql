-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 12 Jan 2026 pada 00.26
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek_sql`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `month`
--

CREATE TABLE `month` (
  `month_num` int(2) NOT NULL,
  `month_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`id`, `nama_barang`, `satuan`, `pemasukan`, `pengeluaran`, `stok_terakhir`, `tanggal`, `kategori`, `status_id`) VALUES
(8, 'Salbutamol', 'Sirup', '42000', NULL, '9', '2022-06-09', 'Antioksidan', 'pembelian'),
(10, 'Adrome', 'Kapsul', NULL, '30000', '4946', '2022-06-15', 'Stimulan', 'penjualan'),
(11, 'Salbutamol', 'Sirup', NULL, '30000', '9', '2022-06-10', 'Antioksidan', 'penjualan'),
(12, 'amoxcilin', '4', '77000', NULL, '20', '2025-12-16', '217', 'pembelian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_cat`
--

CREATE TABLE `table_cat` (
  `id_kat` int(3) NOT NULL,
  `nama_kategori` varchar(30) NOT NULL,
  `des_kat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `table_cat`
--

INSERT INTO `table_cat` (`id_kat`, `nama_kategori`, `des_kat`) VALUES
(208, 'Anti Depresan', 'Mengurangi depresi'),
(209, 'Vitamin', 'Suplemen'),
(216, 'Stimulan', 'Menstimulasi hewan'),
(217, 'Antibiotik', 'bakteriostatik'),
(222, 'Hemolitika', 'Menghentikan pendarahan'),
(225, 'Antioksidan1', 'Untuk antioksidan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_invoice`
--

CREATE TABLE `table_invoice` (
  `id_tagihan` int(5) NOT NULL,
  `id_stok` int(11) NOT NULL,
  `ref` varchar(10) NOT NULL,
  `nama_obat` varchar(30) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `banyak` int(3) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `nama_pemasok` varchar(30) NOT NULL,
  `nama_pembeli` varchar(40) NOT NULL,
  `tgl_beli` date NOT NULL,
  `grandtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `table_invoice`
--

INSERT INTO `table_invoice` (`id_tagihan`, `id_stok`, `ref`, `nama_obat`, `harga_jual`, `banyak`, `subtotal`, `nama_pemasok`, `nama_pembeli`, `tgl_beli`, `grandtotal`) VALUES
(182, 27, 'INV694fcf8', '', 5000, 1, 5000, '', 'utami', '2025-12-27', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_med`
--

CREATE TABLE `table_med` (
  `id_obat` int(4) NOT NULL,
  `nama_obat` varchar(30) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `nama_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `table_med`
--

INSERT INTO `table_med` (`id_obat`, `nama_obat`, `unit`, `nama_kategori`) VALUES
(1056, 'promag', '4', '208'),
(1059, 'milanta', '3', '209'),
(1060, 'amoxcilin', '4', '217'),
(1061, 'Vitamin B', '4', '209'),
(1063, 'paracetamol', '4', '217');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_med_stok`
--

CREATE TABLE `table_med_stok` (
  `id_stok` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `id_pembelian` int(5) NOT NULL,
  `nama_pemasok` varchar(100) DEFAULT NULL,
  `stok` int(11) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `kedaluwarsa` date DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `table_med_stok`
--

INSERT INTO `table_med_stok` (`id_stok`, `id_obat`, `id_pembelian`, `nama_pemasok`, `stok`, `harga_beli`, `harga_jual`, `kedaluwarsa`, `lokasi`) VALUES
(25, 1060, 75, 'Bina Jaya Apotek', 4, 4000.00, 5000.00, '2027-11-13', NULL),
(27, 1060, 77, 'Bina Jaya Apotek', 0, 4000.00, 5000.00, '2026-05-16', NULL),
(28, 1056, 78, 'Tina Farma', 2, 5000.00, 6000.00, '2026-01-31', NULL),
(29, 1056, 79, 'Surya Farmasi', 1, 5000.00, 6000.00, '2025-12-27', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_purchase`
--

CREATE TABLE `table_purchase` (
  `id_pembelian` int(5) NOT NULL,
  `ref` varchar(10) NOT NULL,
  `nama_pemasok` varchar(40) NOT NULL,
  `tgl_beli` date NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `table_purchase`
--

INSERT INTO `table_purchase` (`id_pembelian`, `ref`, `nama_pemasok`, `tgl_beli`, `grandtotal`, `created_at`) VALUES
(75, 'PB20251227', 'Bina Jaya Apotek', '2025-12-27', 16000, '2025-12-27 02:16:44'),
(77, 'PB20251227', 'Bina Jaya Apotek', '2025-12-27', 4000, '2025-12-27 04:53:30'),
(78, 'PB20251227', 'Tina Farma', '2025-12-27', 10000, '2025-12-27 04:55:22'),
(79, 'PB20251227', 'Surya Farmasi', '2025-12-27', 5000, '2025-12-27 04:59:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_purchase_detail`
--

CREATE TABLE `table_purchase_detail` (
  `id_detail` int(11) NOT NULL,
  `id_pembelian` int(5) NOT NULL,
  `ref` varchar(30) NOT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `nama_obat` varchar(30) NOT NULL,
  `banyak` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `table_purchase_detail`
--

INSERT INTO `table_purchase_detail` (`id_detail`, `id_pembelian`, `ref`, `id_obat`, `nama_obat`, `banyak`, `harga_beli`, `subtotal`, `created_at`) VALUES
(38, 75, '', 1060, 'amoxcilin', 4, 4000, 16000, '2025-12-27 09:16:44'),
(40, 77, '', 1060, 'amoxcilin', 1, 4000, 4000, '2025-12-27 11:53:30'),
(41, 78, '', 1056, 'promag', 2, 5000, 10000, '2025-12-27 11:55:22'),
(42, 79, '', 1056, 'promag', 1, 5000, 5000, '2025-12-27 11:59:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_sup`
--

CREATE TABLE `table_sup` (
  `id_pem` int(3) NOT NULL,
  `nama_pemasok` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `table_sup`
--

INSERT INTO `table_sup` (`id_pem`, `nama_pemasok`, `alamat`, `telepon`) VALUES
(101, 'Bina Jaya Apotek', 'Jalan Kaliurang KM 8', '089693330253'),
(103, 'Kimia Farma', 'Jalan Kaliurang', '02574555'),
(104, 'Tina Farma', 'Jalan Kaliurang', '08775544'),
(105, 'Kenanga Apotek', 'Jalan Magelang', '08965555'),
(108, 'Surya Farmasi', 'Jalan Magelang KM 9', '08546677790'),
(111, 'Apotek Farmasi', 'Surabaya, Jawa Barat', '1234567889');

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_unit`
--

CREATE TABLE `table_unit` (
  `id_unit` int(2) NOT NULL,
  `unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `table_unit`
--

INSERT INTO `table_unit` (`id_unit`, `unit`) VALUES
(2, 'Semprot'),
(9, 'Serbuk'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `pass`, `no_hp`, `level_id`) VALUES
(9, 'Utami', 'admin2', '$2y$10$cFufL/9.OW.fcrASS9Nq3u2T8mJ26q8WcCJbe0hMwjeaPqJ2N9Ore', '', 'pemilik');

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
  ADD UNIQUE KEY `fk_cat` (`nama_kategori`);

--
-- Indeks untuk tabel `table_invoice`
--
ALTER TABLE `table_invoice`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `fk_inv_sup` (`nama_pemasok`),
  ADD KEY `fk_id_stok` (`id_stok`);

--
-- Indeks untuk tabel `table_med`
--
ALTER TABLE `table_med`
  ADD PRIMARY KEY (`id_obat`),
  ADD UNIQUE KEY `nama_obat` (`nama_obat`),
  ADD KEY `med_unit` (`unit`),
  ADD KEY `fk_med_cat` (`nama_kategori`);

--
-- Indeks untuk tabel `table_med_stok`
--
ALTER TABLE `table_med_stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `fk_stok_pembelian` (`id_pembelian`);

--
-- Indeks untuk tabel `table_purchase`
--
ALTER TABLE `table_purchase`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `table_purchase_detail`
--
ALTER TABLE `table_purchase_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `fk_pembelian` (`id_pembelian`);

--
-- Indeks untuk tabel `table_sup`
--
ALTER TABLE `table_sup`
  ADD PRIMARY KEY (`id_pem`),
  ADD KEY `fk_med_sup` (`nama_pemasok`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `table_cat`
--
ALTER TABLE `table_cat`
  MODIFY `id_kat` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT untuk tabel `table_invoice`
--
ALTER TABLE `table_invoice`
  MODIFY `id_tagihan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT untuk tabel `table_med`
--
ALTER TABLE `table_med`
  MODIFY `id_obat` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1064;

--
-- AUTO_INCREMENT untuk tabel `table_med_stok`
--
ALTER TABLE `table_med_stok`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `table_purchase`
--
ALTER TABLE `table_purchase`
  MODIFY `id_pembelian` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT untuk tabel `table_purchase_detail`
--
ALTER TABLE `table_purchase_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `table_sup`
--
ALTER TABLE `table_sup`
  MODIFY `id_pem` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT untuk tabel `table_unit`
--
ALTER TABLE `table_unit`
  MODIFY `id_unit` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `table_invoice`
--
ALTER TABLE `table_invoice`
  ADD CONSTRAINT `fk_id_stok` FOREIGN KEY (`id_stok`) REFERENCES `table_med_stok` (`id_stok`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stok_penjualan` FOREIGN KEY (`id_stok`) REFERENCES `table_med_stok` (`id_stok`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `table_med_stok`
--
ALTER TABLE `table_med_stok`
  ADD CONSTRAINT `fk_stok_pembelian` FOREIGN KEY (`id_pembelian`) REFERENCES `table_purchase` (`id_pembelian`) ON DELETE CASCADE,
  ADD CONSTRAINT `table_med_stok_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `table_med` (`id_obat`);

--
-- Ketidakleluasaan untuk tabel `table_purchase_detail`
--
ALTER TABLE `table_purchase_detail`
  ADD CONSTRAINT `fk_pembelian` FOREIGN KEY (`id_pembelian`) REFERENCES `table_purchase` (`id_pembelian`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
