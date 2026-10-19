-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: warkop_bahagia
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `data_products`
--

DROP TABLE IF EXISTS `data_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_products` (
  `id_data` varchar(11) NOT NULL,
  `aktivitas` varchar(50) NOT NULL,
  `id_produk` varchar(11) NOT NULL,
  `nama_produk` varchar(200) NOT NULL,
  `nama_kasir` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_data`),
  KEY `fk_data_produk` (`id_produk`),
  CONSTRAINT `fk_data_produk` FOREIGN KEY (`id_produk`) REFERENCES `products` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_products`
--

LOCK TABLES `data_products` WRITE;
/*!40000 ALTER TABLE `data_products` DISABLE KEYS */;
INSERT INTO `data_products` VALUES ('DAT0000001','Tambah Produk','PRD0000001','Nasi Goreng ','Kasir Demo','2026-07-01 07:39:25'),('DAT0000002','Tambah Produk','PRD0000002','Indomie Goreng Telor','Kasir Demo','2026-07-01 07:40:30'),('DAT0000003','Tambah Produk','PRD0000003','Indomie Rebus Telor','Kasir Demo','2026-07-01 07:41:13'),('DAT0000004','Tambah Produk','PRD0000004','Bubur Kacang Ijo','Kasir Demo','2026-07-01 07:42:04'),('DAT0000005','Tambah Produk','PRD0000005','Nasi Kucing','Kasir Demo','2026-07-01 07:42:49'),('DAT0000006','Tambah Produk','PRD0000006','Pancong Keju','Kasir Demo','2026-07-01 07:43:36'),('DAT0000007','Tambah Produk','PRD0000007','Roti Bakar Coklat','Kasir Demo','2026-07-01 07:45:14'),('DAT0000008','Tambah Produk','PRD0000008','Kentang Goreng','Kasir Demo','2026-07-01 07:46:05'),('DAT0000009','Tambah Produk','PRD0000009','Bakwan 1 Pcs','Kasir Demo','2026-07-01 07:51:04'),('DAT0000010','Tambah Produk','PRD0000010','Tempe 1 Pcs','Kasir Demo','2026-07-01 07:52:27'),('DAT0000011','Tambah Produk','PRD0000011','Tahu 1 Pcs','Kasir Demo','2026-07-01 07:52:52'),('DAT0000012','Tambah Produk','PRD0000012','Dimsum Mentai ','Kasir Demo','2026-07-01 07:53:28'),('DAT0000013','Tambah Produk','PRD0000013','Sate Telor 1 Pcs','Kasir Demo','2026-07-01 07:54:05'),('DAT0000014','Tambah Produk','PRD0000014','Sate Usus 1 Pcs','Kasir Demo','2026-07-01 07:54:35'),('DAT0000015','Tambah Produk','PRD0000015','Sate Ati Ampela 1 Pcs','Kasir Demo','2026-07-01 07:55:26'),('DAT0000016','Tambah Produk','PRD0000016','Milo','Kasir Demo','2026-07-01 07:56:43'),('DAT0000017','Tambah Produk','PRD0000017','Jeruk','Kasir Demo','2026-07-01 07:57:18'),('DAT0000018','Tambah Produk','PRD0000018','Teh Manis','Kasir Demo','2026-07-01 07:57:51'),('DAT0000019','Tambah Produk','PRD0000019','Lemon Tea','Kasir Demo','2026-07-01 07:58:59'),('DAT0000020','Tambah Produk','PRD0000018','Teh Manis (Gabungan)','Kasir Demo','2026-07-01 08:00:08'),('DAT0000021','Tambah Produk','PRD0000021','Susu Putih','Kasir Demo','2026-07-01 08:00:49'),('DAT0000022','Tambah Produk','PRD0000022','Air Mineral','Kasir Demo','2026-07-01 08:01:18'),('DAT0000023','Tambah Produk','PRD0000023','Capucinno','Kasir Demo','2026-07-01 08:01:48'),('DAT0000024','Tambah Produk','PRD0000024','Kopi Susu','Kasir Demo','2026-07-01 08:02:33'),('DAT0000025','Tambah Produk','PRD0000025','Kopi Hitam','Kasir Demo','2026-07-01 08:03:38'),('DAT0000026','Tambah Produk','PRD0000026','Nasi Kuning','Kasir Demo','2026-10-13 02:18:08'),('DAT0000027','Tambah Produk','PRD0000027','Nasi Uduk','Kasir Demo','2026-10-13 02:18:08'),('DAT0000028','Tambah Produk','PRD0000028','Lontong Sayur','Kasir Demo','2026-10-13 02:18:08'),('DAT0000029','Tambah Produk','PRD0000029','Bubur Ayam','Kasir Demo','2026-10-13 02:18:08'),('DAT0000030','Tambah Produk','PRD0000030','Ayam Geprek + Nasi','Kasir Demo','2026-10-13 02:18:08');
INSERT INTO `data_products` (`id_data`,`aktivitas`,`id_produk`,`nama_produk`,`nama_kasir`) VALUES
('DAT0000031','Tambah Produk','PRD0000031','ABC Susu','Kasir Demo'),
('DAT0000032','Tambah Produk','PRD0000032','Indocafe','Kasir Demo'),
('DAT0000033','Tambah Produk','PRD0000033','Kapal Api Special Mix','Kasir Demo'),
('DAT0000034','Tambah Produk','PRD0000034','Good Day Biasa','Kasir Demo'),
('DAT0000035','Tambah Produk','PRD0000035','Luwak White Coffee','Kasir Demo'),
('DAT0000036','Tambah Produk','PRD0000036','Torabika Creamy Latte','Kasir Demo'),
('DAT0000037','Tambah Produk','PRD0000037','Good Day Freeze','Kasir Demo'),
('DAT0000038','Tambah Produk','PRD0000038','Nescafe Ice Roast','Kasir Demo'),
('DAT0000039','Tambah Produk','PRD0000039','ABC Klepon','Kasir Demo'),
('DAT0000040','Tambah Produk','PRD0000040','Good Day Biasa','Kasir Demo'),
('DAT0000041','Tambah Produk','PRD0000041','Tora Cafe','Kasir Demo'),
('DAT0000042','Tambah Produk','PRD0000042','Es Nutrisari','Kasir Demo');
/*!40000 ALTER TABLE `data_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id_notif` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` varchar(11) NOT NULL,
  `id_meja` varchar(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `total` decimal(12,2) DEFAULT 0.00,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_notif`),
  KEY `fk_notif_order` (`id_order`),
  KEY `fk_notif_meja` (`id_meja`),
  CONSTRAINT `fk_notif_meja` FOREIGN KEY (`id_meja`) REFERENCES `tables_meja` (`id_meja`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_notif_order` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id_items` varchar(11) NOT NULL,
  `id_order` varchar(11) NOT NULL,
  `id_produk` varchar(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `opsi` varchar(100) DEFAULT NULL,
  `catatan` varchar(500) DEFAULT NULL,
  `suhu` varchar(10) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT 0.00,
  `qty` int(11) DEFAULT 0,
  `subtotal` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_items`),
  KEY `fk_orderitems_order` (`id_order`),
  KEY `fk_orderitems_produk` (`id_produk`),
  CONSTRAINT `fk_orderitems_order` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_orderitems_produk` FOREIGN KEY (`id_produk`) REFERENCES `products` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id_order` varchar(11) NOT NULL,
  `id_meja` varchar(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `total` decimal(12,2) DEFAULT 0.00,
  `status` enum('sedang_dibuat','menunggu_pembayaran','lunas') DEFAULT 'sedang_dibuat',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `metode_pembayaran` enum('cash','qris') DEFAULT 'cash',
  PRIMARY KEY (`id_order`),
  KEY `fk_orders_meja` (`id_meja`),
  CONSTRAINT `fk_orders_meja` FOREIGN KEY (`id_meja`) REFERENCES `tables_meja` (`id_meja`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id_pay` varchar(11) NOT NULL,
  `id_order` varchar(11) NOT NULL,
  `id_user` varchar(11) NOT NULL,
  `nama_kasir` varchar(200) NOT NULL,
  `metode_pembayaran` enum('cash','qris') DEFAULT 'cash',
  `total_order` decimal(12,2) DEFAULT 0.00,
  `uang_dibayar` decimal(12,2) DEFAULT 0.00,
  `kembalian` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pay`),
  KEY `fk_payment_order` (`id_order`),
  KEY `fk_payment_user` (`id_user`),
  CONSTRAINT `fk_payment_order` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_payment_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id_produk` varchar(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `harga` decimal(12,2) DEFAULT 0.00,
  `stok` int(11) DEFAULT 0,
  `varian_suhu` tinyint(1) NOT NULL DEFAULT 0,
  `tambahan_harga_es` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gambar` varchar(255) NOT NULL,
  `suhu_tetap` varchar(10) DEFAULT NULL,
  `punya_opsi` tinyint(1) NOT NULL DEFAULT 0,
  `label_opsi` varchar(40) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id_produk`,`nama`,`kategori`,`harga`,`stok`,`varian_suhu`,`tambahan_harga_es`,`gambar`,`created_at`) VALUES ('PRD0000001','Nasi Goreng ','Makanan Berat',16000.00,3,0,0.00,'1782891565_af07d1c8e2315eba526e.jpeg','2026-07-01 07:39:25'),('PRD0000002','Indomie Goreng Telor','Makanan Berat',14000.00,15,0,0.00,'1782891630_26c8fcfc238747f9d178.jpg','2026-07-01 07:40:30'),('PRD0000003','Indomie Rebus Telor','Makanan Berat',14000.00,9,0,0.00,'1782891673_3a19720e46a9be9c7775.jpg','2026-07-01 07:41:13'),('PRD0000004','Bubur Kacang Ijo','Makanan Berat',12000.00,20,0,0.00,'1782891724_6c21cc833c61523f6af4.webp','2026-07-01 07:42:04'),('PRD0000005','Nasi Kucing','Makanan Berat',8000.00,15,0,0.00,'1782891769_c5b0bcadfb44d38234a4.webp','2026-07-01 07:42:49'),('PRD0000006','Pancong Keju','Cemilan',10000.00,24,0,0.00,'1782891816_786a944dbfabaee44fb8.jpeg','2026-07-01 07:43:36'),('PRD0000007','Roti Bakar Coklat','Cemilan',8000.00,10,0,0.00,'1782891914_eb59436f346118c70051.webp','2026-07-01 07:45:14'),('PRD0000008','Kentang Goreng','Cemilan',10000.00,20,0,0.00,'1782891965_98b1c540141dc1eb58a4.jpg','2026-07-01 07:46:05'),('PRD0000009','Bakwan 1 Pcs','Cemilan',2000.00,29,0,0.00,'1782892263_434cd0136cfd2722be8c.jpg','2026-07-01 07:51:04'),('PRD0000010','Tempe 1 Pcs','Cemilan',2000.00,25,0,0.00,'1782892347_671cdf0dd96840bee1f9.jpg','2026-07-01 07:52:27'),('PRD0000011','Tahu 1 Pcs','Cemilan',2000.00,15,0,0.00,'1782892372_a297cd893fbd687a9e5d.jpg','2026-07-01 07:52:52'),('PRD0000012','Dimsum Mentai ','Cemilan',15000.00,18,0,0.00,'1782892408_4b7ee137701e664ed6cb.jpg','2026-07-01 07:53:28'),('PRD0000013','Sate Telor 1 Pcs','Cemilan',3000.00,100,0,0.00,'1782892445_186ac56379c4a036d498.jpg','2026-07-01 07:54:05'),('PRD0000014','Sate Usus 1 Pcs','Cemilan',3000.00,100,0,0.00,'1782892475_fd46d605570d5a9615e7.webp','2026-07-01 07:54:35'),('PRD0000015','Sate Ati Ampela 1 Pcs','Cemilan',3000.00,99,0,0.00,'1782892526_438340effe2d3bdd20a2.webp','2026-07-01 07:55:26'),('PRD0000016','Milo','Minuman Non Kopi',7000.00,30,1,0.00,'1782892603_d89f90befaf837d8644b.jpg','2026-07-01 07:56:43'),('PRD0000017','Jeruk','Minuman Non Kopi',6000.00,20,1,0.00,'1782892638_134ca8dd804e6be7fbc5.png','2026-07-01 07:57:18'),('PRD0000018','Teh Manis','Minuman Non Kopi',5000.00,45,1,0.00,'1782892671_5d17140debb9adc1a0f7.jpg','2026-07-01 07:57:51'),('PRD0000019','Lemon Tea','Minuman Non Kopi',7000.00,40,1,0.00,'1782892739_5710e7e00431f6e601b9.jpg','2026-07-01 07:58:59'),('PRD0000021','Susu Putih','Minuman Non Kopi',6000.00,15,1,0.00,'1782892849_cca365c575d52226cdfc.jpeg','2026-07-01 08:00:49'),('PRD0000022','Air Mineral','Minuman Non Kopi',2000.00,49,0,0.00,'1782892878_06fc1658f73a7f863548.png','2026-07-01 08:01:18'),('PRD0000023','Capucinno','Minuman Kopi',8000.00,19,1,0.00,'1782892908_bfa51afe039cc5d8285e.jpg','2026-07-01 08:01:48'),('PRD0000024','Kopi Susu','Minuman Kopi',5000.00,15,1,0.00,'1782892953_7355e2cffff88b69963b.png','2026-07-01 08:02:33'),('PRD0000025','Kopi Hitam','Minuman Kopi',3000.00,15,1,0.00,'1782893018_3852702b5d883e8b42a6.jpg','2026-07-01 08:03:38'),('PRD0000026','Nasi Kuning','Makanan Berat',10000.00,20,0,0.00,'nasi-kuning.jpg','2026-10-13 02:18:08'),('PRD0000027','Nasi Uduk','Makanan Berat',10000.00,20,0,0.00,'nasi-uduk.jpg','2026-10-13 02:18:08'),('PRD0000028','Lontong Sayur','Makanan Berat',10000.00,20,0,0.00,'lontong-sayur.jpg','2026-10-13 02:18:08'),('PRD0000029','Bubur Ayam','Makanan Berat',12000.00,20,0,0.00,'bubur-ayam.jpg','2026-10-13 02:18:08'),('PRD0000030','Ayam Geprek + Nasi','Makanan Berat',15000.00,20,0,0.00,'ayam-geprek.png','2026-10-13 02:18:08');
INSERT INTO `products` (`id_produk`,`nama`,`kategori`,`harga`,`stok`,`varian_suhu`,`tambahan_harga_es`,`gambar`,`suhu_tetap`,`punya_opsi`,`label_opsi`) VALUES
('PRD0000031','ABC Susu','Kopi Panas',5000,50,0,0,'abc-susu.svg','panas',0,NULL),
('PRD0000032','Indocafe','Kopi Panas',5000,50,0,0,'indocafe.svg','panas',0,NULL),
('PRD0000033','Kapal Api Special Mix','Kopi Panas',5000,50,0,0,'kapal-api-special-mix.svg','panas',0,NULL),
('PRD0000034','Good Day Biasa','Kopi Panas',6000,50,0,0,'good-day-hot.svg','panas',1,'Pilih rasa'),
('PRD0000035','Luwak White Coffee','Kopi Panas',5000,50,0,0,'luwak-white-coffee.svg','panas',0,NULL),
('PRD0000036','Torabika Creamy Latte','Kopi Panas',6000,50,0,0,'torabika-creamy-latte.svg','panas',0,NULL),
('PRD0000037','Good Day Freeze','Es Kopi',8000,50,0,0,'good-day-freeze.svg','dingin',1,'Pilih rasa'),
('PRD0000038','Nescafe Ice Roast','Es Kopi',7000,50,0,0,'nescafe-ice-roast.svg','dingin',0,NULL),
('PRD0000039','ABC Klepon','Es Kopi',8000,50,0,0,'abc-klepon.svg','dingin',0,NULL),
('PRD0000040','Good Day Biasa','Es Kopi',7000,50,0,0,'good-day-iced.svg','dingin',1,'Pilih rasa'),
('PRD0000041','Tora Cafe','Es Kopi',7000,50,0,0,'tora-cafe.svg','dingin',0,NULL),
('PRD0000042','Es Nutrisari','Es Nutrisari',5000,50,0,0,'fruit-drink.svg','dingin',1,'Pilih rasa');
UPDATE `products` SET `deskripsi` = CASE `id_produk`
  WHEN 'PRD0000001' THEN 'Nasi goreng berbumbu gurih yang nikmat disantap hangat.'
  WHEN 'PRD0000002' THEN 'Mi goreng berbumbu dengan tambahan telur.'
  WHEN 'PRD0000003' THEN 'Mi kuah hangat dengan bumbu gurih dan tambahan telur.'
  WHEN 'PRD0000004' THEN 'Bubur kacang hijau manis dan lembut untuk teman santai.'
  WHEN 'PRD0000005' THEN 'Porsi nasi sederhana yang pas untuk camilan atau teman ngopi.'
  WHEN 'PRD0000006' THEN 'Kue pancong hangat dengan taburan keju gurih.'
  WHEN 'PRD0000007' THEN 'Roti bakar hangat dengan isian cokelat manis.'
  WHEN 'PRD0000008' THEN 'Kentang goreng renyah yang cocok untuk camilan.'
  WHEN 'PRD0000009' THEN 'Bakwan goreng gurih dan renyah, disajikan per buah.'
  WHEN 'PRD0000010' THEN 'Tempe goreng gurih sebagai camilan atau lauk, disajikan per buah.'
  WHEN 'PRD0000011' THEN 'Tahu goreng gurih sebagai camilan atau lauk, disajikan per buah.'
  WHEN 'PRD0000012' THEN 'Dimsum lembut dengan saus mentai yang gurih dan creamy.'
  WHEN 'PRD0000013' THEN 'Sate telur gurih yang praktis dinikmati sebagai camilan.'
  WHEN 'PRD0000014' THEN 'Sate usus berbumbu gurih, disajikan per tusuk.'
  WHEN 'PRD0000015' THEN 'Sate ati ampela berbumbu gurih, disajikan per tusuk.'
  WHEN 'PRD0000016' THEN 'Minuman cokelat malt yang nikmat disajikan panas atau es.'
  WHEN 'PRD0000017' THEN 'Minuman rasa jeruk yang menyegarkan, tersedia panas atau es.'
  WHEN 'PRD0000018' THEN 'Teh dengan rasa manis yang pas, dapat dinikmati panas atau es.'
  WHEN 'PRD0000019' THEN 'Perpaduan teh dan lemon dengan rasa segar, tersedia panas atau es.'
  WHEN 'PRD0000021' THEN 'Susu putih dengan rasa lembut, dapat dinikmati panas atau es.'
  WHEN 'PRD0000022' THEN 'Air mineral untuk menemani makan atau melepas dahaga.'
  WHEN 'PRD0000023' THEN 'Kopi cappuccino dengan perpaduan rasa kopi dan susu yang creamy.'
  WHEN 'PRD0000024' THEN 'Kopi dengan campuran susu yang lembut dan seimbang.'
  WHEN 'PRD0000025' THEN 'Kopi hitam dengan cita rasa kopi yang kuat dan sederhana.'
  WHEN 'PRD0000026' THEN 'Nasi kuning berbumbu gurih, cocok untuk menu makan yang mengenyangkan.'
  WHEN 'PRD0000027' THEN 'Nasi uduk gurih yang cocok dinikmati sebagai menu makan.'
  WHEN 'PRD0000028' THEN 'Lontong sayur dengan kuah berbumbu gurih untuk santapan mengenyangkan.'
  WHEN 'PRD0000029' THEN 'Bubur ayam hangat dengan rasa gurih, pas untuk santapan ringan.'
  WHEN 'PRD0000030' THEN 'Ayam geprek dengan nasi, pilihan makan gurih dan mengenyangkan.'
  WHEN 'PRD0000031' THEN 'Kopi instan bercita rasa kopi dan susu yang nikmat disajikan panas.'
  WHEN 'PRD0000032' THEN 'Kopi instan dengan rasa lembut untuk menemani waktu santai.'
  WHEN 'PRD0000033' THEN 'Kopi instan dengan perpaduan kopi dan gula yang praktis disajikan panas.'
  WHEN 'PRD0000034' THEN 'Kopi Good Day panas dengan pilihan rasa yang bisa dipilih.'
  WHEN 'PRD0000035' THEN 'Kopi putih bercita rasa lembut dan creamy, disajikan panas.'
  WHEN 'PRD0000036' THEN 'Kopi latte dengan perpaduan kopi dan krimer yang creamy.'
  WHEN 'PRD0000037' THEN 'Kopi Good Day Freeze dingin dengan pilihan rasa yang bisa dipilih.'
  WHEN 'PRD0000038' THEN 'Kopi dingin dengan rasa kopi yang kuat dan menyegarkan.'
  WHEN 'PRD0000039' THEN 'Kopi dingin dengan sentuhan rasa klepon yang manis dan creamy.'
  WHEN 'PRD0000040' THEN 'Good Day Biasa disajikan dingin dengan pilihan rasa yang bisa dipilih.'
  WHEN 'PRD0000041' THEN 'Kopi instan dingin dengan rasa kopi dan susu yang lembut.'
  WHEN 'PRD0000042' THEN 'Minuman Nutrisari dingin dengan pilihan rasa buah yang menyegarkan.'
  ELSE `deskripsi`
END
WHERE `id_produk` IN (
  'PRD0000001','PRD0000002','PRD0000003','PRD0000004','PRD0000005','PRD0000006',
  'PRD0000007','PRD0000008','PRD0000009','PRD0000010','PRD0000011','PRD0000012',
  'PRD0000013','PRD0000014','PRD0000015','PRD0000016','PRD0000017','PRD0000018',
  'PRD0000019','PRD0000021','PRD0000022','PRD0000023','PRD0000024','PRD0000025',
  'PRD0000026','PRD0000027','PRD0000028','PRD0000029','PRD0000030','PRD0000031',
  'PRD0000032','PRD0000033','PRD0000034','PRD0000035','PRD0000036','PRD0000037',
  'PRD0000038','PRD0000039','PRD0000040','PRD0000041','PRD0000042'
);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_options`
--

DROP TABLE IF EXISTS `product_options`;
CREATE TABLE `product_options` (
  `id_opsi` varchar(11) NOT NULL,
  `id_produk` varchar(11) NOT NULL,
  `nama_opsi` varchar(100) NOT NULL,
  `tambahan_harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gambar` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_opsi`),
  KEY `product_options_product` (`id_produk`),
  CONSTRAINT `fk_product_options_product` FOREIGN KEY (`id_produk`) REFERENCES `products` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `product_options` (`id_opsi`,`id_produk`,`nama_opsi`,`tambahan_harga`,`urutan`,`aktif`) VALUES
('OPT0000001','PRD0000034','Cappuccino',0,1,1),
('OPT0000002','PRD0000034','Moccacino',0,2,1),
('OPT0000003','PRD0000034','Vanilla Latte',0,3,1),
('OPT0000004','PRD0000034','Carribean Nut',0,4,1),
('OPT0000005','PRD0000034','Coolin'' Caffe',0,5,1),
('OPT0000006','PRD0000037','Mocafrio',0,1,1),
('OPT0000007','PRD0000037','Hazelnut Macchiato',0,2,1),
('OPT0000008','PRD0000037','Cookies ''N Cream',0,3,1),
('OPT0000009','PRD0000037','Choc Orange',0,4,1),
('OPT0000010','PRD0000040','Cappuccino',0,1,1),
('OPT0000011','PRD0000040','Moccacino',0,2,1),
('OPT0000012','PRD0000040','Vanilla Latte',0,3,1),
('OPT0000013','PRD0000040','Carribean Nut',0,4,1),
('OPT0000014','PRD0000040','Coolin'' Caffe',0,5,1),
('OPT0000015','PRD0000042','Jeruk Nipis',0,1,1),
('OPT0000016','PRD0000042','Anggur',0,2,1),
('OPT0000017','PRD0000042','Lemon',0,3,1),
('OPT0000018','PRD0000042','Jeruk Peras',0,4,1);

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id_setting` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `value` text DEFAULT NULL,
  PRIMARY KEY (`id_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('SET001','logo','uploads/1782893162_877638d3b731e6f63229.png'),('SET002','nama_warkop','Warkop Bahagia'),('SET003','alamat','Alamat Demo'),('SET004','kontak','Kontak belum diatur'),('SET005','server_url','localhost:8080');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables_meja`
--

DROP TABLE IF EXISTS `tables_meja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tables_meja` (
  `id_meja` varchar(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  PRIMARY KEY (`id_meja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables_meja`
--

LOCK TABLES `tables_meja` WRITE;
/*!40000 ALTER TABLE `tables_meja` DISABLE KEYS */;
INSERT INTO `tables_meja` VALUES ('MEJA001','Meja 1'),('MEJA002','Meja 2'),('MEJA003','Meja 3'),('MEJA004','Meja 4'),('MEJA005','Meja 5'),('MEJA006','Meja 6'),('MEJA007','Meja 7'),('MEJA008','Meja 8'),('MEJA009','Meja 9'),('MEJA010','Meja 10');
/*!40000 ALTER TABLE `tables_meja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` varchar(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_kasir` varchar(200) NOT NULL,
  `role` enum('admin','kasir') DEFAULT 'kasir',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('USR0000001','demo_user_27', '!disabled!', 'Kasir Demo','admin','2026-06-22 04:17:56'),('USR002','demo_user_159', '!disabled!', 'Kasir Demo','kasir','2026-06-30 13:16:02'),('USR003','demo_user_278', '!disabled!', 'Kasir Demo','kasir','2026-10-12 01:42:31');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-13  9:31:10
