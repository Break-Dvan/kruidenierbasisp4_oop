/* 
Maak eerst een nieuwe database op je hostomgeving of op je laptop.
Selecteer deze database in phpMyAdmin of andere MySQL-client
=> USE <database_name>;
Voer dan onderstaande SQL-code uit
(BkD 7-6-2024 09:21)
*/

--
-- Table structure for table `bestelling`
--

DROP TABLE IF EXISTS `bestelling`;
CREATE TABLE `bestelling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactie_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `omschrijving` varchar(60) NOT NULL,
  `prijs` decimal(2,2) NOT NULL,
  `aantal` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bestelling`
--

LOCK TABLES `bestelling` WRITE;
-- geen data...
UNLOCK TABLES;

--
-- Table structure for table `medewerker`
--

DROP TABLE IF EXISTS `medewerker`;
CREATE TABLE `medewerker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inlognaam` varchar(50) NOT NULL UNIQUE,
  `wachtwoord` varchar(150) NOT NULL COMMENT 'geheim',
  `rol_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medewerker`
--
-- wachtwoord = geheim

LOCK TABLES `medewerker` WRITE;
INSERT INTO `medewerker` 
VALUES 
(1,'bob','$2y$10$LDRVeXOg7ctR3lKx4fSzeODTYCIRrUuqOAyarmnOOdZJFAcr8H2te',1,'2021-06-09 20:23:27','2021-06-09 20:23:27'),
(2,'toos','$2y$10$LDRVeXOg7ctR3lKx4fSzeODTYCIRrUuqOAyarmnOOdZJFAcr8H2te',2,'2021-06-09 20:23:27','2021-06-09 20:23:27');
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artikelnummer` int(11) NOT NULL,
  `omschrijving` varchar(50) NOT NULL,
  `leverancier` varchar(50) NOT NULL,
  `artikelgroep` varchar(50) NOT NULL,
  `eenheid` varchar(10) NOT NULL,
  `prijs` decimal(5,2) NOT NULL,
  `aantal` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artikelnummer_UNIQUE` (`artikelnummer`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
INSERT INTO `product` 
VALUES 
(1,123456,'Broccoli','Boer Harms','Aardappels, groente en fruit','stuk',1.99,15,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(2,123457,'Bloemkool','Boer Harms','Aardappels, groente en fruit','stuk',2.99,50,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(3,123458,'Aubergine','Boer Harms','Aardappels, groente en fruit','stuk',0.89,75,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(4,123459,'Salade ui','Boer Harms','Aardappels, groente en fruit','bosje',0.59,50,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(5,123460,'Snoepgroente tomaat','Boer Harms','Aardappels, groente en fruit','500g',2.99,75,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(6,123461,'Kruimige aardappel','Boer Harms','Aardappels, groente en fruit','1kg',1.09,25,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(7,123462,'Kruimige aardappel','Boer Harms','Aardappels, groente en fruit','5kg',2.75,25,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(8,123463,'Kaas geraspt mid 45+','De Zaanse Hoeve','Kaas,vleeswaren','200g',1.79,45,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(9,123464,'Kaas Pittig 45+ geraspt','De Zaanse Hoeve','Kaas,vleeswaren','200g',1.89,45,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(10,123465,'Kaas Jong 48+','De Zaanse Hoeve','Kaas,vleeswaren','400g',2.89,45,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(11,123466,'Kipfilet','Meester & Zn.','Kaas,vleeswaren','150g',1.69,40,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(12,123467,'Gerookte spekreepjes','Meester & Zn.','Kaas,vleeswaren','300g',2.69,40,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(13,123468,'Gerookte schouderham','Meester & Zn.','Kaas,vleeswaren','150g',1.09,40,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(14,123469,'Boterhamworst','Meester & Zn.','Kaas,vleeswaren','150g',0.99,45,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(15,123470,'Pindakaas','Calvé','Broodbeleg','350g',2.69,65,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(16,123471,'Appelstroop','Rinse','Broodbeleg','450g',0.69,65,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(17,123472,'Hazelnootpasta','Nutella','Broodbeleg','630g',4.99,65,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(18,123473,'Vruchtenhagel','De Ruijter','Broodbeleg','400g',1.35,65,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(19,123474,'Chocoladehagel puur','De Ruijter','Broodbeleg','390g',2.49,56,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(20,123475,'Hagelslag melk','Venz','Broodbeleg','400g',1.69,57,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(21,123476,'Rimboe kroko vlokken puur/vanille','Venz','Broodbeleg','200g',1.99,35,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(22,123477,'Vlokken puur','De Ruijter','Broodbeleg','300g',1.99,55,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(23,123478,'Cola Zero sugar','Coca-Cola','Frisdrank','1l',1.85,100,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(24,123479,'Cola Regular','Coca-Cola','Frisdrank','1l',1.85,150,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(25,123480,'Fanta Orange','Fanta','Frisdrank','1,5l',1.95,125,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(26,123481,'Aroma rood filter koffie','Douwe Egberts','Koffie','250g',3.29,250,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(27,123482,'Aroma rood filter koffie','Douwe Egberts','Koffie','500g',6.15,125,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(28,123483,'Koffiemelk Halvamel','Friesche vlag','Koffie','455ml',1.25,122,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(29,123484,'Senseo Classic Koffiepads','Douwe Egberts','Koffie','36st',3.69,100,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(30,123485,'Opschuimmelk voor cappucino','Friesche vlag','Koffie','1l',1.35,50,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(31,123486,'Huisblends Aroma snelfiltermaling','Perla','Koffie','250g',2.89,75,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(32,123487,'Chips Naturel','Lay\'s','Chips','225g',1.49,75,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(33,123488,'Chips Paprika','Lay\'s','Chips','225g',1.49,85,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(34,123489,'Superchips paprika','Lay\'s','Chips','200g',1.59,10,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(35,123490,'Nibb-it sticks','Cheetos','Chips','110g',1.35,5,'2021-06-10 09:12:46','2021-06-10 09:12:46'),
(36,123491,'Ontbijtkoek naturel gesneden','Peijnenburg','Koek','485g',1.75,15,'2021-06-10 09:12:46','2021-06-10 09:12:46');
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
INSERT INTO `rol` 
VALUES 
(1,'bedrijfsleider'),
(2,'kassiere ');

UNLOCK TABLES;

--
-- Table structure for table `transactie`
--

DROP TABLE IF EXISTS `transactie`;
CREATE TABLE `transactie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` datetime NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactie`
--

LOCK TABLES `transactie` WRITE;
-- leeg...
UNLOCK TABLES;

DROP TABLE IF EXISTS `log_import`;
CREATE TABLE `log_import` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `bestand` VARCHAR(255) NULL,
  `medewerker` VARCHAR(45) NULL,
  `datum_import` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `update` INT NULL,
  `new` INT NULL,
  PRIMARY KEY (`id`));
