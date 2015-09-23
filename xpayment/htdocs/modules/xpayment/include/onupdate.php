<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function xoops_module_update_xpayment($module, $oldversion) {
	
	$sql=array();
	
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `paid` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `reoccurrence` int(8) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `reoccurrence_period_days` int(8) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `reoccurrences` int(8) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `occurrence` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `previous` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `occurrence_amount` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `occurrence_grand` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `occurrence_shipping` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `occurrence_handling` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `occurrence_tax` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `occurrence_weight` decimal(15,6) DEFAULT \'0.000000\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `remittion` enum(\'NONE\',\'PENDING\',\'NOTICE\',\'COLLECT\',\'FRAUD\',\'SETTLED\') NOT NULL DEFAULT \'NONE\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `remittion_settled` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `donation` tinyint(2) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `comment` varchar(5000) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ip` varchar(128) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_netaddy` varchar(255) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_uid` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_uids` varchar(1000) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `broker_uids` varchar(1000) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `accounts_uids` varchar(1000) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `officer_uids` varchar(1000) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `remitted` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `due` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `collect` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `wait` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `offline` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `interest` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `rate` decimal(10,4) DEFAULT \'0.0000\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `annum` int(13) DEFAULT \'0\'';
	$sql[] = 'UPDATE TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' SET `rate` = \'7\' WHERE `rate` = \'0.0000\'';
	$sql[] = 'UPDATE TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' SET `annum` = `created` + (60*60*24*7*4) WHERE `annum` = \'0\'';	
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `items` `items` DECIMAL(15,3) DEFAULT \'0.000\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_items') . ' ADD COLUMN `description` varchar(5000) DEFAULT NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_items') . ' ADD COLUMN `mode` enum(\'PURCHASED\', \'REFUNDED\', \'UNDELIVERED\', \'DAMAGED\', \'EXPRESS\') NOT NULL DEFAULT \'PURCHASED\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_items') . ' ADD COLUMN `created` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_items') . ' ADD COLUMN `updated` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_items') . ' ADD COLUMN `actioned` int(13) DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_items') . ' CHANGE COLUMN `quantity` `quantity` DECIMAL(15,3) DEFAULT \'0.000\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_transactions') . ' ADD COLUMN `mode` enum(\'PAYMENT\', \'REFUND\', \'PENDING\', \'NOTICE\', \'OTHER\') NOT NULL DEFAULT \'PAYMENT\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice_transactions') . ' ADD COLUMN `deposit` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'CREATE TABLE `'.$GLOBALS['xoopsDB']->prefix('xpayment_groups') . '` (
  `rid` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `mode` enum(\'BROKERS\',\'ACCOUNTS\',\'OFFICERS\') DEFAULT NULL,
  `plugin` varchar(128) DEFAULT \'*\',
  `uid` int(13) DEFAULT \'0\',
  `limit` tinyint(2) DEFAULT \'0\',
  `minimum` decimal(45,2) DEFAULT \'0.00\',
  `maximum` decimal(45,2) DEFAULT \'0.00\',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_country_code` varchar(3) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_country_name` varchar(128) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_region_name` varchar(128) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_city_name` varchar(128) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_postcode` varchar(15) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_latitude` decimal(5,5) default \'0.00000\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_longitude` decimal(5,5) default \'0.00000\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `user_ipdb_time_zone` varchar(6) default \'00:00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_errors` varchar(1000) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_warnings` varchar(1000) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_messages` varchar(1000) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_districtcity` varchar(128) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_ipcountrycode` varchar(3) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_ipcountry` varchar(128) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_ipregioncode` varchar(3) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_ipregion` varchar(128) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_ipcity` varchar(128) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_score` int(10) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_accuracyscore` int(10) default NULL';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `fraud_ipdb_scoredetails` MEDIUMTEXT';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `fraud_ipdb_scoredetails` `fraud_ipdb_scoredetails` MEDIUMTEXT';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `discount_amount` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `discount` decimal(10,4) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `did` int(30) unsigned DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `remittion` `remittion` enum(\'NONE\',\'PENDING\',\'NOTICE\',\'COLLECT\',\'FRAUD\',\'SETTLED\',\'DISCOUNTED\') NOT NULL DEFAULT \'NONE\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_discounts') . ' ADD COLUMN `sent` INT(13) UNSIGNED DEFAULT \'0\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `paid` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `amount` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `grand` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `shipping` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `handling` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `weight` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `tax` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `interest` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `discount_amount` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `occurrence_amount` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `occurrence_grand` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `occurrence_shipping` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `occurrence_handling` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `occurrence_tax` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' CHANGE COLUMN `remittion_settled` decimal(45,2) DEFAULT \'0.00\'';
	$sql[] = 'CREATE TABLE `'.$GLOBALS['xoopsDB']->prefix('xpayment_discounts') . "` (
  `did` INT(30) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` INT(13) UNSIGNED DEFAULT '0',
  `code` VARCHAR(48) DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `validtill` INT(13) UNSIGNED DEFAULT '0',
  `redeems` INT(10) UNSIGNED DEFAULT '0',
  `discount` DECIMAL(10,4) DEFAULT '0.0000',
  `redeemed` INT(13) UNSIGNED DEFAULT '0',
  `iids` VARCHAR(1000) DEFAULT NULL,
  `sent` INT(13) UNSIGNED DEFAULT '0',
  `created` INT(13) UNSIGNED DEFAULT '0',
  `updated` INT(13) UNSIGNED DEFAULT '0',
  PRIMARY KEY (`did`)
) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = 'ALTER TABLE '.$GLOBALS['xoopsDB']->prefix('xpayment_invoice') . ' ADD COLUMN `topayment` int(13) DEFAULT \'0\'';
	
	foreach($sql as $question)
		if ($GLOBALS['xoopsDB']->queryF($question))
			xoops_error($question, 'Executed Successfully');

	$question = 'CREATE TABLE `'.$GLOBALS['xoopsDB']->prefix('xpayment_autotax') . '` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(128) NOT NULL,
  `code` varchar(3) NOT NULL,
  `rate` decimal(10,5) DEFAULT \'0.00000\',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8;';
	if ($GLOBALS['xoopsDB']->queryF($question)) {
		xoops_error($question, 'Executed Successfully');
		$question = "insert  into `".$GLOBALS['xoopsDB']->prefix('xpayment_autotax') ."` (`id`,`country`,`code`,`rate`) values (1,'AFGHANISTAN','AF','0.00000'),(2,'ALAND ISLANDS','AX','0.00000'),(3,'ALBANIA','AL','0.00000'),(4,'ALGERIA','DZ','0.00000'),(5,'AMERICAN SAMOA','AS','0.00000'),(6,'ANDORRA','AD','0.00000'),(7,'ANGOLA','AO','0.00000'),(8,'ANGUILLA','AI','0.00000'),(9,'ANTARCTICA','AQ','0.00000'),(10,'ANTIGUA AND BARBUDA','AG','0.00000'),(11,'ARGENTINA','AR','0.00000'),(12,'ARMENIA','AM','0.00000'),(13,'ARUBA','AW','0.00000'),(14,'AUSTRALIA','AU','0.00000'),(15,'AUSTRIA','AT','0.00000'),(16,'AZERBAIJAN','AZ','0.00000'),(17,'BAHAMAS','BS','0.00000'),(18,'BAHRAIN','BH','0.00000'),(19,'BANGLADESH','BD','0.00000'),(20,'BARBADOS','BB','0.00000'),(21,'BELARUS','BY','0.00000'),(22,'BELGIUM','BE','0.00000'),(23,'BELIZE','BZ','0.00000'),(24,'BENIN','BJ','0.00000'),(25,'BERMUDA','BM','0.00000'),(26,'BHUTAN','BT','0.00000'),(27,'BOLIVIA, PLURINATIONAL STATE OF','BO','0.00000'),(28,'BONAIRE, SAINT EUSTATIUS AND SABA','BQ','0.00000'),(29,'BOSNIA AND HERZEGOVINA','BA','0.00000'),(30,'BOTSWANA','BW','0.00000'),(31,'BOUVET ISLAND','BV','0.00000'),(32,'BRAZIL','BR','0.00000'),(33,'BRITISH INDIAN OCEAN TERRITORY','IO','0.00000'),(34,'BRUNEI DARUSSALAM','BN','0.00000'),(35,'BULGARIA','BG','0.00000'),(36,'BURKINA FASO','BF','0.00000'),(37,'BURUNDI','BI','0.00000'),(38,'CAMBODIA','KH','0.00000'),(39,'CAMEROON','CM','0.00000'),(40,'CANADA','CA','0.00000'),(41,'CAPE VERDE','CV','0.00000'),(42,'CAYMAN ISLANDS','KY','0.00000'),(43,'CENTRAL AFRICAN REPUBLIC','CF','0.00000'),(44,'CHAD','TD','0.00000'),(45,'CHILE','CL','0.00000'),(46,'CHINA','CN','0.00000'),(47,'CHRISTMAS ISLAND','CX','0.00000'),(48,'COCOS (KEELING) ISLANDS','CC','0.00000'),(49,'COLOMBIA','CO','0.00000'),(50,'COMOROS','KM','0.00000'),(51,'CONGO','CG','0.00000'),(52,'CONGO, THE DEMOCRATIC REPUBLIC OF THE','CD','0.00000'),(53,'COOK ISLANDS','CK','0.00000'),(54,'COSTA RICA','CR','0.00000'),(55,'COTE D\'IVOIRE','CI','0.00000'),(56,'CROATIA','HR','0.00000'),(57,'CUBA','CU','0.00000'),(58,'CURACAO','CW','0.00000'),(59,'CYPRUS','CY','0.00000'),(60,'CZECH REPUBLIC','CZ','0.00000'),(61,'DENMARK','DK','0.00000'),(62,'DJIBOUTI','DJ','0.00000'),(63,'DOMINICA','DM','0.00000'),(64,'DOMINICAN REPUBLIC','DO','0.00000'),(65,'ECUADOR','EC','0.00000'),(66,'EGYPT','EG','0.00000'),(67,'EL SALVADOR','SV','0.00000'),(68,'EQUATORIAL GUINEA','GQ','0.00000'),(69,'ERITREA','ER','0.00000'),(70,'ESTONIA','EE','0.00000'),(71,'ETHIOPIA','ET','0.00000'),(72,'FALKLAND ISLANDS (MALVINAS)','FK','0.00000'),(73,'FAROE ISLANDS','FO','0.00000'),(74,'FIJI','FJ','0.00000'),(75,'FINLAND','FI','0.00000'),(76,'FRANCE','FR','0.00000'),(77,'FRENCH GUIANA','GF','0.00000'),(78,'FRENCH POLYNESIA','PF','0.00000'),(79,'FRENCH SOUTHERN TERRITORIES','TF','0.00000'),(80,'GABON','GA','0.00000'),(81,'GAMBIA','GM','0.00000'),(82,'GEORGIA','GE','0.00000'),(83,'GERMANY','DE','0.00000'),(84,'GHANA','GH','0.00000'),(85,'GIBRALTAR','GI','0.00000'),(86,'GREECE','GR','0.00000'),(87,'GREENLAND','GL','0.00000'),(88,'GRENADA','GD','0.00000'),(89,'GUADELOUPE','GP','0.00000'),(90,'GUAM','GU','0.00000'),(91,'GUATEMALA','GT','0.00000'),(92,'GUERNSEY','GG','0.00000'),(93,'GUINEA','GN','0.00000'),(94,'GUINEA-BISSAU','GW','0.00000'),(95,'GUYANA','GY','0.00000'),(96,'HAITI','HT','0.00000'),(97,'HEARD ISLAND AND MCDONALD ISLANDS','HM','0.00000'),(98,'HOLY SEE (VATICAN CITY STATE)','VA','0.00000'),(99,'HONDURAS','HN','0.00000'),(100,'HONG KONG','HK','0.00000'),(101,'HUNGARY','HU','0.00000'),(102,'ICELAND','IS','0.00000'),(103,'INDIA','IN','0.00000'),(104,'INDONESIA','ID','0.00000'),(105,'IRAN, ISLAMIC REPUBLIC OF','IR','0.00000'),(106,'IRAQ','IQ','0.00000'),(107,'IRELAND','IE','0.00000'),(108,'ISLE OF MAN','IM','0.00000'),(109,'ISRAEL','IL','0.00000'),(110,'ITALY','IT','0.00000'),(111,'JAMAICA','JM','0.00000'),(112,'JAPAN','JP','0.00000'),(113,'JERSEY','JE','0.00000'),(114,'JORDAN','JO','0.00000'),(115,'KAZAKHSTAN','KZ','0.00000'),(116,'KENYA','KE','0.00000'),(117,'KIRIBATI','KI','0.00000'),(118,'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','KP','0.00000'),(119,'KOREA, REPUBLIC OF','KR','0.00000'),(120,'KUWAIT','KW','0.00000'),(121,'KYRGYZSTAN','KG','0.00000'),(122,'LAO PEOPLE\'S DEMOCRATIC REPUBLIC','LA','0.00000'),(123,'LATVIA','LV','0.00000'),(124,'LEBANON','LB','0.00000'),(125,'LESOTHO','LS','0.00000'),(126,'LIBERIA','LR','0.00000'),(127,'LIBYAN ARAB JAMAHIRIYA','LY','0.00000'),(128,'LIECHTENSTEIN','LI','0.00000'),(129,'LITHUANIA','LT','0.00000'),(130,'LUXEMBOURG','LU','0.00000'),(131,'MACAO','MO','0.00000'),(132,'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','MK','0.00000'),(133,'MADAGASCAR','MG','0.00000'),(134,'MALAWI','MW','0.00000'),(135,'MALAYSIA','MY','0.00000'),(136,'MALDIVES','MV','0.00000'),(137,'MALI','ML','0.00000'),(138,'MALTA','MT','0.00000'),(139,'MARSHALL ISLANDS','MH','0.00000'),(140,'MARTINIQUE','MQ','0.00000'),(141,'MAURITANIA','MR','0.00000'),(142,'MAURITIUS','MU','0.00000'),(143,'MAYOTTE','YT','0.00000'),(144,'MEXICO','MX','0.00000'),(145,'MICRONESIA, FEDERATED STATES OF','FM','0.00000'),(146,'MOLDOVA, REPUBLIC OF','MD','0.00000'),(147,'MONACO','MC','0.00000'),(148,'MONGOLIA','MN','0.00000'),(149,'MONTENEGRO','ME','0.00000'),(150,'MONTSERRAT','MS','0.00000'),(151,'MOROCCO','MA','0.00000'),(152,'MOZAMBIQUE','MZ','0.00000'),(153,'MYANMAR','MM','0.00000'),(154,'NAMIBIA','NA','0.00000'),(155,'NAURU','NR','0.00000'),(156,'NEPAL','NP','0.00000'),(157,'NETHERLANDS','NL','0.00000'),(158,'NEW CALEDONIA','NC','0.00000'),(159,'NEW ZEALAND','NZ','0.00000'),(160,'NICARAGUA','NI','0.00000'),(161,'NIGER','NE','0.00000'),(162,'NIGERIA','NG','0.00000'),(163,'NIUE','NU','0.00000'),(164,'NORFOLK ISLAND','NF','0.00000'),(165,'NORTHERN MARIANA ISLANDS','MP','0.00000'),(166,'NORWAY','NO','0.00000'),(167,'OMAN','OM','0.00000'),(168,'PAKISTAN','PK','0.00000'),(169,'PALAU','PW','0.00000'),(170,'PALESTINIAN TERRITORY, OCCUPIED','PS','0.00000'),(171,'PANAMA','PA','0.00000'),(172,'PAPUA NEW GUINEA','PG','0.00000'),(173,'PARAGUAY','PY','0.00000'),(174,'PERU','PE','0.00000'),(175,'PHILIPPINES','PH','0.00000'),(176,'PITCAIRN','PN','0.00000'),(177,'POLAND','PL','0.00000'),(178,'PORTUGAL','PT','0.00000'),(179,'PUERTO RICO','PR','0.00000'),(180,'QATAR','QA','0.00000'),(181,'REUNION','RE','0.00000'),(182,'ROMANIA','RO','0.00000'),(183,'RUSSIAN FEDERATION','RU','0.00000'),(184,'RWANDA','RW','0.00000'),(185,'SAINT BARTHELEMY','BL','0.00000'),(186,'SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA','SH','0.00000'),(187,'SAINT KITTS AND NEVIS','KN','0.00000'),(188,'SAINT LUCIA','LC','0.00000'),(189,'SAINT MARTIN (FRENCH PART)','MF','0.00000'),(190,'SAINT PIERRE AND MIQUELON','PM','0.00000'),(191,'SAINT VINCENT AND THE GRENADINES','VC','0.00000'),(192,'SAMOA','WS','0.00000'),(193,'SAN MARINO','SM','0.00000'),(194,'SAO TOME AND PRINCIPE','ST','0.00000'),(195,'SAUDI ARABIA','SA','0.00000'),(196,'SENEGAL','SN','0.00000'),(197,'SERBIA','RS','0.00000'),(198,'SEYCHELLES','SC','0.00000'),(199,'SIERRA LEONE','SL','0.00000'),(200,'SINGAPORE','SG','0.00000'),(201,'SINT MAARTEN (DUTCH PART)','SX','0.00000'),(202,'SLOVAKIA','SK','0.00000'),(203,'SLOVENIA','SI','0.00000'),(204,'SOLOMON ISLANDS','SB','0.00000'),(205,'SOMALIA','SO','0.00000'),(206,'SOUTH AFRICA','ZA','0.00000'),(207,'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS','GS','0.00000'),(208,'SPAIN','ES','0.00000'),(209,'SRI LANKA','LK','0.00000'),(210,'SUDAN','SD','0.00000'),(211,'SURINAME','SR','0.00000'),(212,'SVALBARD AND JAN MAYEN','SJ','0.00000'),(213,'SWAZILAND','SZ','0.00000'),(214,'SWEDEN','SE','0.00000'),(215,'SWITZERLAND','CH','0.00000'),(216,'SYRIAN ARAB REPUBLIC','SY','0.00000'),(217,'TAIWAN, PROVINCE OF CHINA','TW','0.00000'),(218,'TAJIKISTAN','TJ','0.00000'),(219,'TANZANIA, UNITED REPUBLIC OF','TZ','0.00000'),(220,'THAILAND','TH','0.00000'),(221,'TIMOR-LESTE','TL','0.00000'),(222,'TOGO','TG','0.00000'),(223,'TOKELAU','TK','0.00000'),(224,'TONGA','TO','0.00000'),(225,'TRINIDAD AND TOBAGO','TT','0.00000'),(226,'TUNISIA','TN','0.00000'),(227,'TURKEY','TR','0.00000'),(228,'TURKMENISTAN','TM','0.00000'),(229,'TURKS AND CAICOS ISLANDS','TC','0.00000'),(230,'TUVALU','TV','0.00000'),(231,'UGANDA','UG','0.00000'),(232,'UKRAINE','UA','0.00000'),(233,'UNITED ARAB EMIRATES','AE','0.00000'),(234,'UNITED KINGDOM','GB','0.00000'),(235,'UNITED STATES','US','0.00000'),(236,'UNITED STATES MINOR OUTLYING ISLANDS','UM','0.00000'),(237,'URUGUAY','UY','0.00000'),(238,'UZBEKISTAN','UZ','0.00000'),(239,'VANUATU','VU','0.00000'),(240,'VENEZUELA, BOLIVARIAN REPUBLIC OF','VE','0.00000'),(241,'VIET NAM','VN','0.00000'),(242,'VIRGIN ISLANDS, BRITISH','VG','0.00000'),(243,'VIRGIN ISLANDS, U.S.','VI','0.00000'),(244,'WALLIS AND FUTUNA','WF','0.00000'),(245,'WESTERN SAHARA','EH','0.00000'),(246,'YEMEN','YE0','0.00000'),(247,'ZAMBIA','ZM','0.00000'),(248,'ZIMBABWE','ZW','0.00000')";
		xoops_error($question, 'Executed Successfully');
	}
	
	xoops_loadLanguage('modinfo', 'xpayment');
	
	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_BROKER);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _XPY_MI_GROUP_NAME_BROKER);
		$group->setVar('description', _XPY_MI_GROUP_DESC_BROKER);
		$group->setVar('group_type', _XPY_MI_GROUP_TYPE_BROKER);
		$groups_handler->insert($group, true);
	}

	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_ACCOUNTS);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _XPY_MI_GROUP_NAME_ACCOUNTS);
		$group->setVar('description', _XPY_MI_GROUP_DESC_ACCOUNTS);
		$group->setVar('group_type', _XPY_MI_GROUP_TYPE_ACCOUNTS);
		$groups_handler->insert($group, true);
	}

	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _XPY_MI_GROUP_TYPE_OFFICER);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _XPY_MI_GROUP_NAME_OFFICER);
		$group->setVar('description', _XPY_MI_GROUP_DESC_OFFICER);
		$group->setVar('group_type', _XPY_MI_GROUP_TYPE_OFFICER);
		$groups_handler->insert($group, true);
	}
				
	return true;
}
?>