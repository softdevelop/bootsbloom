SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `backers`
--

CREATE TABLE IF NOT EXISTS `backers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payment authorizedor captured',
  `paypal_payment_token_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reauthorize_date` int(11) NOT NULL,
  `capture_date` int(11) DEFAULT NULL,
  `captured_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `void_date` int(11) DEFAULT NULL,
  `void_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_cancelled` tinyint(4) NOT NULL DEFAULT '0',
  `cancellation_notification_sent` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE IF NOT EXISTS `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE IF NOT EXISTS `blocked_users` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `blocked_user_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `blog_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `name`, `slug`, `blog_image`, `description`, `active`, `created`, `modified`) VALUES
(1, 'BoostBloom', 'boostbloom', 'Blog1363710909test_blog.jpg', 'Blog Control', 1, 1346925259, 1363715661);

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `blog_id`, `category_name`, `slug`, `description`, `active`, `created`, `modified`) VALUES
(1, 1, 'News', 'news', 'nnews', 1, 1346925282, 1346925282),
(2, 1, 'Profile', 'profile', 'profile', 1, 1346928892, 1351488422),
(3, 1, 'updates', 'updates', 'updates', 1, 1356950811, 1383090752);

-- --------------------------------------------------------

--
-- Table structure for table `blog_fav_projects`
--

CREATE TABLE IF NOT EXISTS `blog_fav_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `blog_category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(555) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `allow_comment` tinyint(1) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_comments`
--

CREATE TABLE IF NOT EXISTS `blog_post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `blog_post_id` int(11) NOT NULL,
  `blog_category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `category_name`, `slug`, `active`, `is_deleted`, `created`, `modified`) VALUES
