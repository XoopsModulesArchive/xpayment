CREATE TABLE `xpayment_discounts` (
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
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `xpayment_gateway` (
  `gid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `testmode` tinyint(2) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gid`),
  KEY `SEARCH` (`gid`,`name`(12),`class`(13))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xpayment_gateway_options` (
  `goid` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(6) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(1000) DEFAULT NULL,
  `refereer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`goid`),
  KEY `SEARCH` (`gid`,`name`,`refereer`(12))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xpayment_groups` (
  `rid` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `mode` enum('BROKERS','ACCOUNTS','OFFICERS') DEFAULT NULL,
  `plugin` varchar(128) DEFAULT '*',
  `uid` int(13) DEFAULT '0',
  `limit` tinyint(2) DEFAULT '0',
  `minimum` decimal(15,2) DEFAULT '0.00',
  `maximum` decimal(15,2) DEFAULT '0.00',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xpayment_invoice` (
  `iid` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `mode` enum('PAID','UNPAID','CANCEL') NOT NULL DEFAULT 'UNPAID',
  `plugin` varchar(128) NOT NULL,
  `return` varchar(1000) NOT NULL,
  `cancel` varchar(1000) NOT NULL,
  `ipn` varchar(1000) NOT NULL,
  `invoicenumber` varchar(64) DEFAULT NULL,
  `drawfor` varchar(255) DEFAULT NULL,
  `drawto` varchar(255) NOT NULL,
  `drawto_email` varchar(255) NOT NULL,
  `paid` decimal(15,2) DEFAULT '0.00',
  `amount` decimal(15,2) DEFAULT '0.00',
  `grand` decimal(15,2) DEFAULT '0.00',
  `shipping` decimal(15,2) DEFAULT '0.00',
  `handling` decimal(15,2) DEFAULT '0.00',
  `weight` decimal(15,2) DEFAULT '0.00',
  `weight_unit` enum('lbs','kgs') DEFAULT 'kgs',
  `tax` decimal(15,2) DEFAULT '0.00',
  `interest` decimal(15,2) DEFAULT '0.00',
  `rate` decimal(10,4) DEFAULT '0.0000',
  `discount` decimal(10,4) DEFAULT '0.0000',
  `discount_amount` decimal(15,2) DEFAULT '0.00',
  `did` int(30) unsigned DEFAULT '0',
  `currency` varchar(3) DEFAULT 'AUD',
  `items` decimal(15,3) DEFAULT '0.000',
  `key` varchar(255) DEFAULT NULL,
  `transactionid` varchar(255) DEFAULT NULL,
  `gateway` varchar(128) DEFAULT NULL,
  `topayment` int(13) DEFAULT '0',
  `created` int(13) DEFAULT '0',
  `updated` int(13) DEFAULT '0',
  `actioned` int(13) DEFAULT '0',
  `reoccurrence` int(8) DEFAULT '0',
  `reoccurrence_period_days` int(8) DEFAULT '0',
  `reoccurrences` int(8) DEFAULT '0',
  `occurrence` int(13) DEFAULT '0',
  `previous` int(13) DEFAULT '0',
  `occurrence_amount` decimal(15,2) DEFAULT '0.00',
  `occurrence_grand` decimal(15,2) DEFAULT '0.00',
  `occurrence_shipping` decimal(15,2) DEFAULT '0.00',
  `occurrence_handling` decimal(15,2) DEFAULT '0.00',
  `occurrence_tax` decimal(15,2) DEFAULT '0.00',
  `occurrence_weight` decimal(15,6) DEFAULT '0.000000',
  `remittion` enum('NONE','PENDING','NOTICE','COLLECT','FRAUD','SETTLED','DISCOUNTED') NOT NULL DEFAULT 'NONE',
  `remittion_settled` decimal(15,2) DEFAULT '0.00',
  `donation` tinyint(2) DEFAULT '0',
  `comment` varchar(5000) DEFAULT NULL,
  `user_ip` varchar(128) DEFAULT NULL,
  `user_netaddy` varchar(255) DEFAULT NULL,
  `user_uid` int(13) DEFAULT '0',
  `user_uids` varchar(1000) DEFAULT NULL,
  `broker_uids` varchar(1000) DEFAULT NULL,
  `accounts_uids` varchar(1000) DEFAULT NULL,
  `officer_uids` varchar(1000) DEFAULT NULL,
  `remitted` int(13) DEFAULT '0',
  `user_ipdb_country_code` varchar(3) default NULL,
  `user_ipdb_country_name` varchar(128) default NULL,
  `user_ipdb_region_name` varchar(128) default NULL,
  `user_ipdb_city_name` varchar(128) default NULL,
  `user_ipdb_postcode` varchar(15) default NULL,
  `user_ipdb_latitude` decimal(5,5) default '0.00000',
  `user_ipdb_longitude` decimal(5,5) default '0.00000',
  `user_ipdb_time_zone` varchar(6) default '00:00',
  `fraud_ipdb_errors` varchar(1000) default NULL,
  `fraud_ipdb_warnings` varchar(1000) default NULL,
  `fraud_ipdb_messages` varchar(1000) default NULL,
  `fraud_ipdb_districtcity` varchar(128) default NULL,
  `fraud_ipdb_ipcountrycode` varchar(3) default NULL,
  `fraud_ipdb_ipcountry` varchar(128) default NULL,
  `fraud_ipdb_ipregioncode` varchar(3) default NULL,
  `fraud_ipdb_ipregion` varchar(128) default NULL,
  `fraud_ipdb_ipcity` varchar(128) default NULL,
  `fraud_ipdb_score` int(10) default NULL,
  `fraud_ipdb_accuracyscore` int(10) default NULL,
  `fraud_ipdb_scoredetails` MEDIUMTEXT,
  `due` int(13) DEFAULT '0',
  `collect` int(13) DEFAULT '0',
  `wait` int(13) DEFAULT '0',
  `offline` int(13) DEFAULT '0',
  `annum` int(13) DEFAULT '0',
  PRIMARY KEY (`iid`),
  KEY `SEARCH` (`iid`,`mode`,`currency`,`items`,`remittion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xpayment_invoice_items` (
  `iiid` int(26) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(15) unsigned NOT NULL,
  `cat` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` decimal(19,4) DEFAULT '0.0000',
  `quantity` decimal(15,3) DEFAULT '0.000',
  `shipping` decimal(15,2) DEFAULT '0.00',
  `handling` decimal(15,2) DEFAULT '0.00',
  `weight` decimal(15,6) DEFAULT '0.000000',
  `tax` decimal(15,2) DEFAULT '0.00',
  `description` varchar(5000) DEFAULT NULL,
  `mode` enum('PURCHASED', 'REFUNDED', 'UNDELIVERED', 'DAMAGED', 'EXPRESS') NOT NULL DEFAULT 'PURCHASED',
  `created` int(13) DEFAULT '0',
  `updated` int(13) DEFAULT '0',
  `actioned` int(13) DEFAULT '0',
  PRIMARY KEY (`iiid`),
  KEY `SEARCH` (`iid`,`cat`(12),`name`(12))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xpayment_invoice_transactions` (
  `tiid` int(28) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(23) unsigned NOT NULL,
  `transactionid` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `custom` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` int(13) DEFAULT '0',
  `gross` decimal(15,2) DEFAULT '0.00',
  `fee` decimal(15,2) DEFAULT '0.00',
  `deposit` decimal(15,2) DEFAULT '0.00',
  `settle` decimal(15,2) DEFAULT '0.00',
  `exchangerate` varchar(128) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `address_status` varchar(255) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `payer_status` varchar(255) DEFAULT NULL,
  `gateway` varchar(128) DEFAULT NULL,
  `plugin` varchar(128) DEFAULT NULL,
  `mode` enum('PAYMENT', 'REFUND', 'PENDING', 'NOTICE', 'OTHER') NOT NULL DEFAULT 'PAYMENT',
  PRIMARY KEY (`tiid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xpayment_autotax` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(128) NOT NULL,
  `code` varchar(3) NOT NULL,
  `rate` decimal(10,5) DEFAULT '0.00000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8;
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (1,'AFGHANISTAN','AF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (2,'ALAND ISLANDS','AX','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (3,'ALBANIA','AL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (4,'ALGERIA','DZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (5,'AMERICAN SAMOA','AS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (6,'ANDORRA','AD','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (7,'ANGOLA','AO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (8,'ANGUILLA','AI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (9,'ANTARCTICA','AQ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (10,'ANTIGUA AND BARBUDA','AG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (11,'ARGENTINA','AR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (12,'ARMENIA','AM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (13,'ARUBA','AW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (14,'AUSTRALIA','AU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (15,'AUSTRIA','AT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (16,'AZERBAIJAN','AZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (17,'BAHAMAS','BS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (18,'BAHRAIN','BH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (19,'BANGLADESH','BD','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (20,'BARBADOS','BB','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (21,'BELARUS','BY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (22,'BELGIUM','BE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (23,'BELIZE','BZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (24,'BENIN','BJ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (25,'BERMUDA','BM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (26,'BHUTAN','BT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (27,'BOLIVIA, PLURINATIONAL STATE OF','BO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (28,'BONAIRE, SAINT EUSTATIUS AND SABA','BQ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (29,'BOSNIA AND HERZEGOVINA','BA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (30,'BOTSWANA','BW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (31,'BOUVET ISLAND','BV','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (32,'BRAZIL','BR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (33,'BRITISH INDIAN OCEAN TERRITORY','IO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (34,'BRUNEI DARUSSALAM','BN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (35,'BULGARIA','BG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (36,'BURKINA FASO','BF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (37,'BURUNDI','BI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (38,'CAMBODIA','KH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (39,'CAMEROON','CM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (40,'CANADA','CA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (41,'CAPE VERDE','CV','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (42,'CAYMAN ISLANDS','KY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (43,'CENTRAL AFRICAN REPUBLIC','CF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (44,'CHAD','TD','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (45,'CHILE','CL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (46,'CHINA','CN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (47,'CHRISTMAS ISLAND','CX','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (48,'COCOS (KEELING) ISLANDS','CC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (49,'COLOMBIA','CO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (50,'COMOROS','KM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (51,'CONGO','CG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (52,'CONGO, THE DEMOCRATIC REPUBLIC OF THE','CD','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (53,'COOK ISLANDS','CK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (54,'COSTA RICA','CR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (55,'COTE D\'IVOIRE','CI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (56,'CROATIA','HR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (57,'CUBA','CU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (58,'CURACAO','CW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (59,'CYPRUS','CY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (60,'CZECH REPUBLIC','CZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (61,'DENMARK','DK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (62,'DJIBOUTI','DJ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (63,'DOMINICA','DM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (64,'DOMINICAN REPUBLIC','DO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (65,'ECUADOR','EC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (66,'EGYPT','EG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (67,'EL SALVADOR','SV','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (68,'EQUATORIAL GUINEA','GQ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (69,'ERITREA','ER','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (70,'ESTONIA','EE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (71,'ETHIOPIA','ET','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (72,'FALKLAND ISLANDS (MALVINAS)','FK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (73,'FAROE ISLANDS','FO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (74,'FIJI','FJ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (75,'FINLAND','FI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (76,'FRANCE','FR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (77,'FRENCH GUIANA','GF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (78,'FRENCH POLYNESIA','PF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (79,'FRENCH SOUTHERN TERRITORIES','TF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (80,'GABON','GA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (81,'GAMBIA','GM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (82,'GEORGIA','GE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (83,'GERMANY','DE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (84,'GHANA','GH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (85,'GIBRALTAR','GI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (86,'GREECE','GR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (87,'GREENLAND','GL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (88,'GRENADA','GD','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (89,'GUADELOUPE','GP','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (90,'GUAM','GU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (91,'GUATEMALA','GT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (92,'GUERNSEY','GG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (93,'GUINEA','GN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (94,'GUINEA-BISSAU','GW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (95,'GUYANA','GY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (96,'HAITI','HT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (97,'HEARD ISLAND AND MCDONALD ISLANDS','HM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (98,'HOLY SEE (VATICAN CITY STATE)','VA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (99,'HONDURAS','HN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (100,'HONG KONG','HK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (101,'HUNGARY','HU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (102,'ICELAND','IS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (103,'INDIA','IN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (104,'INDONESIA','ID','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (105,'IRAN, ISLAMIC REPUBLIC OF','IR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (106,'IRAQ','IQ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (107,'IRELAND','IE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (108,'ISLE OF MAN','IM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (109,'ISRAEL','IL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (110,'ITALY','IT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (111,'JAMAICA','JM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (112,'JAPAN','JP','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (113,'JERSEY','JE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (114,'JORDAN','JO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (115,'KAZAKHSTAN','KZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (116,'KENYA','KE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (117,'KIRIBATI','KI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (118,'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','KP','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (119,'KOREA, REPUBLIC OF','KR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (120,'KUWAIT','KW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (121,'KYRGYZSTAN','KG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (122,'LAO PEOPLE\'S DEMOCRATIC REPUBLIC','LA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (123,'LATVIA','LV','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (124,'LEBANON','LB','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (125,'LESOTHO','LS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (126,'LIBERIA','LR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (127,'LIBYAN ARAB JAMAHIRIYA','LY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (128,'LIECHTENSTEIN','LI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (129,'LITHUANIA','LT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (130,'LUXEMBOURG','LU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (131,'MACAO','MO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (132,'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','MK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (133,'MADAGASCAR','MG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (134,'MALAWI','MW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (135,'MALAYSIA','MY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (136,'MALDIVES','MV','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (137,'MALI','ML','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (138,'MALTA','MT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (139,'MARSHALL ISLANDS','MH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (140,'MARTINIQUE','MQ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (141,'MAURITANIA','MR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (142,'MAURITIUS','MU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (143,'MAYOTTE','YT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (144,'MEXICO','MX','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (145,'MICRONESIA, FEDERATED STATES OF','FM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (146,'MOLDOVA, REPUBLIC OF','MD','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (147,'MONACO','MC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (148,'MONGOLIA','MN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (149,'MONTENEGRO','ME','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (150,'MONTSERRAT','MS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (151,'MOROCCO','MA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (152,'MOZAMBIQUE','MZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (153,'MYANMAR','MM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (154,'NAMIBIA','NA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (155,'NAURU','NR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (156,'NEPAL','NP','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (157,'NETHERLANDS','NL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (158,'NEW CALEDONIA','NC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (159,'NEW ZEALAND','NZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (160,'NICARAGUA','NI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (161,'NIGER','NE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (162,'NIGERIA','NG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (163,'NIUE','NU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (164,'NORFOLK ISLAND','NF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (165,'NORTHERN MARIANA ISLANDS','MP','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (166,'NORWAY','NO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (167,'OMAN','OM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (168,'PAKISTAN','PK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (169,'PALAU','PW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (170,'PALESTINIAN TERRITORY, OCCUPIED','PS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (171,'PANAMA','PA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (172,'PAPUA NEW GUINEA','PG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (173,'PARAGUAY','PY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (174,'PERU','PE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (175,'PHILIPPINES','PH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (176,'PITCAIRN','PN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (177,'POLAND','PL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (178,'PORTUGAL','PT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (179,'PUERTO RICO','PR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (180,'QATAR','QA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (181,'REUNION','RE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (182,'ROMANIA','RO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (183,'RUSSIAN FEDERATION','RU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (184,'RWANDA','RW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (185,'SAINT BARTHELEMY','BL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (186,'SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA','SH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (187,'SAINT KITTS AND NEVIS','KN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (188,'SAINT LUCIA','LC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (189,'SAINT MARTIN (FRENCH PART)','MF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (190,'SAINT PIERRE AND MIQUELON','PM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (191,'SAINT VINCENT AND THE GRENADINES','VC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (192,'SAMOA','WS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (193,'SAN MARINO','SM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (194,'SAO TOME AND PRINCIPE','ST','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (195,'SAUDI ARABIA','SA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (196,'SENEGAL','SN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (197,'SERBIA','RS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (198,'SEYCHELLES','SC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (199,'SIERRA LEONE','SL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (200,'SINGAPORE','SG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (201,'SINT MAARTEN (DUTCH PART)','SX','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (202,'SLOVAKIA','SK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (203,'SLOVENIA','SI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (204,'SOLOMON ISLANDS','SB','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (205,'SOMALIA','SO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (206,'SOUTH AFRICA','ZA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (207,'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS','GS','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (208,'SPAIN','ES','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (209,'SRI LANKA','LK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (210,'SUDAN','SD','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (211,'SURINAME','SR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (212,'SVALBARD AND JAN MAYEN','SJ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (213,'SWAZILAND','SZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (214,'SWEDEN','SE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (215,'SWITZERLAND','CH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (216,'SYRIAN ARAB REPUBLIC','SY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (217,'TAIWAN, PROVINCE OF CHINA','TW','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (218,'TAJIKISTAN','TJ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (219,'TANZANIA, UNITED REPUBLIC OF','TZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (220,'THAILAND','TH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (221,'TIMOR-LESTE','TL','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (222,'TOGO','TG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (223,'TOKELAU','TK','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (224,'TONGA','TO','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (225,'TRINIDAD AND TOBAGO','TT','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (226,'TUNISIA','TN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (227,'TURKEY','TR','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (228,'TURKMENISTAN','TM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (229,'TURKS AND CAICOS ISLANDS','TC','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (230,'TUVALU','TV','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (231,'UGANDA','UG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (232,'UKRAINE','UA','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (233,'UNITED ARAB EMIRATES','AE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (234,'UNITED KINGDOM','GB','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (235,'UNITED STATES','US','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (236,'UNITED STATES MINOR OUTLYING ISLANDS','UM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (237,'URUGUAY','UY','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (238,'UZBEKISTAN','UZ','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (239,'VANUATU','VU','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (240,'VENEZUELA, BOLIVARIAN REPUBLIC OF','VE','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (241,'VIET NAM','VN','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (242,'VIRGIN ISLANDS, BRITISH','VG','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (243,'VIRGIN ISLANDS, U.S.','VI','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (244,'WALLIS AND FUTUNA','WF','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (245,'WESTERN SAHARA','EH','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (246,'YEMEN','YE0','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (247,'ZAMBIA','ZM','0.00000');
insert  into `xpayment_autotax` (`id`,`country`,`code`,`rate`) values (248,'ZIMBABWE','ZW','0.00000');