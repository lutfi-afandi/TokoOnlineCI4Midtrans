-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: dbgudang
-- ------------------------------------------------------
-- Server version 	8.0.30
-- Date: Thu, 09 Mar 2023 16:23:14 +0700

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40101 SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barang`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang` (
  `brgkode` char(10) CHARACTER SET utf8mb3 NOT NULL,
  `brgnama` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `brgkatid` int DEFAULT NULL,
  `brgsatid` int DEFAULT NULL,
  `brgharga` double DEFAULT NULL,
  `brggambar` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `brgstok` int DEFAULT NULL,
  PRIMARY KEY (`brgkode`),
  KEY `barang_brgkatid_foreign` (`brgkatid`),
  KEY `barang_brgsatid_foreign` (`brgsatid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `barang` VALUES ('B001','Sepatu',9,1,600000,'assets/upload/B001_1.png',0),('B002','Rolex',11,3,100000,'assets/upload/B002.jpg',0),('B003','Flashdisk 32GB',11,3,60000,'assets/upload/B003_1.jpg',48),('B004','Asus Zenfone',11,3,3000000,'',7),('B006','Ourtuseight',9,1,300000,'',19);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `barang` with 5 row(s)
--

--
-- Table structure for table `barangkeluar`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barangkeluar` (
  `faktur` char(20) NOT NULL,
  `tglfaktur` date DEFAULT NULL,
  `idpel` int DEFAULT NULL,
  `totalharga` double DEFAULT NULL,
  `jumlahuang` double DEFAULT NULL,
  `sisauang` double DEFAULT NULL,
  PRIMARY KEY (`faktur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangkeluar`
--

LOCK TABLES `barangkeluar` WRITE;
/*!40000 ALTER TABLE `barangkeluar` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `barangkeluar` VALUES ('0601230001','2023-01-06',2,1200000,15000000,4800000),('0701230001','2023-01-07',7,7800000,500000,20000);
/*!40000 ALTER TABLE `barangkeluar` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `barangkeluar` with 2 row(s)
--

--
-- Table structure for table `barangmasuk`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barangmasuk` (
  `faktur` char(20) NOT NULL,
  `tglfaktur` date DEFAULT NULL,
  `totalharga` double DEFAULT NULL,
  PRIMARY KEY (`faktur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangmasuk`
--

LOCK TABLES `barangmasuk` WRITE;
/*!40000 ALTER TABLE `barangmasuk` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `barangmasuk` VALUES ('F002','2022-12-12',5000000),('F038','2023-03-08',750000),('F039','2023-03-09',1000000);
/*!40000 ALTER TABLE `barangmasuk` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `barangmasuk` with 3 row(s)
--

--
-- Table structure for table `detail_barangkeluar`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_barangkeluar` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `detfaktur` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detbrgkode` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dethargajual` double DEFAULT NULL,
  `detjumlah` int DEFAULT NULL,
  `detsubtotal` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barangkeluar`
--

LOCK TABLES `detail_barangkeluar` WRITE;
/*!40000 ALTER TABLE `detail_barangkeluar` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `detail_barangkeluar` VALUES (15,'0601230001','B006',300000,3,900000),(16,'0601230001','B003',60000,5,300000),(17,'0701230001','B006',300000,5,1500000),(18,'0701230001','B003',60000,5,300000),(22,'0701230001','B004',3000000,2,6000000);
/*!40000 ALTER TABLE `detail_barangkeluar` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `detail_barangkeluar` with 5 row(s)
--

--
-- Table structure for table `detail_barangmasuk`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_barangmasuk` (
  `iddetail` bigint NOT NULL AUTO_INCREMENT,
  `detfaktur` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detbrgkode` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dethargamasuk` double DEFAULT NULL,
  `dethargajual` double DEFAULT NULL,
  `detjumlah` int DEFAULT NULL,
  `detsubtotal` double DEFAULT NULL,
  PRIMARY KEY (`iddetail`),
  KEY `detfaktur` (`detfaktur`),
  CONSTRAINT `detail_barangmasuk_ibfk_1` FOREIGN KEY (`detfaktur`) REFERENCES `barangmasuk` (`faktur`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barangmasuk`
--

LOCK TABLES `detail_barangmasuk` WRITE;
/*!40000 ALTER TABLE `detail_barangmasuk` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `detail_barangmasuk` VALUES (6,'F002','B004',2500000,3000000,2,5000000),(10,'F039','B003',50000,60000,20,1000000),(12,'F038','B006',150000,300000,5,750000);
/*!40000 ALTER TABLE `detail_barangmasuk` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `detail_barangmasuk` with 3 row(s)
--

--
-- Table structure for table `kategori`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `katid` int unsigned NOT NULL AUTO_INCREMENT,
  `katnama` varchar(50) NOT NULL,
  KEY `katid` (`katid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `kategori` VALUES (8,'Minuman'),(9,'Pakaian'),(10,'Makanan'),(11,'elektronik'),(12,'Outdoor'),(13,'Perkakas Rumahan'),(14,'Kendaraan'),(15,'Aksesoris HP'),(16,'Anak-Anak'),(17,'Pertanian'),(18,'Digital');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `kategori` with 11 row(s)
--

--
-- Table structure for table `levels`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `levels` (
  `levelid` int NOT NULL AUTO_INCREMENT,
  `levelnama` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`levelid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `levels`
--

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `levels` VALUES (1,'Admin'),(2,'Kasir'),(3,'Gudang'),(4,'Pimpinan');
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `levels` with 4 row(s)
--

--
-- Table structure for table `migrations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `migrations` VALUES (1,'2022-09-01-021434','App\\Database\\Migrations\\Kategori','default','App',1669787717,1),(2,'2022-09-01-021440','App\\Database\\Migrations\\Satuan','default','App',1669787717,1),(3,'2022-09-01-021444','App\\Database\\Migrations\\Barang','default','App',1669787717,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `migrations` with 3 row(s)
--

--
-- Table structure for table `pelanggan`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelanggan` (
  `pelid` int NOT NULL AUTO_INCREMENT,
  `pelnama` varchar(100) DEFAULT NULL,
  `peltelp` char(20) DEFAULT NULL,
  PRIMARY KEY (`pelid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelanggan`
--

LOCK TABLES `pelanggan` WRITE;
/*!40000 ALTER TABLE `pelanggan` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `pelanggan` VALUES (2,'Usman','09999999'),(7,'Lukman','0897');
/*!40000 ALTER TABLE `pelanggan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `pelanggan` with 2 row(s)
--

--
-- Table structure for table `satuan`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `satuan` (
  `satid` int unsigned NOT NULL AUTO_INCREMENT,
  `satnama` varchar(50) NOT NULL,
  KEY `satid` (`satid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `satuan`
--

LOCK TABLES `satuan` WRITE;
/*!40000 ALTER TABLE `satuan` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `satuan` VALUES (1,'pcs'),(3,'Unit'),(4,'Set'),(5,'Kg'),(6,'Gram'),(7,'pack');
/*!40000 ALTER TABLE `satuan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `satuan` with 6 row(s)
--

--
-- Table structure for table `temp_barangkeluar`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_barangkeluar` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `detfaktur` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `detbrgkode` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `dethargajual` double DEFAULT NULL,
  `detjumlah` int DEFAULT NULL,
  `detsubtotal` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_barangkeluar`
--

LOCK TABLES `temp_barangkeluar` WRITE;
/*!40000 ALTER TABLE `temp_barangkeluar` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `temp_barangkeluar` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `temp_barangkeluar` with 0 row(s)
--

--
-- Table structure for table `temp_barangmasuk`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp_barangmasuk` (
  `iddetail` bigint NOT NULL AUTO_INCREMENT,
  `detfaktur` char(20) DEFAULT NULL,
  `detbrgkode` char(10) DEFAULT NULL,
  `dethargamasuk` double DEFAULT NULL,
  `dethargajual` double DEFAULT NULL,
  `detjumlah` int DEFAULT NULL,
  `detsubtotal` double DEFAULT NULL,
  PRIMARY KEY (`iddetail`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_barangmasuk`
--

LOCK TABLES `temp_barangmasuk` WRITE;
/*!40000 ALTER TABLE `temp_barangmasuk` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `temp_barangmasuk` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `temp_barangmasuk` with 0 row(s)
--

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userid` char(50) NOT NULL,
  `usernama` varchar(100) DEFAULT NULL,
  `userpassword` varchar(100) DEFAULT NULL,
  `userlevelid` int DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `users` VALUES ('admin','Administrator','$2y$10$dKUWugxNbTQDOWIUgECNce728B.KoZBLqThAnfLrhEeIehMyp6Lee',1),('gudang','Rois','$2y$10$dKUWugxNbTQDOWIUgECNce728B.KoZBLqThAnfLrhEeIehMyp6Lee',3),('kasir','Lutfi Afandi','$2y$10$dKUWugxNbTQDOWIUgECNce728B.KoZBLqThAnfLrhEeIehMyp6Lee',2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `users` with 3 row(s)
--

DROP TRIGGER IF EXISTS `trigger_tambahstok`;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_tambahstok` AFTER INSERT ON `detail_barangmasuk` FOR EACH ROW BEGIN
	update barang set barang.`brgstok` = barang.`brgstok` +new.detjumlah where barang.`brgkode`=new.detbrgkode;
    END */;;
DELIMITER ;

DROP TRIGGER IF EXISTS `tri_update_stok_barang`;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tri_update_stok_barang` AFTER UPDATE ON `detail_barangmasuk` FOR EACH ROW BEGIN
	UPDATE `barang`SET `brgstok` = (brgstok - old.detjumlah) +new.detjumlah WHERE brgkode = old.detbrgkode;
    END */;;
DELIMITER ;

DROP TRIGGER IF EXISTS `tri_kurangi_stok_barang`;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tri_kurangi_stok_barang` AFTER DELETE ON `detail_barangmasuk` FOR EACH ROW BEGIN
update `barang`set `brgstok` = brgstok - old.detjumlah where brgkode = old.detbrgkode;
    END */;;
DELIMITER ;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET AUTOCOMMIT=@OLD_AUTOCOMMIT */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Thu, 09 Mar 2023 16:23:14 +0700