(1, 0, 'Art', 'art', 1, 0, 1340889444, 1342611099),
(2, 0, 'Comics', 'comics', 1, 0, 1340889471, 1342611094),
(3, 0, 'Dance', 'dance', 1, 0, 1341824195, 1342611089),
(4, 0, 'Design', 'design', 1, 0, 1341824205, 1342611151),
(5, 0, 'Fashion', 'fashion', 1, 0, 1341824257, 1342611076),
(6, 0, 'Film & Video', 'film-video', 1, 0, 1341824807, 1342611070),
(7, 0, 'Food', 'food', 1, 0, 1341824821, 1342611060),
(8, 0, 'Games', 'games', 1, 0, 1341824831, 1342611037),
(9, 0, 'Music', 'music', 1, 0, 1341824858, 1342611030),
(10, 0, 'Photography', 'photography', 1, 0, 1341824884, 1342611024),
(11, 0, 'Publishing', 'publishing', 1, 0, 1341824891, 1342611018),
(12, 0, 'Technology', 'technology', 1, 0, 1341824926, 1342611013),
(13, 0, 'Theater', 'theater', 1, 0, 1341824942, 1342611007),
(14, 1, 'Conceptual Art', 'conceptual-art', 1, 0, 1343393369, 1343393956),
(15, 0, 'Social', 'social', 1, 0, 1348841439, 1351487807);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `iso3166_1` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=447 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `iso3166_1`, `name`, `created`, `modified`) VALUES
(398, 'AM', 'Yerevan', 1383334737, 1383334737),
(399, 'AM', 'Gyumri', 1383334771, 1383334771),
(400, 'AM', 'Vanadzor', 1383334793, 1383334793),
(401, 'AM', 'Vagharshapat', 1383334813, 1383334813),
(402, 'AM', 'Hrazdan', 1383334827, 1383334827),
(403, 'AM', 'Abovyan', 1383334845, 1383334845),
(404, 'AM', 'Kapan', 1383334876, 1383334876),
(405, 'AM', 'Armavir', 1383334890, 1383334890),
(406, 'AM', 'Gavar', 1383334907, 1383334907),
(407, 'AM', 'Artashat', 1383334946, 1383334946),
(408, 'AM', 'Charentsavan', 1383334961, 1383334961),
(409, 'AM', 'Sevan', 1383334978, 1383334978),
(410, 'AM', 'Goris', 1383335000, 1383335000),
(411, 'AM', 'Masis', 1383335016, 1383335016),
(412, 'AM', 'Ashtarak', 1383335031, 1383335031),
(413, 'AM', 'Ararat', 1383335044, 1383335044),
(414, 'AM', 'Ijevan', 1383335062, 1383335062),
(415, 'AM', 'Artik', 1383335074, 1383335074),
(416, 'AM', 'Sisian', 1383335092, 1383335092),
(417, 'AM', 'Alaverdi', 1383335106, 1383335106),
(418, 'AM', 'Stepanavan', 1383335122, 1383335122),
(419, 'AM', 'Dilijan', 1383335134, 1383335134),
(420, 'AM', 'Spitak', 1383335146, 1383335146),
(421, 'AM', 'Vedi', 1383335157, 1383335157),
(422, 'AM', 'Vardenis', 1383335170, 1383335170),
(423, 'AM', 'Yeghvard', 1383335187, 1383335187),
(424, 'AM', 'Martuni', 1383335200, 1383335200),
(425, 'AM', 'Metsamor', 1383335212, 1383335212),
(426, 'AM', 'Nor Hachen', 1383335227, 1383335227),
(427, 'AM', 'Tashir', 1383335242, 1383335242),
(428, 'AM', 'Berd', 1383335253, 1383335253),
(429, 'AM', 'Kajaran', 1383335275, 1383335275),
(430, 'AM', 'Byureghavan', 1383335286, 1383335286),
(431, 'AM', 'Yeghegnadzor', 1383335300, 1383335300),
(432, 'AM', 'Chambarak', 1383335311, 1383335311),
(433, 'AM', 'Aparan', 1383335325, 1383335325),
(434, 'AM', 'Jermuk', 1383335338, 1383335338),
(435, 'AM', 'Maralik', 1383335349, 1383335349),
(436, 'AM', 'Vayk', 1383335359, 1383335359),
(437, 'AM', 'Talin', 1383335370, 1383335370),
(438, 'AM', 'Noyemberyan', 1383335383, 1383335383),
(439, 'AM', 'Meghri', 1383335396, 1383335396),
(440, 'AM', 'Agarak', 1383335412, 1383335412),
(441, 'AM', 'Akhtala', 1383335422, 1383335422),
(442, 'AM', 'Ayrum', 1383335433, 1383335433),
(443, 'AM', 'Tumanyan', 1383335445, 1383335445),
(444, 'AM', 'Tsaghkadzor', 1383335457, 1383335457),
(445, 'AM', 'Shamlugh', 1383335467, 1383335467),
(446, 'AM', 'Dastakert', 1383335477, 1383335477);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `iso3166_1` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_type` (`iso3166_1`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=242 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `iso3166_1`) VALUES
(1, 'Afganistan', 'AF'),
(2, 'Aland', 'AX'),
(3, 'Albania', 'AL'),
(4, 'Algeria', 'DZ'),
(5, 'American Samoa', 'AS'),
(6, 'Andorra', 'AD'),
(7, 'Angola', 'AO'),
(8, 'Anguilla', 'AI'),
(9, 'Antarctica', 'AQ'),
(10, 'Antigua and Barbuda', 'AG'),
(11, 'Argentina', 'AR'),
(12, 'Armenia', 'AM'),
(13, 'Aruba', 'AW'),
(14, 'Australia', 'AU'),
(15, 'Austria', 'AT'),
(16, 'Azerbaijan', 'AZ'),
(17, 'Bahamas', 'BS'),
(18, 'Bahrain', 'BH'),
(19, 'Bangladesh', 'BD'),
(20, 'Barbados', 'BB'),
(21, 'Belarus', 'BY'),
(22, 'Belgium', 'BE'),
(23, 'Belize', 'BZ'),
(24, 'Benin', 'BJ'),
(25, 'Bermuda', 'BM'),
(26, 'Bhutan', 'BT'),
(27, 'Bolivia', 'BO'),
(28, 'Bosnia and Herzegovina', 'BA'),
(29, 'Botswana', 'BW'),
(30, 'Bouvet Island', 'BV'),
(31, 'Brazil', 'BR'),
(32, 'British Indian Ocean Territory', 'IO'),
(33, 'Brunei Darussalam', 'BN'),
(34, 'Bulgaria', 'BG'),
(35, 'Burkina Faso', 'BF'),
(36, 'Burundi', 'BI'),
(37, 'Cambodia', 'KH'),
(38, 'Cameroon', 'CM'),
(39, 'Canada', 'CA'),
(40, 'Cape Verde', 'CV'),
(41, 'Cayman Islands', 'KY'),
(42, 'Central African Republic', 'CF'),
(43, 'Chad', 'TD'),
(44, 'Chile', 'CL'),
(45, 'China', 'CN'),
(46, 'Christmas Island', 'CX'),
(47, 'Cocos (Keeling) Islands', 'CC'),
(48, 'Colombia', 'CO'),
(49, 'Comoros', 'KM'),
(50, 'Congo (Brazzaville)', 'CG'),
(51, 'Congo (Kinshasa)', 'CD'),
(52, 'Cook Islands', 'CK'),
(53, 'Costa Rica', 'CR'),
(54, 'Cote d Ivoire', 'CI'),
(55, 'Croatia', 'HR'),
(56, 'Cuba', 'CU'),
(57, 'Cyprus', 'CY'),
(58, 'Czech Republic', 'CZ'),
(59, 'Denmark', 'DK'),
(60, 'Djibouti', 'DJ'),
(61, 'Dominica', 'DM'),
(62, 'Dominican Republic', 'DO'),
(63, 'East Timor', 'TP'),
(64, 'Ecuador', 'EC'),
(65, 'Egypt', 'EG'),
(66, 'El Salvador', 'SV'),
(67, 'Equatorial Guinea', 'GQ'),
(68, 'Eritrea', 'ER'),
(69, 'Estonia', 'EE'),
(70, 'Ethiopia', 'ET'),
(71, 'Falkland Islands', 'FK'),
(72, 'Faroe Islands', 'FO'),
(73, 'Fiji', 'FJ'),
(74, 'Finland', 'FI'),
(75, 'France', 'FR'),
(76, 'French Guiana', 'GF'),
(77, 'French Polynesia', 'PF'),
(78, 'French Southern Lands', 'TF'),
(79, 'Gabon', 'GA'),
(80, 'Gambia', 'GM'),
(81, 'Georgia', 'GE'),
(82, 'Germany', 'DE'),
(83, 'Ghana', 'GH'),
(84, 'Gibraltar', 'GI'),
(85, 'Greece', 'GR'),
(86, 'Greenland', 'GL'),
(87, 'Grenada', 'GD'),
(88, 'Guadeloupe', 'GP'),
(89, 'Guam', 'GU'),
(90, 'Guatemala', 'GT'),
(91, 'Guinea', 'GN'),
(92, 'Guinea-Bissau', 'GW'),
(93, 'Guyana', 'GY'),
(94, 'Haiti', 'HT'),
(95, 'Heard and McDonald Islands', 'HM'),
(96, 'Honduras', 'HN'),
(97, 'Hong Kong', 'HK'),
(98, 'Hungary', 'HU'),
(99, 'Iceland', 'IS'),
(100, 'India', 'IN'),
(101, 'Indonesia', 'ID'),
(102, 'Iran', 'IR'),
(103, 'Iraq', 'IQ'),
(104, 'Ireland', 'IE'),
(105, 'Israel', 'IL'),
(106, 'Italy', 'IT'),
(107, 'Jamaica', 'JM'),
(108, 'Japan', 'JP'),
(109, 'Jordan', 'JO'),
(110, 'Kazakhstan', 'KZ'),
(111, 'Kenya', 'KE'),
(112, 'Kiribati', 'KI'),
(113, 'Korea, North', 'KP'),
(114, 'Korea, South', 'KR'),
(115, 'Kuwait', 'KW'),
(116, 'Kyrgyzstan', 'KG'),
(117, 'Laos', 'LA'),
(118, 'Latvia', 'LV'),
(119, 'Lebanon', 'LB'),
(120, 'Lesotho', 'LS'),
(121, 'Liberia', 'LR'),
(122, 'Libya', 'LY'),
(123, 'Liechtenstein', 'LI'),
(124, 'Lithuania', 'LT'),
(125, 'Luxembourg', 'LU'),
(126, 'Macau', 'MO'),
(127, 'Macedonia', 'MK'),
(128, 'Madagascar', 'MG'),
(129, 'Malawi', 'MW'),
(130, 'Malaysia', 'MY'),
(131, 'Maldives', 'MV'),
(132, 'Mali', 'ML'),
(133, 'Malta', 'MT'),
(134, 'Marshall Islands', 'MH'),
(135, 'Martinique', 'MQ'),
(136, 'Mauritania', 'MR'),
(137, 'Mauritius', 'MU'),
(138, 'Mayotte', 'YT'),
(139, 'Mexico', 'MX'),
(140, 'Micronesia', 'FM'),
(141, 'Moldova', 'MD'),
(142, 'Monaco', 'MC'),
(143, 'Mongolia', 'MN'),
(144, 'Montserrat', 'MS'),
(145, 'Morocco', 'MA'),
(146, 'Mozambique', 'MZ'),
(147, 'Myanmar', 'MM'),
(148, 'Namibia', 'NA'),
(149, 'Nauru', 'NR'),
(150, 'Nepal', 'NP'),
(151, 'Netherlands', 'NL'),
(152, 'Netherlands Antilles', 'AN'),
(153, 'New Caledonia', 'NC'),
(154, 'New Zealand', 'NZ'),
(155, 'Nicaragua', 'NI'),
(156, 'Niger', 'NE'),
(157, 'Nigeria', 'NG'),
(158, 'Niue', 'NU'),
(159, 'Norfolk Island', 'NF'),
(160, 'Northern Mariana Islands', 'MP'),
(161, 'Norway', 'NO'),
(162, 'Oman', 'OM'),
(163, 'Pakistan', 'PK'),
(164, 'Palau', 'PW'),
(165, 'Palestine', 'PS'),
(166, 'Panama', 'PA'),
(167, 'Papua New Guinea', 'PG'),
(168, 'Paraguay', 'PY'),
(169, 'Peru', 'PE'),
(170, 'Philippines', 'PH'),
(171, 'Pitcairn', 'PN'),
(172, 'Poland', 'PL'),
(173, 'Portugal', 'PT'),
(174, 'Puerto Rico', 'PR'),
(175, 'Qatar', 'QA'),
(176, 'Reunion', 'RE'),
(177, 'Romania', 'RO'),
(178, 'Russian Federation', 'RU'),
(179, 'Rwanda', 'RW'),
(180, 'Saint Helena', 'SH'),
(181, 'Saint Kitts and Nevis', 'KN'),
(182, 'Saint Lucia', 'LC'),
(183, 'Saint Pierre and Miquelon', 'PM'),
(184, 'Saint Vincent and the Grenadines', 'VC'),
(185, 'Samoa', 'WS'),
(186, 'San Marino', 'SM'),
(187, 'Sao Tome and Principe', 'ST'),
(188, 'Saudi Arabia', 'SA'),
(189, 'Senegal', 'SN'),
(190, 'Serbia and Montenegro', 'CS'),
(191, 'Seychelles', 'SC'),
(192, 'Sierra Leone', 'SL'),
(193, 'Singapore', 'SG'),
(194, 'Slovakia', 'SK'),
(195, 'Slovenia', 'SI'),
(196, 'Solomon Islands', 'SB'),
(197, 'Somalia', 'SO'),
(198, 'South Africa', 'ZA'),
(199, 'South Georgia and South Sandwich Islands', 'GS'),
(200, 'Spain', 'ES'),
(201, 'Sri Lanka', 'LK'),
(202, 'Sudan', 'SD'),
(203, 'Suriname', 'SR'),
(204, 'Svalbard and Jan Mayen Islands', 'SJ'),
(205, 'Swaziland', 'SZ'),
(206, 'Sweden', 'SE'),
(207, 'Switzerland', 'CH'),
(208, 'Syria', 'SY'),
(209, 'Taiwan', 'TW'),
(210, 'Tajikistan', 'TJ'),
(211, 'Tanzania', 'TZ'),
(212, 'Thailand', 'TH'),
(213, 'Timor-Leste', 'TL'),
(214, 'Togo', 'TG'),
(215, 'Tokelau', 'TK'),
(216, 'Tonga', 'TO'),
(217, 'Trinidad and Tobago', 'TT'),
(218, 'Tunisia', 'TN'),
(219, 'Turkey', 'TR'),
(220, 'Turkmenistan', 'TM'),
(221, 'Turks and Caicos Islands', 'TC'),
(222, 'Tuvalu', 'TV'),
(223, 'Uganda', 'UG'),
(224, 'Ukraine', 'UA'),
(225, 'United Arab Emirates', 'AE'),
(226, 'United Kingdom', 'GB'),
(227, 'United States Minor Outlying Islands', 'UM'),
(228, 'United States of America', 'US'),
(229, 'Uruguay', 'UY'),
(230, 'Uzbekistan', 'UZ'),
(231, 'Vanuatu', 'VU'),
(232, 'Vatican City', 'VA'),
(233, 'Venezuela', 'VE'),
(234, 'Vietnam', 'VN'),
(235, 'Virgin Islands, British', 'VG'),
(236, 'Virgin Islands, U.S.', 'VI'),
(237, 'Wallis and Futuna Islands', 'WF'),
(238, 'Western Sahara', 'EH'),
(239, 'Yemen', 'YE'),
(240, 'Zambia', 'ZM'),
(241, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `cron_send_notification_emails`
--

CREATE TABLE IF NOT EXISTS `cron_send_notification_emails` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_PROFILE_PROPERTY` (`field`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `emaillogs`
--

CREATE TABLE IF NOT EXISTS `emaillogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_type` enum('A','B','C','D','E','F','G','H','I','J','K') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(11) NOT NULL DEFAULT '1',
  `deleted` tinyint(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facebook_friends`
--

CREATE TABLE IF NOT EXISTS `facebook_friends` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friend_facebook_user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friend_facebook_image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `friend_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `slug`, `active`, `created`, `modified`) VALUES
(1, 'Super Admin', 'supar-admin', 1, 2012, 1347429663),
(2, 'Sub Admin', 'sub-admin', 1, 2012, 2012),
(3, 'Users', 'users', 1, 2012, 1351077043);

-- --------------------------------------------------------

--
-- Table structure for table `group_privileges`
--

CREATE TABLE IF NOT EXISTS `group_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1078 ;

--
-- Dumping data for table `group_privileges`
--

INSERT INTO `group_privileges` (`id`, `group_id`, `module_id`, `created`, `modified`) VALUES
(1004, 2, 30, 1368627105, 1368627105),
(1003, 2, 29, 1368627105, 1368627105),
(1002, 2, 28, 1368627105, 1368627105),
(1001, 2, 27, 1368627105, 1368627105),
(1000, 2, 26, 1368627105, 1368627105),
(999, 2, 25, 1368627105, 1368627105),
(998, 2, 24, 1368627105, 1368627105),
(997, 2, 23, 1368627105, 1368627105),
(996, 2, 22, 1368627105, 1368627105),
(995, 2, 21, 1368627105, 1368627105),
(994, 2, 20, 1368627105, 1368627105),
(993, 2, 19, 1368627105, 1368627105),
(992, 2, 18, 1368627105, 1368627105),
(991, 2, 17, 1368627105, 1368627105),
(990, 2, 16, 1368627105, 1368627105),
(989, 2, 15, 1368627105, 1368627105),
(988, 2, 13, 1368627105, 1368627105),
(987, 2, 12, 1368627105, 1368627105),
(986, 2, 11, 1368627105, 1368627105),
(985, 2, 119, 1368627105, 1368627105),
(984, 2, 9, 1368627105, 1368627105),
(983, 2, 8, 1368627105, 1368627105),
(982, 2, 7, 1368627105, 1368627105),
(981, 2, 5, 1368627105, 1368627105),
(980, 2, 4, 1368627105, 1368627105),
(979, 2, 3, 1368627105, 1368627105),
(978, 2, 2, 1368627105, 1368627105),
(1005, 2, 31, 1368627105, 1368627105),
(1006, 2, 32, 1368627105, 1368627105),
(1007, 2, 33, 1368627105, 1368627105),
(1008, 2, 34, 1368627105, 1368627105),
(1009, 2, 36, 1368627105, 1368627105),
(1010, 2, 37, 1368627105, 1368627105),
(1011, 2, 38, 1368627105, 1368627105),
(1012, 2, 39, 1368627105, 1368627105),
(1013, 2, 40, 1368627105, 1368627105),
(1014, 2, 41, 1368627105, 1368627105),
(1015, 2, 42, 1368627105, 1368627105),
(1016, 2, 43, 1368627105, 1368627105),
(1017, 2, 44, 1368627105, 1368627105),
(1018, 2, 45, 1368627105, 1368627105),
(1019, 2, 46, 1368627105, 1368627105),
(1020, 2, 48, 1368627105, 1368627105),
(1021, 2, 49, 1368627105, 1368627105),
(1022, 2, 50, 1368627105, 1368627105),
(1023, 2, 51, 1368627105, 1368627105),
(1024, 2, 52, 1368627105, 1368627105),
(1025, 2, 53, 1368627105, 1368627105),
(1026, 2, 54, 1368627105, 1368627105),
(1027, 2, 55, 1368627105, 1368627105),
(1028, 2, 56, 1368627105, 1368627105),
(1029, 2, 57, 1368627105, 1368627105),
(1030, 2, 58, 1368627105, 1368627105),
(1031, 2, 59, 1368627105, 1368627105),
(1032, 2, 60, 1368627105, 1368627105),
(1033, 2, 61, 1368627105, 1368627105),
(1034, 2, 62, 1368627105, 1368627105),
(1035, 2, 63, 1368627105, 1368627105),
(1036, 2, 64, 1368627105, 1368627105),
(1037, 2, 65, 1368627105, 1368627105),
(1038, 2, 66, 1368627105, 1368627105),
(1039, 2, 67, 1368627105, 1368627105),
(1040, 2, 68, 1368627105, 1368627105),
(1041, 2, 75, 1368627105, 1368627105),
(1042, 2, 78, 1368627105, 1368627105),
(1043, 2, 77, 1368627105, 1368627105),
(1044, 2, 76, 1368627105, 1368627105),
(1045, 2, 80, 1368627105, 1368627105),
(1046, 2, 81, 1368627105, 1368627105),
(1047, 2, 82, 1368627105, 1368627105),
(1048, 2, 83, 1368627105, 1368627105),
(1049, 2, 84, 1368627105, 1368627105),
(1050, 2, 85, 1368627105, 1368627105),
(1051, 2, 87, 1368627105, 1368627105),
(1052, 2, 88, 1368627105, 1368627105),
(1053, 2, 89, 1368627105, 1368627105),
(1054, 2, 90, 1368627105, 1368627105),
(1055, 2, 91, 1368627105, 1368627105),
(1056, 2, 93, 1368627105, 1368627105),
(1057, 2, 94, 1368627105, 1368627105),
(1058, 2, 95, 1368627105, 1368627105),
(1059, 2, 96, 1368627105, 1368627105),
(1060, 2, 97, 1368627105, 1368627105),
(1061, 2, 98, 1368627105, 1368627105),
(1062, 2, 100, 1368627105, 1368627105),
(1063, 2, 101, 1368627105, 1368627105),
(1064, 2, 102, 1368627105, 1368627105),
(1065, 2, 103, 1368627105, 1368627105),
(1066, 2, 104, 1368627105, 1368627105),
(1067, 2, 105, 1368627105, 1368627105),
(1068, 2, 107, 1368627105, 1368627105),
(1069, 2, 108, 1368627105, 1368627105),
(1070, 2, 109, 1368627105, 1368627105),
(1071, 2, 111, 1368627105, 1368627105),
(1072, 2, 112, 1368627105, 1368627105),
(1073, 2, 114, 1368627105, 1368627105),
(1074, 2, 115, 1368627105, 1368627105),
(1075, 2, 116, 1368627105, 1368627105),
(1076, 2, 117, 1368627105, 1368627105),
(1077, 2, 118, 1368627105, 1368627105);

-- --------------------------------------------------------

--
-- Table structure for table `help_categories`
--

CREATE TABLE IF NOT EXISTS `help_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `section` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_name_hy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug_hy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=64 ;

--
-- Dumping data for table `help_categories`
--

INSERT INTO `help_categories` (`id`, `parent_id`, `section`, `category_name`, `category_name_hy`, `slug`, `slug_hy`, `category_image`, `active`, `is_deleted`, `created`, `modified`) VALUES
(1, 0, 'faq', 'faq', 'faq', 'faq', 'faq', '', 1, 0, 1345809603, 1351863602),
(2, 0, 'school', 'school', 'school', 'school', 'school', '', 1, 0, 1345809603, 1351863602),
(8, 1, 'faq', 'Boostbloom Basics', 'Fonctionnement de Boostbloom', 'boostbloom-basics', 'boostbloom-basics', '', 1, 0, 1345810877, 1351863602),
(9, 1, 'faq', 'Creators Questions', 'Créer un projet', 'creators-questions', 'creators-questions', '', 1, 0, 1345810909, 1351863602),
(10, 1, 'faq', 'Backers Questions', 'Soutenir un  projet', 'backers-questions', 'backers-questions', '', 1, 0, 1345810928, 1351863602),
(11, 2, 'school', 'What is a project?', 'Définir votre projet', 'what-is-a-project', 'what-is-a-project', 'school_category__1348920136ksr-school-icon-1.gif', 1, 0, 1345809603, 1365080368),
(12, 10, 'faq', 'Pledging', 'Soutenir', 'how-do-i-pledge', 'how-do-i-pledge', '', 1, 0, 1345815629, 1351863602),
(13, 10, 'faq', 'Rewards', 'Récompenses', 'rewards', 'rewards', '', 1, 0, 1345815677, 1351863602),
(14, 10, 'faq', 'Accountability', 'Engagement et responsabilités ', 'accountability', 'accountability', '', 1, 0, 1345815695, 1354103601),
(21, 2, 'school', 'Building Your Project', 'Configuration de votre objectif', 'building-your-project', 'building-your-project', 'school_category__1348920111ksr-school-icon-3.gif', 1, 0, 1345872806, 1365268668),
(23, 2, 'school', 'What''s A Goal?', 'Récompenses création', 'whats-a-goal', 'whats-a-goal', 'school_category__1348920074ksr-school-icon-2.gif', 1, 0, 1345873543, 1365090483),
(36, 9, 'faq', 'Discover', 'Découvrir', 'discover', 'discover', '', 1, 0, 1346058188, 1351863602),
(37, 9, 'faq', 'Project Media', 'Utiliser des Vidéos', 'project-media', 'project-media', '', 1, 0, 1346058203, 1351863602),
(38, 9, 'faq', 'Project Updates', 'Mettre à jour votre projet', 'project-updates', 'project-updates', '', 1, 0, 1346058215, 1351863602),
(39, 9, 'faq', 'Paypal & Verifications', 'Paypal et vérification', 'paypal-verifications', 'paypal-verifications', '', 1, 0, 1346058242, 1354103513),
(40, 8, 'faq', 'How It Works', 'Comment ça marche', 'how-it-works', 'how-it-works', '', 1, 0, 1346058285, 1351863602),
(41, 8, 'faq', 'Starting a Project', 'Lancer un Projet', 'starting-a-project', 'starting-a-project', '', 1, 0, 1346058296, 1351863602),
(42, 8, 'faq', 'Account Settings', 'Votre Compte', 'account-settings', 'account-settings', '', 1, 0, 1346058309, 1351863602),
(43, 8, 'faq', 'Odds & Ends', 'spéciales et Partenariats', 'odds-ends', 'odds-ends', '', 1, 0, 1346058323, 1351863602),
(44, 2, 'school', 'Creating Rewards', 'Rendre votre vidéo', 'creating-rewards', 'creating-rewards', 'school_category__1348920053ksr-school-icon-4.gif', 1, 0, 1346058380, 1365086093),
(45, 2, 'school', 'Making a Video', 'Construire votre projet', 'making-a-video', 'making-a-video', 'school_category__1348920019ksr-school-icon-5.gif', 1, 0, 1346058414, 1365268691),
(46, 2, 'school', 'Your Project Description', 'Promotion de votre projet', 'your-project-description', 'your-project-description', 'school_category__1348919977ksr-school-icon-6.gif', 1, 0, 1346058430, 1365268768),
(47, 2, 'school', 'Promoting Your Project', 'Mises à jour du projet', 'promoting-your-project', 'promoting-your-project', 'school_category__1348919948ksr-school-icon-7.gif', 1, 0, 1346058442, 1365089092),
(48, 2, 'school', 'Project Updates', 'Accomplissement récompense', 'project-updates', 'project-updates', 'school_category__1348919871ksr-school-icon-8.gif', 1, 0, 1346058454, 1365087764),
(53, 52, 'faq', 'rajat', 'rajat', 'rajat', 'rajat', '', 1, 0, 1346216351, 1351863602),
(63, 62, 'faq', 'sub of ask for help', 'sub of ask for help', 'sub-of-ask-for-help', 'sub-of-ask-for-help', '', 1, 0, 1346230338, 1351863602);

-- --------------------------------------------------------

--
-- Table structure for table `help_posts`
--

CREATE TABLE IF NOT EXISTS `help_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_title_hy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug_hy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_hy` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=85 ;

--
-- Dumping data for table `help_posts`
--

INSERT INTO `help_posts` (`id`, `parent_id`, `post_title`, `post_title_hy`, `slug`, `slug_hy`, `description`, `description_hy`, `active`, `created`, `modified`) VALUES
(1, 40, 'What is Boostbloom', 'Qu’est-ceque Boostbloom? ', 'what-is-boostbloom', 'what-is-boostbloom', '<p>\r\n	Boostbloom is a new way to fund creative projects. We believe that: &bull; A good idea, communicated well, can spread fast and wide. &bull; A large group of people can be a tremendous source of money and encouragement. Boostbloom is powered by a unique all-or-nothing funding method where projects must be fully-funded or no money changes hands.</p>\r\n', '<p>\r\n	Boostbloom is a new way to fund creative projects. We believe that: &bull; A good idea, communicated well, can spread fast and wide. &bull; A large group of people can be a tremendous source of money and encouragement. Boostbloom is powered by a unique all-or-nothing funding method where projects must be fully-funded or no money changes hands.</p>\r\n', 1, 1346239057, 1351863602),
(2, 40, 'Who can fund their project on Boostbloom', 'Qui peut lancer un projet sur Boostbloom ?', 'who-can-fund-their-project-on-boostbloom', 'who-can-fund-their-project-on-boostbloom', '<p>BoostBloom is focused on creative projects. We&#39;re a great way for artists, filmmakers, musicians, designers, writers, illustrators, explorers, curators, performers, and others to bring their projects, events, and dreams to life. The word &ldquo;project&rdquo; is just as important as &ldquo;creative&rdquo; in defining what works on BoostBloom . A project is something finite with a clear beginning and end. Someone can be held accountable to the framework of a project &mdash; a project was either completed or it wasn&rsquo;t &mdash; and there are definable expectations that everyone can agree to. This is imperative for every BoostBloom project. We know there are a lot of great projects that fall outside of our scope, but BoostBloom is not a place for soliciting donations to causes, charity projects, or general business expenses. Learn more about our<a href="http://www.boostbloom.com/display/guidelines"> project guidelines</a>.</p>\r\n', '<p>Boostbloom is focused on creative projects. We&#39;re a great way for artists, filmmakers, musicians, designers, writers, illustrators, explorers, curators, performers, and others to bring their projects, events, and dreams to life. The word &ldquo;project&rdquo; is just as important as &ldquo;creative&rdquo; in defining what works on Boostbloom . A project is something finite with a clear beginning and end. Someone can be held accountable to the framework of a project &mdash; a project was either completed or it wasn&rsquo;t &mdash; and there are definable expectations that everyone can agree to. This is imperative for every Boostbloom project. We know there are a lot of great projects that fall outside of our scope, but Boostbloom is not a place for soliciting donations to causes, charity projects, or general business expenses. Learn more about our <a href="http://www.boostbloom.com/display/guidelines">project guidelines</a>.</p>\r\n', 1, 1346239100, 1385721491),
(3, 40, 'All-or-nothing funding?', 'Système du toutourien, quèsaco?', 'all-or-nothing-funding', 'all-or-nothing-funding', '<p>\r\n	Every Boostbloom project must be fully funded before its time expires or no money changes hands. Why? 1. It&#39;s less risk for everyone. If you need $5,000, it&#39;s tough having $2,000 and a bunch of people expecting you to complete a $5,000 project. 2. It allows people to test concepts (or conditionally sell stuff) without risk. If you don&#39;t receive the support you want, you&#39;re not compelled to follow through. This is huge! 3. It motivates. If people want to see a project come to life, they&#39;re going to spread the word.</p>\r\n', '<p>\r\n	Every Boostbloom project must be fully funded before its time expires or no money changes hands. Why? 1. It&#39;s less risk for everyone. If you need $5,000, it&#39;s tough having $2,000 and a bunch of people expecting you to complete a $5,000 project. 2. It allows people to test concepts (or conditionally sell stuff) without risk. If you don&#39;t receive the support you want, you&#39;re not compelled to follow through. This is huge! 3. It motivates. If people want to see a project come to life, they&#39;re going to spread the word.</p>\r\n', 1, 1346239138, 1351863602),
(4, 40, 'Why do people support projects?', 'Pourquoi soutenir un projet?', 'why-do-people-support-projects', 'why-do-people-support-projects', '<p>\r\n	REWARDS! Project creators inspire people to open their wallets by offering smart, fun, and tangible rewards (products, benefits, and experiences). STORIES! Boostbloom projects are efforts by real people to do something they love, something fun, or at least something of note. These stories unfold through blog posts, pics, and videos as people bring their ideas to life. Take a peek around the site and see what we&#39;re talking about. Stories abound.</p>\r\n', '<p>\r\n	REWARDS! Project creators inspire people to open their wallets by offering smart, fun, and tangible rewards (products, benefits, and experiences). STORIES! Boostbloom projects are efforts by real people to do something they love, something fun, or at least something of note. These stories unfold through blog posts, pics, and videos as people bring their ideas to life. Take a peek around the site and see what we&#39;re talking about. Stories abound.</p>\r\n', 1, 1346239184, 1351863602),
(5, 40, 'Does Boostbloom take some percentage of ownership or intellectual property?', 'Est-ce que BoostBloom va acquérir des parts ou des droits de propriété intellectuelle sur les projets?', 'does-boostbloom-take-some-percentage-of-ownership-or-intellectual-property', 'does-boostbloom-take-some-percentage-of-ownership-or-intellectual-property', '<p>\r\n	Absolutely not. Project creators keep 100% ownership of their work.</p>\r\n', '<p>\r\n	Absolutely not. Project creators keep 100% ownership of their work.</p>\r\n', 1, 1346239223, 1351863602),
(6, 41, 'How do I start a project?', 'Comment lancer un projet', 'how-do-i-start-a-project', 'how-do-i-start-a-project', '<p>\r\n	Click the green &ldquo;Start Your Project&rdquo; button on the Start page. That will take you through the process of building your project. All projects must meet Boostbloom&rsquo;s Project Guidelines and all creators must meet Amazon Payments&rsquo; eligibility requirements.</p>\r\n', '<p>\r\n	Click the green &ldquo;Start Your Project&rdquo; button on the Start page. That will take you through the process of building your project. All projects must meet Boostbloom&rsquo;s Project Guidelines and all creators must meet Amazon Payments&rsquo; eligibility requirements.</p>\r\n', 1, 1346239267, 1354106837),
(7, 41, 'Does Boostbloom screen projects before they launch?', 'Comment les projets sont-ils sélectionnés?', 'does-boostbloom-screen-projects-before-they-launch', 'does-boostbloom-screen-projects-before-they-launch', '<p>\r\n	Only a quick guidelines review to make sure they meet our Project Guidelines. Our review process is not an exact science, so we keep an eye out for objectionable content after launch as well, and we ask our community to do the same.</p>\r\n', '<p>\r\n	Only a quick guidelines review to make sure they meet our Project Guidelines. Our review process is not an exact science, so we keep an eye out for objectionable content after launch as well, and we ask our community to do the same.</p>\r\n', 1, 1346239299, 1351863602),
(8, 41, 'Does Boostbloom investigate what a project says it’s going to do?', 'BoostBloom s’assure-t-il de la faisabilitéd’un projet?', 'does-boostbloom-investigate-what-a-project-says-it-s-going-to-do', 'does-boostbloom-investigate-what-a-project-says-it-s-going-to-do', '<p>Boostbloom does not investigate a project&rsquo;s claims. The claims and responsibilities of every project are its creator&rsquo;s. The community ultimately decides the validity and worthiness of a project by whether they decide to fund it.</p>\r\n', '<p>Boostbloom does not investigate a project&rsquo;s claims. The claims and responsibilities of every project are its creator&rsquo;s. The community ultimately decides the validity and worthiness of a project by whether they decide to fund it.</p>\r\n', 1, 1346239330, 1385721637),
(9, 41, 'How does the project review process work?', 'Comment se fait la sélection?', 'how-does-the-project-review-process-work', 'how-does-the-project-review-process-work', '<p>\r\n	When someone has finished building their project they submit it to BoostBloom for a guidelines review to ensure that it does not violate the Project Guidelines. A project is either approved or declined, and in some cases we&#39;ll reach out with a question asking for clarification. In every case, we send an email notification to the creator. The creator has the ability to appeal a decline if they wish.</p>\r\n', '<p>\r\n	When someone has finished building their project they submit it to BoostBloom for a guidelines review to ensure that it does not violate the Project Guidelines. A project is either approved or declined, and in some cases we&#39;ll reach out with a question asking for clarification. In every case, we send an email notification to the creator. The creator has the ability to appeal a decline if they wish.</p>\r\n', 1, 1346239362, 1351863602),
(10, 41, 'What percentage of submitted projects are accepted?', 'Quel est la part de projets acceptés par Boostbloom?', 'what-percentage-of-submitted-projects-are-accepted', 'what-percentage-of-submitted-projects-are-accepted', '<p>Approximately 75% of submitted projects are accepted. The remaining 25% of projects are declined because they do not meet the Project Guidelines. For more, see the <a href="http://www.boostbloom.com/help/help-detail/faq/boostbloom-basics/#why-do-people-support-projects">Project Submissions FAQ section</a>.</p>\r\n', '<p>Approximately 75% of submitted projects are accepted. The remaining 25% of projects are declined because they do not meet the Project Guidelines. For more, see the <a href="http://www.boostbloom.com/help/help-detail/faq/boostbloom-basics/#why-do-people-support-projects">Project Submissions FAQ section</a>.</p>\r\n', 1, 1346239391, 1385721177),
(11, 42, 'How can I change my profile name?', 'Comment changer de pseudo ?', 'how-can-i-change-my-profile-name', 'how-can-i-change-my-profile-name', '<p>\r\n	Make sure you&rsquo;re logged in to BoostBloom and go to your profile page.</p>\r\n', '<p>\r\n	Make sure you&rsquo;re logged in to BoostBloom and go to your profile page.</p>\r\n', 1, 1346239459, 1351863602),
(12, 42, 'How can I change the email address associated with my account?', 'Comment changer l’email associé à mon compte ?', 'how-can-i-change-the-email-address-associated-with-my-account', 'how-can-i-change-the-email-address-associated-with-my-account', '<p>\r\n	Make sure you&rsquo;re logged in to BoostBloom and go to your account page.</p>\r\n', '<p>\r\n	Make sure you&rsquo;re logged in to Boostbloom and go to your account page.</p>\r\n', 1, 1346239486, 1354107154),
(13, 42, 'How do I unsubscribe from or adjust which emails I receive?', 'Comme choisir les emails que je reçois?', 'how-do-i-unsubscribe-from-or-adjust-which-emails-i-receive', 'how-do-i-unsubscribe-from-or-adjust-which-emails-i-receive', '<p>\r\n	Make sure you&rsquo;re logged in to BoostBloom and go to your notifications page.</p>\r\n', '<p>\r\n	Make sure you&rsquo;re logged in to BoostBloom and go to your notifications page.</p>\r\n', 1, 1346239513, 1351863602),
(14, 42, 'I forgot my password, how do I log in?', 'J’aioubliémon mot de passe, comment faire pourme connecter?', 'i-forgot-my-password-how-do-i-log-in', 'i-forgot-my-password-how-do-i-log-in', '<p>You can request a password reset at the bottom of the login page.</p>\r\n', '<p>You can request a password reset at the bottom of the login page.</p>\r\n', 1, 1346239577, 1385721040),
(15, 42, 'How do I disconnect my Facebook account?', 'Comment déconnecter mon compte Facebook?', 'how-do-i-disconnect-my-facebook-account', 'how-do-i-disconnect-my-facebook-account', '<p>\r\n	Log in to BoostBloom through Facebook, then go to your account settings to disconnect from Facebook and set a password on your account page.</p>\r\n', '<p>\r\n	Log in to BoostBloom through Facebook, then go to your account settings to disconnect from Facebook and set a password on your account page.</p>\r\n', 1, 1346239626, 1351863602),
(16, 42, 'How do I delete my account?', 'Comment effacer mon compte', 'how-do-i-delete-my-account', 'how-do-i-delete-my-account', '<p>\r\n	Your account can be deleted from your account page. Warning: this is not reversible!</p>\r\n', '<p>\r\n	Your account can be deleted from your account page. Warning: this is not reversible!</p>\r\n', 1, 1346239707, 1351863602),
(17, 43, 'What are Curated Pages?', 'Que signifient pages spéciales et partenariats?', 'what-are-curated-pages', 'what-are-curated-pages', '<p>\r\n	Curated Pages are a way for people to discover projects curated by some of the world&#39;s foremost creative communities. You can check them all out here.</p>\r\n', '<p>\r\n	Curated Pages are a way for people to discover projects curated by some of the world&#39;s foremost creative communities. You can check them all out here.</p>\r\n', 0, 1346239772, 1385720808),
(18, 43, 'Who uses Curated Pages, and how?', 'Qui les utilise?', 'who-uses-curated-pages-and-how', 'who-uses-curated-pages-and-how', '<p>\r\n	Curated Pages are open to cultural organizations and institutions in creative fields: museums, film societies, record labels, publishers, creative trade organizations, educational institutions, and more. Featured projects can be directly associated with an organization or simply align with its mission. As long as the project is on BoostBloom, it can be featured on a Curated Page.</p>\r\n', '<p>\r\n	Curated Pages are open to cultural organizations and institutions in creative fields: museums, film societies, record labels, publishers, creative trade organizations, educational institutions, and more. Featured projects can be directly associated with an organization or simply align with its mission. As long as the project is on BoostBloom, it can be featured on a Curated Page.</p>\r\n', 0, 1346239815, 1385720805),
(19, 43, 'How can my organization sign up for a Curated Page?', 'Comment mon organisation peut tirer profit des pages spéciales et partenariats ?', 'how-can-my-organization-sign-up-for-a-curated-page', 'how-can-my-organization-sign-up-for-a-curated-page', '<p>\r\n	Curated Pages are extended by invitation, with an editorial focus in mind. We typically work with cultural organizations, arts groups, and educational institutions.</p>\r\n', '<p>\r\n	Curated Pages are extended by invitation, with an editorial focus in mind. We typically work with cultural organizations, arts groups, and educational institutions.</p>\r\n', 0, 1346239844, 1385720801),
(20, 43, 'How can my project be featured on a Curated Page?', 'Comment mon projet peut-il figure parmi les pages spéciales et partenariats?', 'how-can-my-project-be-featured-on-a-curated-page', 'how-can-my-project-be-featured-on-a-curated-page', '<p>\r\n	Curated Pages are maintained by the organizations who manage them. To be considered for inclusion on a page, please reach out to the page owner directly.</p>\r\n', '<p>\r\n	Curated Pages are maintained by the organizations who manage them. To be considered for inclusion on a page, please reach out to the page owner directly.</p>\r\n', 0, 1346239874, 1385720796),
(21, 43, 'Do projects have RSS feeds?', 'Les projets ont-ils un fil rss?', 'do-projects-have-rss-feeds', 'do-projects-have-rss-feeds', '<p>\r\n	Each project has an RSS feed of its Project Updates. You can find it in the project&#39;s share section. (Note that backer-only Updates are not included.) There&rsquo;s also an overall RSS feed of Recommended projects</p>\r\n', '<p>\r\n	Each project has an RSS feed of its Project Updates. You can find it in the project&#39;s share section. (Note that backer-only Updates are not included.) There&rsquo;s also an overall RSS feed of Recommended projects</p>\r\n', 0, 1346239920, 1385720788),
(22, 43, 'How can I contact BoostBloom?', 'Comment contacter BoostBloom', 'how-can-i-contact-BoostBloom', 'how-can-i-contact-BoostBloom', '<p>\r\n	There&#39;s a &quot;Contact&quot; button at the bottom of this page, in the site footer.</p>\r\n', '<p>\r\n	There&#39;s a &quot;Contact&quot; button at the bottom of this page, in the site footer.</p>\r\n', 1, 1346239963, 1351863602),
(23, 12, 'How do I pledge?', 'Comment soutenir un projet?', 'how-do-i-pledge', 'how-do-i-pledge', '<p>\r\n	To pledge to a project, just click the green &ldquo;Back This Project&rdquo; button on any project page. You will be asked to enter your pledge amount and select a reward. From there, you will go through the Amazon checkout process. Note that you must finish the Amazon checkout process for your pledge to be recorded.</p>\r\n', '<p>\r\n	To pledge to a project, just click the green &ldquo;Back This Project&rdquo; button on any project page. You will be asked to enter your pledge amount and select a reward. From there, you will go through the Paypal checkout process. Note that you must finish the Paypal checkout process for your pledge to be recorded.</p>\r\n', 1, 1346240038, 1351863602),
(24, 12, 'If I make a pledge, when is my card charged?', 'Si je veux soutenir un projet, quand ma carte est-elle débitée?', 'if-i-make-a-pledge-when-is-my-card-charged', 'if-i-make-a-pledge-when-is-my-card-charged', '<p>\r\n	If the project you&rsquo;re backing is successfully funded, your card will be charged when the project reaches its funding deadline. If the project does not reach its funding goal, your card is never charged. That&#39;s why we call them pledges.</p>\r\n', '<p>\r\n	If the project you&rsquo;re backing is successfully funded, your card will be charged when the project reaches its funding deadline. If the project does not reach its funding goal, your card is never charged. That&#39;s why we call them pledges.</p>\r\n', 1, 1346240068, 1351863602),
(25, 12, 'If funding does not succeed do backers pay anything?', 'Si un projet que je soutiens n’atteint pas son objectif, est-ce que je paie quelque chose ?', 'if-funding-does-not-succeed-do-backers-pay-anything', 'if-funding-does-not-succeed-do-backers-pay-anything', '<p>\r\n	Nothing. If funding is unsuccessful, all pledges are canceled and that&#39;s that.</p>\r\n', '<p>\r\n	Nothing. If funding is unsuccessful, all pledges are canceled and that&#39;s that.</p>\r\n', 1, 1346240102, 1351863602),
(26, 12, 'What if I want to pledge anonymously?', 'Puis-je soutenir unprojet de façonanonyme?', 'what-if-i-want-to-pledge-anonymously', 'what-if-i-want-to-pledge-anonymously', '<p>\r\n	We don&#39;t currently have an anonymous pledge feature. You are free to choose any username you wish, though, so you could anonymize that way if you would like. Otherwise, we hope you&#39;re okay with showing your name and support.</p>\r\n', '<p>\r\n	We don&#39;t currently have an anonymous pledge feature. You are free to choose any username you wish, though, so you could anonymize that way if you would like. Otherwise, we hope you&#39;re okay with showing your name and support.</p>\r\n', 1, 1346240128, 1351863602),
(27, 12, 'Why isn''t the Backers tab updated with every backer?', 'Pourquoi la liste des personnes qui soutiennent un projet  n’est-elle pas complète ?', 'why-isn-t-the-backers-tab-updated-with-every-backer', 'why-isn-t-the-backers-tab-updated-with-every-backer', '<p>\r\n	While the total amount pledged and number of backers are updated on a project page in real time, the actual names of backers are added in groups of ten. When names are posted, they&#39;re listed in a random order. BoostBloom never discloses the amount that backers pledge, just that they&#39;re proud backers. The Backers tab ensures that no one but the creator can figure out who pledged what. We love seeing our names up top on the Backers tab, but privacy is a top priority for us.</p>\r\n', '<p>\r\n	While the total amount pledged and number of backers are updated on a project page in real time, the actual names of backers are added in groups of ten. When names are posted, they&#39;re listed in a random order. BoostBloom never discloses the amount that backers pledge, just that they&#39;re proud backers. The Backers tab ensures that no one but the creator can figure out who pledged what. We love seeing our names up top on the Backers tab, but privacy is a top priority for us.</p>\r\n', 1, 1346240156, 1351863602),
(28, 13, 'Who is responsible for making sure project creators deliver what they promise?', 'Qui  s’assure de la réalisation des promesses d''un projet?', 'who-is-responsible-for-making-sure-project-creators-deliver-what-they-promise', 'who-is-responsible-for-making-sure-project-creators-deliver-what-they-promise', '<p>\r\n	Project creators are solely responsible for fulfilling the promises of their projects. See the Accountability section below for more.</p>\r\n', '<p>\r\n	Project creators are solely responsible for fulfilling the promises of their projects. See the Accountability section below for more.</p>\r\n', 1, 1346240205, 1354104404),
(29, 13, 'How will project creators get my info (mailing address, T-shirt size, etc.) to deliver rewards?', 'Commentles créateurs de projets auront-ils mes coordonnées pour m’envoyer ma récompense', 'how-will-project-creators-get-my-info-mailing-address-t-shirt-size-etc-to-deliver-rewards', 'how-will-project-creators-get-my-info-mailing-address-t-shirt-size-etc-to-deliver-rewards', '<p>\r\n	Project creators will send you an email survey to request any info they need to deliver you and your fellow backers&rsquo; rewards, such as your mailing address or other details. Surveys are sent only after a project has been successfully funded. Some creators send surveys immediately, others wait until they&rsquo;re ready to deliver rewards. If you think you might have missed a survey email, please log in to your BoostBloom account to check &mdash; you&rsquo;ll see a notification at the top of the site for any missed surveys.</p>\r\n', '<p>\r\n	Project creators will send you an email survey to request any info they need to deliver you and your fellow backers&rsquo; rewards, such as your mailing address or other details. Surveys are sent only after a project has been successfully funded. Some creators send surveys immediately, others wait until they&rsquo;re ready to deliver rewards. If you think you might have missed a survey email, please log in to your BoostBloom account to check &mdash; you&rsquo;ll see a notification at the top of the site for any missed surveys.</p>\r\n', 1, 1346240242, 1351863602),
(30, 13, 'How do I know when rewards for a project will be delivered?', 'Comment puis-je savoir quand ma récompense sera livrée?', 'how-do-i-know-when-rewards-for-a-project-will-be-delivered', 'how-do-i-know-when-rewards-for-a-project-will-be-delivered', '<p>\r\n	Projects launched from August 2011 onward have an Estimated Delivery Date under each reward. This date (month and year) is entered by project creators as their best guess for delivery to backers. Older projects may not contain this information. Check the project&#39;s updates or comments to see if the creator has indicated when they plan to deliver rewards. If a creator is communicative about delivery taking longer than expected, we ask that you take that transparency into account. If a creator is not communicating and you want to know what&rsquo;s going on, contact the creator by posting a public comment or sending a private message.</p>\r\n', '<p>\r\n	Projects launched from August 2011 onward have an Estimated Delivery Date under each reward. This date (month and year) is entered by project creators as their best guess for delivery to backers. Older projects may not contain this information. Check the project&#39;s updates or comments to see if the creator has indicated when they plan to deliver rewards. If a creator is communicative about delivery taking longer than expected, we ask that you take that transparency into account. If a creator is not communicating and you want to know what&rsquo;s going on, contact the creator by posting a public comment or sending a private message.</p>\r\n<p>\r\n	&nbsp;</p>\r\n', 1, 1346240275, 1354104531),
(31, 13, 'I haven''t gotten my reward yet. What do I do?', ' Je n''ai pas encorereçuma récompense.Que dois-jefaire?', 'i-haven-t-gotten-my-reward-yet-what-do-i-do', 'i-haven-t-gotten-my-reward-yet-what-do-i-do', '<p>\r\n	The first step is checking the Estimated Delivery Date on the project page. Backing a project is a lot different than simply ordering a product online, and sometimes projects are in very early stages when they are funded. If the Estimated Delivery Date has passed, check for Project Updates that may explain what happened. Sometimes creators hit unexpected roadblocks, or simply underestimate how much work it takes to complete a project. Creators are expected to communicate these setbacks should they happen. If the creator hasn&rsquo;t posted an update, send a direct message to request more information about their progress, or post a public comment on their project asking for a status update.</p>\r\n', '<p>\r\n	The first step is checking the Estimated Delivery Date on the project page. Backing a project is a lot different than simply ordering a product online, and sometimes projects are in very early stages when they are funded. If the Estimated Delivery Date has passed, check for Project Updates that may explain what happened. Sometimes creators hit unexpected roadblocks, or simply underestimate how much work it takes to complete a project. Creators are expected to communicate these setbacks should they happen. If the creator hasn&rsquo;t posted an update, send a direct message to request more information about their progress, or post a public comment on their project asking for a status update.</p>\r\n', 1, 1346240307, 1354104693),
(32, 14, 'Who is responsible for fulfilling the promises of a project?', 'Qui me garantit que je recevrai ma récompense?', 'who-is-responsible-for-fulfilling-the-promises-of-a-project', 'who-is-responsible-for-fulfilling-the-promises-of-a-project', '<p>It is the responsibility of the project creator to fulfill the promises of their project. BoostBloom reviews projects to ensure they do not violate the Project Guidelines, however BoostBloom does not investigate a creator&#39;s ability to complete their project. Creators are encouraged to share links to any websites that show work related to the project, or past projects. It&#39;s up to them to make the case for their project and their ability to complete it. Because projects are usually funded by the friends, fans, and communities around its creator, there are powerful social forces that keep creators accountable. The web is an excellent resource for learning about someone&rsquo;s prior experience. If someone has no demonstrable prior history of doing something like their project, or is unwilling to share information, backers should consider that when weighing a pledge. If something sounds too good to be true, it very well may be.</p>\r\n', '<p>It is the responsibility of the project creator to fulfill the promises of their project. BoostBloom reviews projects to ensure they do not violate the Project Guidelines, however BoostBloom does not investigate a creator&#39;s ability to complete their project. Creators are encouraged to share links to any websites that show work related to the project, or past projects. It&#39;s up to them to make the case for their project and their ability to complete it. Because projects are usually funded by the friends, fans, and communities around its creator, there are powerful social forces that keep creators accountable. The web is an excellent resource for learning about someone&rsquo;s prior experience. If someone has no demonstrable prior history of doing something like their project, or is unwilling to share information, backers should consider that when weighing a pledge. If something sounds too good to be true, it very well may be.</p>\r\n', 1, 1346240348, 1385722590),
(33, 14, 'How do I know a project creator is who they claim they are?', 'Comment savoir sile créateur d’un projet est celui qu’il dit être.', 'how-do-i-know-a-project-creator-is-who-they-claim-they-are', 'how-do-i-know-a-project-creator-is-who-they-claim-they-are', '<p>\r\n	Perhaps you know the project creator, or you heard about the project from a trusted source. Maybe they have a first-person video. That would be hard to fake. &quot;Is it really U2?!&quot; Well, it is if Bono&#39;s talking about the project. Still not sure? Look for the creator bio section on the project page. Are they Facebook Connected? Do they provide links for further verification? The web is an invaluable resource for learning more about a person. At the end of the day, use your internet street smarts.</p>\r\n', '<p>\r\n	Perhaps you know the project creator, or you heard about the project from a trusted source. Maybe they have a first-person video. That would be hard to fake. &quot;Is it really U2?!&quot; Well, it is if Bono&#39;s talking about the project. Still not sure? Look for the creator bio section on the project page. Are they Facebook Connected? Do they provide links for further verification? The web is an invaluable resource for learning more about a person. At the end of the day, use your internet street smarts.</p>\r\n', 1, 1346240384, 1351863602),
(34, 14, 'What do I do if I have questions about a project?', 'Comment faire si j’ai une question à propos d’un projet ?', 'what-do-i-do-if-i-have-questions-about-a-project', 'what-do-i-do-if-i-have-questions-about-a-project', '<p>\r\n	Ask the creator! At the bottom of each project page there&rsquo;s an &ldquo;Ask a Question&rdquo; button. This will send your question directly to the creator. If you are already a backer and you would like to make your question public, you can post a comment on the project. The creator will be notified by email when you do.</p>\r\n', '<p>\r\n	Ask the creator! At the bottom of each project page there&rsquo;s an &ldquo;Ask a Question&rdquo; button. This will send your question directly to the creator. If you are already a backer and you would like to make your question public, you can post a comment on the project. The creator will be notified by email when you do.</p>\r\n', 1, 1346240416, 1351863602),
(35, 38, 'What are Project Updates?', 'Qu’est- ce que les mises à jour ?', 'what-are-project-updates', 'what-are-project-updates', '<p>\r\n	Project Updates&quot; is our name for each project&#39;s blog. Project creators use Updates to keep their backers informed on the development of the project. Some creators may post ten Updates a day, others may do it rarely, but it&#39;s the best way to keep backers informed of a project&#39;s progress. Creators have the option to make each post publicly viewable or exclusive to backers. An exclusive Update allows you to communicate privately with backers as a group.</p>\r\n', '<p>\r\n	Project Updates&quot; is our name for each project&#39;s blog. Project creators use Updates to keep their backers informed on the development of the project. Some creators may post ten Updates a day, others may do it rarely, but it&#39;s the best way to keep backers informed of a project&#39;s progress. Creators have the option to make each post publicly viewable or exclusive to backers. An exclusive Update allows you to communicate privately with backers as a group.</p>\r\n', 1, 1346240533, 1351863602),
(36, 38, 'How should Project Updates be used?', 'Comment utiliser les mises à jour?', 'how-should-project-updates-be-used', 'how-should-project-updates-be-used', 'Project Updates can transform projects from simple funding efforts to stories that backers (and other spectators) will eagerly follow. Let backers and spectators be flies on the wall as you make decisions and pursue your goal.', 'Project Updates can transform projects from simple funding efforts to stories that backers (and other spectators) will eagerly follow. Let backers and spectators be flies on the wall as you make decisions and pursue your goal.', 1, 1346240736, 1351863602),
(37, 38, 'What media types are allowed in Updates?', 'Quels types de media pour vos mises à jour ', 'what-media-types-are-allowed-in-updates', 'what-media-types-are-allowed-in-updates', 'You can post Updates with video, audio, and images — and you should!', 'You can post Updates with video, audio, and images — and you should!', 1, 1346240771, 1351863602),
(38, 38, 'How will my backers know I posted a Project Update?', 'Comment les utilisateurs qui soutiennent mon projet sont-ils informés de ma mise à jour du projet?', 'how-will-my-backers-know-i-posted-a-project-update', 'how-will-my-backers-know-i-posted-a-project-update', '<p>\r\n	Project Updates are directly emailed to backers when the Update is posted.</p>\r\n', '<p>\r\n	Project Updates are directly emailed to backers when the Update is posted.</p>\r\n', 1, 1346240799, 1351863602),
(39, 36, 'How does a project become a Staff Pick?', 'How does a project become a Staff Pick?', 'how-does-a-project-become-a-staff-pick', 'how-does-a-project-become-a-staff-pick', '<p>\r\n	At BoostBloom HQ, we spend a big part of our day keeping up with projects. Every morning our editorial team opens hundreds of tabs in their browsers and watches all of the project videos that launched in the last 24 hours. When something sticks out as particularly compelling, whether it&rsquo;s a really fun video, creative and well-priced rewards, a great story, or an exciting idea (ideally all of the above!), we make the project a Staff Pick. We add to Staff Picks throughout the day and throughout the life of a project. We want this page to be ever-evolving and just one way of many for people to find great projects. The best way to get on our editorial radar is to keep running an awesome project. We&rsquo;re always on the lookout, reading about projects through interesting project updates, social media, and articles that pop up in our trusty BoostBloom Google alert. We look forward to reading about yours!</p>\r\n', '<p>\r\n	At BoostBloom HQ, we spend a big part of our day keeping up with projects. Every morning our editorial team opens hundreds of tabs in their browsers and watches all of the project videos that launched in the last 24 hours. When something sticks out as particularly compelling, whether it&rsquo;s a really fun video, creative and well-priced rewards, a great story, or an exciting idea (ideally all of the above!), we make the project a Staff Pick. We add to Staff Picks throughout the day and throughout the life of a project. We want this page to be ever-evolving and just one way of many for people to find great projects. The best way to get on our editorial radar is to keep running an awesome project. We&rsquo;re always on the lookout, reading about projects through interesting project updates, social media, and articles that pop up in our trusty BoostBloom Google alert. We look forward to reading about yours!</p>\r\n', 0, 1346240901, 1351863602),
(40, 36, 'How does a project make it onto the homepage or become the Project of the Day?', 'Comment faire pour que mon projet soit sur la page d’accueil de Boostbloom?', 'how-does-a-project-make-it-onto-the-homepage-or-become-the-project-of-the-day', 'how-does-a-project-make-it-onto-the-homepage-or-become-the-project-of-the-day', '<p>\r\n	Our editorial team selects projects from Staff Picks to include in the homepage rotation. From that homepage rotation, we choose a single project to feature as our Project of the Day. We put a lot of care into selecting projects, focusing on the same qualities we do for Staff Picks. Because the homepage is the first thing people see , we aim to have it populated with projects that are excellent examples of what a BoostBloom project can be. The homepage also features projects in your city, popular projects, and projects your friends have backed and launched. These projects aren&#39;t selected by staff.</p>\r\n', '<p>\r\n	Our editorial team selects projects from Staff Picks to include in the homepage rotation. From that homepage rotation, we choose a single project to feature as our Project of the Day. We put a lot of care into selecting projects, focusing on the same qualities we do for Staff Picks. Because the homepage is the first thing people see&nbsp; we aim to have it populated with projects that are excellent examples of what a BoostBloom project can be. The homepage also features projects in your city, popular projects, and projects your friends have backed and launched. These projects aren&#39;t selected by staff.</p>\r\n', 1, 1346240930, 1351863602),
(41, 36, 'How does the Popular page work?', 'Comment fonctionne la section  populaire?', 'how-does-the-popular-page-work', 'how-does-the-popular-page-work', '<p>\r\n	The Popular page in Discover is divided into categories, and each category rotates when it&rsquo;s refreshed. The page is populated by an algorithm that takes many factors into account that measure, well, popularity!</p>\r\n', '<p>\r\n	The Popular page in Discover is divided into categories, and each category rotates when it&rsquo;s refreshed. The page is populated by an algorithm that takes many factors into account that measure, well, popularity!</p>\r\n', 1, 1346240957, 1351863602),
(42, 36, 'Where can I find my project on BoostBloom?', 'Oùpuis-je trouvermonprojetsur Boostbloom?', 'where-can-i-find-my-project-on-boostbloom', 'where-can-i-find-my-project-on-boostbloom', '<p>\r\n	Every project that launches on BoostBloom can be found on the Recently Launched page in Discover. Your project will also pop up in the Popular section of its corresponding category and subcategory as well as the Currently Funding section of your city. Lots of people who come to BoostBloom browse around and look for projects, but keep in mind that when it comes to getting new backers, getting the word out through your own networks is the most effective. Most of the people who back your project will be friends, friends of friends, or fans of the work you do.</p>\r\n', '<p>\r\n	Every project that launches on Boostbloomcan be found on the Recently Launched page in Discover. Your project will also pop up in the Popular section of its corresponding category and subcategory as well as the Currently Funding section of your city. Lots of people who come to Boostbloom browse around and look for projects, but keep in mind that when it comes to getting new backers, getting the word out through your own networks is the most effective. Most of the people who back your project will be friends, friends of friends, or fans of the work you do.</p>\r\n', 1, 1346240988, 1351863602),
(43, 36, 'If I choose a subcategory, will my project also show up in the main category?', 'Si je choisis une sous-catégorie, mon projet apparait-il également dans la catégorie principale?', 'if-i-choose-a-subcategory-will-my-project-also-show-up-in-the-main-category', 'if-i-choose-a-subcategory-will-my-project-also-show-up-in-the-main-category', '<p>\r\n	Yes. For example, if your project is a documentary and you put it in the Documentary subcategory, your project will appear in the Popular section of Documentary as well as the Popular section of Film &amp; Video.</p>\r\n', '<p>\r\n	Yes. For example, if your project is a documentary and you put it in the Documentary subcategory, your project will appear in the Popular section of Documentary as well as the Popular section of Film &amp; Video.</p>\r\n', 1, 1346241019, 1351863602),
(44, 36, 'Is there a widget that can be put on my own site to promote a project?', 'Y a-t-il un widget qui peut être mis sur mon propre site pour promouvoir un projet?', 'is-there-a-widget-that-can-be-put-on-my-own-site-to-promote-a-project', 'is-there-a-widget-that-can-be-put-on-my-own-site-to-promote-a-project', '<p>\r\n	Yes. You can find it right underneath the project&#39;s video/image in the share section: &quot;Embed.&quot;</p>\r\n', '<p>\r\n	Yes. You can find it right underneath the project&#39;s video/image in the share section: &quot;Embed.&quot;</p>\r\n', 1, 1346241052, 1351863602),
(51, 37, 'What''s the allowed file size for video?', 'Quelle est la taille de fichier autorisée pour la vidéo?', 'what-s-the-allowed-file-size-for-video', 'what-s-the-allowed-file-size-for-video', '<p>\r\n	Videos must be 250MB or less and one of the following file types: MOV, MPEG, AVI, MP4, 3GP, WMV, FLV</p>\r\n', '<p>\r\n	Videos must be 250MB or less and one of the following file types: MOV, MPEG, AVI, MP4, 3GP, WMV, FLV</p>\r\n', 1, 1346241315, 1351863602),
(53, 37, 'Any tips for shooting great videos?', 'Quelques conseils pour la prise de vue?', 'any-tips-for-shooting-great-videos', 'any-tips-for-shooting-great-videos', '<p>\r\n	Videos make projects infinitely more compelling, and you don&rsquo;t have to be a video expert to make a good one. Simply be personal and talk about your project. Put yourself in front of the camera for at least a moment so that people know who you are; making that personal connection is key. Show people examples of your work and use any fun visuals you can think of. No matter how bare-bones or creative you want to get, don&#39;t forget the basics: 1. Introduce yourself 2. Tell your story 3. Ask for people&#39;s support (i.e., their money...) 4. Tell people what they&#39;ll get for their money (i.e., your rewards) 5. Say thank you! There are a million different ways to tell your story. Have fun with it! You can spend days shooting and editing, or you can just knock one out with a couple friends on a Saturday. It doesn&#39;t have to be perfect, it just has to be you. For more tips on making your video, visit BoostBloom School.</p>\r\n', '<p>\r\n	Videos make projects infinitely more compelling, and you don&rsquo;t have to be a video expert to make a good one. Simply be personal and talk about your project. Put yourself in front of the camera for at least a moment so that people know who you are; making that personal connection is key. Show people examples of your work and use any fun visuals you can think of. No matter how bare-bones or creative you want to get, don&#39;t forget the basics: 1. Introduce yourself 2. Tell your story 3. Ask for people&#39;s support (i.e., their money...) 4. Tell people what they&#39;ll get for their money (i.e., your rewards) 5. Say thank you! There are a million different ways to tell your story. Have fun with it! You can spend days shooting and editing, or you can just knock one out with a couple friends on a Saturday. It doesn&#39;t have to be perfect, it just has to be you. For more tips on making your video, visit BoostBloom School.</p>\r\n', 1, 1346241376, 1351863602),
(54, 37, 'What''s the allowed file size for images?', 'Quelle est la taille de fichier autorisée pour les images?', 'what-s-the-allowed-file-size-for-images', 'what-s-the-allowed-file-size-for-images', '<p>\r\n	Images must be 10MB or less, and one of the following file types: JPEG, PNG, GIF, BMP</p>\r\n', '<p>\r\n	Images must be 10MB or less, and one of the following file types: JPEG, PNG, GIF, BMP</p>\r\n', 1, 1346241414, 1351863602),
(55, 37, 'What''s the ideal video encoding?', 'Quel est le codage vidéo idéal?', 'what-s-the-ideal-video-encoding', 'what-s-the-ideal-video-encoding', '<p>\r\n	On Windows, use WMV format. On Mac, use H.264. In both cases, the key variable is the &ldquo;bit rate,&rdquo; so look for that box. If it&rsquo;s measured in kilobits per second (kbps), try 1500 to start. If it&rsquo;s measured in megabits per second (Mbps), try 1.5. If the file is too big: Make that number smaller. If the quality seems bad: Make it bigger.</p>\r\n', '<p>\r\n	On Windows, use WMV format. On Mac, use H.264. In both cases, the key variable is the &ldquo;bit rate,&rdquo; so look for that box. If it&rsquo;s measured in kilobits per second (kbps), try 1500 to start. If it&rsquo;s measured in megabits per second (Mbps), try 1.5. If the file is too big: Make that number smaller. If the quality seems bad: Make it bigger.</p>\r\n', 1, 1346241438, 1351863602),
(56, 37, 'Can I embed media?', 'Puis-je intégrer des médias?', 'can-i-embed-media', 'can-i-embed-media', '<p>\r\n	Yes, you can embed videos, images, and audio in your project description and updates (e.g., from Youtube, Vimeo, Soundcloud, Flickr, etc). However, you cannot embed your main project video; you must upload the original video file. Here&#39;s a full list of supported providers for embedding media: http://embed.ly/providers.</p>\r\n', '<p>\r\n	Yes, you can embed videos, images, and audio in your project description and updates (e.g., from Youtube, Vimeo, Soundcloud, Flickr, etc). However, you cannot embed your main project video; you must upload the original video file. Here&#39;s a full list of supported providers for embedding media: http://embed.ly/providers.</p>\r\n', 1, 1346241470, 1351863602),
(57, 11, '----------------------------------', 'Définissez votre projet', 'defining-your-project', 'defining-your-project', '<h3><strong>Ask yourself: what am I raising funds for?</strong></h3>\r\n\r\n<p>Defining your project is your first step: a project is not a vague idea. A BoostBloom project has a clear beginning and ending with definable expectations to meet.<br />\r\nFor example, recording a new short film, creating cool design chairs, are projects. Such projects end when your film is launched, when your chairs are created. These projects are clear, definable and finite.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Is my idea a BoostBloom project?</strong></h3>\r\n\r\n<p>BoostBloom only accepts finite projects. With a well-defined goal, backers can easily form an opinion on your project&rsquo;s goals and on your ability to complete these goals, while you know in advance where you&rsquo;re putting your efforts into.<br />\r\nYour project&rsquo;s success on BoostBloom depends on this mutual understanding, made of open exchanges and explanations of goals. Before you launch your project, it&rsquo;s a good idea to share it around you, if only to make sure your project is clear. Sharing will also give you extra motivation! If you want to know more about sharing, check out our <a href="http://www.boostbloom.com/display/sharing">SHARING ADVICE</a>.</p>\r\n', '<p>fre_Whether it&rsquo;s a book, a film, or a piece of hardware, the one trait that every BoostBloom campaign shares is that it is a project. Defining what your BoostBloom project is is the first step for every creator. What are you raising funds to do? Having a focused and well-defined project with a clear beginning and end is vital. For example: recording a new album is a finite project &mdash; the project finishes when the band releases the album &mdash; but launching a music career is not. There is no end, just an ongoing effort. BoostBloom is open only to finite projects. With a precisely defined goal, expectations are transparent for both the creator and potential backers. Backers can judge how realistic the project&rsquo;s goals are, as well as the project creator&rsquo;s ability to complete them. And for creators, the practice of defining a project&rsquo;s goal establishes the scope of the endeavor, often an important step in the creative process. BoostBloom thrives on these open exchanges and clear explanations of goals. Make sure your project does this! If you&#39;re unsure if your project is a good fit for BoostBloom (or if BoostBloom is a good fit for your project), we&#39;d encourage you to read the BoostBloom Project Guidelines and peruse recommended and successful projects in your project&#39;s category.</p>\r\n', 1, 1346242408, 1365093103),
(58, 11, 'Creating Rewards', 'Création Récompenses', 'creating-rewards', 'creating-rewards', 'Rewards are what backers receive in exchange for pledging to a project. The importance of creative, tangible, and fairly priced rewards cannot be overstated. Projects whose rewards are overpriced or uninspired struggle to find support.', 'Rewards are what backers receive in exchange for pledging to a project. The importance of creative, tangible, and fairly priced rewards cannot be overstated. Projects whose rewards are overpriced or uninspired struggle to find support.', 0, 1346242444, 1365080599);
INSERT INTO `help_posts` (`id`, `parent_id`, `post_title`, `post_title_hy`, `slug`, `slug_hy`, `description`, `description_hy`, `active`, `created`, `modified`) VALUES
(59, 11, 'Deciding what to offer', 'Décider quoi offrir', 'deciding-what-to-offer', 'deciding-what-to-offer', 'Every project’s primary rewards should be things made by the project itself. If the project is to record a new album, then rewards should include a copy of the CD when it’s finished. Rewards ensure that backers will benefit from a project just as much as its creator (i.e., they get cool stuff that they helped make possible!).\r\n\r\nThere are four common reward types that we see on BoostBloom:\r\n\r\n    Copies of the thing: the album, the DVD, a print from the show. These items should be priced what they would cost in a retail environment.\r\n    Creative collaborations: a backer appears as a hero in the comic, everyone gets painted into the mural, two backers do the handclaps for track 3.\r\n    Creative experiences: a visit to the set, a phone call from the author, dinner with the cast, a concert in your backyard.\r\n    Creative mementos: Polaroids sent from location, thanks in the credits, meaningful tokens that tell a story.\r\n', 'Every project’s primary rewards should be things made by the project itself. If the project is to record a new album, then rewards should include a copy of the CD when it’s finished. Rewards ensure that backers will benefit from a project just as much as its creator (i.e., they get cool stuff that they helped make possible!).\r\n\r\nThere are four common reward types that we see on BoostBloom:\r\n\r\n    Copies of the thing: the album, the DVD, a print from the show. These items should be priced what they would cost in a retail environment.\r\n    Creative collaborations: a backer appears as a hero in the comic, everyone gets painted into the mural, two backers do the handclaps for track 3.\r\n    Creative experiences: a visit to the set, a phone call from the author, dinner with the cast, a concert in your backyard.\r\n    Creative mementos: Polaroids sent from location, thanks in the credits, meaningful tokens that tell a story.\r\n', 0, 1346242478, 1365080609),
(60, 11, 'Deciding how to price', 'Décider comment fixer le prix', 'deciding-how-to-price', 'deciding-how-to-price', 'BoostBloom isn’t charity: we champion exchanges that are a mix of commerce and patronage, and the numbers bear this out. To date the most popular pledge amount is $25 and the average pledge is around $70. Small amounts are where it’s at: projects without a reward less than $20 succeed 35% of the time, while projects with a reward less than $20 succeed 54% of the time.\r\n\r\nSo what works? Offering something of value. Actual value considers more than just sticker price. If it’s a limited edition or a one-of-a-kind experience, there’s a lot of flexibility based on your audience. But if it’s a manufactured good, then it’s a good idea to stay reasonably close to its real-world cost.\r\n\r\nThere is no magic bullet, and we encourage every project to be as creative and true to itself as possible. Put yourself in your backers’ shoes: would you drop the cash on your rewards? The answer to that question will tell you a lot about your project’s potential.\r\n', 'BoostBloom  isn’t charity: we champion exchanges that are a mix of commerce and patronage, and the numbers bear this out. To date the most popular pledge amount is $25 and the average pledge is around $70. Small amounts are where it’s at: projects without a reward less than $20 succeed 35% of the time, while projects with a reward less than $20 succeed 54% of the time.\r\n\r\nSo what works? Offering something of value. Actual value considers more than just sticker price. If it’s a limited edition or a one-of-a-kind experience, there’s a lot of flexibility based on your audience. But if it’s a manufactured good, then it’s a good idea to stay reasonably close to its real-world cost.\r\n\r\nThere is no magic bullet, and we encourage every project to be as creative and true to itself as possible. Put yourself in your backers’ shoes: would you drop the cash on your rewards? The answer to that question will tell you a lot about your project’s potential.\r\n', 0, 1346242552, 1365080606),
(61, 21, '..................................', 'Réglage de votre objectif', 'setting-your-goal', 'setting-your-goal', '<h3><strong>Don&rsquo;t hurry but don&rsquo;t try to make it perfect.</strong></h3>\r\n\r\n<p>Talking about your idea to friends is a good way to make sure you&rsquo;re ready. Are you comfortable with answering their questions? If not, it may be too soon to ask backers for their money. Spend some time fine-tuning your project. A couple of days of reflection can make a huge difference, but when you&rsquo;re ready, don&rsquo;t hesitate!<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Choosing a title for your project</strong></h3>\r\n\r\n<p>Once again put yourself in a backer&rsquo;s shoes and make your BoostBloom project title specific, easy to tweet and to remember.<br />\r\nAs a rule of thumb, do not use generic words like &quot;help,&quot; &quot;support,&quot; &quot;fund&quot; or &ldquo;assist&rdquo;, in your project title. You&rsquo;re not here to ask someone for a favor. You&rsquo;re offering them a unique experience they&rsquo;ll love. In addition, using such words will make it more difficult for your project to be found by name.<br />\r\nIf you&rsquo;re raising funds for an album, a book&hellip;, make sure you include your album or book title in your Boostbloom&rsquo;s project title. For example, if your band is called &ldquo;Slow Rush&rdquo; and the album you want to record is titled &ldquo;Leafless&rdquo;, your BoostBloom project title could be something like &ldquo;Slow Rush record their first LP, Leafless&rdquo;. This project title is more catchy than &ldquo;help me make my album &ldquo;and will make your project easily findable by backers.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Choosing an image for your project</strong></h3>\r\n\r\n<p>Your project image is what will appear on BoostBloom and on the rest of the web. Like before, choose a picture that&rsquo;s specific to your project, descriptive and that looks pretty!<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Writing your short description</strong></h3>\r\n\r\n<p>This short text appears in your project&rsquo;s widget and right under your project image throughout the site. Some would call that an elevator pitch but it would be far too long; we&rsquo;d call this a hand shaking pitch. What would you say to describe your project to someone you&rsquo;re shaking hands with? How would you do it?<br />\r\nThe goal here is to quickly tell your audience what your project is about. Like in your video, stay focused and make sure your few words clearly describe what your project hopes to accomplish.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Writing your bio</strong></h3>\r\n\r\n<p>This is your opportunity to gain trust from backers. Tell them who you are, why you chose to start this project, share with them links to your prior works. In short, share, communicate, and be transparent. Trust us, backers will appreciate.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Choosing your project location</strong></h3>\r\n\r\n<p>The location you give when filling out your basic information could be the difference between being discovered by a backer and being passed over completely.<br />\r\nYou want people browsing Boostbloom to accidentally find your project. It&rsquo;s about being discovered, not accurate. So pick a city that people outside of your state might have heard of! People like to support local projects, but they have to find them first.<br />\r\nBoostbloom asks for your project location when you first create a project. Boostbloom lists 10 cities on the sidebar of the Discover page. If possible, you need to pick one of these cities when you input your project&rsquo;s location, choosing the closest city to you.<br />\r\n<u>If you are from XX, just pick YY. If you are from ZZ, say PP.</u> If you are from some place far away from these cities, then you should still pick the closest big city (or state capital).<br />\r\n&nbsp;</p>\r\n', '<p>BoostBloom operates on an all-or-nothing funding model where projects must be fully funded or no money changes hands. Projects must set a funding goal and a length of time to reach it. There&rsquo;s no magic formula to determining the right goal or duration. Every project is different, but there are a few things to keep in mind.</p>\r\n', 1, 1346242600, 1365089930),
(62, 21, 'Researching your budget', 'L''étude de votre budget de', 'researching-your-budget', 'researching-your-budget', '<p>\r\n	How much money do you need? Are you raising the full budget or a portion of it? Have you factored in the cost of producing rewards and delivering them to backers? Avoid later headaches by doing your research, and be as transparent as you can. Backers will appreciate it.</p>\r\n', '<p>\r\n	How much money do you need? Are you raising the full budget or a portion of it? Have you factored in the cost of producing rewards and delivering them to backers? Avoid later headaches by doing your research, and be as transparent as you can. Backers will appreciate it.</p>\r\n', 0, 1346242628, 1365089658),
(63, 21, 'Considering your networks', 'Compte tenu de vos réseaux', 'considering-your-networks', 'considering-your-networks', '<p>\r\n	BoostBloom is not a magical source of money. Funding comes from a variety of sources &mdash; your audience, your friends and family, your broader social networks, and, if your project does well, strangers from around the web. It&rsquo;s up to you to build that momentum for your project.</p>\r\n', '<p>\r\n	BoostBloom is not a magical source of money. Funding comes from a variety of sources &mdash; your audience, your friends and family, your broader social networks, and, if your project does well, strangers from around the web. It&rsquo;s up to you to build that momentum for your project.</p>\r\n', 0, 1346242660, 1365089663),
(64, 21, 'Choosing your goal', 'Choisir votre objectif', 'choosing-your-goal', 'choosing-your-goal', '<p>\r\n	Once you&rsquo;ve researched your budget and considered your reach, you&rsquo;re ready to set your funding goal. Because funding is all-or-nothing, you can always raise more than your goal but never less. Figure out how much money you need to complete the project as promised (while considering how much funding you think you can generate), and select an amount close to that.</p>\r\n', '<p>\r\n	Once you&rsquo;ve researched your budget and considered your reach, you&rsquo;re ready to set your funding goal. Because funding is all-or-nothing, you can always raise more than your goal but never less. Figure out how much money you need to complete the project as promised (while considering how much funding you think you can generate), and select an amount close to that.</p>\r\n', 0, 1346242686, 1365089669),
(65, 21, 'Setting your project deadline', 'Configuration de votre échéance du projet', 'setting-your-project-deadline', 'setting-your-project-deadline', '<p>\r\n	Projects can last anywhere from one to 60 days, however a longer project duration is not necessarily better. Statistically, projects lasting 30 days or less have our highest success rates. A BoostBloom project takes a lot of work to run, and shorter projects set a tone of confidence and help motivate your backers to join the party. Longer durations incite less urgency, encourage procrastination, and tend to fizzle out.</p>\r\n', '<p>\r\n	Projects can last anywhere from one to 60 days, however a longer project duration is not necessarily better. Statistically, projects lasting 30 days or less have our highest success rates. A BoostBloom project takes a lot of work to run, and shorter projects set a tone of confidence and help motivate your backers to join the party. Longer durations incite less urgency, encourage procrastination, and tend to fizzle out.</p>\r\n', 0, 1346242715, 1365089674),
(66, 44, '..........................................................', 'Rendre votre vidéo', 'making-your-video', 'making-your-video', '<h3><strong>&nbsp;What&rsquo;s a reward?</strong></h3>\r\n\r\n<p>Rewards are what projects creators give to backers in exchange for backing their projects.<br />\r\nRewards should be carefully selected products, artworks, or unique experiences. They should always be cool, fun and creative. When fairly priced and inspired, rewards are great motivations for backers to support a project! With rewards, backers benefit from a project just as much as its creator (i.e., they get cool stuff that they helped make possible!).<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;What you should and should not offer</strong></h3>\r\n\r\n<p>Offering baklavas when your project is to record an album may not be the most appropriate reward. Seriously, backers support your project because they like you as much as they like your project itself. That&rsquo;s why every project&rsquo;s reward should ideally consist of things/experiences made by the project. So if your project is to record a new album, rewards should include a copy of the CD when it&rsquo;s done. A great thing is that BoostBloom allows you to you give out rewards to backers at different levels of funding (i.e. $5, $25, $50&hellip;, whatever you choose).<br />\r\nFor instance, a level 2 reward could be a dedicated picture of your band in addition to the CD you recorded, and why not a printed and signed T-shirt, sent along with the CD to every level 3 backer?<br />\r\nThis system gives you many options, and you can think of anything that will make your rewards unique and fun.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;Do not offer too many different rewards</strong></h3>\r\n\r\n<p>You want to keep things fun and simple. Do not offer too many different rewards or come up with a very complex rewarding system. Like for your goals, things need to be clear: backers need to understand your rewards.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;More examples of rewards</strong></h3>\r\n\r\n<p>Ok, here is what you could think of:<br />\r\n-Copies of your creation: this is the most obvious reward of all: a copy of the album you created thanks to your backers (as we discussed above), the DVD of your Band recording the album, a print from the show your funding made possible, the book you could print thanks to your backers&rsquo; support, the chair you built with the money you raised...<br />\r\nRemember that the rule when pricing these items is to set the price as it would be in a dedicated store (see below for more advice on pricing).<br />\r\n-Collaborations: imagine you&rsquo;re writing a comic on a guy whose obsession is to snowboard on Ararat. Well, you could think of making a backer appear in the comic! He or she could be the character that creates an avalanche so that the ride is more fun? How cool would it be for backers to see themselves in your comic!<br />\r\nLet&rsquo;s say now that you&rsquo;re working on this album we mentioned before. One reward could be not only the album itself but the chance for a backer to do the finger clapping on the opening of track 4 just before the duduk starts. It could be fun, right?<br />\r\n-Interactions: if backers can come, what about this: you could reward them with a visit to the location you shot your short film? Or with a visit to the workshop where you&rsquo;ve sweated so much to build this fabulous chair? What about giving backers a private piano lesson in addition to your CD album, or inviting them to a private concert or to a drink with the whole band?<br />\r\nEven a simple phone call from the lead singer or from the author of the book could be cool and would surely be valued by your backers!<br />\r\n-Associations:<br />\r\nWhat about sending cool pictures from the band taken on location with a special note for backers or thanking them namely in the credits? They are, after all, the ones that made your project possible!<br />\r\nSee, the opportunities are endless; think of anything fun that YOU would like to receive if you were yourself a backer of your project.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;What about rewards if my project is about Charity?</strong></h3>\r\n\r\n<p>Because we treat charity like any other projects, rewards are imperative in this field as well. You can think of any kind of rewards: still, keep in mind that like for other projects, rewards need to be personal and a motivation for backers (think of the products your charity will build thanks to your backers&rsquo; money, or if your charity involves kids, maybe a picture dedicated by them with a special word to backers?).<br />\r\nLike in other areas, you can think of anything that Backers would be happy to receive in exchange for their support.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;Deciding on the price </strong></h3>\r\n\r\n<p>You should place tremendous care in the choice of your rewards and in your pricing. Reasonably priced rewards make the most successful projects: a cool reward that costs less than $20 is an excellent starting price.<br />\r\n-So what works?<br />\r\nWell there is no magic recipe and, like in the real world, offering something of value at an attractive price usually is the best approach.<br />\r\nIs it a manufactured item you&rsquo;re offering as a reward? Then the best thing is to keep your price as close as possible to its cost, or to its retail price if it were sold in a shop.<br />\r\nIs your reward a unique experience or a limited edition? Then you have a variety of pricing options based on who your audience is. Simply stay true to your project, adjust the prices accordingly and don&rsquo;t forget to take into account you shipping costs.<br />\r\nAnd always ask yourself: would you open your purse for your rewards?<br />\r\n&nbsp;</p>\r\n', '<p>f you&rsquo;re like us, the first thing you do when visiting a project page is click play. A video is by far the best way to get a feel for the emotions, motivations, and character of a project. It&rsquo;s a demonstration of effort and a good predictor of success. Projects with videos succeed at a much higher rate than those without (50% vs. 30%). We know that making a video can be intimidating. Not many of us like being in front of a camera. We also know that making a video is a challenge worth taking on. It says you care enough about what you&rsquo;re doing to put yourself out there. It&#39;s a small risk with a big reward. If you have computer access and a ready supply of enthusiasm, you&rsquo;ve got all you need. Some videos are big montages and others are epic long takes, but most videos are just someone telling their story straight into the camera. You can spend days shooting and editing, or you can just knock it out with a couple friends on a Saturday. It doesn&#39;t have to be perfect, it just has to be you. No matter how creative or bare-bones your video, you&#39;ll want to: Tell us who you are. Tell us the story behind your project. Where&#39;d you get the idea? What stage is it at now? How are you feeling about it? Come out and ask for people&#39;s support, explaining why you need it and what you&#39;ll do with their money. Talk about how awesome your rewards are, using any images you can. Explain that if you don&#39;t reach your goal, you&#39;ll get nothing, and everyone will be sad. Thank everyone! And don&#39;t be afraid to put your face in front of the camera and let people see who they&rsquo;re giving money to. We&rsquo;ve watched thousands of these things, and you&rsquo;d be surprised what a difference this makes. Another thing to remember: don&#39;t put any copyrighted music in your video without permission! Expensive lawsuits are never fun. Here are some music resources you can use when the time comes: SoundCloud, Vimeo Music Store, Free Music Archive, and ccMixter. And finally a few technical specs: videos must be 250MB or less and have a file type of MOV, MPEG, AVI, MP4, 3GP, WMV, or FLV.</p>\r\n', 1, 1346242808, 1365085714),
(67, 45, '..................................', 'Construire votre projet', 'building-your-project', 'building-your-project', '<h3><strong>Do you need to make a video? </strong></h3>\r\n\r\n<p>Yes, ABSOLUTELY Why? Because without a video, projects are much more likely to fail.<br />\r\nYour video makes the connection between you and your audience. What&rsquo;s the recipe for that? Well don&rsquo;t hesitate to shoot and reshoot until you&rsquo;re satisfied. The more you practice, the more at ease you&rsquo;ll feel in front of the camera.<br />\r\nIf you lack confidence, don&rsquo;t panic! Few of us feel comfortable in front of a camera. Most of us even look more like Shrek (or his wife) than Brad Pitt (or his wife). No need to be perfect. Keep hesitations or funny facial expressions, viewers will see that you&rsquo;re showing who you really are, and that&rsquo;s what connecting is all about. Whether you entertain or captivate your viewers, your goal here is to make your watchers FEEL something.<br />\r\nOne last thing: keep in mind that the effort you&rsquo;re putting into it is worth it: a video is the first thing backers click on when they want to check a project.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>What is a good video?</strong></h3>\r\n\r\n<p>Quality is important (we&rsquo;ll give you tips for that), but not as much as the story you tell. Be passionate and show your real you.<br />\r\n<strong>Get ready</strong><br />\r\n-Be different. You&rsquo;re free to do whatever you like in your video but making something original will help you stand out more to your viewers. And remember, humor is always cool!<br />\r\n-Write 3 to 4 bullet points and start recording.<br />\r\nyou can edit it together later if you need to.<br />\r\n-Ask your friends to be part of the video! They&rsquo;ll help you out, give advice and make the whole experience more fun!<br />\r\n-Listen to what you just said, decide what you like, discard the rest. Do it again at once and repeat the process (you&rsquo;ll see that you&rsquo;re getting better and better with every take).Don&rsquo;t be too hard on yourself, take your time, breath and don&rsquo;t give up:<br />\r\n-Keep it short: don&rsquo;t waste screen time talking about absolutely all of your rewards or about every single detail of your project (you have a lot of text space under your video to do that).<br />\r\nInstead, focus on making a connection and getting to the point: you&rsquo;re trying to convince people one by one to support you. So show this excitement as if you were talking to your best friend, your mum or spouse, this one single person whose support means the world to you.<br />\r\n-Smile and let the show begin!<br />\r\n<strong>Here are the basics to help you started:</strong><br />\r\n-Introduce yourself.<br />\r\nYou are trying to make a connection so don&rsquo;t be shy! Show your face even for a short time. This will make the video personal and this will help people to know you (this is kind of useful when you try to get people&rsquo;s support!)<br />\r\n-Tell us who you are, why you&rsquo;re doing what you&rsquo;re doing, and how you feel about the whole thing<br />\r\n-Show people examples of your work or talk about your past experience<br />\r\n-Tell people what you are doing here (this is your project&rsquo;s story) using any fun visuals you can think of (see below for tips on how to make the best video you can)<br />\r\n-Ask for people&rsquo;s support and explain why you need it<br />\r\n-Tell people what they&rsquo;ll get for their money (i.e., your rewards)<br />\r\n-You may also want to include a brief explanation for newcomers on Boostbloom&rsquo;s all-or-nothing structure<br />\r\n-Say thank you!<br />\r\nNow that you know what to put in your video, here are some tips on how to do it.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>How to make your video look (and sound) good</strong></h3>\r\n\r\n<p>You don&rsquo;t have to be a video expert, you don&rsquo;t need a top quality camera either; even smartphones can record quality movies. Just make sure to:<br />\r\n-Be heard<br />\r\nSound is essential. Sound must be as clear as possible. (You can easily add subtitles to your video if you want to appeal to a larger audience. The internet offers many ways to add subtitles to video for free.) Make sure you&rsquo;re in a quiet and echo-free place: close doors and windows and if possible, stay away from your fridge (you can eat before recording your video though&hellip;) and from other sources of unwanted noise.<br />\r\n-Be seen<br />\r\nIf your image is grainy, well reason is light (or lack thereof that is). That&rsquo;s why plenty of light is essential when you record. Add as many light sources as possible, image will be sharper, and watchers happier.<br />\r\nBest is to use various sources of lights (lamps, sunlight, flashes or mirrors) coming from many directions. Do not ever record at night or in darkness (unless your project is a horror movie and you want to show a sample of your skills!)<br />\r\n<strong>And the golden rule: Make something you&rsquo;d want to spend your time watching: it&rsquo;s likely other people will enjoy watching it, too!</strong><br />\r\n<u>When you&rsquo;re done, don&rsquo;t forget to share the link to your video around you on your social networks, and ask your friends to share it too! See our special section on Sharing here.</u><br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>A quick word on editing</strong></h3>\r\n\r\n<p>The aim is not to make something professional. If you&rsquo;re a film maker chances are pretty high your video will look great and that&rsquo;s amazing. For others the important thing to remember is that your video needs to be personal, straight to the point, and not too long. If not, you may have to edit it.<br />\r\n-Keep the best parts: here you look for the clear lines, the fun moments where people can see an expression on your face (a smile, an arched eyebrow, a pause as you&rsquo;re searching for the right words). Simply put, any moment that makes your video REAL is good.<br />\r\n-Edit those together in big chunks.<br />\r\nMany free (or not) tools are available. Windows Movie Maker and iMovie both work well for this. But keep in mind that you want to showcase your project, not your editing skills.<br />\r\n-Make it captivating from the start<br />\r\nKeep the essential: When you think you&rsquo;re done, take a break, then come back and cut out 25% of the video. This is a must. Once again put yourself in a potential backer&rsquo;s shoes and make sure your video, especially the first 20 seconds, is pure punch. People are going to visit your page, press &ldquo;play&rdquo; on your video, and&hellip; then what? Zzzzz?<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Encoding</strong></h3>\r\n\r\n<p>On Windows, use WMV format. On Mac, use H.264. In both cases, the key variable is the &ldquo;bit rate,&rdquo; so look for that box. If it&rsquo;s measured in kilobits per second (kbps), try 1500 to start. If it&rsquo;s measured in megabits per second (Mbps), try 1.5. If the file is too big: Make that number smaller. If the quality seems bad: make your video a bit bigger. The main video of your project is limited at 1Go. Only &#39;wmv&#39;, &#39;avi&#39;, &#39;mpeg&#39;, &#39;mpg&#39;, &#39;mp4&#39;, &#39;mov&#39; and &#39;flv&#39; files are allowed. <u>Others can&rsquo;t exceed xxx. (limit size for video and audio and pics in text editor places, but this shouldn&rsquo;t be here)</u><br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>When you&rsquo;re done: </strong></h3>\r\n\r\n<p>Ask yourself:<br />\r\nIs my video fun enough for someone not to press stop in the middle of it?<br />\r\nIs it enjoyable and informative at the same time?<br />\r\nAre you recording an album? If so, did you stop to consider the background music you used on your video, is it your own music? Is it related to your project?<br />\r\nAre you shooting a short movie? Do you show a cool scene of your film in your video?<br />\r\nIs your project planning/organizing an event? Then show some logos, artwork or anything tangible for your viewers to feel that the project is real.<br />\r\nAre you writing a novel? Then show your skills and read us a sample dialogue. You can display your acting skills too at the same time!<br />\r\nIs this a cause you&rsquo;re trying to raise money for? Show your viewers tangible steps that have already been taken and how much it helped!<br />\r\nAnd of course, if you&rsquo;re selling a product, show us a prototype!<br />\r\nSee? Possibilities are endless, just make sure your video is real, informative, short and fun all the way. You&rsquo;re not raising money for a dream, but for a reality. And you&rsquo;re bringing rewards in exchange!<br />\r\n<strong>Spoiler here</strong><br />\r\nMake sure you don&#39;t use copyrighted music in your video unless you get permission! This is against the law and worse (!), your project will be deleted.<br />\r\nFor sound and music, you may try some Creative Commons-licensed music &mdash; per the terms of their licenses. This is available on the Free Music Archive website or on Soundcloud. Check it out!<br />\r\n&nbsp;</p>\r\n', '<p>As you build your project, take your time! The average successfully funded creator spends nearly two weeks tweaking their project before launching. A thoughtful and methodical approach can pay off.</p>\r\n', 1, 1346242853, 1365092673),
(68, 45, 'Titling your project', 'Titrage votre projet', 'titling-your-project', 'titling-your-project', '<p>\r\n	Your BoostBloom project title should be simple, specific, and memorable, and it should include the title of the creative project you&#39;re raising funds for. Imagine your title as a distinct identity that will set it apart (&quot;Make my new album&rdquo; isn&rsquo;t as helpful or searchable as &ldquo;The K-Stars record their debut EP, All Or Nothing &quot;). Avoid words like &quot;help,&quot; &quot;support,&quot; or &quot;fund.&quot; They imply that you&#39;re asking someone to do you a favor rather than offering an experience they&rsquo;re going to love.</p>\r\n', '<p>\r\n	Your BoostBloom project title should be simple, specific, and memorable, and it should include the title of the creative project you&#39;re raising funds for. Imagine your title as a distinct identity that will set it apart (&quot;Make my new album&rdquo; isn&rsquo;t as helpful or searchable as &ldquo;The K-Stars record their debut EP, All Or Nothing &quot;). Avoid words like &quot;help,&quot; &quot;support,&quot; or &quot;fund.&quot; They imply that you&#39;re asking someone to do you a favor rather than offering an experience they&rsquo;re going to love.</p>\r\n', 0, 1346242881, 1365089283),
(69, 45, 'Picking your project image', 'Reprenant l''image de votre projet', 'picking-your-project-image', 'picking-your-project-image', '<p>\r\n	Your project image is how you will be represented on BoostBloom and the rest of the web. Pick something that accurately reflects your project and that looks nice, too!</p>\r\n', '<p>\r\n	Your project image is how you will be represented on BoosBloom and the rest of the web. Pick something that accurately reflects your project and that looks nice, too!</p>\r\n', 0, 1346242909, 1365089298),
(70, 45, 'Writing your short description', 'La rédaction de votre description courte', 'writing-your-short-description', 'writing-your-short-description', '<p>\r\n	Your short description appears in your project&rsquo;s widget, and it&rsquo;s the best place to quickly communicate to your audience what your project is about. Stay focused and be clear on what your project hopes to accomplish. If you had to describe your project in one tweet, how would you do it?</p>\r\n', '<p>\r\n	Your short description appears in your project&rsquo;s widget, and it&rsquo;s the best place to quickly communicate to your audience what your project is about. Stay focused and be clear on what your project hopes to accomplish. If you had to describe your project in one tweet, how would you do it?</p>\r\n', 0, 1346242936, 1365089290),
(71, 45, 'Writing your bio', 'La rédaction de votre bio', 'writing-your-bio', 'writing-your-bio', '<p>\r\n	Your bio is a great opportunity to share more about you. Why are you the one to take on this project? What prior work can you share via links? This is key to earning your backers&rsquo; trust.</p>\r\n', '<p>\r\n	Your bio is a great opportunity to share more about you. Why are you the one to take on this project? What prior work can you share via links? This is key to earning your backers&rsquo; trust.</p>\r\n', 0, 1346242967, 1365089294),
(74, 46, '..............................', 'rencontrer', 'meeting-up', 'meeting-up', '<h3><strong>&nbsp;Make it personal</strong></h3>\r\n\r\n<p>Like for the video, making it personal is a must. Tell a story, your story.<br />\r\nBackers are just as motivated to support you as a person as they are to support your idea itself. Who talks about Van Gogh paintings without mentioning his life, his story, the artist himself?<br />\r\nYour aim is to make backers trust that you will create something amazing with their money. Tell your backers when you first came up with the idea. Were you listening to music on the radio when you realized your own music could be as great? Did you make a jacket for yourself that looked so good that your best friend asked you to make one for him too? Where does your inspiration come from? Let them know! Are you fighting against bigger players in your field? Well this is an opportunity! Tell your backers you can make a difference! Everyone loves success stories and being part of one.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;Build trust</strong></h3>\r\n\r\n<p>Telling your story also makes this connection we talked about: potential backers need to feel that they can trust you with their money, that once you&rsquo;ve reached your goal, your project will succeed so they will receive their rewards.<br />\r\nThe only way to gain their trust is for you to show them that you are going to do what it takes to make your project succeed!<br />\r\nBy explaining your motivation you will motivate others. Did you do something similar in the past? Have you won awards in a field? Say it, show it, share links!<br />\r\nNo publisher wants to publish your work? So what? Explain what you did before, what you&rsquo;re doing now. Build trust!<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;Make it funny</strong></h3>\r\n\r\n<p>You&rsquo;ll see that most successful projects use humor. Because humor is the best ice breaker, it makes an instant connection, closing the distance between you and your viewers. Even one phrase, one expression, a self-deprecating joke can be a good way to help you build this connection with backers.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>&nbsp;Basics that should appear in the description of your project</strong></h3>\r\n\r\n<p>Who is creating the project? If several people are involved, say who they are and explain their roles (you can also show their faces in the video!)<br />\r\nWhy is reaching your funding goal essential for the project? Once more, don&rsquo;t look desperate. Simply explain how important it is for you to reach this goal.<br />\r\nWhy have you decided to start this project?<br />\r\nWho do you think your project is aimed at? (Artists, art lovers, musicians, music fans, avid crime book readers, comics fans, anyone?) Explain who and why, and if you think your project can reach a wide audience, make sure you&rsquo;re not too technical about your project.<br />\r\nWhere is the project located?<br />\r\nWhat rewards will backers obtain? Why are your rewards great? Are you ready to ship worldwide? (This is advisable since your project will hopefully rally support from various countries)<br />\r\nWhen can backers expect to receive their rewards and why?<br />\r\nAnd make sure you anticipate most key questions and doubts. Of course backers can and will ask you questions on your update page (or even directly), but many of them won&rsquo;t go that far as supporting another project is only one click away. In order to save backers time, foresee relevant questions and answer them in your description. This will only bring you closer to achieving your goal.</p>\r\n\r\n<h3><br />\r\n<strong>&nbsp;Should you use titles, paragraphs, sections?</strong></h3>\r\n\r\n<p>Yes, you should. You&rsquo;re free to choose your layout of course! However, we strongly recommend you do it &ldquo;the newspaper way&rdquo;. This means your titles should be bold and big, and your main title bigger still. That&rsquo;s the first thing that will catch your reader&rsquo;s attention -and that&rsquo;s where the decision to go further in the reading is made-.<br />\r\nWords themselves should be catchy: your titles can be a summary of the main ideas you develop in the paragraph, or just an expression that will arouse your viewer&rsquo;s curiosity!</p>\r\n', '<p>Don&rsquo;t be afraid to take your BoostBloom project out into the real world. Nothing connects people to an idea like seeing the twinkle in your eye when you talk about it. Host pledge parties, print posters or flyers to distribute around your community, and organize meetups to educate people about your endeavor. Be creative!</p>\r\n', 1, 1346243098, 1365092885),
(75, 47, '.............................', 'Mises à jour du projet', 'project-updates', 'project-updates', '<p>If your project is outstanding, it will gather support from every corner of the web. But even for such projects, support starts from within your own networks. Take advantage of this! If you want people to back your project, tell them about it using as many ways as possible.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Online</strong></h3>\r\n\r\n<p>-Be personal, creative, and&hellip;be fun!<br />\r\nDon&rsquo;t spam. Sharing your link on other BoostBloom project pages is spam, indiscriminately sending tweets on Twitter is spam, sending links to unknown people on Facebook is also spam.<br />\r\nFirst, doing so is not effective, secondly it can even be counterproductive as it shows you&rsquo;re desperate. Don&rsquo;t forget that you&rsquo;re not begging and that you&rsquo;re offering an opportunity, an experience to backers.<br />\r\n-Be strategic:<br />\r\nContact people individually, it makes a huge difference. Remember that friends and family are your first supporters and will usually be glad to bring you their boost.<br />\r\nUse their first name in your email, add a personal message and explain your project. Tell them you need their support and explain why, share your excitement and point out what they will get in return once they back your project. Once again, remember you&rsquo;re not asking for help here. You&rsquo;re offering something in return.<br />\r\nYour friends and family will often be the first to pledge! Share with them a link to your Boostbloom project and to your BoostBloom profile page, and gently ask them to share this link around! A nicely written reminder once in a while can also be a good idea and will never be a nuisance to your readers if you do it the right way.<br />\r\n-Share what&rsquo;s going on with your project.<br />\r\nPost updates on your Boostbloom&rsquo;s update page. This page is your own personal blog page and is a great way to communicate with your audience. (See Practice no 8 below for more about Updates).<br />\r\nAnswer questions. While your project is live, people will contact you to ask for information about your project. Their questions may vary from delivery dates to specific technicalities. We recommend you answer them PROMPTLY and publicly through a project update and through your own Project FAQ in case other backers or potential backers are wondering the same. Transparency is vital on Boostbloom and essential for the success of your project.<br />\r\n-Write on your Facebook page, use or create a Twitter account to grab everyone&rsquo;s attention.<br />\r\nRemember, don&rsquo;t overdo it, but every time you reach a milestone in your project, make sure you let your networks and your fans know about it! For more on how to make your project known, check out our <a href="http://www.boostbloom.com/display/sharing">Sharing advice!</a><br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>On field</strong></h3>\r\n\r\n<p>-Communicate!<br />\r\nPeople will feel your passion when you describe your project and will spread the word! Seize every opportunity: if you&rsquo;re not shy online, why would you be in the real world?<br />\r\nBe creative! Why not ask your family and friends to click like, +1, or make them tweet from their laptops or from their smartphones all at once when your project is launched! That could be cool!<br />\r\nWhy not throw a party for your project? Possibilities are endless! If your project is about music, why not reward the guest who shares the most pictures of your party with a credit in your album leaflet when your cd is out?<br />\r\nIf it&#39;s an item you&rsquo;re making, why not take a fun picture of every guest posing with the product? It&rsquo;s quite likely your friends will love sharing that with their social networks, giving exposure to your project and reaching a broader audience! All this in a fun way for everyone!<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Talk about your BoostBloom project</strong></h3>\r\n\r\n<p>Get in touch with local newspapers, TV, and radio stations and explain what your project is all about. Don&rsquo;t be shy! Get back online and contact bloggers to share what you&rsquo;re doing. Those who write about the field your project belongs to can be of tremendous help. Remember what we said about how important your story is for the success of your project? Well, this is the time to share your story once more. Bloggers and writers love real stories to talk about! For more, check out our&nbsp;<u><a href="http://www.boostbloom.com/display/sharing">SHARING ADVICE!</a></u></p>\r\n', '<p>Project updates serve as your project&rsquo;s blog. They&rsquo;re a great way to share your progress, post media, and thank your backers. Posting a project update automatically sends an email to all your backers with that update. You can choose to make each update public for everyone to see, or reserve it for just your backers to view.</p>\r\n', 1, 1346243156, 1365512626),
(76, 47, 'Building momentum', 'Renforcer la dynamique', 'building-momentum', 'building-momentum', '<p>\r\n	While your project is live and the clock ticking, keep your backers informed and inspired to help you spread the word. Instead of posting a link to your project and asking for pledges every day, treat your project like a story that is unfolding and update everyone on its progress. &ldquo;Pics from last night&rsquo;s show!&rdquo; or &ldquo;We found a printer for our book!&rdquo; with a link to your project is engaging and fun for everybody to follow along with.</p>\r\n', '<p>\r\n	While your project is live and the clock ticking, keep your backers informed and inspired to help you spread the word. Instead of posting a link to your project and asking for pledges every day, treat your project like a story that is unfolding and update everyone on its progress. &ldquo;Pics from last night&rsquo;s show!&rdquo; or &ldquo;We found a printer for our book!&rdquo; with a link to your project is engaging and fun for everybody to follow along with.</p>\r\n', 0, 1346243197, 1365089018),
(77, 47, 'Sharing the process', 'Partager le processus', 'sharing-the-process', 'sharing-the-process', '<p>\r\n	Once your project is successfully funded, don&rsquo;t forget about all the people that helped make it possible. Let backers and spectators watch your project come to life by sharing the decisions you make with them, explaining how it feels as your goal becomes a reality, and even asking them for feedback. Keeping backers informed and engaged is an essential part of BoostBloom.</p>\r\n', '<p>\r\n	Once your project is successfully funded, don&rsquo;t forget about all the people that helped make it possible. Let backers and spectators watch your project come to life by sharing the decisions you make with them, explaining how it feels as your goal becomes a reality, and even asking them for feedback. Keeping backers informed and engaged is an essential part of BoostBloom.</p>\r\n', 0, 1346243241, 1365089013),
(78, 47, 'Celebrating success', 'célébrer le succès', 'celebrating-success', 'celebrating-success', '<p>\r\n	Sharing reviews, press, and photos from your project out in the world &mdash; whether it&rsquo;s opening night of your play or your book on someone&rsquo;s bookshelf &mdash; is great for everyone involved. The story of your project doesn&rsquo;t end after it gets shipped out. You still have a captivated audience that&rsquo;s cheering for you. Communicating with them can be one of the most rewarding parts of the process.</p>\r\n', '<p>\r\n	Sharing reviews, press, and photos from your project out in the world &mdash; whether it&rsquo;s opening night of your play or your book on someone&rsquo;s bookshelf &mdash; is great for everyone involved. The story of your project doesn&rsquo;t end after it gets shipped out. You still have a captivated audience that&rsquo;s cheering for you. Communicating with them can be one of the most rewarding parts of the process.</p>\r\n', 0, 1346243269, 1365089008),
(83, 48, '.........................................', 'Obtenir bailleur d''informations', 'getting-backer-info', 'getting-backer-info', '<p>Project updates serve as your project&rsquo;s blog. These updates give you freedom and flexibility to interact with backers, share your progress, show your achievements and the obstacles you&rsquo;re dealing with. This page is yours and you can use whatever media you want in order to communicate your message. Use it and abuse it.<br />\r\nBackers will always be pleased to be informed about your project. After all, they are the ones supporting you!<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>Where can you post updates?</strong></h3>\r\n\r\n<p>On home page (if you&rsquo;re not sure to be on home page, click on &ldquo;Boostbloom&rdquo; on top left of the screen, you will be redirected), click on &ldquo;me&rdquo; and choose &ldquo;all my projects&rdquo;. The new screen will show you all the projects you have created. Just scroll down to the project you want to post an update about and click &ldquo;Project update&rdquo; (note: you will see the &ldquo;project update&rdquo; link only on a launched project).<br />\r\nA new window will appear allowing you to post updates!<br />\r\nEvery time you post an update, backers automatically receive an email informing them about it. They also receive a directly notification on Boostbloom. Updates also appear on your project page and Boostbloom&rsquo;s main Blog for everyone to see. This is a very powerful tool.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>How to use update during the funding of your project?</strong></h3>\r\n\r\n<p>The best way to use updates is to talk about stories related to your project. Maybe not about every single detail, but sharing the fun things that happen to you daily or while working on your project are good ways of keeping your audience hooked.<br />\r\nUsing updates to ask for pledges is not a good idea. Instead, think of updates as an open book you&rsquo;re writing for every viewer to discover. Why not let your audience know about the progress of your short film by writing on your updates page &ldquo;we have chosen the setting for the final scene!&rdquo;? Uploading a picture of the chosen location could be a good idea too!<br />\r\nWhat about updating your backers with this: &ldquo;we have received red wood to start our design desk!&rdquo; and show what the wood looks like before you work your magic on it!<br />\r\nAll of these are interesting ways to keep your backers engaged!<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>How to use updates once your project is successful?</strong></h3>\r\n\r\n<p>Well, it&rsquo;s up to you. But thanking everyone that made your project possible is a good start, and backers will surely appreciate.<br />\r\nA word on rewards and on delivery dates may also be useful. This will keep expectations high and show that your motivation is still on top.<br />\r\nThe story of your project is not over after your rewards are shipped out. Your backers have been supporting you! Sharing your success is the best part! Show reviews of your project, share what the press and the online community said about it, attach pictures! Tell the world what your thoughts were, explain what you went through as you were working on the project, and show how you finally made it! In short, keep everyone engaged!<br />\r\nAsking backers for their opinions can also be useful! It can help you come up with great ideas for your future projects.</p>\r\n', '<p>Don&rsquo;t worry about gathering your backers&rsquo; info until after your project is successfully funded. At that point the BoostBloom survey tool will help you create surveys to request whatever info you may need to deliver your rewards (mailing addresses, T-shirt sizes, etc). You can find this feature in your Backer Report. Backers are notified via email when you send out the survey, and their responses are automatically entered into your Backer Report, which can then be exported as an Excel-compatible spreadsheet.</p>\r\n', 1, 1349770530, 1365088258);
INSERT INTO `help_posts` (`id`, `parent_id`, `post_title`, `post_title_hy`, `slug`, `slug_hy`, `description`, `description_hy`, `active`, `created`, `modified`) VALUES
(84, 23, '...................................', 'Deciding what to offer', '', '', '<h3><strong>Setting your goal</strong></h3>\r\n\r\n<p>Projects creators must set a funding goal and a duration to reach this goal. No money will ever change hands if projects are not fully funded.<br />\r\nIn order to determine your goal, make sure you ask yourself:<br />\r\nAm I trying to raise the whole budget or merely a piece of it? Have I taken into consideration the cost of producing and delivering rewards to backers?<br />\r\nAs always, communicating is a good idea: backers will appreciate all information you share about your costs.<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>All or nothing?</strong></h3>\r\n\r\n<p>Remember! Funding is all-or-nothing. This means that you can raise more than your goal but never less. So once you know how much money you need to complete the project, set your funding goal close to that amount.<br />\r\nAnd remember one thing: the quality of your rewards can make a huge difference on how much money your project will raise. (See more about rewards in the next section).</p>\r\n', '<p>BoostBloom isn&rsquo;t charity: we champion exchanges that are a mix of commerce and patronage, and the numbers bear this out. To date the most popular pledge amount is $25 and the average pledge is around $70. Small amounts are where it&rsquo;s at: projects without a reward less than $20 succeed 35% of the time, while projects with a reward less than $20 succeed 54% of the time. So what works? Offering something of value. Actual value considers more than just sticker price. If it&rsquo;s a limited edition or a one-of-a-kind experience, there&rsquo;s a lot of flexibility based on your audience. But if it&rsquo;s a manufactured good, then it&rsquo;s a good idea to stay reasonably close to its real-world cost. There is no magic bullet, and we encourage every project to be as creative and true to itself as possible. Put yourself in your backers&rsquo; shoes: would you drop the cash on your rewards? The answer to that question will tell you a lot about your project&rsquo;s potential.</p>\r\n', 1, 1349770642, 1374793580);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `params` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `is_notified` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_spam` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plugin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=120 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `parent_id`, `module`, `plugin`, `controller`, `action`, `url`, `created`, `modified`) VALUES
(1, 0, 'User Plugin', 'users', '', '', '', 2012, 2012),
(2, 1, 'Users', 'users', 'users', '', 'users/admin_index', 2012, 2012),
(3, 2, 'Users List', 'users', 'users', 'admin_index', 'users/admin_index', 2012, 2012),
(4, 2, 'User Add', 'users', 'users', 'admin_add_user', 'users/admin_add_user', 0, 0),
(5, 2, 'User Edit', 'users', 'users', 'admin_edit', 'users/edit', 2012, 2012),
(6, 0, 'Category Plugin', 'categories', '', '', '', 2012, 2012),
(7, 6, 'Categories', 'categories', 'categories', '', 'categories/index', 2012, 2012),
(8, 7, 'Category Add', 'categories', 'categories', 'admin_add_category', 'categories/add_category', 2012, 2012),
(9, 7, 'Category Edit', 'categories', 'categories', 'admin_edit', 'categories/edit', 2012, 2012),
(10, 0, 'Project', 'projects', '', '', '', 1346839269, 1346839270),
(11, 10, 'Projects', 'projects', 'projects', '', 'projects/admin_index', 1347018215, 1347018216),
(12, 11, 'Project List', 'projects', 'projects', 'admin_index', 'projects/admin_index', 1346839269, 1346839270),
(13, 11, 'Project Update Status', 'projects', 'projects', 'change_project_status', 'projects/admin_change_project_status', 1346839269, 1346839270),
(14, 0, 'Blog', 'blogs', '', '', '', 1346839269, 1346839269),
(15, 14, 'Blog', 'blogs', '', '', 'blogs/admin_index', 1346839269, 1346839269),
(16, 15, 'Blog List', 'blogs', 'blogs', 'admin_index', 'blogs/admin_index', 1346839269, 1346839269),
(17, 15, 'Blog Add', 'blogs', 'blogs', 'admin_add_blog', 'blogs/admin_add_blog', 1346839269, 1346839269),
(18, 15, 'Blog Edit', 'blogs', 'blogs', 'admin_edit_blog', 'blogs/admin_edit_blog', 1340889444, 1340889444),
(19, 15, 'Blog Delete', 'blogs', 'blogs', 'admin_delete_blog', 'blogs/admin_delete_blog', 1340889444, 1340889444),
(20, 15, 'Blog Update Status', 'blogs', 'blogs', 'admin_change_blog_status', 'blogs/admin_change_blog_status', 1346839269, 1346839269),
(21, 15, 'Blog Category List', 'blogs', 'blog_categories', 'admin_index', 'blog_categories/admin_index', 1346839269, 1346839269),
(22, 15, 'Blog Category  Add', 'blogs', 'blog_categories', 'admin_add_blog_category', 'blog_categories/admin_add_blog_category', 1340889444, 1340889444),
(23, 15, 'Blog Category Edit', 'blogs', 'blog_categories', 'admin_edit_blog_category', 'blog_categories/admin_edit_blog_category', 1346839269, 1346839269),
(24, 15, 'Blog Category Delete', 'blogs', 'blog_categories', 'admin_delete_blog_category', 'blog_categories/admin_delete_blog_category', 1345809603, 1345809603),
(25, 15, 'Blog Category Update Status', 'blogs', 'blog_categories', 'admin_change_category_status', 'blog_categories/admin_change_category_status', 1346839269, 1346839269),
(26, 15, 'Blog Post List', 'blogs', 'blog_posts', 'admin_index', 'blog_posts/admin_index', 1346839269, 1346839269),
(27, 15, 'Blog Post Add', 'blogs', 'blog_posts', 'admin_add_post', 'blog_posts/admin_add_post', 1345809603, 1345809603),
(28, 15, 'Blog Post Edit', 'blogs', 'blog_posts', 'admin_edit_post', 'blog_posts/admin_edit_post', 1346839269, 1346839269),
(29, 15, 'Blog Post  Delete', 'blogs', 'blog_posts', 'admin_delete_post', 'blog_posts/admin_delete_post', 1345809603, 1345809603),
(30, 15, 'Blog Post Update Status', 'blogs', 'blog_posts', 'admin_change_post_status', 'blog_posts/admin_change_post_status', 1346839269, 1346839269),
(31, 15, 'Blog Comment List', 'blogs', 'blog_post_comments', 'admin_index', 'blog_post_comments/admin_index', 1345809603, 1345809603),
(32, 15, 'Blog Comment Edit', 'blogs', 'blog_post_comments', 'admin_edit_comment', 'blog_post_comments/admin_edit_comment', 1346839269, 1346839269),
(33, 15, 'Blog Comment Delete', 'blogs', 'blog_post_comments', 'admin_delete_category', 'blog_post_comments/admin_delete_category', 1345809603, 1345809603),
(34, 15, 'Blog Comment Update Status', 'blogs', 'blog_post_comments', 'admin_change_comment_status', 'blog_post_comments/admin_change_comment_status', 1346839269, 1346839269),
(35, 0, ' Newsletter ', 'newsletters', '', '', '', 1346839269, 1346839269),
(36, 35, 'Newsletter ', 'newsletters', '', '', 'newsletters/admin_index', 1346839269, 1346839269),
(37, 36, 'Newsletter List', 'newsletters', 'newsletters', 'admin_index', 'newsletters/admin_index', 1345809603, 1345809603),
(38, 36, 'Newsletter Edit', 'newsletters', 'newsletters', 'admin_edit_newsletter', 'newsletters/admin_edit_newsletter', 1346839269, 1346839269),
(39, 36, 'Newsletter Delete', 'newsletters', 'newsletters', 'admin_delete_newsletter', 'newsletters/admin_delete_newsletter', 1345809603, 1345809603),
(40, 36, 'Newsletter Update Status', 'newsletters', 'newsletters', 'admin_change_newsletter_status', 'newsletters/admin_change_newsletter_status', 1346839269, 1346839269),
(41, 36, 'Newsletter Subscribers List', 'newsletters', 'subscribers', 'admin_index', 'subscribers/admin_index', 1346839269, 1346839269),
(42, 36, 'Newsletter Subscribers Add', 'newsletters', 'subscribers', 'admin_add_subscriber', 'subscribers/admin_add_subscriber', 0, 0),
(43, 36, 'Newsletter Subscribers Edit', 'newsletters', 'subscribers', 'admin_edit_subscriber', 'subscribers/admin_edit_subscriber', 1346839269, 1346839269),
(44, 36, 'Newsletter Subscribers Delete', 'newsletters', 'subscribers', 'admin_delete_subscriber', 'subscribers/admin_delete_subscriber', 1345809603, 1345809603),
(45, 36, 'Newsletter Subscribers Update Status', 'newsletters', 'subscribers', 'admin_change_subscriber_status', 'subscribers/admin_change_subscriber_status', 1346839269, 1346839269),
(46, 36, 'Newsletter Subscribers Send Mail', 'newsletters', 'subscribers', 'admin_subscriber_send_mail', 'subscribers/admin_subscriber_send_mail', 1346839269, 1346839269),
(47, 0, 'Help', 'help_categories', '', '', '', 1346839269, 1346839269),
(48, 47, 'Help', 'help_categories', '', '', 'faqs/admin_index', 1345809603, 1345809603),
(49, 48, 'Faq List', 'help_categories', 'faqs', 'admin_index', 'faqs/admin_index', 1346839269, 1346839269),
(50, 48, 'Faq Add', 'help_categories', 'faqs', 'admin_add_category', 'faqs/admin_add_category', 1345809603, 1345809603),
(51, 48, 'Faq Edit', 'help_categories', 'faqs', 'admin_edit_category', 'faqs/admin_edit_category', 1346839269, 1346839269),
(52, 48, 'Faq Delete', 'help_categories', 'faqs', 'admin_delete_catrgory', 'faqs/admin_delete_catrgory', 1345809603, 1345809603),
(53, 48, 'Faq Update Status', 'help_categories', 'faqs', 'admin_category_status', 'faqs/admin_category_status', 1346839269, 1346839269),
(54, 48, 'Faq Post List', 'help_categories', 'faq_posts', 'admin_index', 'faq_posts/admin_index', 1346839269, 1346839269),
(55, 48, 'Faq Post Add', 'help_categories', 'faq_posts', 'admin_add_faq_post', 'faq_posts/admin_add_faq_post', 1345809603, 1345809603),
(56, 48, 'Faq Post Edit', 'help_categories', 'faq_posts', 'admin_edit_faq_post', 'blog_posts/admin_edit_faq_post', 1346839269, 1346839269),
(57, 48, 'Faq Post Delete', 'help_categories', 'faq_posts', 'admin_delete_faq_post', 'faq_posts/admin_delete_faq_post', 1345809603, 1345809603),
(58, 48, 'Faq Post Update Status', 'help_categories', 'faq_posts', 'admin_faq_post_status', 'faq_posts/admin_faq_post_status', 1346839269, 1346839269),
(59, 48, 'School List', 'help_categories', 'schools', 'admin_index', 'schools/admin_index', 1345809603, 1345809603),
(60, 48, 'School Add', 'help_categories', 'schools', 'admin_add_category', 'schools/admin_add_category', 1346839269, 1346839269),
(61, 48, 'School Edit', 'help_categories', 'schools', 'admin_edit_category', 'schools/admin_edit_category', 1345809603, 1345809603),
(62, 48, 'School Delete', 'help_categories', 'schools', 'admin_delete_catrgory', 'schools/admin_delete_catrgory', 1340889444, 1340889444),
(63, 48, 'School Update Status', 'help_categories', 'schools', 'admin_category_status', 'schools/admin_category_status', 1340889444, 1340889444),
(64, 48, 'School Post List', 'help_categories', 'school_posts', 'admin_index', 'school_posts/admin_index', 1340889444, 1340889444),
(65, 48, 'School Post  Add', 'help_categories', 'school_posts', 'admin_add_post', 'school_posts/admin_add_post', 1346839269, 1346839269),
(66, 48, 'School Post Edit', 'help_categories', 'school_posts', 'admin_edit_post', 'school_posts/admin_edit_post', 1345809603, 1345809603),
(67, 48, 'School Post Delete', 'help_categories', 'school_posts', 'admin_delete_post', 'school_posts/admin_delete_post', 1340889444, 1340889444),
(68, 48, 'School Post Update Status', 'help_categories', 'school_posts', 'admin_post_status', 'school_posts/admin_post_status', 1341572702, 2012),
(78, 75, 'Email Log View Email', 'emaillogs', 'emaillogs', 'admin_view_email', 'emaillogs/admin_view_email', 1346839269, 1346839269),
(77, 75, 'Email Log Delete', 'emailogs', 'emaillogs', 'admin_delete_email', 'emaillogs/admin_delete_email', 1345809603, 1345809603),
(76, 75, 'Email Log List', 'emaillogs', 'emaillogs', 'admin_index', 'emaillogs/admin_index', 1346839269, 1346839269),
(74, 0, 'Email Log', 'emaillogs', '', '', '', 1346839269, 1346839269),
(75, 74, 'Email Log', 'emaillogs', '', '', 'emillogs/admin_index', 1341572702, 1346839269),
(79, 0, 'Partner', 'partners', '', '', '', 1346839269, 1346839269),
(80, 79, 'Partner', 'partners', '', '', 'partners/admin_index', 1346839269, 1346839269),
(81, 80, 'Partner List', 'partners', 'partners', 'admin_index', 'partners/admin_index', 1346839269, 1346839269),
(82, 80, 'Partner Add', 'partners', 'partners', 'admin_add_partner', 'partners/admin_add_partner', 1345809603, 1345809603),
(83, 80, 'Partner Edit', 'partners', 'partners', 'admin_edit_partner', 'projects/admin_edit_partner', 1346839269, 1345809603),
(84, 80, 'Partner Delete', 'partners', 'partners', 'admin_delete_partner', 'partners/admin_delete_partner', 1345809603, 1345809603),
(85, 80, 'Partner Update Status ', 'partners', 'partners', 'admin_change_partner_status', 'partners/admin_change_partner_status', 1346839269, 1346839269),
(86, 0, 'Db Backup', 'backups', '', '', '', 1346839269, 1346839269),
(87, 86, 'Db Backup ', 'backups', '', '', 'backups/admin_index', 1346839269, 1346839269),
(88, 87, 'Db Backup List', 'backups', 'backups', 'admin_index', 'backups/admin_index', 1346839269, 1346839269),
(89, 87, 'Db Backup Add', 'backups', 'backups', 'admin_backup', 'backups/admin_backup', 1345809603, 1345809603),
(90, 87, 'Db Backup Delete', 'backups', 'backups', 'admin_delete_backup', 'backups/admin_delete_backup', 1340889444, 1340889444),
(91, 87, 'Db Backup Download', 'backups', 'backups', 'admin_download_backup', 'backups/admin_download_backup', 1340889444, 1340889444),
(92, 0, 'Testimonial', 'testimonials', '', '', '', 1346839269, 1346839269),
(93, 92, 'Testimonial', 'testimonials', '', '', 'testimonials/admin_index', 1346839269, 1345809603),
(94, 93, 'Testimonial List', 'testimonials', 'testimonials', 'admin_index', 'testimonials/admin_index', 1346839269, 1346839269),
(95, 93, 'Testimonial Add', 'testimonials', 'testimonials', 'admin_add_testimonial', 'testimonials/admin_add_testimonial', 1345809603, 1345809603),
(96, 93, 'Testimonial Edit ', 'testimonials', 'testimonials', 'admin_edit_testimonial', 'testimonials/admin_edit_testimonial', 1340889444, 1340889444),
(97, 93, 'Testimonial Delete', 'testimonials', 'testimonials', 'admin_delete_testimonial', 'testimonials/admin_delete_testimonial', 1340889444, 1340889444),
(98, 93, 'Testimonial Update Status', 'testimonials', 'testimonials', 'admin_change_testimonial_status', 'testimonials/admin_change_testimonial_status', 1341572702, 1340889444),
(99, 0, 'Page', 'pages', '', '', '', 1346839269, 1346839269),
(100, 99, 'Page', 'pages', '', '', 'pages/admin_index', 1346839269, 1346839269),
(101, 100, 'Page List', 'pages', 'pages', 'admin_index', 'pages/admin_index', 1346839269, 1346839269),
(102, 100, 'Page Add', 'pages', 'pages', 'admin_add_page', 'pages/admin_add_page', 1345809603, 1345809603),
(103, 100, 'Page Edit ', 'pages', 'pages', 'admin_edit_page', 'pages/admin_edit_page', 1340889444, 1340889444),
(104, 100, 'Page Delete', 'pages', 'pages', 'admin_delete_page', 'pages/admin_delete_page', 1340889444, 1340889444),
(105, 100, 'Page Update Status', 'pages', 'pages', 'admin_change_status', 'pages/admin_change_status', 1340889444, 1340889444),
(106, 0, 'Staticimages	', 'staticimages', '', '', '', 1346839269, 1346839269),
(107, 106, 'Staticimages', 'staticimages', '', '', 'staticimages/admin_index', 1346839269, 1346839269),
(108, 107, 'Staticimage List ', 'staticimages', 'staticimages', 'admin_index', 'staticimages/admin_index', 1346839269, 1346839269),
(109, 107, 'Staticimage Add', 'staticimages', 'staticimages', 'admin_add_image', 'staticimages/admin_add_image', 1345809603, 1345809603),
(113, 0, 'Systemdoc', 'systemdocs', '', '', '', 1346839269, 1346839269),
(111, 107, 'Staticimage Delete', 'staticimages', 'staticimages', 'admin_delete_image', 'staticimages/admin_delete_image', 1340889444, 1340889444),
(112, 107, 'Staticimage Download', 'staticimages', 'staticimages', 'admin_download_image', 'staticimages/admin_download_image', 1340889444, 1340889444),
(114, 113, 'Systemdoc', 'systemdocs', '', '', 'systemdocs/admin_index', 1346839269, 1346839269),
(115, 114, 'Systemdoc List', 'systemdocs', 'systemdocs', 'admin_index', 'systemdocs/admin_index', 1346839269, 1346839269),
(116, 114, 'Systemdoc Add', 'systemdocs', 'systemdocs', 'admin_add_doc', 'systemdocs/admin_add_doc', 1345809603, 1345809603),
(117, 114, 'Systemdoc Delete', 'systemdocs', 'systemdocs', 'admin_delete_doc', 'systemdocs/admin_delete_doc', 1340889444, 1340889444),
(118, 114, 'Systemdoc Download', 'systemdocs', 'systemdocs', 'admin_download_doc', 'systemdocs/admin_download_doc', 1340889444, 1340889444),
(119, 7, 'Category List', 'categories', 'categories', 'admin_index', 'categories/index', 1346839269, 1346839269);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `newsletter_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notification_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject_id` int(11) NOT NULL,
  `friend_id` bigint(20) NOT NULL,
  `subject_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_read` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `title_hy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug_hy` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `description_hy` mediumtext COLLATE utf8_unicode_ci,
  `home_page` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `metakeyword` mediumtext COLLATE utf8_unicode_ci,
  `metakeyword_hy` mediumtext COLLATE utf8_unicode_ci,
  `metadescription` mediumtext COLLATE utf8_unicode_ci,
  `metadescription_hy` mediumtext COLLATE utf8_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `delete` tinyint(1) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=95 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `title_hy`, `slug`, `slug_hy`, `description`, `description_hy`, `home_page`, `position`, `metakeyword`, `metakeyword_hy`, `metadescription`, `metadescription_hy`, `active`, `delete`, `created`, `modified`) VALUES
(81, 'Where projects come from', 'D’où viennent les projets', 'where-projects-come-from', 'where-projects-come-from', '<p>From you! Boostbloom supports of a wide variety of creative activities from book writing, independent films to music development, civic projects, inventions development, scientific research... Truly anything with a clear, definable and finite goal can be a project in Boostbloom terms.<br />\r\nFor example, recording a new short film, creating cool design chairs, are projects. Such projects end when your film is launched, when your chairs are created.<br />\r\nBoostBloom helps make these projects come to a reality thanks to the rewarded efforts of people who believe in them: backers.</p>\r\n', '<p><span id="result_box" lang="fr"><span class="hps">Chaque projet</span> <span class="hps">est</span> <span class="hps">BoostBloom</span> <span class="hps">la cr&eacute;ation ind&eacute;pendante de</span> <span class="hps">quelqu&#39;un comme vous.</span> <span class="hps">Souhaitez-vous monter</span> <span class="hps">un projet</span><span>,</span> <span class="hps">ou tout simplement</span> <span class="hps">curieux de savoir comment</span> <span class="hps">tout cela fonctionne</span><span>?j</span></span></p>\r\n', 0, 1, 'Each and every BoostBloom project is the independent creation of someone like you.. Want to start a project, or just curious about how it all works?', 'Chaque projet est BoostBloom la création indépendante de quelqu''un comme vous. Souhaitez-vous monter un projet, ou tout simplement curieux de savoir comment tout cela fonctionne?', 'Each and every BoostBloom project is the independent creation of someone like you Want to start a project, or just curious about how it all works?', 'Chaque projet est BoostBloom la création indépendante de quelqu''un comme vous. Souhaitez-vous monter un projet, ou tout simplement curieux de savoir comment tout cela fonctionne?', 1, 0, 1351231002, 1363633372),
(21, 'What is BoostBloom', 'Qu''est-ce que BoostBloom', 'what-is-boostbloom', 'what-is-boostbloom', '<h4><strong>BoostBloom </strong>is a web platform aimed at helping some users (&quot;Project Creators&quot;) run campaigns to raise money from other users (&ldquo;Backers&rdquo;).</h4>\r\n\r\n<h4>Backers do not &quot;invest&quot; in Boostbloom projects to make money; they &quot;back&quot; projects in exchange for an exciting reward or one-of-a-kind experience.</h4>\r\n\r\n<h4>&nbsp;</h4>\r\n\r\n<h4>On BoostBloom <strong>Armenia</strong>, project creators are located in Armenia, but backers can be anywhere in the world.</h4>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h4>&nbsp;From movie making to music, book writing to charity, independent films to music, BoostBloom covers a variety of project categories for which&nbsp; creativity is essential.</h4>\r\n\r\n<h4>&nbsp;Begin now, browse projects or start your own project!</h4>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h4>&nbsp;</h4>\r\n\r\n<p>&nbsp;</p>\r\n<div style="margin-left: 5px;" class="fl">\r\n                <a class="button_yellow ie_radius fl" href="/home/start">Start Your Project</a>                <a class="button_blue ie_radius fl ml10" href="/projects/discover">Discover great projects</a>            </div>', 'Ինչ՞ է Բուստբլումը:<br />\r\nԲուստբլումը ֆինանսավորող պլատֆորմ(հարթակ) է ստեղծարարական նախագծերի համար: Ամեն ինչ՝ սկսած ֆիլմերից, խաղերից &uml; երաժշտությունից մինչ&uml; ձ&uml;ավորում/դիզայն &uml; տեխնոլոգիաներ: Բուստբլումը լի է ձգտումներով, նորարարական &uml; եր&uml;ակայական նախագծերով, որոնք կյանքի են կոչվել այլոց անմիջական աջակցությամբ:', 1, 1, 'Maecenas in urna metus. Vestibulum et dui a velit egestas iaculis sit amet tempor felis. Nullam vitae aliquam massa. Duis adipiscing; ante vitae bibendum sodales, ipsum ipsum ultricies nulla, sed venenatis sem tortor vel sapien? Pellentesque ultricies, diam sit amet aliquam molestie, dui ante facilisis justo, eu varius eros arcu eget ipsum. Donec congue enim eu sapien elementum at imperdiet nisi suscipit. Nunc nibh est, pulvinar sollicitudin pellentesque vel, dictum id diam. In eget elit enim.\r\n\r\nVestibulum facilisis tellus eu nibh sollicitudin ultrices. Fusce commodo consectetur lectus, non lacinia quam luctus id. Mauris tincidunt metus non augue posuere sed posuere ligula iaculis. Donec fringilla eros sed nisl vehicula ultricies? Integer quis augue metus. Etiam vehicula imperdiet facilisis! Donec in orci eu turpis scelerisque convallis ut a tellus. Integer vulputate pulvinar turpis, vitae tincidunt sem rutrum vel. Cras sollicitudin mattis iaculis. Morbi congue, libero eu venenatis lacinia, tellus risus laoreet felis, a bibendum nunc quam quis nulla! Etiam eu risus ante.\r\n\r\nPellentesque lobortis volutpat lorem quis dignissim. Integer quis sem non augue fringilla scelerisque id ut enim. Quisque in lacus enim, sit amet porttitor nibh! Maecenas quam velit, congue dictum dapibus in, tincidunt in metus. Nunc augue ligula, imperdiet sit amet viverra id, bibendum mattis arcu. Cras vitae est lectus! Nullam imperdiet laoreet pretium. Suspendisse a diam nec mi pellentesque adipiscing. In a tellus est. Donec sagittis mi vel felis luctus gravida. Suspendisse quis malesuada mauris. Etiam ultricies, sem id fringilla scelerisque; metus lorem malesuada mi, id ultricies massa nisi in elit. Suspendisse potenti. Duis sollicitudin pretium orci, quis blandit dui volutpat accumsan. Nullam arcu purus, varius quis elementum ut, suscipit non nulla. Cras sit amet orci nec risus euismod elementum ac et quam.\r\n', 'Qu''est-ce que BoostBloom', 'Maecenas in urna metus. Vestibulum et dui a velit egestas iaculis sit amet tempor felis. Nullam vitae aliquam massa. Duis adipiscing; ante vitae bibendum sodales, ipsum ipsum ultricies nulla, sed venenatis sem tortor vel sapien? Pellentesque ultricies, diam sit amet aliquam molestie, dui ante facilisis justo, eu varius eros arcu eget ipsum. Donec congue enim eu sapien elementum at imperdiet nisi suscipit. Nunc nibh est, pulvinar sollicitudin pellentesque vel, dictum id diam. In eget elit enim.\r\n\r\nVestibulum facilisis tellus eu nibh sollicitudin ultrices. Fusce commodo consectetur lectus, non lacinia quam luctus id. Mauris tincidunt metus non augue posuere sed posuere ligula iaculis. Donec fringilla eros sed nisl vehicula ultricies? Integer quis augue metus. Etiam vehicula imperdiet facilisis! Donec in orci eu turpis scelerisque convallis ut a tellus. Integer vulputate pulvinar turpis, vitae tincidunt sem rutrum vel. Cras sollicitudin mattis iaculis. Morbi congue, libero eu venenatis lacinia, tellus risus laoreet felis, a bibendum nunc quam quis nulla! Etiam eu risus ante.\r\n\r\nPellentesque lobortis volutpat lorem quis dignissim. Integer quis sem non augue fringilla scelerisque id ut enim. Quisque in lacus enim, sit amet porttitor nibh! Maecenas quam velit, congue dictum dapibus in, tincidunt in metus. Nunc augue ligula, imperdiet sit amet viverra id, bibendum mattis arcu. Cras vitae est lectus! Nullam imperdiet laoreet pretium. Suspendisse a diam nec mi pellentesque adipiscing. In a tellus est. Donec sagittis mi vel felis luctus gravida. Suspendisse quis malesuada mauris. Etiam ultricies, sem id fringilla scelerisque; metus lorem malesuada mi, id ultricies massa nisi in elit. Suspendisse potenti. Duis sollicitudin pretium orci, quis blandit dui volutpat accumsan. Nullam arcu purus, varius quis elementum ut, suscipit non nulla. Cras sit amet orci nec risus euismod elementum ac et quam.\r\n', 'Qu''est-ce que BoostBloom', 1, 0, 1342172716, 1385306868),
(89, 'Review After Successful Submission', 'Examen Après soumission réussie', 'review-after-successful-submission', 'review-after-successful-submission', '<p>\r\n	We&rsquo;re going to make a quick review of your project. Don&rsquo;t worry It should not take long</p>\r\n<p>\r\n	and we&rsquo;ll send you an email to let you know!</p>\r\n<p>\r\n	Please note that you cannot edit your project before Boostbloom approves it for launch.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	After launch you&rsquo;ll be able to edit the following content:</p>\r\n<p>\r\n	&mdash; Project description<br />\r\n	&mdash; Video and image<br />\r\n	&mdash; Rewards (add new ones or edit those not yet backed)<br />\r\n	&mdash; Your profile<br />\r\n	&mdash; Project FAQs</p>\r\n<p>\r\n	The only things that cannot be edited after launch are:</p>\r\n<p>\r\n	&mdash; The funding goal<br />\r\n	&mdash; The project deadline<br />\r\n	&mdash; Your Boostbloom name<br />\r\n	&mdash; Rewards that have already been selected by a backer</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	<strong>Your Responsibility : If your project is successfully funded, you are required to fullfil all rewards or refund any backer whose reward you do not or cannot fullfil. A failure to do so could result in damage to your reputation or even legal action on behalf of your backers. For more accountability, see the FAQ.</strong></p>\r\n', '<p>\r\n	<span id="result_box" lang="fr"><span class="hps">Nous allons</span> <span class="hps">proc&eacute;der &agrave; un examen</span> <span class="hps">rapide de votre</span> <span class="hps">projet.</span> <span class="hps">Ne vous inqui&eacute;tez pas</span> <span class="hps">il</span> <span class="hps">ne devrait pas tarder</span><br />\r\n	<br />\r\n	<span class="hps">et</span> <span class="hps">nous vous enverrons</span> <span class="hps">un email</span> <span class="hps">pour vous laisser savoir</span><span>!</span><br />\r\n	<br />\r\n	<span class="hps">S&#39;il vous pla&icirc;t</span> <span class="hps">noter que vous</span> <span class="hps">ne pouvez pas &eacute;diter</span> <span class="hps">votre projet avant</span> <span class="hps">Boostbloom</span> <span class="hps">l&#39;approuve</span> <span class="hps">pour le lancement.</span><br />\r\n	<br />\r\n	<span class="hps">Apr&egrave;s le lancement</span><span>, vous serez</span> <span class="hps">en mesure de modifier</span> <span class="hps">le contenu suivant:</span><br />\r\n	<br />\r\n	<span class="hps">Description du projet -</span><br />\r\n	<span class="hps">- Vid&eacute;o et</span> <span class="hps">images</span><br />\r\n	<span class="hps">-</span> <span class="hps atn">R&eacute;compenses (</span><span>en ajouter de nouveaux</span> <span class="hps">ou modifier</span> <span class="hps">ceux qui n&#39;ont pas</span> <span class="hps">encore sauvegard&eacute;</span><span>)</span><br />\r\n	<span class="hps">-</span> <span class="hps">Votre profil</span><br />\r\n	<span class="hps">- Projet de</span> <span class="hps">FAQ</span><br />\r\n	<br />\r\n	<span class="hps">Les seules choses</span> <span class="hps">qui ne peuvent pas</span> <span class="hps">&ecirc;tre modifi&eacute;es</span> <span class="hps">apr&egrave;s le lancement</span> <span class="hps">sont les suivantes:</span><br />\r\n	<br />\r\n	<span class="hps">-</span> <span class="hps atn">L&#39;</span><span>objectif de financement</span><br />\r\n	<span class="hps">-</span> <span class="hps">L&#39;&eacute;ch&eacute;ance du projet</span><br />\r\n	<span class="hps">-</span> <span class="hps">Votre nom</span> <span class="hps">Boostbloom</span><br />\r\n	<span class="hps">-</span> <span class="hps">R&eacute;compenses qui ont</span> <span class="hps">d&eacute;j&agrave; &eacute;t&eacute;</span> <span class="hps">s&eacute;lectionn&eacute;s par</span> <span class="hps">un bailleur de fonds</span><br />\r\n	<br />\r\n	<strong><span class="hps">Votre</span> <span class="hps">responsabilit&eacute;:</span> <span class="hps">Si votre projet est</span> <span class="hps">financ&eacute; avec succ&egrave;s</span><span>,</span> <span class="hps">vous devez</span> <span class="hps">fullfil</span> <span class="hps">toutes les r&eacute;compenses</span> <span class="hps">ou rembourser tout</span> <span class="hps">bailleur de fonds</span> <span class="hps">dont la r&eacute;compense</span> <span class="hps">vous n&#39;avez pas ou</span> <span class="hps">ne peut pas</span> <span class="hps">fullfil</span><span>.</span> <span class="hps">A</span> <span class="hps">d&eacute;faut de le faire</span> <span class="hps">peut causer des dommages</span> <span class="hps">&agrave; votre r&eacute;putation</span> <span class="hps">ou m&ecirc;me</span> <span class="hps">une action en justice</span> <span class="hps">au nom de vos</span> <span class="hps">bailleurs de fonds.</span> <span class="hps atn">Pour plus d&#39;</span><span>obligation de rendre compte</span><span>, consultez la FAQ</span><span>.</span></strong></span></p>\r\n', 0, 1, 'Review After Successful Submission', 'Examen Après soumission réussie', 'Review After Successful Submission', 'Examen Après soumission réussie', 1, 0, 1355462237, 1361857009),
(13, 'Privacy policy', 'Respect de la vie privée', 'privacy-policy', 'privacy-policy', '<p>The Site is operated by Boostbloom, Inc. (&quot;Boostbloom&quot; or the &quot;Company&quot;). This page describes the Privacy Policy (the &quot;Policy&quot;) for the website at www.boostbloom.com, all other sites owned and operated by Boostbloom that redirect to www.boostbloom.com, and all subdomains (collectively, the &ldquo;Site&rdquo;), and the service owned and operated by the Company (together with the Site, the &ldquo;Service&rdquo;)</p>\r\n\r\n<p>Your personal information is very serious to us and is only used for providing and improving the Service. Your privacy is our priority.</p>\r\n\r\n<p>By using the Service, you give your consent to the collection and use of information in accordance with this Policy.</p>\r\n\r\n<p>Boostbloom reserves the right to unilaterally and without notice modify or replace this Policy by posting the new terms on the Site. Users are solely responsible to check changes in the Policy and using the Service after the posting of any updates constitutes acceptance of those changes.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Collection of Information</strong></h3>\r\n\r\n<p>We may collect and process:</p>\r\n\r\n<ul>\r\n	<li>information (such as your name, email and postal address, telephone number, sex, and country of residence), including if you register, subscribe to our newsletter, submit any material through the Site;</li>\r\n	<li>your log-in and password details in connection with the account sign-in process;</li>\r\n	<li>the details of any requests or transactions you made through the Service;</li>\r\n	<li>communications you send to us, for example to report a problem or to submit queries, concerns, or comments regarding the Service or its content;</li>\r\n	<li>information that you post to the Site in the form of comments or contributions to discussions;</li>\r\n	<li>your IP address</li>\r\n</ul>\r\n\r\n<h3><strong>Uses of Your Personal Information</strong></h3>\r\n\r\n<p>We will use the personal information you provide to:</p>\r\n\r\n<ul>\r\n	<li>identify you when you sign-in to your account;</li>\r\n	<li>enable us to provide you with the Services;</li>\r\n	<li>send you information you requested or we think are relevant;</li>\r\n	<li>manage your account with us;</li>\r\n	<li>enable us to reply to your queries;</li>\r\n	<li>analyze your use of the Service to improve our content or for purposes we may disclose to you when we request your information.</li>\r\n</ul>\r\n\r\n<p>Project Creators never receive backers&#39; credit card information. They receive the email addresses of their backers if the project is successfully funded.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Email</strong></h3>\r\n\r\n<p>In the notification section of your account you can choose when you want to receive emails from us. You can opt-in, opt-out, it&rsquo;s up to you. We will also email you relating to your personal transactions or on a particular occasion. As a general rule In we try to keep the number of emails we send you as low as possible.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Third-Party Services</strong></h3>\r\n\r\n<div>We never post anything to your accounts with Twitter, Facebook, or any other third-party sites without your express permission. Except for the purposes of providing the Services, we will not give your name or personal information to third parties.</div>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Technology</strong></h3>\r\n\r\n<p>Boostbloom uses cookies to help recognize you as a repeat visitor, to make our quality of Service better. Some of the cookies we use are served by us, others by third parties who are delivering services on our behalf. Most modern web browsers automatically accept cookies but, if you decide to block, limit or delete cookies used on our Service, you may not be able to take full advantage of our Service.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Voluntary Disclosure</strong></h3>\r\n\r\n<p>The personal information or content that you disclose in public areas of the Site becomes publicly available and may be collected and used by other users. Please show caution.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Other Disclosure</strong></h3>\r\n\r\n<p>When requested by law, or when we believe that disclosure is necessary to protect our rights, or in the good-faith belief that it is necessary to comply with the law, Boostbloom reserves the right to disclose your personal information. &nbsp;</p>\r\n\r\n<p>To make a modification or delete the personal information you have provided to us, please log in to your account and update your profile.</p>\r\n\r\n<p>If you request it we will provide you with a copy of all the personal information about you that we hold. This information is subject to a fee that will not exceed the prescribed fee permitted by law.</p>\r\n\r\n<p>People aged under 18 (or the legal age in your jurisdiction) are not permitted to use Boostbloom on their own, and so this Policy makes no provision for their use of the site.</p>\r\n\r\n<p>Any information you submit through the Service may be transferred to any countries we use to provide the Service to you. As of March 2013, our servers are in Germany. If we transfer your information, we will do make sure that your privacy continues to be protected.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Questions</strong></h3>\r\n\r\n<p>If you have questions or suggestions, please <a href="mailto:info@boostbloom.com">contact us</a>.</p>\r\n\r\n<p>Updated: March 2013</p>\r\n', '<p>fdsfdsf</p>\r\n', 1, 1, 'Maecenas id lectus orci? Donec iaculis, turpis vel viverra lobortis, lectus diam viverra ipsum, eget fermentum sem nulla eget purus! Aenean iaculis volutpat urna ut vehicula. Vestibulum scelerisque velit nec dolor elementum sit amet pulvinar tellus lacinia. Praesent in lacus malesuada elit ullamcorper convallis. Aliquam mattis metus ac risus vestibulum vel convallis velit vulputate. Morbi dui lorem, dapibus at sodales vel, pharetra nec nunc. Morbi non nisl felis. Sed nec vehicula elit. Praesent dapibus porta elit, at ultricies massa venenatis non. Integer sit amet mi eros; non tincidunt felis. Vivamus pharetra purus metus. Proin viverra urna vel nulla rutrum iaculis. Sed nec enim metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n\r\nVivamus lobortis nibh ac est aliquet malesuada sed sed justo? Nulla elit ante, faucibus sit amet porttitor quis, laoreet a tellus? Integer tristique ultricies massa; ut tincidunt diam interdum id. Integer vulputate; elit ut dignissim convallis, massa turpis ullamcorper lorem, vel semper arcu neque id neque. Nunc id porta turpis. Pellentesque eu ligula ut magna volutpat ultrices non et lacus. Nulla et congue nunc? Ut suscipit, ipsum condimentum sagittis malesuada, metus quam posuere libero, vitae luctus ante arcu ut purus. Cras vulputate rutrum mi. Donec enim lacus, sollicitudin vel varius eget, iaculis eu felis. Ut laoreet mattis turpis pellentesque aliquet. Morbi eu gravida eros. Nam ut metus id eros scelerisque tincidunt? Aenean ut velit est, sed malesuada nibh.\r\n\r\nNullam felis nulla, sollicitudin a sodales ac, condimentum sit amet mi. Vestibulum posuere, elit ac pharetra rhoncus, elit velit egestas metus, vel dictum mi mauris quis enim! Cras euismod iaculis dui sed vestibulum? Suspendisse quis elit velit. Proin quam turpis, tempus et varius non, pretium at ante. Nullam dolor libero, tempor vitae laoreet eget, condimentum eu sem. Nullam ultricies tortor quis quam viverra eget tempus erat laoreet? Nunc imperdiet, velit vel mollis vulputate, urna sapien interdum justo, a tristique urna ipsum sed mauris. Maecenas sit amet risus sit amet enim varius viverra. Fusce nec neque dolor. Maecenas id mi nibh, eu bibendum tellus! In nulla sapien, sollicitudin sit amet aliquam eget, porttitor malesuada justo. Integer placerat imperdiet est.\r\n', 'Plus d''informations ce lit? Jusqu''à jeudi, de base ou de retour ici, c''est beaucoup plus, il ya plus de nécessité d''une vidéo! En savoir plus sur nous en tant que véhicules. Entrée de la criminalité, ni ne veut réduire la douleur de l''élément de la terre, la frange pas publiée. Les lacs de la construction de l''école secondaire. Beaucoup de peur et de rire ou d''une véranda commencera ici. Lor produit, mais des membres ou des protéines, ou un carquois maintenant. Les nouveaux joueurs ne sont pas chanceux. Nor Shipping. Plus page du portail de protéines, mais voici tout simplement pas de masse. C''est mon travail, il ne s''arrête pas là. Question pure crainte. Le trafic urbain plus ou plus de nouvelles. Mais pas de panique. Cette page est obligatoire pour déposer un commentaire.\r\n\r\nNous savons qu''il ya de plus en plus efficaces, mais les justes? Pas de pompage avant, des mâchoires est une mesure du possible, administrer un régime? Toute la masse du système de stockage, tel que requis de temps à autre que diam. Ce document, comme une page de WordPress, masse informations sur le format de base, ou ne le faites pas, ni jamais avant. Maintenant que la base. Donnez de l''impact à un bon travail ici, et le lac n''est pas de basket-ball. De plus en plus maintenant? Cela prend très heureux de conseiller les visiteurs, la peur mis en liberté, avant de la proue à la vie pure de deuil. Lire la suite ici. Pour que le lac, ou sur les différents besoins, prenez votre chat. Dans le but d''administrer et laid battre une des émissions globales. Produit concepteurs bravo travail. De peur que c''est plus de travail? Tous droits, c''est qu''il veut, mais plus NIBH.\r\n\r\nAucun chat ne, la préoccupation des membres, et que, assaisonnement, mon pas publiée. Lisez, pompage et augmentation de l''immigration, il faudra aller plus peur, ou pour qui me dit drôle! Demain grab, mais les conditions d''admission? Laisser un commentaire s''il vous plaît. Urbain et malhonnête, le temps, et non pas différents, mais devant le prix. Il n''ya pas de douleur, longue durée de vie de la pompe, doit assaisonnement Vraiment. S''il vous plaît sélectionner plusieurs besoins est le temps de pomper? Produit, de la communication en ligne ou douce, parfois il suffit d''ajouter la banane, à partir de pages, mais drôle. Lire la suite Commentaires La Communauté Pour variait pas publié viverra. Accueil ni. Bienvenue sur mon site, voici la boisson! En aucun homme, sage préoccupation que certains pas publié des besoins jusqu''à la plus juste. S''il vous plaît sélectionner un produit.', 'Maecenas id lectus orci? Donec iaculis, turpis vel viverra lobortis, lectus diam viverra ipsum, eget fermentum sem nulla eget purus! Aenean iaculis volutpat urna ut vehicula. Vestibulum scelerisque velit nec dolor elementum sit amet pulvinar tellus lacinia. Praesent in lacus malesuada elit ullamcorper convallis. Aliquam mattis metus ac risus vestibulum vel convallis velit vulputate. Morbi dui lorem, dapibus at sodales vel, pharetra nec nunc. Morbi non nisl felis. Sed nec vehicula elit. Praesent dapibus porta elit, at ultricies massa venenatis non. Integer sit amet mi eros; non tincidunt felis. Vivamus pharetra purus metus. Proin viverra urna vel nulla rutrum iaculis. Sed nec enim metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.\r\n\r\nVivamus lobortis nibh ac est aliquet malesuada sed sed justo? Nulla elit ante, faucibus sit amet porttitor quis, laoreet a tellus? Integer tristique ultricies massa; ut tincidunt diam interdum id. Integer vulputate; elit ut dignissim convallis, massa turpis ullamcorper lorem, vel semper arcu neque id neque. Nunc id porta turpis. Pellentesque eu ligula ut magna volutpat ultrices non et lacus. Nulla et congue nunc? Ut suscipit, ipsum condimentum sagittis malesuada, metus quam posuere libero, vitae luctus ante arcu ut purus. Cras vulputate rutrum mi. Donec enim lacus, sollicitudin vel varius eget, iaculis eu felis. Ut laoreet mattis turpis pellentesque aliquet. Morbi eu gravida eros. Nam ut metus id eros scelerisque tincidunt? Aenean ut velit est, sed malesuada nibh.\r\n\r\nNullam felis nulla, sollicitudin a sodales ac, condimentum sit amet mi. Vestibulum posuere, elit ac pharetra rhoncus, elit velit egestas metus, vel dictum mi mauris quis enim! Cras euismod iaculis dui sed vestibulum? Suspendisse quis elit velit. Proin quam turpis, tempus et varius non, pretium at ante. Nullam dolor libero, tempor vitae laoreet eget, condimentum eu sem. Nullam ultricies tortor quis quam viverra eget tempus erat laoreet? Nunc imperdiet, velit vel mollis vulputate, urna sapien interdum justo, a tristique urna ipsum sed mauris. Maecenas sit amet risus sit amet enim varius viverra. Fusce nec neque dolor. Maecenas id mi nibh, eu bibendum tellus! In nulla sapien, sollicitudin sit amet aliquam eget, porttitor malesuada justo. Integer placerat imperdiet est.\r\n', 'Plus d''informations ce lit? Jusqu''à jeudi, de base ou de retour ici, c''est beaucoup plus, il ya plus de nécessité d''une vidéo! En savoir plus sur nous en tant que véhicules. Entrée de la criminalité, ni ne veut réduire la douleur de l''élément de la terre, la frange pas publiée. Les lacs de la construction de l''école secondaire. Beaucoup de peur et de rire ou d''une véranda commencera ici. Lor produit, mais des membres ou des protéines, ou un carquois maintenant. Les nouveaux joueurs ne sont pas chanceux. Nor Shipping. Plus page du portail de protéines, mais voici tout simplement pas de masse. C''est mon travail, il ne s''arrête pas là. Question pure crainte. Le trafic urbain plus ou plus de nouvelles. Mais pas de panique. Cette page est obligatoire pour déposer un commentaire.\r\n\r\nNous savons qu''il ya de plus en plus efficaces, mais les justes? Pas de pompage avant, des mâchoires est une mesure du possible, administrer un régime? Toute la masse du système de stockage, tel que requis de temps à autre que diam. Ce document, comme une page de WordPress, masse informations sur le format de base, ou ne le faites pas, ni jamais avant. Maintenant que la base. Donnez de l''impact à un bon travail ici, et le lac n''est pas de basket-ball. De plus en plus maintenant? Cela prend très heureux de conseiller les visiteurs, la peur mis en liberté, avant de la proue à la vie pure de deuil. Lire la suite ici. Pour que le lac, ou sur les différents besoins, prenez votre chat. Dans le but d''administrer et laid battre une des émissions globales. Produit concepteurs bravo travail. De peur que c''est plus de travail? Tous droits, c''est qu''il veut, mais plus NIBH.\r\n\r\nAucun chat ne, la préoccupation des membres, et que, assaisonnement, mon pas publiée. Lisez, pompage et augmentation de l''immigration, il faudra aller plus peur, ou pour qui me dit drôle! Demain grab, mais les conditions d''admission? Laisser un commentaire s''il vous plaît. Urbain et malhonnête, le temps, et non pas différents, mais devant le prix. Il n''ya pas de douleur, longue durée de vie de la pompe, doit assaisonnement Vraiment. S''il vous plaît sélectionner plusieurs besoins est le temps de pomper? Produit, de la communication en ligne ou douce, parfois il suffit d''ajouter la banane, à partir de pages, mais drôle. Lire la suite Commentaires La Communauté Pour variait pas publié viverra. Accueil ni. Bienvenue sur mon site, voici la boisson! En aucun homme, sage préoccupation que certains pas publié des besoins jusqu''à la plus juste. S''il vous plaît sélectionner un produit.', 1, 0, 1342011222, 1363027290);
INSERT INTO `pages` (`id`, `title`, `title_hy`, `slug`, `slug_hy`, `description`, `description_hy`, `home_page`, `position`, `metakeyword`, `metakeyword_hy`, `metadescription`, `metadescription_hy`, `active`, `delete`, `created`, `modified`) VALUES
(15, 'Terms of use ', ' Charte d’utilisation', 'terms-of-use', 'terms-of-use', '<p>Please take some time to read our <strong>Terms of Use</strong> (the &quot;Agreement&quot; or &quot;Terms of Use&quot;) before using the services offered by Boostbloom ( &ldquo;Boostbloom&rdquo; or the &ldquo;Company&rdquo;). This Agreement sets forth the legally binding terms and conditions for your use of the website at www.Boostbloom.com, all other sites owned and operated by Boostbloom that redirect to www.Boostbloom.com, and all subdomains (collectively, the &ldquo;Site&rdquo;), and the service owned and operated by the Company (together with the Site, the &ldquo;Service&rdquo;). By using the Service in any manner, including, but not limited to, visiting or browsing the Site or contributing content, information, or other materials or services to the Site, you agree to be bound by this Agreement.</p>\r\n\r\n<h3>&nbsp;</h3>\r\n\r\n<h3><strong>Summary of Service</strong></h3>\r\n\r\n<div><strong>BoostBloom </strong>is a web platform aimed at helping some users (&quot;Project Creators&quot;) run campaigns to raise money from other users (&ldquo;Backers&rdquo;). In exchange for their funding, backers receive rewards offered by creators.</div>\r\n\r\n<div>Through the Site, various content is made accessible including videos, photographs, images, artwork, graphics, audio clips, comments, data, text, software, scripts, projects, other material and information, and associated trademarks and copyrightable works (collectively, &ldquo;Content&rdquo;).</div>\r\n\r\n<p>Any user of BoostBloom (collectively, &ldquo;Users&rdquo;) may have the ability to contribute, add, create, upload, submit, distribute, facilitate the distribution of, collect, post, or otherwise make accessible (&quot;Submit&quot;) Content. &ldquo;User Submissions&rdquo; means any Content Submitted by Users.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Acceptance of Terms</strong></h3>\r\n\r\n<p>The terms and conditions contained in these Terms of Use, including the Privacy Policy available at <a href="http://www.boostbloom.com/display/privacy-policy">http://www.Boostbloom.com/privacy</a> and any other operating rules or procedures and processes, apply to all Users of the Service.</p>\r\n\r\n<p>Boostbloom reserves the right to unilaterally and without notice modify or replace these Terms of Use by posting the new terms on the Site. Users are solely responsible to check changes in the Terms of Use and using the Service after posting of any updates constitutes acceptance of those changes.</p>\r\n\r\n<p>The Company may limit some features and services or restrict access to the Service or part of it to any Users. Boostbloom also reserves the right to unilaterally and without notice modify, suspend, or discontinue the Service in its entirety or even partially.</p>\r\n\r\n<p>The Service is available to individuals who are 18 years old and older and of legal age in your jurisdiction. You represent and warrant that if you are an individual, you are at least 18 years old and of legal age in your jurisdiction to form a binding contract, and that all registration information you submit is accurate and truthful. The Company may suspend your account until satisfactory proof of age is provided.</p>\r\n\r\n<p>Boostbloom can unilaterally refuse to offer the Service to any person or entity and change its eligibility criteria without notice. This provision is void where prohibited by law and the right to access the Service is revoked in those jurisdictions.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Rules and Conduct</strong></h3>\r\n\r\n<p>You shall use the Service only for your own personal, non-commercial purpose (except as allowed by the terms set forth in the section of these Terms of Use titled, &quot;Projects: Fundraising and Commerce&quot;).</p>\r\n\r\n<p>You are fully and solely responsible for your activity in connection with the Service.</p>\r\n\r\n<p>As a condition of use you promise not to use the Service for any purpose that is prohibited by the Terms of Use or law.</p>\r\n\r\n<p>You shall not, and you shall not allow or facilitate any third party using your account to take any action, or Submit Content, that:</p>\r\n\r\n<ul>\r\n	<li>infringes any patent, trademark, trade secret, copyright, right of publicity, or other right of any other person or entity, or violates any law or contract;</li>\r\n	<li>you know is false, misleading, or even inaccurate;</li>\r\n	<li>is unlawful, threatening, abusive, harassing, defamatory, libelous, deceptive, fraudulent, tortious, obscene, offensive, profane, or invasive of another&#39;s privacy;</li>\r\n	<li>constitutes unsolicited or unauthorized advertising or promotional material or any junk mail, spam, or chain letters;</li>\r\n	<li>contains software viruses or any other computer codes, files, or programs or applications designed or intended to interfere with the function of any software, hardware, or telecommunications equipment or to damage or obtain unauthorized access to any system, data, password, or other information of the Company or any third party;</li>\r\n	<li>is made in breach of any legal duty owed to a third party, such as a contractual duty or a duty of confidence; or</li>\r\n	<li>impersonates any person or entity, including any employee or representative of the Company.</li>\r\n</ul>\r\n\r\n<p>Additionally, you shall not: (i) take any action that imposes or may impose (as determined by the Company in its sole discretion) an unreasonable or disproportionately large load on the Company&rsquo;s or its third-party providers&rsquo; infrastructure; (ii) interfere or attempt to interfere with the proper working of the Service or any activities conducted on the Service; (iii) bypass or try to bypass any measures the Company may take to prevent or restrict access to the Service (or other accounts, computer systems, or networks connected to the Service); (iv) run Maillist, Listserv, or any form of auto-responder or &quot;spam&quot; on the Service; or (v) use manual or automated software, devices, or other processes to &quot;crawl&quot; or &quot;spider&quot; any page of the Site.</p>\r\n\r\n<p>You shall not directly or indirectly: (i) decipher, decompile, disassemble, reverse engineer, or otherwise attempt to derive any source code or underlying ideas or algorithms of any part of the Service, except to the extent applicable laws specifically prohibit such restriction; (ii) modify, translate, or otherwise create derivative works of any part of the Service; or (iii) copy, rent, lease, distribute, or otherwise transfer any of the rights that you receive hereunder. You shall abide by all applicable local, state, national, and international laws and regulations.</p>\r\n\r\n<p>Project Creators shall not use or share personal information for any purpose other than those explicitly specified in their Projects, or is not related to fulfilling delivery of a product or service explicitly specified in their Projects.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Registration</strong></h3>\r\n\r\n<p>When required to register, you shall provide accurate, complete, and updated registration information. Failure to do so shall constitute a breach of the Terms of Use, which may result in immediate termination of your account without prior notice.</p>\r\n\r\n<p>When choosing a User ID, domain name, or project name you shall not use any name or term that (i) is the name of another person, with the intent to impersonate that person; (ii) is subject to any rights of another person, without appropriate authorization; or (iii) is offensive, vulgar, or obscene.</p>\r\n\r\n<p>In its sole discretion, the Company reserves the right to deny registration of or cancel a User ID, domain name, and project name.</p>\r\n\r\n<p>You are solely responsible for activity that occurs on your account and shall be responsible for maintaining the confidentiality of your password for the Site. You shall never use another User account without the other User&rsquo;s express permission.</p>\r\n\r\n<p>Any unauthorized use of your account or suspected or known account-related security breach must be notified to the Service using the Contact us form down the Homepage.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Projects: Fundraising and Commerce</strong></h3>\r\n\r\n<p>BoostBloom is a service where some users (&quot;Project Creators&quot;) run campaigns to raise money from other users (&ldquo;Backers&rdquo;) in exchange for rewards. By doing so, you as the Project Creator are offering the public the opportunity to enter into a contract with you. On the other side by backing a a Project on Boostbloom, you as the Backer accept that offer and the contract between Backer and Project Creator is formed and binding.</p>\r\n\r\n<p>Boostbloom is not a party to that agreement between the Backer and Project Creator. All dealings are solely between Users.</p>\r\n\r\n<p>By backing a project or creating a project on Boostbloom, you agree to be bound by this entire Agreement, including the following terms:</p>\r\n\r\n<ul>\r\n	<li>Backers agree to provide their payment information at the time they pledge to a project. The payment will be collected at or after the campaign deadline and only if the amount of money pledged as of the deadline is at least equal to the fundraising goal. The amount Backers pledge is the amount they will be charged.</li>\r\n	<li>Backers consent to Boostbloom and its payments partners authorizing or reserving a charge on their payment card or other payment method for any amount up to the full pledge at any time between the pledge and collection of the funds.</li>\r\n	<li>Backers agree to have sufficient funds or credit available at the campaign deadline to ensure that the pledge will be collectible.</li>\r\n	<li>Backers may increase, decrease, or cancel their pledge at any time during the fundraising campaign, except that they may not cancel or reduce their pledge if the campaign is in its final 24 hours and the cancellation or reduction would drop the campaign below its goal.</li>\r\n	<li>The Estimated Delivery Date listed on each reward is not a commitment to fulfill by that date, but is merely an estimate of when the Project Creator hopes to fulfill by.</li>\r\n	<li>Project Creators agree to do their maximum to fulfill each reward by its Estimated Delivery Date.</li>\r\n	<li>For all campaigns, Boostbloom provides the Project Creator with each Backer&rsquo;s User ID and pledge amount. For successful campaigns, Boostbloom additionally gives to the Project Creator each Backer&rsquo;s name and email.</li>\r\n	<li>For some rewards, the Project Creator needs further information from Backers, such as a mailing address or t-shirt size, to enable the Project Creator to deliver the rewards. The Project Creator shall request the information directly from Backers at some point after the fundraising campaign is successful. To receive the reward, Backers agree to provide the requested information to the Project Creator within a reasonable amount of time.</li>\r\n	<li>Boostbloom does not offer refunds. A Project Creator is not required to grant a Backer&rsquo;s request for a refund unless the Project Creator is unable or unwilling to fulfill the reward.</li>\r\n	<li>Project Creators are required to fulfill all rewards of their successful fundraising campaigns or refund any Backer whose reward they do not or cannot fulfill.</li>\r\n	<li>Project Creators may exceptionally cancel their project after launch. If they do so, Project creators are not required to fulfill the rewards. Any pledges made by Backers will be cancelled and reimbursed to backers at no cost.</li>\r\n	<li>Because of occasional failures of payments from Backers, Boostbloom cannot guarantee the receipt by Project Creators of the amount pledged minus fees.</li>\r\n	<li>Boostbloom and its payments partners will remove their fees before transmitting proceeds of a campaign. Fees may vary depending on region and other factors.</li>\r\n	<li>In its sole discretion Boostbloom may reject, cancel, interrupt, remove, or suspend a campaign. Boostbloom is not liable for any damages as a result of any of those actions. Boostbloom&rsquo;s policy is not to comment on the reasons for any of those actions.</li>\r\n	<li>Project Creators should make sure they have the ability to withdraw and spend the money before taking any action in reliance on having their project posted on the Site or before having any of the money pledged. There may be a delay between the end of a successful fundraising campaign and access to the funds.</li>\r\n</ul>\r\n\r\n<p>Boostbloom is not responsible for any damages or loss incurred related to rewards or any other use of the Service. Boostbloom declines any obligation to become involved in the settlement of disputes between Users, or between Users and any third party arising in connection with the use of the Service. This includes, but is not limited to, delivery of goods and services, and any other terms, conditions, warranties, or representations associated with campaigns on the Site. Boostbloom does not oversee the performance or punctuality of projects. The Company does not endorse any User Submissions. You release Boostbloom, its officers, employees, agents, and successors in rights from claims, damages, and demands of every kind, known or unknown, suspected or unsuspected, disclosed or undisclosed, arising out of or in any way related to such disputes and the Service.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Fees and Payments</strong></h3>\r\n\r\n<p>Joining Boostbloom is free. However, we do charge fees for certain services. When you use a service that has a fee you have an opportunity to review and accept the fees that you will be charged. Changes to fees are effective after we provide you with notice by posting the changes on the Site. You are responsible for paying all fees and taxes associated with your use of the Service.</p>\r\n\r\n<p>Funds pledged by Backers are collected by Paypal. Boostbloom is not responsible for the performance of Paypal.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Third-Party Sites</strong></h3>\r\n\r\n<p>Using the Service, you may link to other websites or resources on the internet, and other websites or resources may contain links to the Site. When you access third-party websites, you do so at your own risk and you acknowledge that the Company is not liable for any aspect or for any damage related to the use of those other websites or resources. The inclusion on another website of any link to the Site does not imply endorsement by or affiliation with the Company.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Content and License</strong></h3>\r\n\r\n<p>You agree that the Service contains Content provided by the Company and its partners and Users and that the Content may be protected by copyrights, trademarks, service marks, patents, trade secrets, or other rights and laws. You shall abide by and maintain all copyright and other legal notices, information, and restrictions contained in any Content accessed through the Service.</p>\r\n\r\n<p>The Company grants to each User of the Service a worldwide, non-exclusive, non-sublicensable and non-transferable license to use and reproduce the Content, solely for personal, non-commercial use. Use, reproduction, modification, distribution, or storage of any Content for other than personal, non-commercial use is prohibited without prior written permission from the Company, or from the copyright holder. You shall not sell, license, rent, or otherwise use or exploit any Content for commercial use or in any way that violates any third-party right.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Intellectual Property</strong></h3>\r\n\r\n<p>By Submitting User Submissions on the Site or otherwise through the Service, you agree to the following terms:</p>\r\n\r\n<ul>\r\n	<li>The Company will not have any ownership rights over your User Submissions. However, the Company needs the following license to perform and market the Service on your behalf and on behalf of its other Users and itself. You grant to the Company the worldwide, non-exclusive, perpetual, irrevocable, royalty-free, sublicensable, transferable right to (and to allow others acting on its behalf to) (i) use, edit, modify, prepare derivative works of, reproduce, host, display, stream, transmit, playback, transcode, copy, feature, market, sell, distribute, and otherwise fully exploit your User Submissions and your trademarks, service marks, slogans, logos, and similar proprietary rights (collectively, the &quot;Trademarks&quot;) in connection with (a) the Service, (b) the Company&rsquo;s (and its successors&#39; and assigns&rsquo;) businesses, (c) promoting, marketing, and redistributing part or all of the Site (and derivative works thereof) or the Service in any media formats and through any media channels (including, without limitation, third-party websites); (ii) take whatever other action is required to perform and market the Service; (iii) allow its Users to stream, transmit, playback, download, display, feature, distribute, collect, and otherwise use the User Submissions and Trademarks in connection with the Service; and (iv) use and publish, and permit others to use and publish, the User Submissions, Trademarks, names, likenesses, and personal and biographical materials of you and the members of your group, in connection with the provision or marketing of the Service. The foregoing license grant to the Company does not affect your other ownership or license rights in your User Submissions, including the right to grant additional licenses to your User Submissions.</li>\r\n	<li>You are publishing your User Submission, and you may be identified publicly by your name or User ID in association with your User Submission.</li>\r\n	<li>You grant to each User a non-exclusive license to access your User Submissions through the Service, and to use, edit, modify, reproduce, distribute, prepare derivative works of, display and perform such User Submissions solely for personal, non-commercial use.</li>\r\n	<li>You further agree that your User Submissions will not contain third-party copyrighted material, or material that is subject to other third-party proprietary rights, unless you have permission from the rightful owner of the material or you are otherwise legally entitled to post the material and to grant Boostbloom all of the license rights granted herein.</li>\r\n	<li>You will pay all royalties and other amounts owed to any person or entity based on your Submitting User Submissions to the Service or the Company&rsquo;s publishing or hosting of the User Submissions as contemplated by these Terms of Use.</li>\r\n	<li>The use or other exploitation of User Submissions by the Company and Users as contemplated by this Agreement will not infringe or violate the rights of any third party, including without limitation any privacy rights, publicity rights, copyrights, contract rights, or any other intellectual property or proprietary rights.</li>\r\n	<li>The Company shall have the right to delete, edit, modify, reformat, excerpt, or translate any of your User Submissions.</li>\r\n	<li>All information publicly posted or privately transmitted through the Site is the sole responsibility of the person from which that content originated.</li>\r\n	<li>The Company will not be liable for any errors or omissions in any Content.</li>\r\n	<li>The Company cannot guarantee the identity of any other Users with whom you may interact while using the Service.</li>\r\n	<li>All Content you access through the Service is at your own risk and you will be solely responsible for any resulting damage or loss to any party.</li>\r\n</ul>\r\n\r\n<p>In accordance with the Digital Millennium Copyright Act, Boostbloom has adopted a policy of, in appropriate circumstances, terminating User accounts that are repeat infringers of the intellectual property rights of others. Boostbloom also may terminate User accounts even based on a single infringement.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Copyright Notifications</strong></h3>\r\n\r\n<p>Boostbloom will remove infringing materials in accordance with the DMCA if properly notified that Content infringes copyright. If you believe that your work has been copied in a way that constitutes copyright infringement, please notify Boostbloom at this email: <a href="mailto:copyright@Boostbloom.com">copyright@Boostbloom.com</a>. Boostbloom will reply to your request at the soonest. Please make sure you include in your communications:</p>\r\n\r\n<ul>\r\n	<li>an electronic or physical signature of the person authorized to act on behalf of the owner of the copyright interest;</li>\r\n	<li>a description of the copyrighted work that you claim has been infringed;</li>\r\n	<li>a description of where the material that you claim is infringing is located on the Site, sufficient for Boostbloom to locate the material;</li>\r\n	<li>your address, telephone number, and email address;</li>\r\n	<li>a statement by you that you have a good faith belief that the disputed use is not authorized by the copyright owner, its agent, or the law; and</li>\r\n	<li>a statement by you that the information in your notice is accurate and, under penalty of perjury, that you are the copyright owner or authorized to act on the copyright owner&#39;s behalf.</li>\r\n</ul>\r\n\r\n<p>If you believe that your work has been removed or disabled by mistake or misidentification, please notify Boostbloom please notify Boostbloom at this email: copyright@boostbloom.com. Boostbloom will reply to your request at the soonest. Please make sure you include in your communications a physical or electronic signature of the user of the Services;</p>\r\n\r\n<ul>\r\n	<li>identification of the material that has been removed or to which access has been disabled and the location at which the material appeared before it was removed or access to it was disabled;</li>\r\n	<li>a statement made under penalty of perjury that the subscriber has a good faith belief that the material was removed or disabled as a result of mistake or misidentification of the material; and</li>\r\n	<li>the subscriber&#39;s name, address, telephone number, and a statement that the subscriber consents to the jurisdiction of any judicial district in which the service provider may be found, and that the user will accept service of process from the person who provided notification under subscriber (c)(1)(C) or an agent of such person.</li>\r\n</ul>\r\n\r\n<p>Under the Copyright Act, any person who knowingly materially misrepresents that material is infringing or was removed or disabled by mistake or misidentification may be subject to liability.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Termination</strong></h3>\r\n\r\n<p>The Company may terminate your access to the Service, without cause or notice, which may result in the forfeiture and destruction of all information associated with your account. If you wish to terminate your account, you may do so by following the instructions on the Site. Any fees paid to the Company are non-refundable. All provisions of the Terms of Use that by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Warranty Disclaimer</strong></h3>\r\n\r\n<p>The Company has no special relationship with or fiduciary duty to you. You acknowledge that the Company has no duty to take any action regarding any of the following: which Users gain access to the Site; what Content Users access through the Site; what effects the Content may have on Users; how Users may interpret or use the Content; or what actions Users may take as a result of having been exposed to the Content. The Company cannot guarantee the authenticity of any data or information that Users provide about themselves or their campaigns and projects. You release the Company from all liability for your having acquired or not acquired Content through the Site. The Site may contain, or direct you to websites containing, information that some people may find offensive or inappropriate. The Company makes no representations concerning any Content on the Site, and the Company is not liable for the accuracy, copyright compliance, legality, or decency of material contained on the Service.</p>\r\n\r\n<p>The Company does not guarantee that any Content will be made available through the Service. The Company has no obligation to monitor the Service or Content. The Company reserves the right to, at any time, for any reason, and without notice: (i) cancel, reject, interrupt, remove, or suspend a campaign or project; (ii) remove, edit, or modify any Content, including, but not limited to, any User Submission; and (iii) remove or block any User or User Submission. Boostbloom reserves the right not to comment on the reasons for any of these actions.</p>\r\n\r\n<p>The Service is provided &ldquo;as is&rdquo; and &ldquo;as available&rdquo; and is without warranty of any kind, express or implied, including, but not limited to, the implied warranties of title, non-infringement, merchantability, and fitness for a particular purpose, and any warranties implied by any course of performance or usage of trade, all of which are expressly disclaimed. The Company, and its directors, employees, agents, suppliers, partners, and content providers do not warrant that: (a) the Service will be secure or available at any particular time or location; (b) any defects or errors will be corrected; (c) any content or software available at or through the Service is free of viruses or other harmful components; or (d) the results of using the Service will meet your requirements. Your use of the Service is solely at your own risk. Some states or countries do not allow limitations on how long an implied warranty lasts, so the above limitations may not apply to you.</p>\r\n\r\n<p>The Company makes no guaranty of confidentiality or privacy of any communication or information transmitted on the Site or any website linked to the Site. The Company will not be liable for the privacy of email addresses, registration and identification information, disk space, communications, confidential or trade-secret information, or any other Content stored on the Company&rsquo;s equipment, transmitted over networks accessed by the Site, or otherwise connected with your use of the Service.</p>\r\n\r\n<p>Electronic Communications Privacy Act Notice (18 USC &sect;2701-2711): THE COMPANY MAKES NO GUARANTY OF CONFIDENTIALITY OR PRIVACY OF ANY COMMUNICATION OR INFORMATION TRANSMITTED ON THE SITE OR ANY WEBSITE LINKED TO THE SITE. The Company will not be liable for the privacy of email addresses, registration and identification information, disk space, communications, confidential or trade-secret information, or any other Content stored on the Company&rsquo;s equipment, transmitted over networks accessed by the Site, or otherwise connected with your use of the Service.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Indemnification</strong></h3>\r\n\r\n<p>You shall defend, indemnify, and hold harmless the Company, its affiliates, and each of its and its affiliates&rsquo; employees, contractors, directors, suppliers, and representatives from all liabilities, claims, and expenses, including reasonable attorneys&#39; fees and other legal costs, that arise from or relate to your use or misuse of, or access to, the Service and Content, or otherwise from your User Submissions, violation of the Terms of Use, or infringement by you, or any third party using your account, of any intellectual property or other right of any person or entity. The Company reserves the right to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, in which event you will assist and cooperate with the Company in asserting any available defenses.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Limitation of Liability</strong></h3>\r\n\r\n<p>In no event shall the Company, nor its directors, employees, agents, partners, suppliers, or content providers, be liable under contract, tort, strict liability, negligence, or any other legal or equitable theory with respect to the service (i) for any lost profits, data loss, cost of procurement of substitute goods or services, or special, indirect, incidental, punitive, or consequential damages of any kind whatsoever, substitute goods or services (however arising), (ii) for any bugs, viruses, trojan horses, or the like (regardless of the source of origination), or (iii) for any direct or indirect damages</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>International</strong></h3>\r\n\r\n<p>Accessing the Service is prohibited from territories where the Content is illegal. If you access the Service from other locations, you do so at your own initiative and are responsible for compliance with local laws.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Electronic Delivery, Notice Policy, and Your Consent</strong></h3>\r\n\r\n<p>By using the Services, you consent to receive from Boostbloom all communications including notices, agreements, legally required disclosures, or other information in connection with the Services (collectively, &quot;Contract Notices&quot;) electronically. Boostbloom may provide the electronic Contract Notices by posting them on the Site. If you desire to withdraw your consent to receive Contract Notices electronically, you must discontinue your use of the Services.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Governing Law</strong></h3>\r\n\r\n<p>These Terms of Service (and any further rules, policies, or guidelines incorporated by reference) shall be governed by and construed in accordance with the laws of Armenia, without giving effect to any principles of conflicts of law, and without application of the Uniform Computer Information Transaction Act or the United Nations Convention of Controls for International Sale of Goods. You agree that the Company and its Services are deemed a passive website that does not give rise to personal jurisdiction over Boostbloom or its parents, subsidiaries, affiliates, successors, assigns, employees, agents, directors, officers or shareholders, either specific or general, in any jurisdiction other than Armenia. You agree that any action at law or in equity arising out of or relating to these terms, or your use or non-use of the Services, shall be filed only in the state or federal courts located in Armenia and you hereby consent and submit to the personal jurisdiction of such courts for the purposes of litigating any such action. You hereby irrevocably waive any right you may have to trial by jury in any dispute, action, or proceeding.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Integration and Severability</strong></h3>\r\n\r\n<p>These Terms of Use and other referenced material are the entire agreement between you and the Company with respect to the Service, and supersede all prior or contemporaneous communications and proposals (whether oral, written or electronic) between you and the Company with respect to the Service and govern the future relationship. If any provision of the Terms of Use is found to be unenforceable or invalid, that provision will be limited or eliminated to the minimum extent necessary so that the Terms of Use will otherwise remain in full force and effect and enforceable. The failure of either party to exercise in any respect any right provided for herein shall not be deemed a waiver of any further rights hereunder.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Miscellaneous</strong></h3>\r\n\r\n<p>The Company shall not be liable for any failure to perform its obligations hereunder where the failure results from any cause beyond the Company&rsquo;s reasonable control, including, without limitation, mechanical, electronic, or communications failure or degradation. The Terms of Use are personal to you, and are not assignable, transferable, or sublicensable by you except with the Company&#39;s prior written consent. The Company may assign, transfer, or delegate any of its rights and obligations hereunder without consent. No agency, partnership, joint venture, or employment relationship is created as a result of the Terms of Use and neither party has any authority of any kind to bind the other in any respect. In any action or proceeding to enforce rights under the Terms of Use, the prevailing party will be entitled to recover costs and attorneys&#39; fees. All notices under the Terms of Use will be in writing and will be deemed to have been duly given when received, if personally delivered or sent by certified or registered mail, return receipt requested; when receipt is electronically confirmed, if transmitted by facsimile or e-mail; or the day after it is sent, if sent for next day delivery by recognized overnight delivery service.</p>\r\n\r\n<p><strong>Updated: March 2013</strong></p>\r\n', '<p>hojujoujjj</p>\r\n', 1, 1, 'Boostbloom, crowdfunding crowdsourcing, Armenia, Creativity country development, backers, privacy policy', 'http://www.boostbloom.com/display/privacy-policy', 'Boostbloom, crowdfunding crowdsourcing, Armenia, Creativity country development, backers, privacy policy', 'http://www.boostbloom.com/display/privacy-policy', 1, 0, 1342011574, 1385738391),
(18, 'Guidelines', 'Recommendations', 'guidelines', 'guidelines', '<p><strong>Project Guidelines</strong></p>\r\n\r\n<p>Boostbloom is a funding platform for projects where creativity is a must. For us the only requirement is that you invent or create a new thing, a product, a solution, an artwork, just about anything both original and worthwhile. So what is the criteria? Two tiny things: originality and value.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li><strong>What is a project?</strong></li>\r\n</ol>\r\n\r\n<p>Your project is an idea with a clear goal, like writing a book, creating a work of art, assembling a new 4x4 wheelchair or building a soccer field for kids. Only YOU know. So if you have a goal that adds value to the community in any way, this is the place to be. But remember, your project needs a clear objective. Starting a business may be your project but it is not a Boostbloom&rsquo;s project.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li value="2"><strong>Projects must fit Boostbloom&rsquo;s categories</strong></li>\r\n</ol>\r\n\r\n<p>We tried to cover all the fields where creativity plays a role. Your project can be in the worlds of Art, Dance, Fashion, Film, Food, Games, Music, Photography, Publishing, Technology, and Theater. Even Charity, because there are always new, cool and creative ways to help others.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li value="3"><strong>Prohibited uses</strong></li>\r\n</ol>\r\n\r\n<p>This no Santa website. A project will not be accepted if your idea is to raise money for your vacation or to buy a new camera. But if you can do cool things with your camera and need money to create your artwork, we&rsquo;ll be happy to help you with your project.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li value="4"><strong>Quality rewards make the difference</strong></li>\r\n</ol>\r\n\r\n<p>You can create a project for charity, but this not a charity website.</p>\r\n\r\n<p>People who support your project need something in return. Your backers can choose not to receive a reward. But usually the better the reward the more backers you will get, hence the more likely your project will reach its goal. So carefully choose what reward you will give, put yourself in a backer&rsquo;s shoes and ask yourself: what would backers like to receive in exchange for their support?</p>\r\n', '<p>Projet de lignes directrices<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing &eacute;lite. Vestibulum &agrave; tellus eu volutpat lacinia trop pellentesque &agrave; METU. Morbi tincidunt egestas leo, vestibule vulputate urne scelerisque eu. Ut temporo malesuada d&eacute;teste porttitor non. Mauris venenatis, nunc non euismod fermentum, l&#39;&eacute;lite est eleifend lacus, ca volutpat d&eacute;teste leo vel sapien. Proin ac purus auctor Orna posuere NISI. Duis nulla tristique pretium, non posuere pulvinar eget Conf&eacute;rence.<br />\r\nSuspendisse ante eget mauris, nca faucibus moi? Fusce quis douleur iaculis juste volutpat adipiscing nulla sit amet faucibus. Lacus nulla dans rhoncus Velit adipiscing volutpat.<br />\r\nLe financement des projets seulement.<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing &eacute;lite. Vestibulum &agrave; tellus eu volutpat lacinia trop pellentesque &agrave; METU. Morbi tincidunt egestas leo, vestibule vulputate urne scelerisque eu. Ut temporo malesuada d&eacute;teste porttitor non. Mauris venenatis, nunc non euismod fermentum, l&#39;&eacute;lite est eleifend lacus, ca volutpat d&eacute;teste leo vel sapien.<br />\r\nLes projets doivent s&#39;inscrire cat&eacute;gories de BoostBloom.<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing &eacute;lite. Vestibulum &agrave; tellus eu volutpat lacinia trop pellentesque &agrave; METU. Morbi tincidunt egestas leo, vestibule vulputate urne scelerisque eu. Ut temporo malesuada d&eacute;teste porttitor non. Mauris venenatis, nunc non euismod fermentum, l&#39;&eacute;lite est eleifend lacus, ca volutpat d&eacute;teste leo ipsum dolor sit amet sapien.Lorem voile, consectetur adipiscing &eacute;lite. Vestibulum &agrave; tellus eu volutpat lacinia trop pellentesque &agrave; METU. Morbi tincidunt egestas leo, vestibule vulputate urne scelerisque eu. Ut temporo malesuada d&eacute;teste porttitor non. Mauris venenatis, nunc non euismod fermentum, l&#39;&eacute;lite est eleifend lacus, ca volutpat d&eacute;teste leo vel sapien. &lt;a href=&quot;#&quot;&gt; Voir class=&quot;slidedownarrow&quot; conception et les exigences de la technologie<br />\r\nUtilisations interdites:<br />\r\n&lt;p&gt;<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing &eacute;lite. Vestibulum &agrave; tellus eu volutpat lacinia trop pellentesque &agrave; METU. Morbi tincidunt egestas leo, vestibule vulputate urne scelerisque eu. Ut temporo malesuada d&eacute;teste porttitor non.<br />\r\nMauris venenatis, nunc non euismod fermentum, l&#39;&eacute;lite est eleifend lacus, ca volutpat d&eacute;teste leo vel sapien.</p>\r\n', 1, 1, 'guidelines', 'directives', 'guidelines', 'directives', 1, 0, 1342012064, 1385566316),
(26, 'Review', 'Review', 'review', 'review', '<h1>\r\n	Before you submit</h1>\r\n<p>\r\n	Please check that you have:</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		Clearly explained what you&#39;re raising funds to do</li>\r\n	<li>\r\n		Added a video! It&#39;s the best way to connect with your backers</li>\r\n	<li>\r\n		Carefully chosen rewards for your backers: that means well-priced and fun rewards. Not only just thank-yous!</li>\r\n	<li>\r\n		Previewed your project</li>\r\n	<li>\r\n		Shared it with a friend and received feedback</li>\r\n	<li>\r\n		Checked out other projects and backed one to get the backer&#39;s experience</li>\r\n</ul>\r\n<h1>\r\n	After you submit</h1>\r\n<p>\r\n	When all the above is done, you can submit your project for review to Boostbloom:</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		We will make sure your project meets Boostbloom Guidelines</li>\r\n	<li>\r\n		Very quickly (no more than a few days), we&#39;ll send you a message about your project&rsquo;s status</li>\r\n	<li>\r\n		If approved, project will be active to collect funds from the backers</li>\r\n</ul>\r\n', '<h1>\r\n	Before you submit</h1>\r\n<p>\r\n	Make sure you have:</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		Clearly explained what you&#39;re raising funds to do.</li>\r\n	<li>\r\n		Added a video! It&#39;s the best way to connect with your backers.</li>\r\n	<li>\r\n		Created a series of well-priced, fun rewards. Not just thank-yous!</li>\r\n	<li>\r\n		Previewed your project and gotten feedback from a friend.</li>\r\n	<li>\r\n		Checked out other projects on Boostbloom and backed one to get a feel for the experience.</li>\r\n</ul>\r\n<h1>\r\n	After you submit</h1>\r\n<p>\r\n	Once you&#39;ve done everything listed above and submitted your project for review:</p>\r\n<p>\r\n	&nbsp;</p>\r\n<ul>\r\n	<li>\r\n		Your project will be reviewed to ensure it meets the Project Guidelines.</li>\r\n	<li>\r\n		Within a few days, we&#39;ll send you a message about the status of your project.</li>\r\n	<li>\r\n		If approved, project will be active to collect funds from the backers.</li>\r\n</ul>\r\n', 0, 1, 'review', 'Suspendisse sit amet sapien erat, sit amet commodo leo. Donec dignissim, libero quis egestas ultricies, libero odio dignissim erat; vel suscipit quam mauris quis est. Nam vehicula est at massa pretium molestie. Nullam neque lacus, dapibus at ullamcorper ac, elementum et risus. Praesent pulvinar, nisi ut molestie auctor, quam mi eleifend ipsum, sed porta mauris velit vitae mi. Morbi sed facilisis neque. Cras convallis laoreet felis id venenatis. Morbi metus elit, accumsan ut vestibulum ultricies, placerat non quam. Suspendisse potenti. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam ante mauris, mollis eget lacinia ac, mattis sed eros. Aenean semper commodo mauris, vel hendrerit purus pretium at. Cras at justo odio. Aenean vitae semper urna.\r\n\r\nNulla et diam sed erat fermentum interdum. Duis vestibulum lectus accumsan nisl rutrum porttitor. Quisque tempor felis et quam tempor euismod. Morbi volutpat, ante vitae mollis tristique, ante felis tincidunt mi; ac dapibus augue odio sed nisl. Duis bibendum, sapien in consequat venenatis, sem lectus porta leo; eget scelerisque eros purus vitae mauris. Aliquam a leo nulla. In at pellentesque enim.\r\n\r\nVestibulum convallis nunc sit amet dolor euismod vel viverra purus porttitor. Nunc condimentum luctus sapien, at congue mi rutrum ac. Fusce est nunc, ultrices vel sagittis et, volutpat ac odio. Nulla vitae mi sed mi pellentesque viverra. Morbi at ipsum eros. Nulla non venenatis enim. Curabitur cursus, dui eget pretium luctus, est enim tincidunt magna, a iaculis massa quam tempus massa. Maecenas lacinia, nibh nec auctor euismod, lorem ligula tristique erat, sed posuere felis magna eu lacus. Sed vel leo sed tellus condimentum blandit. Donec convallis lorem ac erat fermentum a tristique sapien viverra? Phasellus facilisis tellus vel risus posuere id feugiat enim lacinia! Nulla pellentesque arcu eget felis bibendum vulputate? Donec dignissim, metus et consectetur auctor, turpis tortor pretium nisl, in lobortis lectus risus quis dui! Donec eu turpis nisl? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\n', 'review', 'Suspendisse sit amet sapien erat, sit amet commodo leo. Donec dignissim, libero quis egestas ultricies, libero odio dignissim erat; vel suscipit quam mauris quis est. Nam vehicula est at massa pretium molestie. Nullam neque lacus, dapibus at ullamcorper ac, elementum et risus. Praesent pulvinar, nisi ut molestie auctor, quam mi eleifend ipsum, sed porta mauris velit vitae mi. Morbi sed facilisis neque. Cras convallis laoreet felis id venenatis. Morbi metus elit, accumsan ut vestibulum ultricies, placerat non quam. Suspendisse potenti. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam ante mauris, mollis eget lacinia ac, mattis sed eros. Aenean semper commodo mauris, vel hendrerit purus pretium at. Cras at justo odio. Aenean vitae semper urna.\r\n\r\nNulla et diam sed erat fermentum interdum. Duis vestibulum lectus accumsan nisl rutrum porttitor. Quisque tempor felis et quam tempor euismod. Morbi volutpat, ante vitae mollis tristique, ante felis tincidunt mi; ac dapibus augue odio sed nisl. Duis bibendum, sapien in consequat venenatis, sem lectus porta leo; eget scelerisque eros purus vitae mauris. Aliquam a leo nulla. In at pellentesque enim.\r\n\r\nVestibulum convallis nunc sit amet dolor euismod vel viverra purus porttitor. Nunc condimentum luctus sapien, at congue mi rutrum ac. Fusce est nunc, ultrices vel sagittis et, volutpat ac odio. Nulla vitae mi sed mi pellentesque viverra. Morbi at ipsum eros. Nulla non venenatis enim. Curabitur cursus, dui eget pretium luctus, est enim tincidunt magna, a iaculis massa quam tempus massa. Maecenas lacinia, nibh nec auctor euismod, lorem ligula tristique erat, sed posuere felis magna eu lacus. Sed vel leo sed tellus condimentum blandit. Donec convallis lorem ac erat fermentum a tristique sapien viverra? Phasellus facilisis tellus vel risus posuere id feugiat enim lacinia! Nulla pellentesque arcu eget felis bibendum vulputate? Donec dignissim, metus et consectetur auctor, turpis tortor pretium nisl, in lobortis lectus risus quis dui! Donec eu turpis nisl? Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\r\n', 1, 0, 1344250480, 1355862436);
INSERT INTO `pages` (`id`, `title`, `title_hy`, `slug`, `slug_hy`, `description`, `description_hy`, `home_page`, `position`, `metakeyword`, `metakeyword_hy`, `metadescription`, `metadescription_hy`, `active`, `delete`, `created`, `modified`) VALUES
(23, 'Meet Our Team', 'Rencontrez-nous', 'meet-our-team', 'meet-our-team', '<p><img alt="" contenteditable="false" src="http://www.boostbloom.com/img/uploads/ck_pic/image/1_2.jpg" style="float: left; width: 150px; height: 209px;" />&nbsp;</p>\r\n<span style="font-size: 13px;">&nbsp;&nbsp;<strong>Vahe&nbsp;Fermandjian</strong></span>\r\n\r\n<div><br />\r\n<span style="font-size: 13px;">&nbsp;</span><span style="font-size: 13px;"> </span><span lang="EN-US">Vahe was born to an Armenian family in France where he grew up and studied Law and Finance at IEP Paris.<br />\r\n&nbsp; He has worked in several countries and has therefore built contacts and friendships all around the world. He is intellectually restless and his<br />\r\n&nbsp; passion for IT together with&nbsp; his Armenian heritage led him to launch Boostbloom in 2013.</span></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong><span style="font-size: 13px;">&nbsp; </span><span lang="EN-US">&ldquo;Throughout History, Armenians have proved to be a creative people. Boostbloom is simply the propeller that promotes<br />\r\n&nbsp; great ideas and turns&nbsp; them into tangible realities&quot;.</span></strong></div>\r\n\r\n<p><br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<img alt="" contenteditable="false" src="http://www.boostbloom.com/img/uploads/ck_pic/image/Foto_Cena_Greis3_1.jpg" style="width: 150px; height: 225px; float: left;" />&nbsp;<br />\r\n&nbsp;<strong>&nbsp;&nbsp;</strong><span style="font-size: 13px;"><strong>Aida Irastorza</strong></span><br />\r\n&nbsp;</p>\r\n\r\n<div><span style="font-size: 13px;">&nbsp; </span>Aida was born in Spain and has studied both in Switzerland and in Spain.<br />\r\n&nbsp; Thanks to her studies, she has had the opportunity to travel a lot and&nbsp; therefore live in cultural melting pots.&nbsp; She decided to tag along for the<br />\r\n&nbsp; ride when she was first introduced to Boostbloom at its very early&nbsp;&nbsp; stages. She officially joined Boostbloom in 2013.<span style="font-size: 13px;">.</span></div>\r\n\r\n<div><span style="font-size: 13px;">&nbsp;&nbsp;<br />\r\n<strong>&nbsp;&quot;Boostbloom is here to help Armenian projects come to life. Boostbloom is a gateway to worldwide supporters who believe&nbsp;creativity<br />\r\n&nbsp; should not be limited&nbsp; by a country&#39;s borders&quot;.</strong></span></div>\r\n', '<p><img alt="" contenteditable="false" src="http://www.boostbloom.com/img/uploads/ck_pic/image/1_2.jpg" style="float: left; width: 150px; height: 209px;" />&nbsp;</p>\r\n<span style="font-size: 13px;">&nbsp;&nbsp;<strong>Vahe&nbsp;Fermandjian</strong></span>\r\n\r\n<div><br />\r\n<span style="font-size: 13px;">&nbsp;</span><span style="font-size: 13px;"> </span><span lang="EN-US">Vahe was born to an Armenian family in France where he grew up and studied Law and Finance at IEP Paris.<br />\r\n&nbsp; He has worked in several countries and has therefore built contacts and friendships all around the world. He is intellectually restless and his<br />\r\n&nbsp; passion for IT together with&nbsp; his Armenian heritage led him to launch Boostbloom in 2013.</span></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong><span style="font-size: 13px;">&nbsp; </span><span lang="EN-US">&ldquo;Throughout History, Armenians have proved to be a creative people. Boostbloom is simply the propeller that promotes<br />\r\n&nbsp; great ideas and turns&nbsp; them into tangible realities&quot;.</span></strong></div>\r\n\r\n<p><br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<img alt="" contenteditable="false" src="http://www.boostbloom.com/img/uploads/ck_pic/image/Foto_Cena_Greis3_1.jpg" style="width: 150px; height: 225px; float: left;" />&nbsp;<br />\r\n&nbsp;<strong>&nbsp;&nbsp;</strong><span style="font-size: 13px;"><strong>Aida Irastorza</strong></span><br />\r\n&nbsp;</p>\r\n\r\n<div><span style="font-size: 13px;">&nbsp; </span>Aida was born in Spain and has studied both in Switzerland and in Spain.<br />\r\n&nbsp; Thanks to her studies, she has had the opportunity to travel a lot and&nbsp; therefore live in cultural melting pots.&nbsp; She decided to tag along for the<br />\r\n&nbsp; ride when she was first introduced to Boostbloom at its very early&nbsp;&nbsp; stages. She officially joined Boostbloom in 2013.<span style="font-size: 13px;">.</span></div>\r\n\r\n<div><span style="font-size: 13px;">&nbsp;&nbsp;<br />\r\n<strong>&nbsp;&quot;Boostbloom is here to help Armenian projects come to life. Boostbloom is a gateway to worldwide supporters who believe&nbsp;creativity<br />\r\n&nbsp; should not be limited&nbsp; by a country&#39;s borders&quot;.</strong></span></div>\r\n', 1, 1, 'Vahe Fermandjian, Aida Irastorza, marketing, finance, business development ', 'Vahe Fermandjian, Aida Irastorza, marketing, finance, business development', 'Vahe Fermandjian, Aida Irastorza, marketing, finance, business development ', 'Vahe Fermandjian, Aida Irastorza, marketing, finance, business development', 1, 0, 1342421559, 1385811533),
(24, 'Work With US', 'Travaillez avec nous', 'work-with-us-1', 'work-with-us-1', '<p>Are you Armenian and motivated? Then we&nbsp;we want to hear from you!<br />\r\nUse the contact form down the page and email us, we are interested in a variety of profiles, from marketing to IT. Don&#39;t be shy and we promise we will get back to you at the earliest.</p>\r\n', '<p><span style="font-size: 13px;">Are you Armenian and motivated? Then we&nbsp;we want to hear from you!</span><br style="font-size: 13px;" />\r\n<span style="font-size: 13px;">Use the contact form down the page and email us, we are interested in a variety of profiles, from marketing to IT. Don&#39;t be shy and we promise we will get back to you at the earliest.</span></p>\r\n', 1, 1, 'positions, IT, crowdfunding, crowdsourcing, Armenia, IT, coders, coding, marketing', 'positions, IT, crowdfunding, crowdsourcing, Armenia, IT, coders, coding, marketing', 'positions, IT, crowdfunding, crowdsourcing, Armenia, IT, coders, coding, marketing', 'positions, IT, crowdfunding, crowdsourcing, Armenia, IT, coders, coding, marketing', 1, 0, 1342421604, 1385739080),
(74, 'how to  make an awesome project', 'Comment créer votre projet super Boost Bloom', 'how-to-make-an-awesome-project', 'how-to-make-an-awesome-project', '<strong>Don&rsquo;t hurry but don&rsquo;t try to make it perfect.</strong>\r\n<p>Talking about your idea to friends is a good way to make sure you&rsquo;re ready. Are you comfortable with answering their questions? If not, it may be too soon to ask backers for their money. Spend some time fine tuning your project. A couple of days of reflection can make a huge difference, but when you&rsquo;re ready don&rsquo;t hesitate!</p>\r\n<br />\r\n<strong>Choosing a title for your project</strong>\r\n\r\n<p>Once again put yourself in a backer&rsquo;s shoes and make your BoostBloom project title specific, easy to remember and simple. As a rule of thumb, do not use generic words like &quot;help,&quot; &quot;support,&quot; &quot;fund.&quot; &ldquo;assist&rdquo;, in your project title.<br />\r\nYou are not here to ask someone for a favor. You are offering them a unique experience they&rsquo;ll love.<br />\r\nIf you re raising fund for an album, a book&hellip;, make sure you include your album or book title in your Boostbloom&rsquo;s project title.&nbsp; For example, if your band is called &ldquo;Slow Rush&rdquo; and the album you want to record is titled &ldquo;Leafless&rdquo;, your BoostBloom project title could be something like &ldquo;Slow Rush record their first LP, Leafless&rdquo;. This project title is more catchy than &ldquo;make my album &ldquo;or &ldquo;write my book &ldquo; and makes your project easily findable by backers.</p>\r\n<br />\r\n<strong>Choosing an image for your project</strong>\r\n\r\n<p>Your project image is what will show on BoostBloom and on the rest of the web. Like before, choose a picture that&rsquo;s specific to your project, descriptive and that looks pretty!</p>\r\n<br />\r\n<strong>Writing your short description</strong>\r\n\r\n<p>This short text shows in your project&rsquo;s widget. The goal here is to quickly tell your audience what your project is about. Like in your video, stay focused and make sure your text clearly describes in a few words what your project hopes to accomplish.<br />\r\nSome would call that an elevator pitch but it would be fat too long. We&rsquo;d call this a hand shaking pitch: what would you say to describe your project to someone you are shaking hand with? How would you do it?</p>\r\n<br />\r\n<strong>Writing your bio</strong>\r\n\r\n<p>This is your opportunity to gain trust from backers. Tell them who you are, why you chose this project, share with them links to your prior works. In short share, communicate, and be transparent. Trust us, backers will appreciate.</p>\r\n<br />\r\n<strong>Make a Video</strong><br />\r\n<span style="line-height: 1.6em;">​Don&#39;t forget this step!</span>\r\n\r\n<p>Upload your video on Youtube or Vimeo, share the link when you create your project and you&#39;re done! Just make your video interesting and we guarantee you&#39;ll attract backers !&nbsp;<br />\r\n<br />\r\nFor all our tips on how to make a great project, visit our <strong><a href="http://www.boostbloom.com/help/bestpractices–home">Best Practices</a></strong> area.&nbsp;<br />\r\n&nbsp;</p>\r\n', '<p>&nbsp;</p>\r\n\r\n<div>Nullam accumsan Elit non diam sodales fermentum! Sed dignissim nisl ut lorem iaculis pharetra. Dolor sed porta un felis facilisis vel maxime quam venenatis! Habitant morbi Pellentesque tristique senectus et netus et malesuada fames ac egestas turpis. Mauris rutrum NIBH eu odio Elementum vitae eleifend leo cursus. Mauris ac nisl eget nunc egestas posuere. Cras &agrave; arcu quis justo dignissim tempus dolor ac condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae molestie lectus. Cras &agrave; felis sed ante tincidunt consequat Identifiant Identifiant sem? Aliquam lorem nisl, Convallis non sempre a, Convallis malesuada dui. Sed neque ornare nec magna posuere ornare. Donec risus felis; scelerisque eget luctus moins, euismod dans leo. Nullam feugiat suscipit turpis et auctor. Cras fringilla fringilla tellus eu cursus.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Classe aptent taciti sociosqu ad litora torquent par conubia nostra, par inceptos himenaeos. Nulla facilisi. Entier rutrum mattis neque; non feugiat odio dapibus nca. Donec ut dui et arcu posuere euismod. Nullam vitae enim vel quam scelerisque egestas un lacus vel. Praesent Identifiant Identifiant felis massa ornare Elementum lorem porttitor non! Quisque ornare sodales lorem Aliquam porttitor. En accumsan congue km accumsan eget? Donec eleifend, turpis un consectetur fermentum, nisi felis viverra neque, un volutpat km neque nec nisi. Aliquam erat volutpat. Quisque interdum posuere quam, id fermentum erat porttitor sed. Vestibulum ante ipsum primis dans faucibus orci luctus et ultrices posuere cubilia Curae; Proin et arcu sem. Donec ac iaculis NIBH.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Pellentesque sit amet turpis vel urna imperdiet egestas Fringilla un metus? Praesent pretium adipiscing consequat. Donec dictum turpis vitae Nisi egestas tincidunt posuere Arcu ultricies? Vivamus vel dui ut turpis egestas Aliquam! Sed sed ante est. Entier condimentum NIBH vitae neque tincidunt porta. Quisque ligula arcu, sed Aliquam interdum non, non ultricies lorem. Morbi ut leo felis. Aliquam pretium lacinia elit, sous forme non tempor dicton ipsum. Nullam tellus sem, interdum dapibus pulvinar vitae, dignissim ullamcorper ante. Suspendisse potentiom&egrave;tre. Nam sem non enim, &agrave; tempor tortor.</div>\r\n', 1, 1, 'project, backers creators, video, image', 'projet', 'project, backers creators, video, image', 'project', 1, 0, 1347015650, 1385571411),
(83, 'Start Your Project', '????? ??? ????????', 'start-your-project', 'start-your-project', '<h1 class="pt10 pb20 blue22">We help people <span class="like-you">(like you) start </span>creative projects.</h1>\r\n\r\n<p class="grey20 height206 lh33"><strong>BoostBloom is Armenia&#39;s first funding platform for creative projects.</strong> Every week, people from around the world pledge money to Armenian projects in <span class="category-1">Music</span>, <span class="category-2">film</span>, <span class="category-3">Art</span>, <span class="category-4">Technology</span>, <span class="category-5">Design</span>, <span class="category-6">Food</span>, <span class="category-7">Publishing</span>, Charity and other fields where creativity is a must.</p>\r\n', 'Ինչ՞ է Բուստբլումը:<br />\r\nԲուստբլումը ֆինանսավորող պլատֆորմ(հարթակ) է ստեղծարարական նախագծերի համար: Ամեն ինչ՝ սկսած ֆիլմերից, խաղերից &uml; երաժշտությունից մինչ&uml; ձ&uml;ավորում/դիզայն &uml; տեխնոլոգիաներ: Բուստբլումը լի է ձգտումներով, նորարարական &uml; եր&uml;ակայական նախագծերով, որոնք կյանքի են կոչվել այլոց անմիջական աջակցությամբ:<br />\r\n&nbsp;\r\n<p class="grey20 height206 lh33">&nbsp;</p>\r\n', 0, 1, 'Start your project', 'Start your project', 'Start your project', 'Start your Project', 1, 0, 1354527751, 1385306998),
(84, 'Project Creation Guideline Right Panel', 'Project Creation Guideline Right Panel', 'project-creation-guideline-right-panel', 'project-creation-guideline-right-panel', '<h1 class="mb12">Eligibility requirements</h1>\r\n\r\n<p>To be eligible to start a BoostBloom project, you need to satisfy the requirements of Paypal Payments:</p>\r\n\r\n<ul class="mt10">\r\n	<li>You are 18 years of age or older.</li>\r\n	<li>You are an Armenian resident</li>\r\n	<li>You have an Armenian Bank account</li>\r\n</ul>\r\n', '<h1 class="mb12">crit&egrave;res d&#39;admissibilit&eacute;.</h1>\r\n\r\n<p>Pour &ecirc;tre admissible &agrave; lancer une BoostBloom projet, vous devez satisfaire aux exigences de paiements de Paypal:</p>\r\n\r\n<ul class="mt10">\r\n	<li>Vous avez 18 ans ou plus.</li>\r\n	<li>Vous &ecirc;tes un r&eacute;sident permanent armenian</li>\r\n	<li>Vous avez une adresse armenienne</li>\r\n</ul>\r\n', 0, 1, 'Project Creation Guideline', 'Project Creation Guideline', 'Project Creation Guideline', 'Project Creation Guideline', 1, 0, 1355462761, 1385566596),
(85, 'Project Creation Rewards Right Panel', 'Project Creation Rewards Right Panel', 'project-creation-rewards-right-panel', 'project-creation-rewards-right-panel', '<div class="mt17">\r\n<p>Here you choose what rewards to give out to your backers at different levels of funding (i.e. $5, $25, $50&hellip;).</p>\r\n\r\n<p>Keep it simple! Don&rsquo;t offer too many rewards and make your reward system easy to understand.</p>\r\n\r\n<p>You can also limit the number of rewards for each category (Limit# available)<br />\r\n&nbsp;</p>\r\n\r\n<h3><strong>What to offer</strong></h3>\r\n\r\n<ul>\r\n	<li>Copies of your creation (for example if your project is to record a new album, rewards should include a copy of the CD when it&rsquo;s done)</li>\r\n	<li>Collaborations: anything you can think of that will allow backer to personally take part in your project)</li>\r\n	<li>Interactions or unique experiences: an idea that would allow you and your backers to be in contact more closely</li>\r\n	<li>Associations: personal thank you notes or credits</li>\r\n</ul>\r\nPossibilities are endless: just ask yourself: would YOU open your purse for your rewards?<br />\r\n<strong>For more about Rewards</strong> and examples of Rewards: check our <a href="http://www.boostbloom.com/help/school/school/creating-rewards">Best Practices No. 4 Creating Rewards</a><br />\r\n&nbsp;\r\n<h3 class="mb12"><strong>How to price</strong></h3>\r\n\r\n<ul>\r\n	<li>Price fairly, offer value</li>\r\n	<li>Most popular reward: $25</li>\r\n	<li>Something fun for $10 or less is always a good idea</li>\r\n	<li>Budget shipping cost into the reward price</li>\r\n	<li>You may need to create separate rewards for international backers, or ask them to add a specified amount to their pledges for the added costs</li>\r\n</ul>\r\n\r\n<p class="mb12"><strong>What&#39;s prohibited</strong></p>\r\n\r\n<ul>\r\n	<li>Rewards not directly produced by the creator or the project itself</li>\r\n	<li>Financial incentives</li>\r\n	<li>Raffles, lotteries, and sweepstakes</li>\r\n	<li>Rewards in bulk quantities (more than ten of an item)</li>\r\n</ul>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n', '<h1 class="mb12">Qu&#39;est-ce &agrave; offrir</h1>\r\n\r\n<p>Des copies de ce que vous faites, les exp&eacute;riences uniques et &eacute;ditions limit&eacute;es excellent travail.</p>\r\n\r\n<h1 class="mb12">Comment fixer le prix</h1>\r\n\r\n<ul>\r\n	<li>Prix assez, offrir une valeur</li>\r\n	<li>R&eacute;compense le plus populaire: $25</li>\r\n	<li>Quelque chose d&#39;amusant pour $10 ou moins, c&#39;est toujours une bonne id&eacute;e</li>\r\n	<li>Le co&ucirc;t d&#39;exp&eacute;dition du budget dans le prix r&eacute;compense</li>\r\n	<li>Vous devrez peut-&ecirc;tre cr&eacute;er des r&eacute;compenses distinctes pour les emballeurs internationale, et leur demander d&#39;ajouter un certain montant de leurs engagements pour les co&ucirc;ts suppl&eacute;mentaires</li>\r\n</ul>\r\n\r\n<h1 class="mb12">Ce qui est interdit</h1>\r\n\r\n<ul>\r\n	<li>R&eacute;compenses pas directement produites par le cr&eacute;ateur ou le projet lui-m&ecirc;me</li>\r\n	<li>Des incitations financi&egrave;res</li>\r\n	<li>Raffles, les loteries et tirages au sort,</li>\r\n	<li>Coupons, les remises et les cartes-cadeaux en esp&egrave;ces &agrave; valeur</li>\r\n	<li>R&eacute;compenses en grandes quantit&eacute;s (plus de dix d&#39;un article)</li>\r\n</ul>\r\n', 0, 1, 'Project Creation Rewards', 'Project Creation Rewards', 'Project Creation Rewards', 'Project Creation Rewards', 1, 0, 1355463130, 1385571911),
(86, 'Project Creation Story Right Panel', 'Project Creation Story Right Panel', 'project-creation-story-right-panel', 'project-creation-story-right-panel', '<h3><strong>Why shoot a video?</strong></h3>\r\n\r\n<ul>\r\n	<li>Your video makes the connection between you and your audience</li>\r\n	<li>Your video shows who you are and what you do</li>\r\n	<li>Because without a video, projects are much more likely to fail!</li>\r\n</ul>\r\n\r\n<h3>What do I need?</h3>\r\n\r\n<ul>\r\n	<li>A phone that records sound and video or a camera</li>\r\n	<li>A computer and a web access to upload your video</li>\r\n	<li>A layer of motivation, nothing more</li>\r\n</ul>\r\n\r\n<h3>Basics to include</h3>\r\n\r\n<ul>\r\n	<li>Say and show who you are (show your face!)</li>\r\n	<li>Explain what the project is about</li>\r\n	<li>Tell the story that gave life to the idea</li>\r\n	<li>Give a taste of your rewards and how cool they are</li>\r\n	<li>Explain why reaching your goal is essential (without looking desperate!)</li>\r\n	<li>Say thanks!</li>\r\n</ul>\r\n\r\n<h3>Ask yourself</h3>\r\n\r\n<ul>\r\n	<li>Is my video enjoyable and informative enough for someone not to press stop in the middle of it?</li>\r\n	<li>Isn&rsquo;t it too long?</li>\r\n</ul>\r\n\r\n<h3><br />\r\n<strong>Project description</strong></h3>\r\n\r\n<ul>\r\n	<li>Build trust: share your past achievements and what you&rsquo;ll do to make your project come true</li>\r\n	<li>Mind the layout: keep it clean and clear: use titles, paragraph, section, backers will like it!</li>\r\n	<li>Make it funny: humor always works</li>\r\n</ul>\r\n\r\n<h3>&nbsp; Your text must tell</h3>\r\n\r\n<ul>\r\n	<li>Who&#39;s creating the project and why reaching your funding goal is essential</li>\r\n	<li>What your story is and how you come up with the idea</li>\r\n	<li>What your rewards are and why they&#39;re amazing :)</li>\r\n</ul>\r\n\r\n<p><strong>Reminder</strong>:Make sure you don&#39;t use copyrighted music in your video unless you get permission!<br />\r\nTo grab more advice on how to make your Video, check here: <a href="http://www.boostbloom.com/help/school/school/making-a-video"><u>Best Practices No. 5 Making a video?</u></a></p>\r\n', '<div class="mt17">\r\n<h1>rappel important</h1>\r\n\r\n<p>Ne pas utiliser de musique, des images, des vid&eacute;os ou tout autre contenu que vous n&#39;avez pas les droits. R&eacute;utilisation de mat&eacute;riel sous copyright est presque toujours contraire &agrave; la loi et peut entra&icirc;ner des poursuites judiciaires co&ucirc;teuses sur la route. La meilleure fa&ccedil;on d&#39;&eacute;viter les probl&egrave;mes de droits d&#39;auteur est de cr&eacute;er tout le contenu vous-m&ecirc;me ou utiliser le contenu qui est gratuit pour un usage public.</p>\r\n</div>\r\n', 0, 1, 'Project Creation Story, Video for your project', 'Project Creation Story Right Panel', 'Project Creation Story Video for your project', 'Project Creation Story Right Panel', 1, 0, 1355463276, 1385572032),
(87, 'Project Creation About You Right Panel', 'Project Creation About You Right Panel', 'project-creation-about-you-right-panel', 'project-creation-about-you-right-panel', '<h3 class="mb12"><strong>Accountability and Responsibility</strong></h3>\r\n\r\n<ul>\r\n	<li>Getting backers to trust you is part of your job as a creator. Remember that potential backers do not personally know you. Earning their trust is the key that will bring your project to life.</li>\r\n	<li>Tell who you really are, what your story is, talk about your achievements and share links that help reinforce them.</li>\r\n</ul>\r\n\r\n<h3><br />\r\n<strong>Facebook Connect</strong></h3>\r\n\r\n<ul>\r\n	<li>When you click connect to Facebook on Boostbloom, a lot of cool and useful stuff are going to happen:</li>\r\n	<li>Your backers will see the number of friends you have on FB (this will help you build trust with your backers)</li>\r\n	<li>Your friends will know the projects you have launched and will be able to back them easily</li>\r\n	<li>You&rsquo;ll be able to know what projects your friends have backed or launched</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><strong>Your Biography</strong></h3>\r\n\r\n<ul>\r\n	<li>Will appear on your Profile Page</li>\r\n	<li>Should be personal and say who you are!</li>\r\n	<li>Should tell your story (to motivate backers and to show your own motivation!)<br />\r\n	&nbsp;</li>\r\n</ul>\r\n', '<h1 class="mb12">Remarques importantes relatives &agrave; la responsabilit&eacute;</h1>\r\n\r\n<p>Comment les bailleurs de vous faire confiance fait partie de votre travail en tant que cr&eacute;ateur. Rappelez-vous que bailleurs de fonds potentiels ne pense pas personnellement que vous connaissez. Gagner leur confiance est la cl&eacute; qui permettra de mener votre projet &agrave; vie. Dites qui vous &ecirc;tes vraiment, ce que votre histoire est, parler de vos r&eacute;alisations et partager des liens qui les aident &agrave; renforcer.</p>\r\n', 0, 1, 'Project Creation About You Right Panel', 'Project Creation About You Right Panel', 'Project Creation About You Right Panel', 'Project Creation About You Right Panel', 1, 0, 1355463465, 1365269760),
(88, 'Project Creation Account Right Panel', 'Project Creation Account Right Panel', 'project-creation-account-you-right-panel', 'project-creation-account-you-right-panel', '<h1 class="mb12">Eligibility requirements</h1>\r\n\r\n<ul class="mt10">\r\n	<li>You are 18 years of age or older.</li>\r\n	<li>You are an Armenian resident</li>\r\n	<li>You have an Armenian Bank account to receive money from your backers</li>\r\n</ul>\r\n', '<h1 class="mb12">crit&egrave;res d&#39;admissibilit&eacute;.</h1>\r\n\r\n<ul class="mt10">\r\n	<li>Vous avez 18 ans ou plus.</li>\r\n	<li>Vous &ecirc;tes un r&eacute;sident Armenien</li>\r\n</ul>\r\n', 0, 1, 'Project Creation Account You', 'Project Creation Account You ', 'Project Creation Account You', 'Project Creation Account You', 1, 0, 1355463684, 1385573324);
INSERT INTO `pages` (`id`, `title`, `title_hy`, `slug`, `slug_hy`, `description`, `description_hy`, `home_page`, `position`, `metakeyword`, `metakeyword_hy`, `metadescription`, `metadescription_hy`, `active`, `delete`, `created`, `modified`) VALUES
(91, 'Sharing', 'partage', 'sharing', 'sharing', '<div style="text-align:justify;">\r\n<div>Here is all our advice on how to promote your project!<br />\r\n<br />\r\n<strong>Be a social animal Promote yourself </strong><br />\r\n<br />\r\n<strong>Consistency in social engagement </strong><br />\r\n<br />\r\nDon&rsquo;t be scared about annoying the people in your social circles with regular updates. This could hold you back at a time when you really need to keep reminding people about your efforts. Simply ask your friends: &ldquo;Are my posts annoying you? Be honest.&rdquo; You&rsquo;ll soon realize that most will be excited to see your progress and feel a part of the journey. So don&rsquo;t be afraid to talk about your project. If you are sincerely excited and handle it as an opportunity to share your enthusiasm, people will be glad to join you for the ride. And as the finish line draws closer, you might be amazed to see friends and colleagues rally around your project to spread the word&hellip; Especially if you are bold enough to keep asking! Invest time in building your social network Many people are on Facebook and Twitter. If not already, you need to be there too.<br />\r\n<br />\r\n<strong>Invest time in building your social network</strong><br />\r\nMany people are on Facebook and Twitter. If not already, you need to be there too.<br />\r\n<u>Daily tweets</u><br />\r\n<br />\r\n<br />\r\n&nbsp;</div>\r\n\r\n<div style="width:100%">\r\n<div style="float:left;width:50%;"><img alt="" contenteditable="false" src="http://www.boostbloom.com/img/uploads/ck_pic/image/test.png" style="width: 428px; height: 354px;" /></div>\r\n\r\n<div style="float:right;width:50%;">-post tweets telling of your funding percentages, or about a milestone you&rsquo;ve reached -motivate your followers by sharing what you need and add a word on your reward! -add links at the end of your tweet sending your followers to your Boostbloom profile page or to your Boostbloom project directly (which you can find by going in your profile, clicking&hellip;) -don&rsquo;t just keep posting the same link! Have a look at the screenshot below showing an example on how to use tweets during your project&rsquo;s funding. Hashtag relevant words to your #Project ! In every tweet you send, be sure to &ldquo;#&rdquo; words and phrases related to your project and its campaign. This makes it easier for random people to find your project on Twitter or through a Google search. #boostbloom for example will get you noticed by anyone who follows the boostbloom hashtag and #crowdfundingarmenia by anyone interested in crowdfunding in Armenia. However be sure not to add more than two # (or you&rsquo;ll risk looking like a spammer) and to keep space for linking to your project. . Our twitter link under the project will allow ou to easily share the project link with your followers .be sure to include the #boostblomm hashtag and blablabla.</div>\r\n</div>\r\n\r\n<div style="clear:both;">&nbsp;</div>\r\n\r\n<p><strong>HOW TO GET RE-TWEETED</strong><br />\r\nMore RTs will make it easier for you to attract new followers by getting more exposure in other people&rsquo;s stream. This will drive more traffic to your project. Here are some things you can do to make sure you get re-tweeted as often as possible<strong>.</strong><br />\r\n<br />\r\n<strong>Keep your tweets short</strong><br />\r\nThe more straightforward your tweet is, the <strong>quicker</strong> people understand it, and the easier it is to get it Re-Tweeted. Just r<u>emember to leave enough free space for your tweet to contain the RT and @username. We suggest leaving at least 20 characters free space.</u><br />\r\n<br />\r\n<strong>Carefully choose the time you are going to tweet throughout the day and don&rsquo;t over tweet.</strong><br />\r\nTry to spread your tweets out a bit and make sure that if your followers are in another country they are not sleeping at the time you tweet. You can also choose to schedule your tweets with www.su.pr. About the number of acceptable tweets there is no right or wrong but a single tweet can easily get lost while <strong>tweeting too much will make you look like a spammer<u>.</u></strong> And remember not to tweet exclusively about your campaign.<br />\r\n<br />\r\n<strong>Don&rsquo;t rely on people to just find you on Twitter: Identify some twitter users in your niche and re-tweet them</strong><br />\r\n<br />\r\nFind related tweets by people in your field and retweet them on your account. This will help you come off as sharing opportunities and ideas with your fans and the poster will (hopefully) re-tweet or re-post something of yours in return. As a result, you will be reaching new fans and ultimately increasing your audience.?<br />\r\nSeveral websites can help you do this. On TweetDeck you can create a new column with @username, check the RTs they get and follow those people who made the re-tweet. Easy.<br />\r\n<br />\r\n<strong>Be grateful to people for re-tweeting your tweets.</strong><br />\r\n<u>Something as </u>easy as a simple <strong>&ldquo;</strong>thank you<strong>&rdquo;</strong> will help build a relationship with your &lsquo;RTers&rsquo; and will make them more willing to re-tweet you again. Everyone loves appreciation!<br />\r\n<strong>Don&rsquo;t forget to retweet your followers</strong> , most of them will return the favor!<br />\r\n<strong>And finally&hellip; Just ask for a RT! </strong>This may sound obvious but a &#39;please&#39; can often get you just as far as a &ldquo;thank you&rdquo;. Ask your followers nicely to RT you; you&rsquo;ll be surprised at the response. (Check the screenshot above for examples of tweets.)<br />\r\n&nbsp;<br />\r\n<strong><u>Facebook</u></strong><br />\r\n<br />\r\n<strong>Motivate your friends and your friends&rsquo; friends</strong><br />\r\n<br />\r\nThe idea here is to make your friends and contacts feel like stakeholders in the project. Give them credit for their help and value their efforts when they explain why they believe in your project as they reach out to their networks.<br />\r\nIf you feel your friends are sharing your project out of obligation or guilt, that&#39;s an indication that you haven&#39;t made a compelling case for why audiences should support you. On the contrary when friends as well as your friends&rsquo; friends are willing to share your project on Facebook, it&rsquo;s a very good indicator that your project is going to be a success! Taking into account your friends&rsquo; feedback will also help you refine your message.<br />\r\nIf you don&#39;t have that, you may not be ready to create a big Boostbloom project.<br />\r\n&nbsp;<br />\r\n<strong>Make graphics for Facebook showing where you are in your funding</strong><br />\r\n<strong>Include the URL of your project in your Facebook cover image</strong>! A &ldquo;call to action&rdquo; is not allowed in your header image on Facebook, but you can simply put your URL with a well chosen picture. A URL is not a call to action in Facebook terms.<br />\r\n<strong>Don&rsquo;t forget to create a Facebook page for your project.</strong> This helps you develop a community of people who will follow you on your journey toward funding. Don&rsquo;t be afraid to experiment with titles, descriptions, imagery. Soon you&rsquo;ll see that whenever someone likes your page, you get double bonus: people can easily follow your project and even their friends will see that they liked your page, therefore becoming themselves more likely to follow along as well.<br />\r\n<strong>If you decide to use Facebook ads</strong>, you can do so in a number of ways to expand awareness of your project. &nbsp;Try creating an ad to promote your Boostbloom project and another to promote your Facebook page, and think about who you are going to target: demographics, genders&hellip; It&rsquo;s even better to think about your future audience even before the launch of your project; this will boost expectations! For instance if your project is about making a Hip-hop album, maybe you should target hip-hop fans from Armenian descent in the US or hip-hop fans in Armenia? You&rsquo;ll be surprised by the number of people ready to support you from day one.<br />\r\n&nbsp;<br />\r\n<strong><u>Blogs</u></strong><br />\r\n<br />\r\n<strong>Do you blog?</strong> Then write a blog post about your project. Remember to put a graphical link to the project in your sidebar so that readers who find other articles through Google will still see your project. You can even easily include the Boostbloom widget to your blog (see the Boostloom tools at your disposal <u>below</u>).<br />\r\n<br />\r\n<strong>If you don&rsquo;t have your own Blog</strong>, you may want to create a key list of individual bloggers and leaders/influencers that write about the field your project belongs to. Contact them telling them how great your project is, and some of them may be happy to do free advertising for your project!<br />\r\nThe most results you will get are by finding connections with notable people in your area of interest and getting their help to promote your project. If you aren&rsquo;t widely known, getting the assistance of better-known people and taking advantage of their circle of followers is a good way to push your effort forward. Consider offering a favor or a special reward in return for their help and make sure your request is relevant to their focus and that you quickly get to the point on your<u> ask</u>. Anything that makes them feel like you are taking too much of their time or that they&rsquo;ve just been spammed is going to hurt your effort rather than help it.<br />\r\n<strong>Be a guest author.</strong> More and more blogs accept guest authors. Guest posts are great to buzz up your project. Bloggers usually love them as your project can mean free content for their blog! Email the bloggers you have a good relationship with and check popular blogs on your topic to see who is seeking content. Just be ready to write about your project in an engaging way without copy/pasting the Boostbloom story.<br />\r\n&nbsp;<br />\r\n<strong>Some blogs also accept paid ads</strong>. This is something to consider only if the blog has a large audience and the ad is cheap. If nobody ever comments or only three people read the blog through Google, you probably don&rsquo;t want to waste your money or your time on it.<br />\r\n&nbsp;<br />\r\n<strong><u>Press</u></strong><br />\r\nLikewise, <strong>think about getting the word out to the press</strong>, especially local press whose audience might genuinely be interested in your project.<br />\r\nQuickly explain why you think they and their readers might take an interest in your story and make it clear that you&#39;ve read their work.<br />\r\nIf you are doing a small project and you believe you can raise enough funding through your immediate friends, then maybe you don&#39;t need to reach out to press at all. <u>Otherwise, press will often want two weeks of lead time and a news story, which ideally might be your launch.</u> Take this into account when you prepare your timeline.<br />\r\nLike before, never spam people or press. If you feel you need to, this is a sign that your project isn&rsquo;t as compelling as you had hoped and that you might need to refine your idea.<br />\r\n<br />\r\n<strong>Print promotions (and connecting them to your social media efforts)</strong><br />\r\n<br />\r\nWhy not create your own flyers to promote your Boostbloom project and leave them around town at the start of the campaign? Make sure you choose places relevant to your topic and be sure to include a QR code so that people can quickly access your page if they see it on the go.<br />\r\nAs a general tip, when generating promo materials and rewards for supporters, make sure you consider the return on each investment. Don&rsquo;t set yourself up to owe more in rewards or in marketing than you make on your Boostbloom campaign. Starting small will limit your exposure: if you aren&rsquo;t sure if a postcard will work for your promotion, start out by trying a few fliers from your color printer first, and track the results of those before expanding.<br />\r\n<strong>Go get&rsquo;em!</strong><br />\r\n<br />\r\nAt this stage your social media strategy should be well advanced. By now you should have prepared a list of blogs or press to reach out to, some tweets ready to start with, a cool Facebook picture with a link to your project to share around you.<br />\r\n<br />\r\n<strong>At launch</strong> you can have a &quot;launch party&quot; where you reach out to all your friends and family and <strong>ask them to share</strong> your project. Making it easy for friends and family to share (by sending them the link to your project on Boostbloom) will allow you to get early the traction that will be helpful later on. While blogs work great for some, you can decide to reach hundreds of people individually via Linkedin if you believe they may be interested in the project.<br />\r\nAnd don&rsquo;t forget the rule: <strong>don&rsquo;t spam, be genuine and be personal</strong>. People will be much more likely to answer if they feel they are the only ones you emailed! In short, be bold and experimental! Get ready to work and to make new friends! And if you don&rsquo;t make it the first time around, don&rsquo;t give up: many false starts precede amazing victories.<br />\r\n<br />\r\n&nbsp;</p>\r\n</div>\r\n', '<div style="text-align:justify;"><span id="result_box" lang="fr"><span class="hps">Voici</span> <span class="hps">tous vos conseils</span> <span class="hps">sur la fa&ccedil;on de</span> <span class="hps">promouvoir votre projet</span><span>!</span></span><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">&Ecirc;tre un</span> <span class="hps">animal social</span></span></strong>&nbsp; <span class="short_text" id="result_box" lang="fr"><span class="hps">se promouvoir<br />\r\n<br />\r\n<strong>La coh&eacute;rence dans</strong></span><strong> <span class="hps">l&#39;engagement social</span></strong></span><br />\r\n<span id="result_box" lang="fr"><span class="hps">Ne pas</span> <span class="hps">avoir peur de</span> <span class="hps">g&ecirc;nant</span> <span class="hps">les</span> <span class="hps">contacts de vos cercles</span> <span class="hps">sociaux avec</span> <span class="hps">mises &agrave; jour r&eacute;guli&egrave;res</span><span>.</span> <span class="hps">Cela pourrait</span> <span class="hps">vous retenir</span> <span class="hps">&agrave; un moment o&ugrave;</span> <span class="hps">vous avez vraiment besoin</span> <span class="hps">de</span> <span class="hps">rappeler aux gens</span> <span class="hps">&agrave; propos de</span> <span class="hps">vos efforts</span><span>.</span> <span class="hps">Il suffit de</span> <span class="hps">demander &agrave; vos amis</span><span>:</span> <span class="hps atn">&quot;Etes-</span><span>mes</span> <span class="hps">messages</span> <span class="hps">vous ennuyer</span><span>?</span> <span class="hps">Soyez honn&ecirc;te</span><span>.</span> <span class="hps atn">&quot;</span><br />\r\n<span class="hps">Vous</span> <span class="hps">vous rendrez vite compte</span> <span class="hps">que la plupart</span> <span class="hps">seront ravis de</span> <span class="hps">voir vos progr&egrave;s et</span> <span class="hps">se sentir une partie</span> <span class="hps">du voyage.</span><br />\r\n<span class="hps">Il ne faut donc</span> <span class="hps">pas avoir peur de</span> <span class="hps">parler de votre</span> <span class="hps">projet.</span> <span class="hps">Si</span> <span class="hps">vous &ecirc;tes sinc&egrave;rement</span> <span class="hps">excit&eacute; et</span> <span class="hps">le traiter comme</span> <span class="hps">une occasion de partager</span> <span class="hps">votre enthousiasme</span><span>, les gens seront</span> <span class="hps">heureux de</span> <span class="hps">se joindre &agrave; vous</span> <span class="hps">pour la balade.</span> <span class="hps">Et comme</span> <span class="hps">la ligne d&#39;arriv&eacute;e</span> <span class="hps">se rapproche,</span> <span class="hps">vous pourriez &ecirc;tre</span> <span class="hps">surpris</span> <span class="hps">de voir des amis</span> <span class="hps">et des</span> <span class="hps">coll&egrave;gues</span> <span class="hps">de rallye</span> <span class="hps">autour de votre projet</span> <span class="hps">de passer le mot</span> <span class="hps">...</span> <span class="hps">Surtout si vous &ecirc;tes</span> <span class="hps">assez audacieux pour</span> <span class="hps">continuer &agrave; demander</span><span>!</span></span><br />\r\n<br />\r\n<br />\r\n<strong>Invest time in building your social network</strong><br />\r\nMany people are on Facebook and Twitter. If not already, you need to be there too.<br />\r\n<u>Daily tweets</u><br />\r\n<br />\r\n<br />\r\n<img alt="" contenteditable="false" src="http://www.boostbloom.com/img/uploads/ck_pic/image/test_2.png" style="width: 428px; height: 354px; float: left;" />\r\n<div style="float:right;width:50%;">-<span id="result_box" lang="fr"><span class="hps">publier des tweets</span> <span class="hps">racontant</span> <span class="hps">vos</span> <span class="hps">pourcentages de financement</span><span>, soit environ</span> <span class="hps">un jalon</span> <span class="hps">que vous avez atteint</span><span class="atn">-</span><span>motiver vos</span> <span class="hps">disciples</span> <span class="hps">en partageant ce que</span> <span class="hps">vous avez besoin et</span> <span class="hps">ajouter un mot</span> <span class="hps">sur ??votre</span> <span class="hps">r&eacute;compense!</span> <span class="hps atn">-</span><span>ajouter des liens</span> <span class="hps">&agrave; la fin de</span> <span class="hps">votre tweet</span> <span class="hps">envoyer</span> <span class="hps">vos followers</span> <span class="hps">sur votre</span> <span class="hps">page de profil</span> <span class="hps">Boostbloom</span> <span class="hps">ou</span> <span class="hps">&agrave; votre projet</span> <span class="hps">Boostbloom</span> <span class="hps">directement</span> <span class="hps">(que vous pouvez</span> <span class="hps">trouver en allant</span> <span class="hps">dans votre profil</span><span>, en cliquant</span> <span class="hps">...</span><span>)</span><span>-ne</span> <span class="hps">tout simplement</span> <span class="hps">garder l&#39;affichage</span> <span class="hps">le m&ecirc;me lien</span><span>!</span> <span class="hps">Jetez un oeil &agrave;</span> <span class="hps">la copie d&#39;&eacute;cran</span> <span class="hps">ci-dessous</span> <span class="hps">montre</span> <span class="hps">un exemple sur</span> <span class="hps">la fa&ccedil;on d&#39;utiliser</span> <span class="hps">tweets</span> <span class="hps">pendant</span> <span class="hps">financement</span> <span class="hps">de votre projet.</span> <span class="hps">Hashtag</span> <span class="hps">mots</span> <span class="hps">se rapportant &agrave; votre</span> <span class="hps">projet</span> <span class="hps">#!</span> <span class="hps">Dans</span> <span class="hps">tous les tweets</span> <span class="hps">que vous envoyez</span><span>, n&#39;oubliez pas de</span> <span class="hps">&quot;#&quot;</span> <span class="hps">mots</span> <span class="hps">et expressions</span> <span class="hps">li&eacute;s &agrave; votre projet</span> <span class="hps">et de sa campagne</span><span>.</span> <span class="hps">Cela rend</span> <span class="hps">plus facile pour les</span> <span class="hps">gens au hasard</span> <span class="hps">pour trouver</span> <span class="hps">votre projet</span> <span class="hps">sur ??Twitter</span> <span class="hps">ou par le biais</span> <span class="hps">d&#39;une recherche Google</span><span>.</span> <span class="hps">#</span> <span class="hps">boostbloom</span> <span class="hps">par exemple</span> <span class="hps">vous fera remarquer</span> <span class="hps">par toute personne qui</span> <span class="hps">suit</span> <span class="hps">le hashtag</span> <span class="hps">#</span> <span class="hps">crowdfundingarmenia</span> <span class="hps">boostbloom</span> <span class="hps">et</span> <span class="hps">par</span> <span class="hps">toute personne int&eacute;ress&eacute;e par</span> <span class="hps">crowdfunding</span> <span class="hps">en Arm&eacute;nie</span><span>.</span> <span class="hps">Toutefois, il faut</span> <span class="hps">veiller &agrave; ne pas</span> <span class="hps">ajouter</span> <span class="hps">plus de deux</span> <span class="hps"># (ou</span> <span class="hps">vous risquez</span> <span class="hps">ressembler &agrave; un</span> <span class="hps">spammeur</span><span>) et</span> <span class="hps">de garder l&#39;espace</span> <span class="hps">pour lier</span> <span class="hps">&agrave; votre projet.</span> <span class="hps">.</span> <span class="hps">Notre lien</span> <span class="hps">twitter</span> <span class="hps">dans le cadre du</span> <span class="hps">projet permettra</span> <span class="hps">de partager facilement</span> <span class="hps">ous</span> <span class="hps">le lien du projet</span> <span class="hps">avec vos followers</span><span>.</span> <span class="hps">N&#39;oubliez pas d&#39;inclure</span> <span class="hps">le hashtag #</span> <span class="hps">boostblomm</span> <span class="hps">et</span> <span class="hps">blablabla</span><span>.</span></span></div>\r\n\r\n<div style="clear:both;">&nbsp;</div>\r\n\r\n<p><strong><span class="short_text" id="result_box" lang="fr"><span class="hps">COMMENT SE RENDRE</span> <span class="hps atn">RE-</span><span>tweet&eacute;</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps atn">Plus d&#39;</span><span>inhaloth&eacute;rapeutes</span><span>, il sera</span> <span class="hps">plus facile</span> <span class="hps">pour vous d&#39;attirer</span> <span class="hps">de nouveaux adeptes</span> <span class="hps">en obtenant</span> <span class="hps">plus de visibilit&eacute;</span> <span class="hps">dans le flux</span> <span class="hps">des autres.</span> <span class="hps">Cela permet de mettre</span> <span class="hps">plus de trafic vers</span> <span class="hps">votre projet.</span> <span class="hps">Voici quelques</span> <span class="hps">choses que vous</span> <span class="hps">pouvez faire pour</span> <span class="hps">vous assurer d&#39;obtenir</span> <span class="hps">re</span><span class="atn">-</span><span>tweet&eacute;</span> <span class="hps">aussi souvent que possible</span><span>.</span></span><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Gardez</span> <span class="hps">vos tweets</span> <span class="hps">&agrave; court</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">Le</span> <span class="hps">plus simple</span> <span class="hps">est de</span> <span class="hps">votre tweet</span><span>, les gens</span> <span class="hps">le comprennent</span> <span class="hps">plus rapides</span><span>,</span> <span class="hps">et</span> <span class="hps">plus il est facile</span> <span class="hps">de l&#39;obtenir</span> <span class="hps">&agrave; nouveau</span> <span class="hps">tweet&eacute;</span><span>.</span> <span class="hps">N&#39;oubliez pas de</span> <span class="hps">laisser suffisamment d&#39;espace</span> <span class="hps">libre pour</span> <span class="hps">votre tweet</span> <span class="hps">pour contenir la</span> <span class="hps">RT</span> <span class="hps">@</span> <span class="hps">et</span> <span class="hps">nom d&#39;utilisateur.</span> <span class="hps">Nous</span> <span class="hps">sugg&eacute;rons de laisser</span> <span class="hps">au moins 20</span> <span class="hps">caract&egrave;res d&#39;espace</span> <span class="hps">libre.</span></span><br />\r\n<br />\r\n<strong><span id="result_box" lang="fr"><span class="hps">Choisissez avec soin le</span> <span class="hps">temps que vous allez</span> <span class="hps">&agrave; tweeter</span> <span class="hps">toute la journ&eacute;e</span> <span class="hps">et ne pas trop</span> <span class="hps">tweet.</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">Essayez de r&eacute;partir</span> <span class="hps">vos tweets</span> <span class="hps">sur</span> <span class="hps">un peu</span> <span class="hps">et assurez-vous</span> <span class="hps">que si vos</span> <span class="hps">disciples</span> <span class="hps">sont</span> <span class="hps">dans un autre pays</span><span>, ils</span> <span class="hps">ne dorment pas</span> <span class="hps">au moment o&ugrave; vous</span> <span class="hps">tweet.</span> <span class="hps">Vous pouvez</span> <span class="hps">&eacute;galement choisir de</span> <span class="hps">programmer vos</span> <span class="hps">tweets avec</span> <span class="hps">www.su.pr.</span> <span class="hps">A propos du</span> <span class="hps">nombre de tweets</span> <span class="hps">acceptables</span> <span class="hps">n&#39;y a pas de</span> <span class="hps">bonne ou de mauvaise</span><span>, mais</span> <span class="hps">un tweet</span> <span class="hps">simple</span> <span class="hps">peut facilement se perdre</span> <span class="hps">tout en</span></span> <strong><span id="result_box" lang="fr"><span class="hps">tweeting</span> <span class="hps">trop de</span> <span class="hps">vous faire ressembler &agrave;</span> <span class="hps">un spammeur</span></span><u>.</u></strong> <span id="result_box" lang="fr"><span class="hps">Et rappelez-vous</span> <span class="hps">de ne pas</span> <span class="hps">tweeter</span> <span class="hps">exclusivement</span> <span class="hps">sur ??votre campagne.</span></span><br />\r\n<br />\r\n<strong><span id="result_box" lang="fr"><span class="hps">Ne vous fiez pas</span> <span class="hps">aux gens de</span> <span class="hps">simplement vous</span> <span class="hps">retrouver sur Twitter</span><span>:</span> <span class="hps">Identifier</span> <span class="hps">certains</span> <span class="hps">utilisateurs de Twitter</span> <span class="hps">dans votre niche et</span> <span class="hps">les</span> <span class="hps">re-tweet</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">Trouvez</span> <span class="hps">tweets</span> <span class="hps">li&eacute;s</span> <span class="hps">par des personnes</span> <span class="hps">dans votre domaine</span> <span class="hps">et de les</span> <span class="hps">retweeter</span> <span class="hps">sur votre compte.</span> <span class="hps">Cela vous aidera &agrave;</span> <span class="hps">se d&eacute;tacher comme</span> <span class="hps">le partage</span> <span class="hps">des opportunit&eacute;s</span> <span class="hps">et des id&eacute;es</span> <span class="hps">avec vos fans</span> <span class="hps">et les</span> <span class="hps">affiches seront</span> <span class="hps atn">(</span><span>esp&eacute;rons-le)</span> <span class="hps">ou</span> <span class="hps">re-tweet</span> <span class="hps">re</span><span>-post</span> <span class="hps">quelque chose de toi</span> <span class="hps">en retour.</span> <span class="hps">En cons&eacute;quence</span><span>, vous serez</span> <span class="hps">atteint</span> <span class="hps">de nouveaux fans</span> <span class="hps">et en augmentant</span> <span class="hps">votre auditoire.</span><span>?</span><br />\r\n<span class="hps">Plusieurs sites</span> <span class="hps">peuvent vous aider &agrave;</span> <span class="hps">faire cela</span><span>.</span> <span class="hps">Sur</span> <span class="hps">TweetDeck</span> <span class="hps">vous pouvez cr&eacute;er</span> <span class="hps">une nouvelle colonne avec</span> <span class="hps">le nom d&#39;utilisateur</span> <span class="hps">@</span><span>, v&eacute;rifiez la</span> <span class="hps">RT</span> <span class="hps">qu&#39;ils obtiennent et</span> <span class="hps">suivre</span> <span class="hps">ceux qui ont fait</span> <span class="hps">la</span> <span class="hps">re-tweet</span><span>.</span> <span class="hps">facile</span></span>.<br />\r\n<br />\r\n<strong><span id="result_box" lang="fr"><span class="hps">Soyez reconnaissants</span> <span class="hps">pour</span> <span class="hps">les gens</span> <span class="hps">de</span> <span class="hps">retweeter</span> <span class="hps">vos tweets.</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">Quelque chose d&#39;aussi</span> <span class="hps">simple que</span> <span class="hps atn">d&#39;un simple &quot;</span><span>merci&quot;</span> <span class="hps">va</span> <span class="hps">aider &agrave; construire</span> <span class="hps">une relation avec</span> <span class="hps atn">vos &laquo;</span><span>RTers</span><span>&raquo;</span> <span class="hps">et</span> <span class="hps">les rendra plus</span> <span class="hps">dispos&eacute;s &agrave;</span> <span class="hps">re-tweet</span><span>-vous</span> <span class="hps">&agrave; nouveau</span><span>.</span> <span class="hps">Tout le monde aime</span> <span class="hps">l&#39;appr&eacute;ciation!</span></span><br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">N&#39;oubliez pas de</span> <span class="hps">retweeter</span> <span class="hps">vos followers</span></span></strong> , <span class="short_text" id="result_box" lang="fr"><span class="hps">plupart d&#39;entre eux</span> <span class="hps">vous le rendront bien</span><span>!</span></span><br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Et enfin ...</span> <span class="hps">Il suffit de demander</span> <span class="hps">pour une</span> <span class="hps">RT</span><span>! </span></span></strong><span id="result_box" lang="fr"><span class="hps">Cela peut</span> <span class="hps">sembler &eacute;vident, mais</span> <span class="hps atn">un &laquo;</span><span>s&#39;il vous pla&icirc;t&raquo;</span> <span class="hps">peut</span> <span class="hps">souvent vous</span> <span class="hps">aussi loin que</span> <span class="hps">d&#39;un</span> <span class="hps">&laquo;merci&raquo;</span><span>.</span> <span class="hps">Demandez &agrave; vos</span> <span class="hps">disciples</span> <span class="hps">bien &agrave;</span> <span class="hps">RT</span><span>-vous</span><span>, vous</span> <span class="hps">serez surpris de</span> <span class="hps">la r&eacute;ponse</span><span>.</span> <span class="hps">(Cochez</span> <span class="hps">la capture d&#39;&eacute;cran</span> <span class="hps">ci-dessus</span> <span class="hps">pour des exemples de</span> <span class="hps">tweets</span><span>.</span><span>)</span></span><br />\r\n&nbsp;<br />\r\n<strong><u>Facebook</u></strong><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Motivez vos</span> <span class="hps">amis et les amis</span> <span class="hps">de vos amis</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">L&#39;id&eacute;e ici</span> <span class="hps">est de rendre vos</span> <span class="hps">amis et contacts</span> <span class="hps">sentir comme</span> <span class="hps">parties prenantes dans le</span> <span class="hps">projet.</span> <span class="hps">Leur donner cr&eacute;dit pour</span> <span class="hps">leur aide et leur</span> <span class="hps">valeur</span> <span class="hps">leurs</span> <span class="hps">efforts quand ils</span> <span class="hps">expliquer pourquoi</span> <span class="hps">ils croient en</span> <span class="hps">votre projet</span> <span class="hps">puisqu&#39;elles touchent</span> <span class="hps">&agrave; leurs r&eacute;seaux</span><span>.</span><br />\r\n<span class="hps">Si</span> <span class="hps">vous sentez que vos</span> <span class="hps">amis</span> <span class="hps">partagent</span> <span class="hps">votre projet</span> <span class="hps">par obligation</span> <span class="hps">ou de culpabilit&eacute;</span><span>, c&#39;est</span> <span class="hps">une indication que</span> <span class="hps">vous n&#39;avez pas fait</span> <span class="hps">de fa&ccedil;on convaincante</span> <span class="hps">pourquoi le public</span> <span class="hps">devrait</span> <span class="hps">vous aider.</span> <span class="hps">Au contraire, quand</span> <span class="hps">des amis</span> <span class="hps">ainsi que des amis</span> <span class="hps">de vos amis</span> <span class="hps">sont pr&ecirc;ts &agrave; partager</span> <span class="hps">votre projet</span> <span class="hps">sur ??Facebook</span><span>, c&#39;est un</span> <span class="hps">tr&egrave;s bon indicateur</span> <span class="hps">que votre projet</span> <span class="hps">va &ecirc;tre</span> <span class="hps">un succ&egrave;s!</span> <span class="hps">En tenant compte</span> <span class="hps">des commentaires</span> <span class="hps">de vos amis</span> <span class="hps">sera &eacute;galement</span> <span class="hps">vous aider &agrave; affiner</span> <span class="hps">votre message</span><span>.</span><br />\r\n<span class="hps">Si</span> <span class="hps">vous n&#39;avez pas</span> <span class="hps">cela, vous</span> <span class="hps">ne pouvez pas</span> <span class="hps">&ecirc;tre pr&ecirc;t &agrave; cr&eacute;er</span> <span class="hps">un projet</span> <span class="hps">Boostbloom</span> <span class="hps">grande</span><span>.</span></span><br />\r\n&nbsp;<br />\r\n<strong><span id="result_box" lang="fr"><span class="hps">Faire</span> <span class="hps">des graphiques pour</span> <span class="hps">montrer</span> <span class="hps">Facebook</span> <span class="hps">o&ugrave; vous &ecirc;tes dans</span> <span class="hps">votre financement</span><br />\r\n<span class="hps">Inclure</span> <span class="hps">l&#39;URL de votre</span> <span class="hps">projet dans votre</span> <span class="hps">image de couverture</span> <span class="hps">Facebook</span><span>!</span></span></strong> <span id="result_box" lang="fr"><span class="hps">Un</span> <span class="hps atn">&laquo;</span><span>appel &agrave; l&#39;action</span><span>&quot;</span> <span class="hps">n&#39;est pas autoris&eacute; dans</span> <span class="hps">votre image</span> <span class="hps">d&#39;en-t&ecirc;te</span> <span class="hps">sur Facebook, mais</span> <span class="hps">vous pouvez simplement mettre</span> <span class="hps">votre URL</span> <span class="hps">avec une image</span> <span class="hps">bien choisie</span><span>.</span> <span class="hps">Une URL</span> <span class="hps">n&#39;est pas un</span> <span class="hps">appel &agrave; l&#39;action</span> <span class="hps">en termes</span> <span class="hps">de Facebook.</span></span><br />\r\n<br />\r\n<strong><span id="result_box" lang="fr"><span class="hps">Ne</span> <span class="hps">pas oublier de cr&eacute;er</span> <span class="hps">une page Facebook pour</span> <span class="hps">votre projet.</span></span></strong> <span id="result_box" lang="fr"><span class="hps">Cela vous aide &agrave;</span> <span class="hps">d&eacute;velopper</span> <span class="hps">une communaut&eacute; de personnes</span> <span class="hps">qui vous</span> <span class="hps">suivent</span> <span class="hps">sur ??votre</span> <span class="hps">chemin vers</span> <span class="hps">le financement</span><span>.</span> <span class="hps">N&#39;ayez pas peur</span> <span class="hps">d&#39;exp&eacute;rimenter</span> <span class="hps">avec des titres</span><span>, des descriptions</span><span>, des images</span><span>.</span> <span class="hps">Bient&ocirc;t vous</span> <span class="hps">verrez que</span> <span class="hps">chaque fois que quelqu&#39;un</span> <span class="hps">aime</span> <span class="hps">votre page, vous</span> <span class="hps">obtenez un bonus</span> <span class="hps">double:</span> <span class="hps">les gens peuvent</span> <span class="hps">facilement suivre</span> <span class="hps">votre projet</span> <span class="hps">et m&ecirc;me</span> <span class="hps">leurs amis peuvent voir</span> <span class="hps">qu&#39;ils aimaient</span> <span class="hps">votre page,</span> <span class="hps">donc de plus en</span> <span class="hps">plus tendance &agrave;</span> <span class="hps">se</span> <span class="hps">suivre</span> <span class="hps">ainsi</span><span>.</span></span><br />\r\n<br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Si</span> <span class="hps">vous d&eacute;cidez d&#39;utiliser</span> <span class="hps">publicit&eacute;s Facebook</span></span></strong>, <span id="result_box" lang="fr"><span class="hps">vous pouvez</span> <span class="hps">le faire dans</span> <span class="hps">un certain nombre de</span> <span class="hps">moyens d&#39;&eacute;tendre</span> <span class="hps">la notori&eacute;t&eacute; de votre</span> <span class="hps">projet.</span> <span class="hps">Essayez de cr&eacute;er</span> <span class="hps">une annonce</span> <span class="hps">pour promouvoir votre projet</span> <span class="hps">Boostbloom</span> <span class="hps">et un autre pour</span> <span class="hps">la promotion de votre</span> <span class="hps">page Facebook</span><span>,</span> <span class="hps">et de r&eacute;fl&eacute;chir &agrave;</span> <span class="hps">qui vous allez</span> <span class="hps">&agrave; la cible</span><span>:</span> <span class="hps">la d&eacute;mographie, les</span> <span class="hps">hommes et les femmes</span> <span class="hps">...</span> <span class="hps">C&#39;est encore mieux</span> <span class="hps">de penser &agrave; votre</span> <span class="hps">futur public</span> <span class="hps">avant m&ecirc;me le lancement</span> <span class="hps">de votre projet</span><span>, ce qui</span> <span class="hps">va</span> <span class="hps">stimuler</span> <span class="hps">les attentes</span><span>!</span> <span class="hps">Par exemple, si</span> <span class="hps">votre projet</span> <span class="hps">est</span> <span class="hps">de faire</span> <span class="hps">un album de</span> <span class="hps">hip-hop</span><span>, peut-&ecirc;tre</span> <span class="hps">que vous devriez</span> <span class="hps">cibler</span> <span class="hps">fans de hip hop</span> <span class="hps">de</span> <span class="hps">descendance arm&eacute;nienne</span> <span class="hps">aux Etats-Unis</span> <span class="hps">ou</span> <span class="hps">fans de hip hop</span> <span class="hps">en Arm&eacute;nie</span><span>?</span> <span class="hps">Vous serez surpris</span> <span class="hps">par le nombre</span> <span class="hps">de personnes pr&ecirc;tes &agrave;</span> <span class="hps">vous soutenir</span> <span class="hps">d&egrave;s le premier jour</span><span>.</span></span><br />\r\n&nbsp;<br />\r\n<strong><u>Blogs</u></strong><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Bloguez-vous</span><span>?</span></span></strong> <span id="result_box" lang="fr"><span class="hps">Ensuite, &eacute;crire</span> <span class="hps">un blog sur</span> <span class="hps">votre projet.</span> <span class="hps">N&#39;oubliez pas de mettre</span> <span class="hps">un lien</span> <span class="hps">graphique pour</span> <span class="hps">le projet</span> <span class="hps">dans votre barre lat&eacute;rale</span> <span class="hps">afin que les lecteurs</span> <span class="hps">qui trouvent</span> <span class="hps">d&#39;autres articles</span> <span class="hps">via Google</span> <span class="hps">verrez toujours</span> <span class="hps">votre projet.</span> <span class="hps">Vous pouvez m&ecirc;me</span> <span class="hps">inclure facilement</span> <span class="hps">le widget</span> <span class="hps">Boostbloom</span> <span class="hps">sur votre blog</span> <span class="hps atn">(</span><span>voir les outils</span> <span class="hps">Boostloom</span> <span class="hps">&agrave; votre disposition</span> <span class="hps">ci-dessous)</span><span>.</span></span><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Si</span> <span class="hps">vous n&#39;avez pas</span> <span class="hps">votre propre blog</span></span></strong>, <span id="result_box" lang="fr"><span class="hps">vous pouvez</span> <span class="hps">cr&eacute;er une</span> <span class="hps">liste de cl&eacute;s</span> <span class="hps">de blogueurs</span> <span class="hps">individuels</span> <span class="hps">et les dirigeants</span> <span class="hps">/</span> <span class="hps">influenceurs qui</span> <span class="hps">&eacute;crivent sur</span> <span class="hps">le champ de</span> <span class="hps">votre projet</span> <span class="hps">appartient.</span> <span class="hps">Contactez-les</span> <span class="hps">en leur disant</span> <span class="hps">&agrave; quel point</span> <span class="hps">votre projet,</span> <span class="hps">et</span> <span class="hps">certains d&#39;entre eux</span> <span class="hps">peuvent &ecirc;tre heureux de</span> <span class="hps">faire de la publicit&eacute;</span> <span class="hps">gratuite</span> <span class="hps">pour votre projet!</span></span><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">Les</span> <span class="hps">plupart des</span> <span class="hps">r&eacute;sultats que vous</span> <span class="hps">obtiendrez sont</span> <span class="hps">en trouvant des</span> <span class="hps">liens avec des gens</span> <span class="hps">remarquables</span> <span class="hps">dans votre</span> <span class="hps">domaine d&#39;int&eacute;r&ecirc;t</span> <span class="hps">et d&#39;obtenir leur</span> <span class="hps">aide</span> <span class="hps">pour promouvoir votre projet</span><span>.</span> <span class="hps">Si vous n&#39;&ecirc;tes pas</span> <span class="hps">tr&egrave;s connu,</span> <span class="hps">obtenir l&#39;aide</span> <span class="hps">des</span> <span class="hps">plus connus</span> <span class="hps">et</span> <span class="hps">les gens</span> <span class="hps">profitent de leur</span> <span class="hps">cercle des disciples</span> <span class="hps">est un bon moyen</span> <span class="hps">pour pousser votre</span> <span class="hps">effort</span> <span class="hps">vers l&#39;avant.</span> <span class="hps">Pensez &agrave; offrir</span> <span class="hps">une faveur ou</span> <span class="hps">une r&eacute;compense sp&eacute;ciale</span> <span class="hps">en &eacute;change de leur</span> <span class="hps">aide et</span> <span class="hps">assurez-vous que</span> <span class="hps">votre demande</span> <span class="hps">est pertinente &agrave; leur</span> <span class="hps">mise au point et</span> <span class="hps">que</span> <span class="hps">vous obtenez rapidement</span> <span class="hps">le point</span> <span class="hps">sur ??votre</span> <span class="hps">demande</span><span>.</span> <span class="hps">Tout ce qui</span> <span class="hps">les fait se sentir</span> <span class="hps">comme vous prenez</span> <span class="hps">trop de leur</span> <span class="hps">temps ou</span> <span class="hps">qu&#39;ils ont</span> <span class="hps">tout juste d&#39;&ecirc;tre</span> <span class="hps">spamm&eacute;</span> <span class="hps">va</span> <span class="hps">nuire &agrave; votre</span> <span class="hps">effort</span> <span class="hps atn">plut&ocirc;t que de l&#39;</span><span>aider.</span></span><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Soyez</span> <span class="hps">un auteur invit&eacute;</span><span>.</span></span></strong> <span id="result_box" lang="fr"><span class="hps">Les blogs</span> <span class="hps">de plus en plus</span> <span class="hps">accepter</span> <span class="hps">auteurs invit&eacute;s</span><span>.</span> <span class="hps">Les messages</span> <span class="hps">sont</span> <span class="hps">invit&eacute;s</span> <span class="hps">&agrave; bourdonner</span> <span class="hps">grande</span> <span class="hps">place de votre projet</span><span>.</span> <span class="hps">Les blogueurs</span> <span class="hps">habitude de les</span> <span class="hps">aimer comme</span> <span class="hps">votre projet</span> <span class="hps">peut signifier</span> <span class="hps">contenu gratuit</span> <span class="hps">pour leur blog</span><span>!</span> <span class="hps">Envoyer</span> <span class="hps">les</span> <span class="hps">blogueurs</span> <span class="hps">que vous avez</span> <span class="hps">une bonne relation avec</span> <span class="hps">les blogs</span> <span class="hps">et v&eacute;rifier</span> <span class="hps">plus populaires de votre</span> <span class="hps">sujet</span> <span class="hps">pour voir qui</span> <span class="hps">est &agrave; la recherche</span> <span class="hps">de contenu</span><span>.</span> <span class="hps">Juste &ecirc;tre</span> <span class="hps">pr&ecirc;t &agrave; &eacute;crire</span> <span class="hps">au sujet de votre</span> <span class="hps">projet</span> <span class="hps">de mani&egrave;re attrayante</span> <span class="hps">sans</span> <span class="hps">copier / coller</span> <span class="hps">l&#39;histoire</span> <span class="hps">Boostbloom</span><span>.</span></span><br />\r\n&nbsp;<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Certains blogs</span> <span class="hps">acceptons aussi les</span> <span class="hps">annonces pay&eacute;es</span></span></strong>. T<span id="result_box" lang="fr"><span class="hps">son</span> <span class="hps">est</span> <span class="hps">quelque chose &agrave; consid&eacute;rer</span> <span class="hps">que si le</span> <span class="hps">blog a un</span> <span class="hps">large public et</span> <span class="hps">l&#39;annonce</span> <span class="hps">ne co&ucirc;te pas cher</span><span>.</span> <span class="hps">Si</span> <span class="hps">personne n&#39;a jamais</span> <span class="hps">commentaires</span> <span class="hps">ou</span> <span class="hps">trois personnes seulement</span> <span class="hps">lire le blog</span> <span class="hps">via Google,</span> <span class="hps">vous n&#39;avez probablement pas</span> <span class="hps">envie de perdre votre</span> <span class="hps">argent ou votre temps</span> <span class="hps">l&agrave;-dessus</span><span>.</span></span><br />\r\n&nbsp;<br />\r\n<u><strong><span class="short_text" id="result_box" lang="fr"><span class="hps">appuyer</span></span></strong></u><br />\r\n<br />\r\n<span class="short_text" id="result_box" lang="fr"><span class="hps">&eacute;galement</span></span>,<strong> <span class="short_text" id="result_box" lang="fr"><span class="hps">pensez &agrave;</span> <span class="hps">faire passer le mot</span> <span class="hps">&agrave; la presse</span></span></strong>, <span id="result_box" lang="fr"><span class="hps">en particulier</span> <span class="hps">la presse</span> <span class="hps">locale</span> <span class="hps">dont le public</span> <span class="hps">pourrait</span> <span class="hps">v&eacute;ritablement</span> <span class="hps">&ecirc;tre int&eacute;ress&eacute; par</span> <span class="hps">votre projet.</span><br />\r\n<span class="hps">Expliquer rapidement</span> <span class="hps">pourquoi vous pensez que</span> <span class="hps">eux et leurs</span> <span class="hps">lecteurs pourraient</span> <span class="hps">s&#39;int&eacute;resser &agrave;</span> <span class="hps">votre histoire</span> <span class="hps">et de faire comprendre</span> <span class="hps">que vous avez lu</span> <span class="hps">leur travail.</span><br />\r\n<span class="hps">Si</span> <span class="hps">vous faites</span> <span class="hps">un petit projet</span> <span class="hps">et vous</span> <span class="hps">croyez que vous pouvez</span> <span class="hps">obtenir un financement suffisant</span> <span class="hps">par vos amis</span> <span class="hps">imm&eacute;diats</span><span>,</span> <span class="hps">alors peut-&ecirc;tre</span> <span class="hps">vous n&#39;avez pas besoin</span> <span class="hps">de tendre la main</span> <span class="hps">pour presser</span> <span class="hps">du tout</span><span>.</span> <span class="hps">Sinon, appuyez sur</span> <span class="hps">voudront souvent</span> <span class="hps">deux semaines de</span> <span class="hps">d&eacute;lai</span> <span class="hps">et une histoire</span> <span class="hps">nouvelles,</span> <span class="hps">qui, id&eacute;alement,</span> <span class="hps">pourrait &ecirc;tre votre</span> <span class="hps">lancement</span><span>.</span> <span class="hps">Tenez-en compte</span> <span class="hps">lorsque vous pr&eacute;parez</span> <span class="hps">votre calendrier</span><span>.</span><br />\r\n<span class="hps">Comme</span> <span class="hps">avant</span><span>,</span> <span class="hps">les gens n&#39;ont jamais</span> <span class="hps">de mails</span> <span class="hps">ou</span> <span class="hps">de presse.</span> <span class="hps">Si</span> <span class="hps">vous sentez que vous</span> <span class="hps">avez besoin,</span> <span class="hps">c&#39;est un signe</span> <span class="hps">que votre projet</span> <span class="hps">n&#39;est pas aussi convaincante</span> <span class="hps">que vous aviez esp&eacute;r&eacute;</span> <span class="hps">et que</span> <span class="hps">vous pourriez avoir besoin</span> <span class="hps">pour affiner votre</span> <span class="hps">id&eacute;e.</span></span><br />\r\n<br />\r\n<strong><span id="result_box" lang="fr"><span class="hps">Promotions</span> <span class="hps atn">d&#39;impression (</span><span>et de les relier</span> <span class="hps">&agrave; vos</span> <span class="hps">les m&eacute;dias sociaux</span><span>)</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">Pourquoi ne pas cr&eacute;er</span> <span class="hps">vos propres d&eacute;pliants</span> <span class="hps">pour promouvoir votre projet</span> <span class="hps">Boostbloom</span> <span class="hps">et laissez-les</span> <span class="hps">autour de la ville</span> <span class="hps">au d&eacute;but</span> <span class="hps">de la campagne?</span> <span class="hps">Assurez-vous de</span> <span class="hps">choisir des endroits</span> <span class="hps">pertinents</span> <span class="hps">&agrave; votre sujet et</span> <span class="hps">n&#39;oubliez pas d&#39;inclure</span> <span class="hps">un code</span> <span class="hps">QR</span> <span class="hps">pour que</span> <span class="hps">les gens puissent</span> <span class="hps">acc&eacute;der rapidement &agrave; votre</span> <span class="hps">page si</span> <span class="hps">ils le voient</span> <span class="hps">sur ??la route</span><span>.</span><br />\r\n<span class="hps">Comme une astuce</span> <span class="hps">g&eacute;n&eacute;ral,</span> <span class="hps">lors de la g&eacute;n&eacute;ration</span> <span class="hps">du mat&eacute;riel promotionnel</span> <span class="hps">et des r&eacute;compenses</span> <span class="hps">pour les supporters</span><span>,</span> <span class="hps atn">assurez-vous d&#39;</span><span>examiner</span> <span class="hps">le rendement de chaque</span> <span class="hps">investissement.</span> <span class="hps">Ne vous mettez pas</span> <span class="hps">&agrave;</span> <span class="hps">devoir plus</span> <span class="hps">de</span> <span class="hps">r&eacute;compenses</span> <span class="hps">ou</span> <span class="hps">de</span> <span class="hps">marketing que</span> <span class="hps">vous faites sur</span> <span class="hps">votre campagne</span> <span class="hps">Boostbloom</span><span>.</span> <span class="hps">Commencer petit</span> <span class="hps">va</span> <span class="hps">limiter votre exposition</span><span>:</span> <span class="hps">si vous</span> <span class="hps">ne savez pas si</span> <span class="hps">une carte postale</span> <span class="hps">va travailler pour</span> <span class="hps">votre promotion</span><span>, commencez par</span> <span class="hps">essayer</span> <span class="hps">un</span> <span class="hps">peu de</span> <span class="hps">tracts</span> <span class="hps">&agrave; partir de votre</span> <span class="hps">imprimante couleur</span> <span class="hps">d&#39;abord, et</span> <span class="hps">suivre les r&eacute;sultats de</span> <span class="hps">ceux d&#39;avant</span> <span class="hps">l&#39;expansion</span><span>.</span></span><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Aller</span> <span class="hps">Get&#39;em</span><span>!</span></span></strong><br />\r\n<br />\r\n<span id="result_box" lang="fr"><span class="hps">A ce stade</span> <span class="hps">de votre</span> <span class="hps">strat&eacute;gie de m&eacute;dias sociaux</span> <span class="hps">devraient &ecirc;tre bien avanc&eacute;es</span><span>.</span> <span class="hps">Vous devriez maintenant</span> <span class="hps">avoir pr&eacute;par&eacute;</span> <span class="hps">une liste de blogs</span> <span class="hps">ou appuyez sur pour</span> <span class="hps">aller vers</span><span>,</span> <span class="hps">quelques tweets</span> <span class="hps">pr&ecirc;ts &agrave;</span> <span class="hps">commencer,</span> <span class="hps">une image</span> <span class="hps">fra&icirc;che</span> <span class="hps">Facebook</span> <span class="hps">avec un lien vers</span> <span class="hps">votre projet</span> <span class="hps">&agrave; partager</span> <span class="hps">autour de vous</span><span>.</span></span><br />\r\n<br />\r\n<strong><span class="short_text" id="result_box" lang="fr"><span class="hps">Lors de son lancement</span></span></strong> <span id="result_box" lang="fr"><span class="hps">vous pouvez avoir</span> <span class="hps">une</span> <span class="hps atn">&quot;</span><span>soir&eacute;e de lancement</span><span>&quot;</span> <span class="hps">o&ugrave; vous</span> <span class="hps">tendre la main &agrave;</span> <span class="hps">tous vos</span> <span class="hps">amis et famille et</span></span> <strong><span class="short_text" id="result_box" lang="fr"><span class="hps">demandez-leur</span> <span class="hps">de partager</span></span></strong> <span id="result_box" lang="fr"><span class="hps">votre projet.</span> <span class="hps">Le rendant facile</span> <span class="hps">pour les amis et</span> <span class="hps">la famille &agrave; partager</span> <span class="hps atn">(</span><span>en leur envoyant le</span> <span class="hps">lien vers</span> <span class="hps">votre projet sur</span> <span class="hps">Boostbloom</span><span>)</span> <span class="hps">vous permettra</span> <span class="hps">d&#39;obtenir</span> <span class="hps">au d&eacute;but</span> <span class="hps">de la traction</span> <span class="hps">qui sera utile</span> <span class="hps">plus tard.</span> <span class="hps">Alors que les blogs</span> <span class="hps">excellent travail pour</span> <span class="hps">certains,</span> <span class="hps">vous pouvez d&eacute;cider</span> <span class="hps">de rejoindre des centaines</span> <span class="hps">de personnes</span> <span class="hps">individuellement via</span> <span class="hps">Linkedin</span> <span class="hps">si vous croyez qu&#39;ils</span> <span class="hps">peuvent &ecirc;tre</span> <span class="hps">int&eacute;ress&eacute;s par le projet</span><span>.</span></span><br />\r\n<br />\r\n<span class="short_text" id="result_box" lang="fr"><span class="hps">Et n&#39;oubliez pas</span> <span class="hps">la r&egrave;gle</span><span>:</span></span><strong><span class="short_text" id="result_box" lang="fr"><span class="hps">ne pas le spam</span><span>,</span> <span class="hps">&ecirc;tre v&eacute;ritable et</span> <span class="hps">personnelle</span></span></strong>. <span id="result_box" lang="fr"><span class="hps">Les gens seront beaucoup</span> <span class="hps">plus susceptibles de r&eacute;pondre</span> <span class="hps">s&#39;ils sentent qu&#39;ils</span> <span class="hps">sont les seuls &agrave;</span> <span class="hps">vous</span> <span class="hps">envoy&eacute;es par courrier &eacute;lectronique</span><span>!</span> <span class="hps">En bref,</span> <span class="hps">&ecirc;tre audacieux et</span> <span class="hps">exp&eacute;rimental!</span> <span class="hps">Pr&eacute;parez-vous</span> <span class="hps">&agrave; travailler et &agrave;</span> <span class="hps">faire de nouveaux amis</span><span>!</span> <span class="hps">Et si vous ne</span> <span class="hps">faites pas</span> <span class="hps">la premi&egrave;re fois</span><span>,</span> <span class="hps">ne vous d&eacute;couragez pas</span><span>:</span> <span class="hps">de nombreux faux d&eacute;parts</span> <span class="hps">pr&eacute;c&eacute;der</span> <span class="hps">victoires &eacute;tonnantes</span><span>.</span></span></p>\r\n</div>\r\n', 0, 1, 'Sharing', 'partage', 'Sharing', 'partage', 1, 0, 1364646938, 1364648665);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `partner_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partner_site_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE IF NOT EXISTS `payment_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `backer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_log_message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `short_description` mediumtext COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flv_file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `video_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `project_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_city_json` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_country_json` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duration_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'User can enter number of day or end date and time',
  `no_of_day` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `launch_date` int(11) NOT NULL,
  `project_end_date` int(11) NOT NULL,
  `funding_goal` int(11) NOT NULL,
  `is_successful` tinyint(4) NOT NULL DEFAULT '0' COMMENT '(set as the cron runs and capture the autherized amount)',
  `is_cancelled` tinyint(4) NOT NULL DEFAULT '0',
  `project_success_date` int(11) DEFAULT NULL COMMENT 'date on which cron run and captured the amount ',
  `is_funded` tinyint(4) NOT NULL DEFAULT '0' COMMENT '(set as the cron runs and capture the autherized amount)',
  `funding_date` int(11) NOT NULL,
  `is_recommended` tinyint(1) NOT NULL,
  `recommended_date` int(11) NOT NULL,
  `submitted_status` tinyint(4) NOT NULL DEFAULT '0',
  `project_preview_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0' COMMENT 'published status (0 for pending,1for approved,2 for not approved )',
  `delete` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `project_approved_by_admin_date` int(11) NOT NULL,
  `admin_commission` float(16,2) DEFAULT NULL,
  `is_payment_processed` tinyint(1) DEFAULT '0',
  `ending_soon_notification` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'flag for send notificaiton of 48 hrs',
  `cancellation_request_sent` tinyint(4) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_asked_questions`
--

CREATE TABLE IF NOT EXISTS `project_asked_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `answer` mediumtext COLLATE utf8_unicode_ci,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_cancellation_requests`
--

CREATE TABLE IF NOT EXISTS `project_cancellation_requests` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_comments`
--

CREATE TABLE IF NOT EXISTS `project_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_comment_threads`
--

CREATE TABLE IF NOT EXISTS `project_comment_threads` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `project_comment_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `message_type` enum('Reply','Comment') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Reply',
  `status` tinyint(2) NOT NULL,
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_reports`
--

CREATE TABLE IF NOT EXISTS `project_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_type_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT '0',
  `suggestion` mediumtext COLLATE utf8_unicode_ci,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='report project works like report abuse' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `project_report_types`
--

CREATE TABLE IF NOT EXISTS `project_report_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `report` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `project_report_types`
--

INSERT INTO `project_report_types` (`id`, `report_title`, `report`, `created`, `modified`) VALUES
(1, 'This project creator is spamming me. ', 'Project creators are not permitted to spam. This includes sending unsolicited mass emails and unsolicited @messages on Twitter.\r\n', 1344587246, 1344587248),
(3, 'This is not a project.', 'BoostBloom is for project funding only. Projects must have a plan and a clear goal. ', 1344587281, 1344587282),
(4, 'Prohibited rewards.', 'Raffles, discounts, coupons, contests, and investment offers are prohibited. For more, please review our list of prohibited items and subject matter.', 1344587308, 1344587312),
(5, 'Miscategorized as', '', 1344855067, 1344581410),
(6, 'This project does not come from Armenia', '', 1361370377, 1361370377);

-- --------------------------------------------------------

--
-- Table structure for table `project_surveys`
--

CREATE TABLE IF NOT EXISTS `project_surveys` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `reward_id` bigint(20) NOT NULL DEFAULT '0',
  `owner_id` bigint(20) NOT NULL,
  `survey_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `survey_message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `backers_count` int(11) NOT NULL DEFAULT '0',
  `current_cron_index` int(11) NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_transactions`
--

CREATE TABLE IF NOT EXISTS `project_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `pledge_amount` float(16,2) NOT NULL,
  `admin_commission_percent` float(16,2) DEFAULT NULL,
  `admin_commission_amount` float(16,2) DEFAULT NULL,
  `paypal_commission` float(16,2) DEFAULT NULL,
  `paypal_commission_amount` float(16,2) DEFAULT NULL,
  `amount_for_project_owner` float(16,2) DEFAULT NULL,
  `is_paid` tinyint(1) DEFAULT '0',
  `payment_date` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_updates`
--

CREATE TABLE IF NOT EXISTS `project_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_update_number` int(11) NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_update_comments`
--

CREATE TABLE IF NOT EXISTS `project_update_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `update_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE IF NOT EXISTS `rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `pledge_amount` int(11) NOT NULL,
  `limit` int(11) NOT NULL,
  `limit_value` int(11) DEFAULT '0',
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `est_delivery_month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `est_delivery_year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `send_email_backups`
--

CREATE TABLE IF NOT EXISTS `send_email_backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_to` varchar(555) COLLATE utf8_unicode_ci NOT NULL,
  `email_from` varchar(555) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(555) COLLATE utf8_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `flag` varchar(555) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `fromemail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_limit` int(11) NOT NULL,
  `site_default_language` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'eng',
  `currencySymb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city_json` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `facebook_lnk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_app_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_api_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_lnk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blog_lnk` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meet_team` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `work_with_us` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fromname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emailsingnature` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reply_to_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `copyright` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `site_title` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `front_welcome_msg` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `admin_welcome_msg` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blocked_ip` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `free_phone_within_nz` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `registration_success` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `success_account_activation` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_account_activation` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `forgot_password` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `enquiry_email` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `newsletter` int(20) NOT NULL,
  `project_comment` int(20) NOT NULL,
  `project_listing` int(20) NOT NULL,
  `project_update` int(20) NOT NULL,
  `project_backers` int(20) NOT NULL,
  `blog_listing` int(20) NOT NULL,
  `blog_comments` int(20) NOT NULL,
  `paypal_api_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_api_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_api_signature` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_mode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sandbox',
  `per_project_admin_commission` float(16,2) NOT NULL,
  `start_project_video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `paypal_commission` float(16,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `fromemail`, `page_limit`, `site_default_language`, `currencySymb`, `currency`, `country`, `city`, `city_json`, `facebook_lnk`, `facebook_app_id`, `facebook_api_key`, `facebook_secret`, `twitter_lnk`, `blog_lnk`, `meet_team`, `work_with_us`, `fromname`, `emailsingnature`, `reply_to_email`, `copyright`, `meta_description`, `meta_keywords`, `site_title`, `front_welcome_msg`, `admin_welcome_msg`, `blocked_ip`, `phone`, `fax`, `free_phone_within_nz`, `email`, `postal_address`, `registration_success`, `success_account_activation`, `failed_account_activation`, `forgot_password`, `enquiry_email`, `newsletter`, `project_comment`, `project_listing`, `project_update`, `project_backers`, `blog_listing`, `blog_comments`, `paypal_api_username`, `paypal_api_password`, `paypal_api_signature`, `paypal_mode`, `per_project_admin_commission`, `start_project_video`, `active`, `deleted`, `created`, `modified`, `paypal_commission`) VALUES
(1, 'no-reply@boostbloom.com', 5, 'eng', '$', 'USD', 'AM', '398', '{"id":"398##Yerevan##AM","name":"Yerevan, AM"}', 'http://www.facebook.com/pages/Boostbloom/493017274068268', '102127296610178', '102127296610178', '38b35e4dfffc7beec6ee7168ee056c64', 'https://twitter.com/boostbloom', 'http://www.boostbloom.com/pages/pages/display/blogs', 'http://www.boostbloom.com/display/meet-our-team', 'http://www.boostbloom.com/display/work-with-us-1', 'BoostBloom', 'somdatt.sharma.com', 'info@boostbloom.com', 'Copyright &copy; 2012  BoostBloom, Inc.', 'Welcome to BoostBloom', 'Welcome to BoostBloom', 'BoostBloom', 'Welcome to BoostBloom', 'Welcome to BoostBloom', '168.192.15.22', '(0141) 253050', '(0141) 253050', 'somdatt.sharma.com', 'info@boostbloom.com', 'P.O.Box 58-441, Botany 2163, New York, us', 'Congratulations! Your registration has been successful. Please check you email address for confirmation email. Thank You!', 'Congratulations! Your account has been activated successfully. Please check your email for login credentials. ', 'Sorry! Your account is already activated.', 'You have been sent an email with the login credentials. If the email does not arrive within several minutes, be sure to check your spam or junk mail folders. Thank You!', 'Your enquiry has been submitted successfully.', 4, 4, 6, 4, 4, 4, 4, 'api.paypal.com', '', '', 'production', 0.00, 'project_1354543111.flv', 2, 2, 0, 1386256001, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `stared_projects`
--

CREATE TABLE IF NOT EXISTS `stared_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `staticimages`
--

CREATE TABLE IF NOT EXISTS `staticimages` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vendor_id` int(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `systemdocs`
--

CREATE TABLE IF NOT EXISTS `systemdocs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `doc_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_project_notifications`
--

CREATE TABLE IF NOT EXISTS `temp_project_notifications` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL COMMENT 'update id if update is posted, user id if backed etc',
  `user_id` bigint(20) NOT NULL COMMENT 'backer id (useed if project is backed by user)',
  `activity_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_user_notifications`
--

CREATE TABLE IF NOT EXISTS `temp_user_notifications` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT 'user id who made activity',
  `activity_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'backed if user back a project',
  `subject_id` bigint(20) NOT NULL COMMENT 'project id if activity is for project, etc',
  `subject_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'project if it is for project',
  `created` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='temp table for send notification to users following friends ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `testimonial_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `testimonial_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '1',
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forgot_password_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forgot_password_token_expire` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tmp_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_authenticated` tinyint(1) DEFAULT '0',
  `email_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_token_expire` int(11) DEFAULT NULL,
  `email_reset` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_facebook_user` tinyint(4) NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fb_image_url` text COLLATE utf8_unicode_ci,
  `fb_authontication_token` text COLLATE utf8_unicode_ci,
  `biography` text COLLATE utf8_unicode_ci,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_json` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_json` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` text COLLATE utf8_unicode_ci,
  `phone_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_varified_phone_no` int(11) DEFAULT '0',
  `verification_method_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `receive_weekly_newsletter` int(11) DEFAULT '0',
  `notify_follower_backs_launch` bigint(20) DEFAULT '1',
  `notify_getting_new_follower` bigint(20) DEFAULT '1',
  `notify_created_project_pledges` bigint(20) DEFAULT '1',
  `notify_created_project_comment` bigint(20) DEFAULT '1',
  `notify_backing_project_update` bigint(20) DEFAULT '1',
  `is_opt_out` tinyint(1) DEFAULT '0',
  `active` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `last_activity` datetime NOT NULL,
  `is_login` tinyint(4) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `BY_EMAIL` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `name`, `slug`, `passwd`, `password_token`, `forgot_password_token`, `forgot_password_token_expire`, `email`, `tmp_email`, `email_authenticated`, `email_token`, `email_token_expire`, `email_reset`, `profile_image`, `is_facebook_user`, `facebook_id`, `fb_image_url`, `fb_authontication_token`, `biography`, `city`, `city_json`, `country`, `country_json`, `website`, `phone_no`, `timezone`, `paypal_email`, `is_varified_phone_no`, `verification_method_type`, `receive_weekly_newsletter`, `notify_follower_backs_launch`, `notify_getting_new_follower`, `notify_created_project_pledges`, `notify_created_project_comment`, `notify_backing_project_update`, `is_opt_out`, `active`, `last_login`, `last_activity`, `is_login`, `is_admin`, `is_deleted`, `role`, `created`, `modified`) VALUES
