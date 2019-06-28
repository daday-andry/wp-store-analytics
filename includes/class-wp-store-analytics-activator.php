<?php

/**
 * Fired during plugin activation
 *
 * @link       andrynirina.portfoliobox.net
 * @since      1.0.0
 *
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Store_Analytics
 * @subpackage Wp_Store_Analytics/includes
 * @author     DADAY Andry <andrysahaedena@gmail.com>
 */
//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/';


class Wp_Store_Analytics_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
  private static $tablePrefix;

	public static function activate() {	
		/** Teste if woocomerce is present **/
		if (class_exists( 'WooCommerce')) {
      global  $woocommerce ;
      global $wpdb;
      self::$tablePrefix=$wpdb->prefix.WSM_PREFIX;

			if(!version_compare( $woocommerce->version,"2.7", ">=" ) ) {
				die('Woocomerce doit >= 2.7. Curent version:'.$woocommerce->version);
			}else{
				add_option('active_ecommerce_plugin_name','woocomerce');
        add_option('active_ecommerce_plugin_version',$woocommerce->version);
        
        /*** construct */

				/** create trafic tracer table */
				//Create database table if not exists
        self::CreateDatabaseSchema();
        global $wsmRequestArray;        
        if(isset($wsmRequestArray['wmcAction']) && ($wsmRequestArray['wmcAction']=='wmcTrack' || $wsmRequestArray['wmcAction']=='wmcAutoCron') ){
            self::$objWsmRequest= new wsmRequests($wsmRequestArray);
        }
			}
		}
		/*** Test if WP-commerce is present */
		elseif(!is_plugin_active('wp-e-commerce/wp-shopping-cart.php')){
			die("ce plugin necessite woocommerce > 2.7 ou WP eCommerce");
		}else{
			add_option('active_ecommerce_plugin_name','wp-e-commerce');
		}	
	}
	static function CreateDatabaseSchema(){
		$arrTables=array();
        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_url_log (
          id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          pageId int(10) UNSIGNED NULL,
          title text,
          hash VARCHAR(20) NOT NULL,
          protocol VARCHAR(10) NOT NULL,
          url text,
          searchEngine int(2) UNSIGNED NULL,
          toolBar int(2) UNSIGNED NULL,
          PRIMARY KEY (id),
          KEY index_type_hash (pageId,hash,searchEngine),
          KEY index_tb_hash (pageId,hash,searchEngine)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_url_log',array('create'=>$sql));
        $arrTables['LOG_URL']='_url_log';

        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_logUniqueVisit(
          id bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          siteId int(10) UNSIGNED NOT NULL,
          visitorId varchar(20) NOT NULL,
          visitLastActionTime datetime NOT NULL,
          configId varchar(20) NOT NULL,
          ipAddress varchar(16) NOT NULL,
          userId varchar(200) DEFAULT NULL,
          firstActionVisitTime datetime NOT NULL,
          daysSinceFirstVisit smallint(5) UNSIGNED DEFAULT NULL,
          returningVisitor tinyint(1) DEFAULT NULL,
          visitCount int(11) UNSIGNED NOT NULL,
          visitEntryURLId int(11) UNSIGNED DEFAULT NULL,
          visitExitURLId int(11) UNSIGNED DEFAULT \'0\',
          visitTotalActions int(11) UNSIGNED DEFAULT NULL,
          refererUrlId int(11),          
          browserLang varchar(20) DEFAULT NULL,
          browserId int(11) UNSIGNED DEFAULT NULL,
          deviceType varchar(20) DEFAULT NULL,
          oSystemId int(11) UNSIGNED DEFAULT NULL,
          currentLocalTime time DEFAULT NULL,
          daysSinceLastVisit smallint(5) UNSIGNED DEFAULT NULL,
          totalTimeVisit int(11) UNSIGNED NOT NULL,
          resolutionId int(11) UNSIGNED DEFAULT NULL,
          cookie tinyint(1) DEFAULT NULL,
          director tinyint(1) DEFAULT NULL,
          flash tinyint(1) DEFAULT NULL,
          gears tinyint(1) DEFAULT NULL,
          java tinyint(1) DEFAULT NULL,
          pdf tinyint(1) DEFAULT NULL,
          quicktime tinyint(1) DEFAULT NULL,
          realplayer tinyint(1) DEFAULT NULL,
          silverlight tinyint(1) DEFAULT NULL,
          windowsmedia tinyint(1) DEFAULT NULL,
          city varchar(255) DEFAULT NULL,
          countryId int(3) UNSIGNED NOT NULL,
          latitude decimal(9,6) DEFAULT NULL,
          longitude decimal(9,6) DEFAULT NULL,
          regionId tinyint(2) DEFAULT NULL,
          PRIMARY KEY (id),
          KEY index_config_datetime (configId,visitLastActionTime),
          KEY index_datetime (visitLastActionTime),
          KEY index_idvisitor (visitorId)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_logUniqueVisit',array('create'=>$sql));
        $arrTables['LOG_UNIQUE']='_logUniqueVisit';

        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_logVisit(
          id bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          siteId int(10) UNSIGNED NOT NULL,
          visitorId varchar(20) NOT NULL,
          visitId bigint(10) UNSIGNED NOT NULL,
          refererUrlId int(10) UNSIGNED DEFAULT 0,
          keyword varchar(200) DEFAULT NULL,
          serverTime datetime NOT NULL,
          timeSpentRef int(11) UNSIGNED NOT NULL,
          URLId int(10) UNSIGNED DEFAULT NULL,
          PRIMARY KEY (id),
          KEY index_visitId (visitId),
          KEY index_siteId_serverTime (siteId,serverTime)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_logVisit',array('create'=>$sql));
        $arrTables['LOG_VISIT']='_logVisit';

        $sql='CREATE TABLE '.self::$tablePrefix.'_oSystems (
          id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;';
        $insertSQL="INSERT IGNORE INTO  ".self::$tablePrefix."_oSystems (id,name) VALUES (1,'Windows 98'),(2,'Windows CE'),(3,'Linux'),(4,'Unix'),(5,'Windows 2000'),(6,'Windows XP'),(7,'Windows 8'),(8,'Windows 10'),(9,'Mac OS'),(10,'Android'),(11,'IOS')";
        self::CreateDatabaseTables('_oSystems',array('create'=>$sql,'insert'=>$insertSQL,'truncate'=>true));
        $arrTables['OS']='_oSystems';

        $sql='CREATE TABLE '.self::$tablePrefix.'_browsers (
          id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $insertSQL="INSERT IGNORE INTO  ".self::$tablePrefix."_browsers (id,name) VALUES (1,'Mozilla Firefox'),(2,'Google Chrome'),(3,'Opera'),(4,'Safari'),(5,'Internet Explorer'),(6,'Micorsoft Edge'),(7,'Torch'),(8,'Maxthon'),(9,'SeaMonkey'),(10,'Avant Browser'),(11,'Deepnet Explorer'),(12,'UE Browser')";
        self::CreateDatabaseTables('_browsers',array('create'=>$sql,'insert'=>$insertSQL,'truncate'=>true));
        $arrTables['BROW']='_browsers';

        $sql='CREATE TABLE '.self::$tablePrefix.'_toolBars (
          id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $insertSQL="INSERT IGNORE INTO  ".self::$tablePrefix."_toolBars (id,name) VALUES (1,'Alexa'),(2,'AOL'),(3,'Bing'),(4,'Data'),(5,'Google'),(6,'Kiwee'),(7,'Mirar'),(8,'Windows Live'),(9,'Yahoo')";
        self::CreateDatabaseTables('_toolBars',array('create'=>$sql,'insert'=>$insertSQL,'truncate'=>true));
        $arrTables['TOOL']='_toolBars';

        $sql='CREATE TABLE '.self::$tablePrefix.'_searchEngines (
          id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $insertSQL="INSERT IGNORE INTO  ".self::$tablePrefix."_searchEngines (id,name) VALUES (1,'Google'),(2,'Bing'),(3,'Yahoo'),(4,'Baidu'),(5,'AOL'),(6,'Ask'),(7,'Excite'),(8,'Duck Duck Go'),(9,'WolframAlpha'),(10,'Yandex'),(11,'Lycos'),(12,'Chacha')";
         self::CreateDatabaseTables('_searchEngines',array('create'=>$sql,'insert'=>$insertSQL,'truncate'=>true));
         $arrTables['SE']='_searchEngines';

        $sql='CREATE TABLE '.self::$tablePrefix.'_regions (
          id tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT,
          code char(2) NOT NULL COMMENT \'Region code\',
          name varchar(255) DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
         $insertSQL="INSERT IGNORE INTO  ".self::$tablePrefix."_regions (id,code,name) VALUES (1,'AF', 'Africa'),(2,'AN', 'Antarctica'),(3,'AS', 'Asia'),(4,'EU', 'Europe'),(5,'NA', 'North America'),(6,'OC', 'Oceania'),(7,'SA', 'South America')";
        self::CreateDatabaseTables('_regions',array('create'=>$sql,'insert'=>$insertSQL,'truncate'=>true));
        $arrTables['RG']='_regions';

        $sql='CREATE TABLE '.self::$tablePrefix.'_resolutions (
          id tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;';
        $insertSQL="INSERT IGNORE INTO  ".self::$tablePrefix."_resolutions (id, name) VALUES (1,'640x480'),(2,'800x600'),(3,'960x720'),(4,'1024x768'),(5,'1280x960'),(6,'1400x1050'),(7,'1440x1080'),(8,'1600x1200'),(9,'1856x1392'),(10,'1920x1440'),(11,'2048x1536'),(12,'1280x800'),(13,'1440x900'),(14,'1680x1050'),(15,'1920x1200'),(16,'2560x1600'),(17,'1024x576'),(18,'1152x648'),(19,'1280x720'),(20,'1366x768'),(21,'1600x900'),(22,'1920x1080'),(23,'2560x1440'),(24,'3840x2160')";
        self::CreateDatabaseTables('_resolutions',array('create'=>$sql,'insert'=>$insertSQL,'truncate'=>true));
        $arrTables['RSOL']='_resolutions';

        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_countries(
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          name varchar(255) COLLATE utf8_bin NOT NULL,
          alpha2Code varchar(2) COLLATE utf8_bin NOT NULL,
          alpha3Code varchar(3) COLLATE utf8_bin NOT NULL,
          numericCode smallint(6) NOT NULL,
          PRIMARY KEY (id),
          UNIQUE KEY id (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8';
        $insertSQL="INSERT IGNORE INTO  ".self::$tablePrefix."_countries (id, name, alpha2Code,alpha3Code,numericCode) VALUES
            (1, 'Afghanistan', 'AF', 'AFG', 4),
            (2, '&Aring;land Islands', 'AX', 'ALA', 248),
            (3, 'Albania', 'AL', 'ALB', 8),
            (4, 'Algeria', 'DZ', 'DZA', 12),
            (5, 'American Samoa', 'AS', 'ASM', 16),
            (6, 'Andorra', 'AD', 'AND', 20),
            (7, 'Angola', 'AO', 'AGO', 24),
            (8, 'Anguilla', 'AI', 'AIA', 660),
            (9, 'Antarctica', 'AQ', 'ATA', 10),
            (10, 'Antigua and Barbuda', 'AG', 'ATG', 28),
            (11, 'Argentina', 'AR', 'ARG', 32),
            (12, 'Armenia', 'AM', 'ARM', 51),
            (13, 'Aruba', 'AW', 'ABW', 533),
            (14, 'Australia', 'AU', 'AUS', 36),
            (15, 'Austria', 'AT', 'AUT', 40),
            (16, 'Azerbaijan', 'AZ', 'AZE', 31),
            (17, 'Bahamas', 'BS', 'BHS', 44),
            (18, 'Bahrain', 'BH', 'BHR', 48),
            (19, 'Bangladesh', 'BD', 'BGD', 50),
            (20, 'Barbados', 'BB', 'BRB', 52),
            (21, 'Belarus', 'BY', 'BLR', 112),
            (22, 'Belgium', 'BE', 'BEL', 56),
            (23, 'Belize', 'BZ', 'BLZ', 84),
            (24, 'Benin', 'BJ', 'BEN', 204),
            (25, 'Bermuda', 'BM', 'BMU', 60),
            (26, 'Bhutan', 'BT', 'BTN', 64),
            (27, 'Bolivia, Plurinational State of', 'BO', 'BOL', 68),
            (28, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', 535),
            (29, 'Bosnia and Herzegovina', 'BA', 'BIH', 70),
            (30, 'Botswana', 'BW', 'BWA', 72),
            (31, 'Bouvet Island', 'BV', 'BVT', 74),
            (32, 'Brazil', 'BR', 'BRA', 76),
            (33, 'British Indian Ocean Territory', 'IO', 'IOT', 86),
            (34, 'Brunei Darussalam', 'BN', 'BRN', 96),
            (35, 'Bulgaria', 'BG', 'BGR', 100),
            (36, 'Burkina Faso', 'BF', 'BFA', 854),
            (37, 'Burundi', 'BI', 'BDI', 108),
            (38, 'Cambodia', 'KH', 'KHM', 116),
            (39, 'Cameroon', 'CM', 'CMR', 120),
            (40, 'Canada', 'CA', 'CAN', 124),
            (41, 'Cape Verde', 'CV', 'CPV', 132),
            (42, 'Cayman Islands', 'KY', 'CYM', 136),
            (43, 'Central African Republic', 'CF', 'CAF', 140),
            (44, 'Chad', 'TD', 'TCD', 148),
            (45, 'Chile', 'CL', 'CHL', 152),
            (46, 'China', 'CN', 'CHN', 156),
            (47, 'Christmas Island', 'CX', 'CXR', 162),
            (48, 'Cocos (Keeling) Islands', 'CC', 'CCK', 166),
            (49, 'Colombia', 'CO', 'COL', 170),
            (50, 'Comoros', 'KM', 'COM', 174),
            (51, 'Congo', 'CG', 'COG', 178),
            (52, 'Congo, the Democratic Republic of the', 'CD', 'COD', 180),
            (53, 'Cook Islands', 'CK', 'COK', 184),
            (54, 'Costa Rica', 'CR', 'CRI', 188),
            (55, 'C&ocirc;te d\'\'Ivoire', 'CI', 'CIV', 384),
            (56, 'Croatia', 'HR', 'HRV', 191),
            (57, 'Cuba', 'CU', 'CUB', 192),
            (58, 'Cura', 'CW', 'CUW', 531),
            (59, 'Cyprus', 'CY', 'CYP', 196),
            (60, 'Czech Republic', 'CZ', 'CZE', 203),
            (61, 'Denmark', 'DK', 'DNK', 208),
            (62, 'Djibouti', 'DJ', 'DJI', 262),
            (63, 'Dominica', 'DM', 'DMA', 212),
            (64, 'Dominican Republic', 'DO', 'DOM', 214),
            (65, 'Ecuador', 'EC', 'ECU', 218),
            (66, 'Egypt', 'EG', 'EGY', 818),
            (67, 'El Salvador', 'SV', 'SLV', 222),
            (68, 'Equatorial Guinea', 'GQ', 'GNQ', 226),
            (69, 'Eritrea', 'ER', 'ERI', 232),
            (70, 'Estonia', 'EE', 'EST', 233),
            (71, 'Ethiopia', 'ET', 'ETH', 231),
            (72, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 238),
            (73, 'Faroe Islands', 'FO', 'FRO', 234),
            (74, 'Fiji', 'FJ', 'FJI', 242),
            (75, 'Finland', 'FI', 'FIN', 246),
            (76, 'France', 'FR', 'FRA', 250),
            (77, 'French Guiana', 'GF', 'GUF', 254),
            (78, 'French Polynesia', 'PF', 'PYF', 258),
            (79, 'French Southern Territories', 'TF', 'ATF', 260),
            (80, 'Gabon', 'GA', 'GAB', 266),
            (81, 'Gambia', 'GM', 'GMB', 270),
            (82, 'Georgia', 'GE', 'GEO', 268),
            (83, 'Germany', 'DE', 'DEU', 276),
            (84, 'Ghana', 'GH', 'GHA', 288),
            (85, 'Gibraltar', 'GI', 'GIB', 292),
            (86, 'Greece', 'GR', 'GRC', 300),
            (87, 'Greenland', 'GL', 'GRL', 304),
            (88, 'Grenada', 'GD', 'GRD', 308),
            (89, 'Guadeloupe', 'GP', 'GLP', 312),
            (90, 'Guam', 'GU', 'GUM', 316),
            (91, 'Guatemala', 'GT', 'GTM', 320),
            (92, 'Guernsey', 'GG', 'GGY', 831),
            (93, 'Guinea', 'GN', 'GIN', 324),
            (94, 'Guinea-Bissau', 'GW', 'GNB', 624),
            (95, 'Guyana', 'GY', 'GUY', 328),
            (96, 'Haiti', 'HT', 'HTI', 332),
            (97, 'Heard Island and McDonald Islands', 'HM', 'HMD', 334),
            (98, 'Holy See (Vatican City State)', 'VA', 'VAT', 336),
            (99, 'Honduras', 'HN', 'HND', 340),
            (100, 'Hong Kong', 'HK', 'HKG', 344),
            (101, 'Hungary', 'HU', 'HUN', 348),
            (102, 'Iceland', 'IS', 'ISL', 352),
            (103, 'India', 'IN', 'IND', 356),
            (104, 'Indonesia', 'ID', 'IDN', 360),
            (105, 'Iran, Islamic Republic of', 'IR', 'IRN', 364),
            (106, 'Iraq', 'IQ', 'IRQ', 368),
            (107, 'Ireland', 'IE', 'IRL', 372),
            (108, 'Isle of Man', 'IM', 'IMN', 833),
            (109, 'Israel', 'IL', 'ISR', 376),
            (110, 'Italy', 'IT', 'ITA', 380),
            (111, 'Jamaica', 'JM', 'JAM', 388),
            (112, 'Japan', 'JP', 'JPN', 392),
            (113, 'Jersey', 'JE', 'JEY', 832),
            (114, 'Jordan', 'JO', 'JOR', 400),
            (115, 'Kazakhstan', 'KZ', 'KAZ', 398),
            (116, 'Kenya', 'KE', 'KEN', 404),
            (117, 'Kiribati', 'KI', 'KIR', 296),
            (118, 'Korea, Democratic People''s Republic of', 'KP', 'PRK', 408),
            (119, 'Korea, Republic of', 'KR', 'KOR', 410),
            (120, 'Kuwait', 'KW', 'KWT', 414),
            (121, 'Kyrgyzstan', 'KG', 'KGZ', 417),
            (122, 'Lao People''s Democratic Republic', 'LA', 'LAO', 418),
            (123, 'Latvia', 'LV', 'LVA', 428),
            (124, 'Lebanon', 'LB', 'LBN', 422),
            (125, 'Lesotho', 'LS', 'LSO', 426),
            (126, 'Liberia', 'LR', 'LBR', 430),
            (127, 'Libya', 'LY', 'LBY', 434),
            (128, 'Liechtenstein', 'LI', 'LIE', 438),
            (129, 'Lithuania', 'LT', 'LTU', 440),
            (130, 'Luxembourg', 'LU', 'LUX', 442),
            (131, 'Macao', 'MO', 'MAC', 446),
            (132, 'Macedonia, the former Yugoslav Republic of', 'MK', 'MKD', 807),
            (133, 'Madagascar', 'MG', 'MDG', 450),
            (134, 'Malawi', 'MW', 'MWI', 454),
            (135, 'Malaysia', 'MY', 'MYS', 458),
            (136, 'Maldives', 'MV', 'MDV', 462),
            (137, 'Mali', 'ML', 'MLI', 466),
            (138, 'Malta', 'MT', 'MLT', 470),
            (139, 'Marshall Islands', 'MH', 'MHL', 584),
            (140, 'Martinique', 'MQ', 'MTQ', 474),
            (141, 'Mauritania', 'MR', 'MRT', 478),
            (142, 'Mauritius', 'MU', 'MUS', 480),
            (143, 'Mayotte', 'YT', 'MYT', 175),
            (144, 'Mexico', 'MX', 'MEX', 484),
            (145, 'Micronesia\, Federated States of', 'FM', 'FSM', 583),
            (146, 'Moldova, Republic of', 'MD', 'MDA', 498),
            (147, 'Monaco', 'MC', 'MCO', 492),
            (148, 'Mongolia', 'MN', 'MNG', 496),
            (149, 'Montenegro', 'ME', 'MNE', 499),
            (150, 'Montserrat', 'MS', 'MSR', 500),
            (151, 'Morocco', 'MA', 'MAR', 504),
            (152, 'Mozambique', 'MZ', 'MOZ', 508),
            (153, 'Myanmar', 'MM', 'MMR', 104),
            (154, 'Namibia', 'NA', 'NAM', 516),
            (155, 'Nauru', 'NR', 'NRU', 520),
            (156, 'Nepal', 'NP', 'NPL', 524),
            (157, 'Netherlands', 'NL', 'NLD', 528),
            (158, 'New Caledonia', 'NC', 'NCL', 540),
            (159, 'New Zealand', 'NZ', 'NZL', 554),
            (160, 'Nicaragua', 'NI', 'NIC', 558),
            (161, 'Niger', 'NE', 'NER', 562),
            (162, 'Nigeria', 'NG', 'NGA', 566),
            (163, 'Niue', 'NU', 'NIU', 570),
            (164, 'Norfolk Island', 'NF', 'NFK', 574),
            (165, 'Northern Mariana Islands', 'MP', 'MNP', 580),
            (166, 'Norway', 'NO', 'NOR', 578),
            (167, 'Oman', 'OM', 'OMN', 512),
            (168, 'Pakistan', 'PK', 'PAK', 586),
            (169, 'Palau', 'PW', 'PLW', 585),
            (170, 'Palestine, State of', 'PS', 'PSE', 275),
            (171, 'Panama', 'PA', 'PAN', 591),
            (172, 'Papua New Guinea', 'PG', 'PNG', 598),
            (173, 'Paraguay', 'PY', 'PRY', 600),
            (174, 'Peru', 'PE', 'PER', 604),
            (175, 'Philippines', 'PH', 'PHL', 608),
            (176, 'Pitcairn', 'PN', 'PCN', 612),
            (177, 'Poland', 'PL', 'POL', 616),
            (178, 'Portugal', 'PT', 'PRT', 620),
            (179, 'Puerto Rico', 'PR', 'PRI', 630),
            (180, 'Qatar', 'QA', 'QAT', 634),
            (181, 'R&eacute;union', 'RE', 'REU', 638),
            (182, 'Romania', 'RO', 'ROU', 642),
            (183, 'Russian Federation', 'RU', 'RUS', 643),
            (184, 'Rwanda', 'RW', 'RWA', 646),
            (185, 'Saint Barth&eacute;lemy', 'BL', 'BLM', 652),
            (186, 'Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN', 654),
            (187, 'Saint Kitts and Nevis', 'KN', 'KNA', 659),
            (188, 'Saint Lucia', 'LC', 'LCA', 662),
            (189, 'Saint Martin (French part)', 'MF', 'MAF', 663),
            (190, 'Saint Pierre and Miquelon', 'PM', 'SPM', 666),
            (191, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 670),
            (192, 'Samoa', 'WS', 'WSM', 882),
            (193, 'San Marino', 'SM', 'SMR', 674),
            (194, 'Sao Tome and Principe', 'ST', 'STP', 678),
            (195, 'Saudi Arabia', 'SA', 'SAU', 682),
            (196, 'Senegal', 'SN', 'SEN', 686),
            (197, 'Serbia', 'RS', 'SRB', 688),
            (198, 'Seychelles', 'SC', 'SYC', 690),
            (199, 'Sierra Leone', 'SL', 'SLE', 694),
            (200, 'Singapore', 'SG', 'SGP', 702),
            (201, 'Sint Maarten (Dutch part)', 'SX', 'SXM', 534),
            (202, 'Slovakia', 'SK', 'SVK', 703),
            (203, 'Slovenia', 'SI', 'SVN', 705),
            (204, 'Solomon Islands', 'SB', 'SLB', 90),
            (205, 'Somalia', 'SO', 'SOM', 706),
            (206, 'South Africa', 'ZA', 'ZAF', 710),
            (207, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', 239),
            (208, 'South Sudan', 'SS', 'SSD', 728),
            (209, 'Spain', 'ES', 'ESP', 724),
            (210, 'Sri Lanka', 'LK', 'LKA', 144),
            (211, 'Sudan', 'SD', 'SDN', 729),
            (212, 'Suriname', 'SR', 'SUR', 740),
            (213, 'Svalbard and Jan Mayen', 'SJ', 'SJM', 744),
            (214, 'Swaziland', 'SZ', 'SWZ', 748),
            (215, 'Sweden', 'SE', 'SWE', 752),
            (216, 'Switzerland', 'CH', 'CHE', 756),
            (217, 'Syrian Arab Republic', 'SY', 'SYR', 760),
            (218, 'Taiwan, Province of China', 'TW', 'TWN', 158),
            (219, 'Tajikistan', 'TJ', 'TJK', 762),
            (220, 'Tanzania, United Republic of', 'TZ', 'TZA', 834),
            (221, 'Thailand', 'TH', 'THA', 764),
            (222, 'Timor-Leste', 'TL', 'TLS', 626),
            (223, 'Togo', 'TG', 'TGO', 768),
            (224, 'Tokelau', 'TK', 'TKL', 772),
            (225, 'Tonga', 'TO', 'TON', 776),
            (226, 'Trinidad and Tobago', 'TT', 'TTO', 780),
            (227, 'Tunisia', 'TN', 'TUN', 788),
            (228, 'Turkey', 'TR', 'TUR', 792),
            (229, 'Turkmenistan', 'TM', 'TKM', 795),
            (230, 'Turks and Caicos Islands', 'TC', 'TCA', 796),
            (231, 'Tuvalu', 'TV', 'TUV', 798),
            (232, 'Uganda', 'UG', 'UGA', 800),
            (233, 'Ukraine', 'UA', 'UKR', 804),
            (234, 'United Arab Emirates', 'AE', 'ARE', 784),
            (235, 'United Kingdom', 'GB', 'GBR', 826),
            (236, 'United States', 'US', 'USA', 840),
            (237, 'United States Minor Outlying Islands', 'UM', 'UMI', 581),
            (238, 'Uruguay', 'UY', 'URY', 858),
            (239, 'Uzbekistan', 'UZ', 'UZB', 860),
            (240, 'Vanuatu', 'VU', 'VUT', 548),
            (241, 'Venezuela\, Bolivarian Republic of', 'VE', 'VEN', 862),
            (242, 'Viet Nam', 'VN', 'VNM', 704),
            (243, 'Virgin Islands, British', 'VG', 'VGB', 92),
            (244, 'Virgin Islands, U.S.', 'VI', 'VIR', 850),
            (245, 'Wallis and Futuna', 'WF', 'WLF', 876),
            (246, 'Western Sahara', 'EH', 'ESH', 732),
            (247, 'Yemen', 'YE', 'YEM', 887),
            (248, 'Zambia', 'ZM', 'ZMB', 894),
            (249, 'Zimbabwe', 'ZW', 'ZWE', 716)";
        self::CreateDatabaseTables('_countries',array('create'=>$sql,'insert'=>$insertSQL,'truncate'=>true));
        $arrTables['COUNTRY']='_countries';
        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_dailyHourlyReport(
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          name varchar(50) NOT NULL,
          reportDate datetime NOT NULL,
          content TEXT NOT NULL,
          timezone varchar(20) NOT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_dailyHourlyReport',array('create'=>$sql));
        $arrTables['DHR']='_dailyHourlyReport';
        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_monthlyDailyReport(
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          name varchar(50) NOT NULL,
          reportMonthYear varchar(50) NOT NULL,
          content TEXT NOT NULL,
          timezone varchar(20) NOT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_monthlyDailyReport',array('create'=>$sql));
        $arrTables['MDR']='_monthlyDailyReport';
        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_yearlyMonthlyReport(
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          name varchar(50) NOT NULL,
          reportYear varchar(10) NOT NULL,
          content TEXT NOT NULL,
          timezone varchar(20) NOT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_yearlyMonthlyReport',array('create'=>$sql));
        $arrTables['YMR']='_yearlyMonthlyReport';
        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_datewise_report(
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          date date NOT NULL,
          normal int(2) NOT NULL DEFAULT "0",
          hour int(2) NOT NULL DEFAULT "0",
          search_engine varchar(255) NOT NULL DEFAULT "",
          browser int(2) NOT NULL DEFAULT "0",
          screen int(2) NOT NULL DEFAULT "0",
          country int(3) NOT NULL DEFAULT "0",
          city varchar(255) NOT NULL DEFAULT "",
          operating_system int(2) NOT NULL DEFAULT "0",
          url_id int(11) NOT NULL DEFAULT "0",
          total_page_views int(11) NOT NULL DEFAULT "0",
          total_visitors int(11) NOT NULL DEFAULT "0",
          total_first_time_visitors int(11) NOT NULL DEFAULT "0",
          total_bounce int(11) NOT NULL DEFAULT "0",
          PRIMARY KEY (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_datewise_report',array('create'=>$sql));
        $arrTables['DWR']='_datewise_report';
        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_monthwise_report(
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          date date NOT NULL,
          normal int(2) NOT NULL DEFAULT "0",
          hour int(2) NOT NULL DEFAULT "0",
          search_engine varchar(255) NOT NULL DEFAULT "",
          browser int(2) NOT NULL DEFAULT "0",
          screen int(2) NOT NULL DEFAULT "0",
          country int(3) NOT NULL DEFAULT "0",
          city varchar(255) NOT NULL DEFAULT "",
          operating_system int(2) NOT NULL DEFAULT "0",
          url_id int(11) NOT NULL DEFAULT "0",
          total_page_views int(11) NOT NULL DEFAULT "0",
          total_visitors int(11) NOT NULL DEFAULT "0",
          total_first_time_visitors int(11) NOT NULL DEFAULT "0",
          total_bounce int(11) NOT NULL DEFAULT "0",
          PRIMARY KEY (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_monthwise_report',array('create'=>$sql));
        $arrTables['MWR']='_monthwise_report';
        $sql='CREATE TABLE IF NOT EXISTS '.self::$tablePrefix.'_yearwise_report(
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          date date NOT NULL,
          normal int(2) NOT NULL DEFAULT "0",
          hour int(2) NOT NULL DEFAULT "0",
          search_engine varchar(255) NOT NULL DEFAULT "",
          browser int(2) NOT NULL DEFAULT "0",
          screen int(2) NOT NULL DEFAULT "0",
          country int(3) NOT NULL DEFAULT "0",
          city varchar(255) NOT NULL DEFAULT "",
          operating_system int(2) NOT NULL DEFAULT "0",
          url_id int(11) NOT NULL DEFAULT "0",
          total_page_views int(11) NOT NULL DEFAULT "0",
          total_visitors int(11) NOT NULL DEFAULT "0",
          total_first_time_visitors int(11) NOT NULL DEFAULT "0",
          total_bounce int(11) NOT NULL DEFAULT "0",
          PRIMARY KEY (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8';
        self::CreateDatabaseTables('_yearwise_report',array('create'=>$sql));
        $arrTables['YWR']='_yearwise_report';
        
        update_option(WSM_PREFIX.'_tables',$arrTables);
        
        $sql='SELECT LV.visitId, LV.URLId, LV.keyword, LV.refererUrlId, LU.countryId, LU.regionId, COUNT(*) As totalViews, max(LV.serverTime) AS visitLastActionTime FROM '.self::$tablePrefix.'_logVisit LV LEFT JOIN '.self::$tablePrefix.'_logUniqueVisit LU ON LV.visitId=LU.id GROUP BY LV.visitId, LV.URLId';
        self::wsmCreateDatabaseView(self::$tablePrefix.'_pageViews',$sql);
                
        $sql='SELECT LU.id, LU.visitorId,sum(LU.totalTimeVisit) as totalTimeVisit,MIN(LV.serverTime) as firstVisitTime, LU.refererUrlId FROM '.self::$tablePrefix.'_logUniqueVisit LU LEFT JOIN '.self::$tablePrefix.'_logVisit LV ON LV.visitId=LU.id GROUP BY LU.visitorId';
        self::wsmCreateDatabaseView(self::$tablePrefix.'_uniqueVisitors',$sql);
        $sql='SELECT visitId, visitLastActionTime FROM '.self::$tablePrefix.'_pageViews GROUP BY visitId HAVING COUNT(URLId)=1';
        self::wsmCreateDatabaseView(self::$tablePrefix.'_bounceVisits',$sql);        
      
        //left JOIN '.self::$tablePrefix.'_logVisit LV2 ON LV.visitId=LV2.visitId AND LV2.serverTime>LV.serverTime
        $sql='SELECT LV.visitId,LU.userId, LV.serverTime,LU.visitLastActionTime, LV.urlId, COUNT(LV.urlId) as hits, UL.title, CONCAT(UL.protocol, UL.url) as url, CONCAT(UL2.protocol, UL2.url) as refUrl, LU.visitorId, LU.ipAddress,LU.city, C.alpha2Code,C.name as country, LU.deviceType, B.name as browser,OS.name as osystem, LU.latitude, LU.longitude,R.name as resolution, SE.name as searchEngine, TB.name as toolBar FROM '.self::$tablePrefix.'_logVisit LV LEFT JOIN '.self::$tablePrefix.'_logUniqueVisit LU ON LU.id=LV.visitId LEFT JOIN '.self::$tablePrefix.'_countries C ON C.id=LU.countryId LEFT JOIN '.self::$tablePrefix.'_browsers B ON B.id=LU.browserId LEFT JOIN '.self::$tablePrefix.'_resolutions R ON R.id=LU.resolutionId LEFT JOIN '.self::$tablePrefix.'_url_log UL ON LV.urlId=UL.id LEFT JOIN '.self::$tablePrefix.'_url_log UL2 ON LV.refererUrlId=UL2.id  LEFT JOIN '.self::$tablePrefix.'_searchEngines SE ON SE.id=UL.searchEngine LEFT JOIN '.self::$tablePrefix.'_toolBars TB ON TB.id=UL.toolBar LEFT JOIN '.self::$tablePrefix.'_oSystems OS ON OS.id=LU.oSystemId GROUP BY LV.visitId,LV.urlId ORDER BY LV.visitId DESC ,LV.serverTime DESC';
        self::wsmCreateDatabaseView(self::$tablePrefix.'_visitorInfo',$sql);
        //self::wsm_fnCreateImportantViews();
        //self::wsm_createMonthWiseViews();
	}

	static function wsmCreateDatabaseView($viewName, $sqlQuery){
        global $wpdb;
       // echo '<br>'.$sql="DROP VIEW {$viewName};";
        //$wpdb->query($sql);
        $sql="CREATE OR REPLACE VIEW {$viewName} AS {$sqlQuery}";
        $wpdb->query($sql);
    }
    static function CreateDatabaseTables($tableName, $arrSQL){
        global $wpdb;
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
        $checkSQL = "show tables like '".self::$tablePrefix."{$tableName}'";
        if($wpdb->get_var($checkSQL) != self::$tablePrefix.$tableName){
            if(isset($arrSQL['create']) && $arrSQL['create']!=''){
                $res=dbDelta($arrSQL['create']);
            }
        }
        if(isset($arrSQL['truncate']) && $arrSQL['truncate']==true){
                $wpdb->query('TRUNCATE TABLE '.self::$tablePrefix.$tableName);
        }
        if(isset($arrSQL['insert']) && $arrSQL['insert']!=''){
                $wpdb->query($arrSQL['insert']);
            }
        return false;
    }



  

}