(1, 1, 'SiteAdmin', 'admin', '5991a545d6929d21676f428a0a574d97', 'cricristg2943%!1', 'efa63b13153bc54ed7acf5c90203f2001a6dcf14', '', 'danewadmin1!@boostbloom.com', '', 0, NULL, NULL, '', NULL, 0, '100002951586959', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '', 0, '0', 0, 0, 0, 0, 0, 0, 0, 1, 0, '0000-00-00 00:00:00', 1, 1, 0, 'admin', 2012, 1386572186),
(2, 3, 'Vahe Jean Charles', 'vahe-jean-charles', 'c2635be28eaf8e7e15bc5ad410ca64b1', 'fahb356aok', '', '', 'jcfermandjian@gmail.com', '', 1, '', 1355492238, '', 'profile_119_1359802594dddd.JPG', 1, '1483323133', '', 'AAACEQLOUe9cBALPXfWhrgVQXDmKZCHLr2DOKdVIRxjyLkgfZAl5ZAHP1nyrN7ShyLokDohYswAdvwGDcZCFCZCSJbWu6JYjFwzP9VeMsggZC0FYkrrvE3b', 'Hi this is me, I like to eat!', '146', '{"id":"146##Strasbourg##FR","name":"Strasbourg, FR"}', 'FR', '', 'www.boostbloom.com,www.google.com,www.yahoo.com', NULL, '+1.0', 'pourtoh@yahoo.fr', 0, '0', 1, 1, 1, 1, 1, 1, 0, 1, 1382191617, '0000-00-00 00:00:00', 0, 0, 0, '', 1350009023, 1386356134),
(3, 3, 'Aida Irastorza', 'aida-irastorza', '74df0cc920b8c1af6c78438b3dac5558', 'aidina', '', '', 'aidina_007@hotmail.com', '', 1, '', 1363193914, '', NULL, 0, '698517192', 'https://graph.facebook.com/698517192/picture?type=large', '102127296610178|38b35e4dfffc7beec6ee7168ee056c64', 'Un beso Dos Besos', '149', '{"id":"149##Lille##FR","name":"Lille, FR"}', 'FR', '', '', NULL, '+1.0', '', 0, '0', 0, 1, 1, 1, 1, 1, 0, 1, 1362588747, '0000-00-00 00:00:00', 0, 0, 0, '', 1360421236, 1386353305),
(4, 3, 'Alexander Karpan', 'alexander-karpan', 'd747c9cbac74fbced95e74c79d20d66c', '20332350', '', '', 'a.karpan@gmail.com', '', 0, NULL, NULL, '', NULL, 1, '760666498', 'https://graph.facebook.com/760666498/picture?type=large', 'CAACEQLOUe9cBAPZCrfr1hNgYyfqMtTn9yiZCQyZAc2aEqqHLdNZAAKS0c3miZAFGmOijNtitKx6I3ayCHGtbBV0DZBlWZApusAmnTtPoZCD6xxnzjPAJYg9dbZAjnVijHJMzDy7stuEFpZBmSKhVb1GNBckCBhZBPugPJXNVYgXeGH55wZDZD', 'HOhoho', '142', '{"id":"142##Lyon##FR","name":"Lyon, FR"}', 'FR', '', '', NULL, NULL, '', 0, '0', 0, 1, 1, 1, 1, 1, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', 1374589048, 1383295775);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE IF NOT EXISTS `user_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_PROFILE_PROPERTY` (`field`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_follows`
--

CREATE TABLE IF NOT EXISTS `user_follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `follow_user_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `part_no` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
