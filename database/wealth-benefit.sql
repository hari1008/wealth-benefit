-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2017 at 07:00 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `benefit_wellness`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_invites`
--

CREATE TABLE `app_invites` (
  `app_invite_id` int(11) NOT NULL COMMENT 'Primary key of the table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `invitee_email_id` varchar(50) DEFAULT NULL COMMENT 'Email of Invitee',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_invites`
--

INSERT INTO `app_invites` (`app_invite_id`, `user_id`, `invitee_email_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(40, 174, 'lotte@yopmail.com', '2017-03-17 09:40:48', '0000-00-00 00:00:00', NULL),
(41, 174, 'jack@yopmail.com', '2017-03-17 09:40:48', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `user_id` int(11) NOT NULL COMMENT 'It is the Primary key of users table, here act as a foreign key',
  `device_id` int(11) NOT NULL COMMENT 'It is act as primary key of devices',
  `device_type` varchar(100) CHARACTER SET latin1 NOT NULL COMMENT 'Kept information about the type of device type i.e ios,android',
  `ip_address` varchar(100) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Kept ip address of the devices',
  `device_token` varchar(255) CHARACTER SET latin1 DEFAULT NULL COMMENT 'Kept the token of devices for mapping devices',
  `user_token` varchar(255) NOT NULL COMMENT 'Kept the token of users for mapping users during api requests ',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`user_id`, `device_id`, `device_type`, `ip_address`, `device_token`, `user_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(128, 1, 'android', NULL, 'fh1G9_j4G7g:APA91bErMxXHeJE-_NDC3qGa2vC_l__ltsN3JuIn2Gsve_POZ9VYok_9qTGqp0otL-Ecc9TE_3QZgw3UK8N-FwW1s8QLCgKO9Ew5ArRGxza7CqL3DgI29V5bPldJ6YYg_6WNSP_VBVvp', '08bba804813ff84422aeee0941473c9d', '2016-12-21 04:51:44', '2016-12-21 04:51:44', NULL),
(174, 2, 'ios', NULL, '34C704FAE9452DBDF2032AFC6F5D973116E262DC268276166E35D78B5AFA3973', 'a824ea6de81f9075ee44cfcc47d42114', '2016-12-22 03:58:48', '2016-12-22 03:58:48', NULL),
(1, 3, 'android', NULL, 'eeJ-HveAf7E:APA91bGRmLsmR2tZR2LPzNFr3HCjlJWU53K2D3FHdFOH378FcXyGB2_ofMAhxbszQ4mPdnS-FcIzZ0cUOP-kKQgjTjbeH9JMxM2pSWeAA2cVygp2CTqxhzXVFZ0IkRLxiadhCWg7WyJ_', '2dcdbb1ac8bb513e7a0782a4b78e9043', '2017-01-06 03:44:57', '2017-01-12 00:36:41', NULL),
(2, 4, 'ios', NULL, 'BA76054A6A4F05D8E64EF6A47F16397592D3587C031F0AC7D23AECE1F848215E', '1b376629bb4d64c1474a90e88aead869', '2017-01-12 00:48:16', '2017-02-05 04:48:46', NULL),
(178, 5, 'ios', NULL, '', 'a10a41cd3b4b070564d2a289d8546fe5', '2017-01-12 22:10:38', '2017-01-12 22:10:38', NULL),
(179, 6, 'ios', NULL, '', 'b2befcd107620c2c7aea871ca9875699', '2017-01-16 01:04:49', '2017-01-16 01:04:49', NULL),
(103, 7, 'android', NULL, 'ddydB57L1F4:APA91bED-4Lniky3Ocdg5STbadhEmV5EE6c8vnw777ZyCN9gQIQRYhoEwBTjMk8-_sc2dzOq6N99q6ncdPXmwDiAacBebFJYbMb2URUb6-uzcV3WLXFPTaBRcUpnlJZ0YmSFaRZ2_Adv', '2937eb4a144becfd7201cd70ad30e105', '2017-01-16 01:21:04', '2017-01-16 01:21:04', NULL),
(181, 8, 'ios', NULL, '', 'f4c3c20d74723e9a104900d10307e2fd', '2017-01-16 01:21:48', '2017-01-16 01:21:48', NULL),
(182, 9, 'ios', NULL, '', 'ca72d4a26d8176e1f3be281a5b2d7370', '2017-01-16 01:22:31', '2017-01-17 00:31:41', NULL),
(183, 10, 'ios', NULL, '', 'a860c161532a0d83dd70e4eac0cf01b9', '2017-01-16 01:22:54', '2017-01-17 00:31:29', NULL),
(184, 11, 'android', NULL, 'exNT1Z4BaPs:APA91bHXczqeDL10R2pqJM5dxcztn4OXf-8xAvAcPS7cssMPKurjdIaiz_JkMnbZe0mDLCYMXqcHSdXYVOxrMWWtHIxyrHP_p33r6FySJ5g8y9Igm1Laq7fKOx92Ld-uht5c2xcMouCt', '7013b8f69b27ffaa04c43f0850e92983', '2017-01-17 00:46:57', '2017-01-17 00:47:13', NULL),
(192, 15, 'ios', NULL, '', 'd6849719e08bf1dae1b05b0a31ebdc95', '2017-03-29 09:33:48', '2017-05-02 07:05:07', NULL),
(197, 16, 'ios', NULL, '', '412a958826b0bb9bdca48656e71ae89f', '2017-04-04 07:03:11', '2017-04-04 07:03:11', NULL),
(198, 17, 'ios', NULL, '', '2a0417bd0a58bd1d343cff2efd12a427', '2017-04-17 05:14:46', '2017-04-17 05:14:46', NULL),
(196, 18, 'ios', NULL, '123456dfef', '8ce8315c5abffbf0fb9b4bfe7059f6f4', '2017-05-02 07:03:47', '2017-05-02 07:05:07', NULL),
(214, 19, 'ios', NULL, '', '40bca870a916792b17a14cd28d97e383', '2017-06-06 05:17:12', '2017-06-06 05:17:12', NULL),
(215, 20, 'ios', NULL, '', 'e7979b11f4235defe3733ffd74accfca', '2017-06-06 05:22:58', '2017-06-06 05:22:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ecosystem_features`
--

CREATE TABLE `ecosystem_features` (
  `ecosystem_feature_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `ecosystem_id` int(11) NOT NULL COMMENT 'Foreign key to map ecosystems',
  `feature_id` int(11) NOT NULL COMMENT 'Foreign key to map features',
  `created_at` int(11) NOT NULL COMMENT 'Created Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecosystem_features`
--

INSERT INTO `ecosystem_features` (`ecosystem_feature_id`, `ecosystem_id`, `feature_id`, `created_at`) VALUES
(2, 4, 2, 0),
(7, 4, 1, 0),
(15, 6, 1, 0),
(16, 6, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ecosystem_rewards`
--

CREATE TABLE `ecosystem_rewards` (
  `ecosystem_reward_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `ecosystem_id` int(11) NOT NULL COMMENT 'Foreign key to map ecosystems',
  `master_merchant_id` int(11) NOT NULL COMMENT 'Foreign Key to Master Merchants',
  `master_reward_id` int(11) NOT NULL COMMENT 'Foreign key to map rewards',
  `tier` int(11) NOT NULL COMMENT 'Tier for which this reward is ',
  `expiry` int(11) NOT NULL DEFAULT '1' COMMENT 'Expiry of rewards (number of rewards)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ecosystem_rewards`
--

INSERT INTO `ecosystem_rewards` (`ecosystem_reward_id`, `ecosystem_id`, `master_merchant_id`, `master_reward_id`, `tier`, `expiry`, `created_at`) VALUES
(59, 6, 1, 3, 2, 100, '2017-04-24 06:09:33'),
(74, 4, 1, 3, 3, 1, '2017-05-30 11:32:51'),
(75, 4, 1, 4, 3, 1, '2017-05-30 11:32:51');

-- --------------------------------------------------------

--
-- Table structure for table `ecosystem_works`
--

CREATE TABLE `ecosystem_works` (
  `ecosystem_feature_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `ecosystem_id` int(11) NOT NULL COMMENT 'Foreign key to map ecosystems',
  `work_id` int(11) NOT NULL COMMENT 'Foreign key to map features',
  `created_at` int(11) NOT NULL COMMENT 'Created Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expert_calendar`
--

CREATE TABLE `expert_calendar` (
  `calendar_id` int(11) NOT NULL COMMENT 'It is act as primary key of expert_calendar',
  `expert_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users(expert)',
  `date` date DEFAULT NULL COMMENT 'Kept date of sessions for expert',
  `start_time` time NOT NULL DEFAULT '00:00:00' COMMENT 'Kept start time of sessions for expert',
  `end_time` time NOT NULL DEFAULT '00:00:00' COMMENT 'Kept end time of sessions for expert',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expert_health_categories`
--

CREATE TABLE `expert_health_categories` (
  `expert_health_id` int(11) NOT NULL COMMENT 'Primary key of the table',
  `expert_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users(expert)',
  `category_id` int(11) NOT NULL COMMENT 'It is a foreign key to map health categories',
  `category_name` varchar(200) NOT NULL COMMENT 'Name of the Category',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expert_qualifications`
--

CREATE TABLE `expert_qualifications` (
  `qualification_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `qualification_name` varchar(200) NOT NULL COMMENT 'Name of Qualification',
  `qualification_image` varchar(300) NOT NULL COMMENT 'Name of the image',
  `expert_id` int(11) NOT NULL COMMENT 'Foreign key to map expert',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expert_qualifications`
--

INSERT INTO `expert_qualifications` (`qualification_id`, `qualification_name`, `qualification_image`, `expert_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'sdfdd', 'https://s3-ap-southeast-1.amazonaws.com/benefits-qa/qualification/qualification9618955941-1.jpg', 1, '2017-01-31 06:20:08', '2017-05-31 06:48:25', NULL),
(7, 'Image 1', 'https://s3-ap-southeast-1.amazonaws.com/benefits-qa/qualification/qualification9618955941-1.jpg', 1, '2017-01-31 06:24:21', '2017-05-31 06:48:31', NULL),
(8, 'sdfdd', '1485843861545.png', 128, '2017-01-31 06:24:21', '0000-00-00 00:00:00', NULL),
(9, 'Image 1', '1486274551344.png', 128, '2017-02-05 06:02:31', '0000-00-00 00:00:00', NULL),
(10, 'sdfdd', '1486274551831.png', 128, '2017-02-05 06:02:31', '0000-00-00 00:00:00', NULL),
(13, 'Image 1', '1486275006298.png', 128, '2017-02-05 06:10:06', '0000-00-00 00:00:00', NULL),
(14, 'sdfdd', '1486275006994.png', 128, '2017-02-05 06:10:06', '0000-00-00 00:00:00', NULL),
(15, 'Image 1', '1486276258695.png', 128, '2017-02-05 06:30:58', '0000-00-00 00:00:00', NULL),
(16, 'sdfdd', '1486276258765.png', 128, '2017-02-05 06:30:58', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `get_helps`
--

CREATE TABLE `get_helps` (
  `help_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `description` varchar(1000) NOT NULL COMMENT 'Description for Help',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `get_helps`
--

INSERT INTO `get_helps` (`help_id`, `user_id`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'I need help', '2016-12-06 09:00:31', '2016-12-06 09:00:31', NULL),
(2, 1, 'I need help', '2016-12-06 09:04:20', '2016-12-06 09:04:20', NULL),
(3, 1, 'I need help', '2016-12-06 09:04:21', '2016-12-06 09:04:21', NULL),
(5, 1, 'I need help', '2016-12-06 09:04:25', '2016-12-06 09:04:25', NULL),
(6, 1, 'I need help', '2016-12-06 09:11:17', '2016-12-06 09:11:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `goal_id` int(11) NOT NULL COMMENT 'Primary Key of the Table',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key to map users',
  `week_number` int(11) NOT NULL COMMENT 'Week Number for Goals',
  `date` date NOT NULL COMMENT 'Any Date of the Week',
  `is_today_steps_achieved` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Keep status of today step count achieved',
  `is_today_gym_visit_achieved` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Keep status of today gym visit achieved',
  `is_today_pt_session_achieved` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Keep status of today PT Session achieved',
  `goal_achieved` int(11) NOT NULL COMMENT 'Number of Goals Achieved in this week',
  `is_weekly_goals_achieved` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Weather user achieved its weekly goal in this week',
  `tier` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Tier of user in this week',
  `health_score` int(11) NOT NULL COMMENT 'Number of point in Current Week',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `goals`
--

INSERT INTO `goals` (`goal_id`, `user_id`, `week_number`, `date`, `is_today_steps_achieved`, `is_today_gym_visit_achieved`, `is_today_pt_session_achieved`, `goal_achieved`, `is_weekly_goals_achieved`, `tier`, `health_score`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(2, 128, 12, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-24 10:18:40', NULL),
(3, 128, 14, '2017-04-06', 0, 0, 0, 3, 0, 1, 2, '2017-04-06 11:19:37', '2017-04-24 10:19:50', NULL),
(5, 2, 15, '2017-04-11', 0, 0, 0, 3, 1, 1, 3, '2017-04-11 06:37:52', '2017-04-11 12:09:59', NULL),
(7, 2, 16, '2017-04-19', 1, 0, 0, 3, 1, 1, 3, '2017-04-18 10:11:19', '2017-04-19 09:58:25', NULL),
(8, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(9, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(10, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(11, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(12, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(13, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(14, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(15, 174, 14, '2017-04-06', 0, 0, 0, 3, 1, 1, 2, '2017-04-06 11:19:37', '2017-04-06 22:48:32', NULL),
(16, 174, 18, '2017-05-02', 0, 0, 0, 3, 0, 1, 2, '2017-04-06 11:19:37', '2017-05-02 15:21:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_activation_codes`
--

CREATE TABLE `master_activation_codes` (
  `code_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `code` varchar(255) NOT NULL COMMENT 'Kept Activation Code',
  `mail` varchar(200) DEFAULT NULL COMMENT 'For which email this code',
  `name` varchar(200) NOT NULL COMMENT 'Name of the Employee',
  `surname` varchar(200) NOT NULL COMMENT 'Surname of the Employee',
  `company` varchar(200) DEFAULT NULL COMMENT 'Company of the related user',
  `department` varchar(200) DEFAULT NULL COMMENT 'Department of the related User',
  `designation` varchar(200) DEFAULT NULL COMMENT 'Designation of the related User',
  `ecosystem_id` int(11) NOT NULL COMMENT 'Foreign Key to Map Ecosystem ',
  `private_type` tinyint(1) NOT NULL DEFAULT '0',
  `expiry_date` date DEFAULT NULL COMMENT 'Expiry Date of Activation Code',
  `status` enum('1','2') NOT NULL COMMENT 'Status of Code(1 - Active , 2 - Inactive)',
  `is_used` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Kept weather used by any user or not',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the Created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the Deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_activation_codes`
--

INSERT INTO `master_activation_codes` (`code_id`, `code`, `mail`, `name`, `surname`, `company`, `department`, `designation`, `ecosystem_id`, `private_type`, `expiry_date`, `status`, `is_used`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, '5O5IPI', 'sandy@gmail.com', '', '', 'App', 'Development', 'engineer', 4, 0, NULL, '1', 0, '2017-03-30 08:53:47', '0000-00-00 00:00:00', NULL),
(11, 'JFWWFS', 'normaluser@yopmail.com', '', '', 'App', 'Development', 'engineer', 1, 0, NULL, '1', 0, '2017-04-06 09:28:08', '0000-00-00 00:00:00', NULL),
(12, 'LBBR9Y', 'normaluserxyz@yopmail.com', '', '', 'App', 'Development', 'engineer', 6, 0, NULL, '1', 0, '2017-04-24 06:39:18', '0000-00-00 00:00:00', NULL),
(13, 'QL8AD2', 'normaluserxyzw@yopmail.com', 'Jack', '', 'App', 'Development', 'engineer', 4, 0, NULL, '1', 0, '2017-05-15 07:00:28', '0000-00-00 00:00:00', NULL),
(14, 'KD7KJP', 'normaluserpqr@yopmail.com', 'Jack', '', 'App', 'Development', 'engineer', 4, 0, NULL, '1', 0, '2017-05-22 06:41:44', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_beacons`
--

CREATE TABLE `master_beacons` (
  `master_beacon_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `beacon_uuid` varchar(100) NOT NULL COMMENT 'Unique Id of Beacon',
  `beacon_major` varchar(100) NOT NULL COMMENT 'Major of Beacon',
  `beacon_minor` varchar(100) NOT NULL COMMENT 'Minor of Beacon',
  `master_gym_id` int(11) NOT NULL COMMENT 'Foreign Key to link Associated Gym',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_beacons`
--

INSERT INTO `master_beacons` (`master_beacon_id`, `beacon_uuid`, `beacon_major`, `beacon_minor`, `master_gym_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'abc', '2213232', '454545', 1, '2017-03-15 13:33:50', '0000-00-00 00:00:00', NULL),
(3, 'abc1', '2213236', '454548', 2, '2017-03-15 13:33:50', '2017-03-16 04:40:22', NULL),
(4, '123', '123', '123', 16, '2017-03-20 07:11:39', '0000-00-00 00:00:00', NULL),
(5, '123', '123456', '123456', 17, '2017-03-20 07:16:56', '2017-03-28 09:58:31', '2017-03-28 09:58:31'),
(6, '111', '111', '111', 18, '2017-03-20 09:11:39', '0000-00-00 00:00:00', NULL),
(7, '111', '111', '111', 19, '2017-03-20 09:44:52', '2017-03-20 09:46:55', '2017-03-20 09:46:55'),
(8, '111', '111', '111', 19, '2017-03-20 09:46:55', '2017-03-20 09:49:24', '2017-03-20 09:49:24'),
(9, '111', '111', '111', 19, '2017-03-20 09:49:24', '2017-03-20 09:59:08', '2017-03-20 09:59:08'),
(10, '111', '111', '111', 19, '2017-03-20 09:59:08', '2017-03-20 10:18:55', '2017-03-20 10:18:55'),
(11, '1112', '1112', '1112', 19, '2017-03-20 09:59:08', '2017-03-20 10:18:55', '2017-03-20 10:18:55'),
(12, '1112', '1112', '1112', 19, '2017-03-20 10:18:55', '2017-03-20 10:42:29', '2017-03-20 10:42:29'),
(13, '1112', '1112', '1112', 19, '2017-03-20 10:42:29', '2017-03-28 09:58:39', '2017-03-28 09:58:39'),
(14, '11121', '11121', '11121', 19, '2017-03-20 10:42:29', '2017-03-28 09:58:39', '2017-03-28 09:58:39'),
(15, '123', '123456', '123456', 17, '2017-03-28 09:58:31', '0000-00-00 00:00:00', NULL),
(16, '11121', '11121', '11121', 19, '2017-03-28 09:58:39', '2017-04-03 16:04:48', '2017-04-03 16:04:48'),
(17, '11121', '11121', '11121', 19, '2017-04-03 16:04:48', '2017-04-03 16:04:59', '2017-04-03 16:04:59'),
(18, '11122', '11122', '11122', 19, '2017-04-03 16:04:48', '2017-04-03 16:04:59', '2017-04-03 16:04:59'),
(19, '11122', '11122', '11122', 19, '2017-04-03 16:04:59', '2017-04-03 16:08:18', '2017-04-03 16:08:18'),
(20, '11122', '11122', '11122', 19, '2017-04-03 16:08:18', '2017-05-15 06:28:01', '2017-05-15 06:28:01'),
(21, '11121', '11121', '11121', 19, '2017-04-03 16:08:18', '2017-05-15 06:28:01', '2017-05-15 06:28:01'),
(22, '11122', '11122', '11122', 19, '2017-05-15 06:28:01', '2017-05-15 06:28:09', '2017-05-15 06:28:09'),
(23, '11121', '11121', '11121', 19, '2017-05-15 06:28:01', '2017-05-15 06:28:09', '2017-05-15 06:28:09'),
(24, '11122', '11122', '11122', 19, '2017-05-15 06:28:09', '0000-00-00 00:00:00', NULL),
(25, '11121', '11121', '11121', 19, '2017-05-15 06:28:09', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_ecosystems`
--

CREATE TABLE `master_ecosystems` (
  `ecosystem_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `ecosystem_name` varchar(200) NOT NULL COMMENT 'Name of the Ecosystem',
  `logo` varchar(500) NOT NULL COMMENT 'Logo of the Ecosystem',
  `number_of_users` int(11) NOT NULL COMMENT 'Number of Users allowed to be in the Ecosystem',
  `expiry_date` date DEFAULT NULL COMMENT 'Expiry Date of Ecosystem',
  `subadmin_user_id` int(11) DEFAULT NULL COMMENT 'User Id of the Sub Admin of the Ecosystem',
  `merchant_code` varchar(6) NOT NULL COMMENT 'Merchant Code For Activity Rewards',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_ecosystems`
--

INSERT INTO `master_ecosystems` (`ecosystem_id`, `ecosystem_name`, `logo`, `number_of_users`, `expiry_date`, `subadmin_user_id`, `merchant_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Ecosystem Local', '99841492513889.png', 4, '2017-05-06', 213, 'HW70VB', '2017-03-24 07:01:08', '2017-05-30 10:02:51', NULL),
(6, 'App', '1491199990984.png', 102, '2017-04-17', 210, 'MMJDWW', '2017-04-03 06:13:10', '2017-04-24 06:15:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_features`
--

CREATE TABLE `master_features` (
  `feature_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `feature_name` varchar(200) NOT NULL COMMENT 'Name of the Feature',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_features`
--

INSERT INTO `master_features` (`feature_id`, `feature_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'White Labeling', '2017-03-29 04:53:05', '0000-00-00 00:00:00', NULL),
(2, 'Activity Rewards', '2017-03-29 04:53:05', '2017-03-29 10:09:13', NULL),
(3, 'Redemption Reward', '2017-03-29 04:53:05', '2017-03-29 10:09:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_gyms`
--

CREATE TABLE `master_gyms` (
  `master_gym_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `gym_name` varchar(100) NOT NULL COMMENT 'Name of Gym',
  `gym_address` varchar(200) NOT NULL COMMENT 'Street Address of Gym',
  `gym_lat` decimal(20,6) NOT NULL COMMENT 'City of Gym',
  `gym_long` decimal(20,6) NOT NULL COMMENT 'State of Gym',
  `zip_code` varchar(100) NOT NULL COMMENT 'Zip code of Gym',
  `gym_mail_id` varchar(100) DEFAULT NULL COMMENT 'Mail Id of Gym',
  `gym_phone` varchar(100) DEFAULT NULL COMMENT 'Phone number of Gym',
  `gym_website` varchar(200) DEFAULT NULL COMMENT 'Website address of Gym',
  `master_work_id` int(11) NOT NULL COMMENT 'Foreign key to map gym group',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_gyms`
--

INSERT INTO `master_gyms` (`master_gym_id`, `gym_name`, `gym_address`, `gym_lat`, `gym_long`, `zip_code`, `gym_mail_id`, `gym_phone`, `gym_website`, `master_work_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gold Gym ', 'Gurgaon', '0.000000', '0.000000', '122001', '', '', '', 2, '2017-03-15 13:33:20', '2017-03-17 17:34:06', NULL),
(2, 'Fitness', 'Gurgaon', '0.000000', '0.000000', '122001', '', '', '', 2, '2017-03-15 13:33:20', '2017-03-17 17:34:10', NULL),
(5, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 3, '2017-03-20 06:44:30', '2017-04-04 05:54:50', NULL),
(6, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 06:49:33', '2017-03-20 06:49:33', NULL),
(7, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 06:52:00', '2017-03-20 06:52:00', NULL),
(8, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 06:55:06', '2017-03-20 06:55:06', NULL),
(9, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 06:57:46', '2017-03-20 06:57:46', NULL),
(10, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 06:58:27', '2017-03-20 06:58:27', NULL),
(11, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 06:58:59', '2017-03-20 06:58:59', NULL),
(12, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 06:59:36', '2017-03-20 06:59:36', NULL),
(13, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 07:00:23', '2017-03-20 07:00:23', NULL),
(14, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 07:00:36', '2017-03-20 07:00:36', NULL),
(15, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 07:04:22', '2017-03-20 07:04:22', NULL),
(16, 'dfgfdg', '6 Cowper Wharf Rd, Woolloomooloo NSW 2011, Australia', '0.000000', '0.000000', '122001', NULL, NULL, NULL, 1, '2017-03-20 07:11:39', '2017-03-20 07:11:39', NULL),
(17, 'Sector 14 Branch', 'Gold''s Gym, Sec 14, Gurugram, Haryana, India', '28.468694', '77.044091', '122001', NULL, NULL, NULL, 4, '2017-03-20 07:16:56', '2017-03-28 09:58:31', NULL),
(18, 'Fitness First', 'Fitness First, New Delhi, Delhi, India', '28.568402', '77.217194', '122001', NULL, NULL, NULL, 1, '2017-03-20 09:11:39', '2017-03-20 09:11:39', NULL),
(19, 'Fitness First @24', 'Fitness First, New Delhi, Delhi, India', '28.568402', '77.217194', '122001', 'jack@yopmail.com', '7532079392', 'www.app.in', 3, '2017-03-20 09:44:52', '2017-05-15 06:28:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_health_categories`
--

CREATE TABLE `master_health_categories` (
  `category_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `name` varchar(255) NOT NULL COMMENT 'Name of the Category',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_health_categories`
--

INSERT INTO `master_health_categories` (`category_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Health2', '2016-11-21 06:38:13', '2017-06-01 05:28:15', '2017-06-01 05:28:15'),
(6, 'Health1', '2016-11-21 06:38:13', '2017-06-01 09:45:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_health_providers_insurances`
--

CREATE TABLE `master_health_providers_insurances` (
  `attribute_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `name` varchar(50) DEFAULT NULL COMMENT 'Name of the Service Provider',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Type of Service Provider(1=Health provider 2=Insurance)',
  `logo` varchar(500) DEFAULT NULL COMMENT 'Logo Image of Service Provider',
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `delivery` tinyint(4) DEFAULT '0' COMMENT 'Delivery Status(0 - No , 1 - Yes )',
  `closing_day` varchar(10) DEFAULT NULL,
  `opening_hrs` varchar(10) DEFAULT NULL,
  `closing_hrs` varchar(10) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `lat` decimal(20,6) DEFAULT '0.000000',
  `lng` decimal(20,6) DEFAULT '0.000000',
  `description` varchar(1000) DEFAULT NULL COMMENT 'About the Service Provider',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_health_providers_insurances`
--

INSERT INTO `master_health_providers_insurances` (`attribute_id`, `name`, `type`, `logo`, `website`, `email`, `delivery`, `closing_day`, `opening_hrs`, `closing_hrs`, `phone`, `address`, `lat`, `lng`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Health Service Providers', 1, '24611492410199.jpeg', 'www.xyz.com', 'abc@gmail.com', 1, '6', '09:00 AM', '02:00 PM', '546646', 'Muzaffarnagar, Uttar Pradesh, India', '29.472682', '77.708509', 'Description of providers goes here...', '2016-12-06 05:26:34', '2017-04-17 06:23:20', NULL),
(2, 'DSSDaaaaa', 2, '1487072867889.png', 'xyz.com', 'abc@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.000000', '0.000000', 'scxa', '2016-12-16 05:20:38', '2017-05-22 04:19:28', NULL),
(3, 'dvfvb', 2, '1487067573414.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000000', '0.000000', 'cdvfvfv', '2017-02-14 04:49:33', '2017-02-14 04:49:33', NULL),
(4, 'DSSDa', 2, '1487071233542.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000000', '0.000000', 'scdcdv', '2017-02-14 05:50:33', '2017-03-16 16:45:20', '0000-00-00 00:00:00'),
(5, 'ghghghgjyjyefgregtre', 2, '1488175780214.png', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '0.000000', '0.000000', '1234567ghrebetnn', '2017-02-27 00:39:40', '2017-02-27 00:40:53', '0000-00-00 00:00:00'),
(6, 'asas', 1, '24941492409784.jpg', 'www.abc.com', 'admin.dev@yopmail.com', 0, '', '12:00 AM', '06:30 AM', '9899651049', 'Nagarro Software, Aricent Ln, Electronic City, Udyog Vihar Phase IV, Sector 18, Gurugram, Haryana 122008, India', '28.499098', '77.069792', 'sasa', '2017-04-17 06:15:38', '2017-05-30 09:26:53', NULL),
(7, 'Jack Jonathan', 2, '97591495426795.jpeg', 'xyz.comm', NULL, 0, NULL, NULL, NULL, NULL, NULL, '0.000000', '0.000000', 'scxa', '2017-05-22 04:19:56', '2017-05-22 02:51:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_issues`
--

CREATE TABLE `master_issues` (
  `issue_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `issue` varchar(500) NOT NULL COMMENT 'Description of Issue Faced',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_issues`
--

INSERT INTO `master_issues` (`issue_id`, `issue`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'App not working properly.', '2016-11-21 04:33:56', '0000-00-00 00:00:00', NULL),
(2, 'App not working properly 1.', '2016-11-21 04:33:56', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_merchants`
--

CREATE TABLE `master_merchants` (
  `master_merchant_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `merchant_name` varchar(200) NOT NULL COMMENT 'Name of the Merchant',
  `merchant_code` varchar(6) NOT NULL COMMENT 'Code of the Merchant',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_merchants`
--

INSERT INTO `master_merchants` (`master_merchant_id`, `merchant_name`, `merchant_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'KFC', '67DFE1', '2017-03-30 10:03:58', '0000-00-00 00:00:00', NULL),
(3, 'Mc Donald', 'NXJRS7', '2017-03-30 10:46:16', '2017-03-30 10:46:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_rewards`
--

CREATE TABLE `master_rewards` (
  `master_reward_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `reward_name` varchar(200) NOT NULL COMMENT 'Name of the reward',
  `reward_description` varchar(700) NOT NULL COMMENT 'Description of the reward',
  `reward_image` varchar(500) NOT NULL COMMENT 'Image of Reward',
  `master_merchant_id` int(11) NOT NULL COMMENT 'Foreign Key to Map Master Merchant',
  `ecosystem_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_rewards`
--

INSERT INTO `master_rewards` (`master_reward_id`, `reward_name`, `reward_description`, `reward_image`, `master_merchant_id`, `ecosystem_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Reward 2', 'Description goes here ...', '1491216682398.png', 1, 3, '2017-04-03 10:51:22', '2017-06-01 03:06:19', '2017-06-01 03:06:19'),
(3, 'Reward 1', 'Description goes here ...', '25431492514172.jpeg', 1, 0, '2017-03-31 11:09:00', '2017-06-01 03:04:39', NULL),
(4, 'Reward 2', 'Description goes here ...', '1491216682398.png', 1, 3, '2017-04-03 10:51:22', '2017-06-01 03:06:49', '2017-06-01 03:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `master_works`
--

CREATE TABLE `master_works` (
  `work_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `work_name` varchar(200) NOT NULL COMMENT 'Name of the Work Place/Gym',
  `logo` varchar(300) NOT NULL COMMENT 'logo of the work',
  `type` tinyint(4) NOT NULL COMMENT 'Type of work (1 - Personal Trainer , 2 - Wellness Professional)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_works`
--

INSERT INTO `master_works` (`work_id`, `work_name`, `logo`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gold Gym Work', '82111492410412.jpeg', 1, '2017-01-31 04:45:13', '2017-05-30 08:56:52', '2017-05-30 08:56:52'),
(2, 'Hospital @24', '11321494829773.jpeg', 2, '2017-01-31 04:45:13', '2017-05-15 06:29:34', NULL),
(3, 'dvdvfrbvfb fbfb', '1487068667785.png', 0, '2017-02-14 05:07:47', '2017-06-08 03:06:01', '2017-06-08 03:06:01'),
(4, 'Gold Gym Work', '1489682752704.png', 2, '2017-03-16 16:45:52', '2017-04-11 09:46:58', NULL),
(5, 'dsvdsvbdbv', '1489910549707.png', 0, '2017-03-19 08:02:29', '2017-03-19 08:02:38', '2017-03-19 08:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications_logs`
--

CREATE TABLE `notifications_logs` (
  `notification_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `sender_user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users as Sender',
  `reciever_user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users as Reciever',
  `type` tinyint(4) DEFAULT NULL COMMENT 'Type of Notification (0 = Get Invite , 1 = Get High Five , 2 = Booked Expert Slot, 3 = Cancel Expert Slot , 4 = Upcoming Booking , 5 = Expert Approved , 6 = Expert Disapproved)',
  `device_token` varchar(500) DEFAULT NULL COMMENT 'Device Token for Push',
  `message` varchar(255) DEFAULT NULL COMMENT 'Message in notification',
  `payload` varchar(500) DEFAULT NULL COMMENT 'Payload of Notification',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Status of Notification(0 = Unread , 1 = read)',
  `invite_id` int(11) DEFAULT NULL COMMENT 'Foreign Key to Map Invite',
  `invite_notification_status` int(11) NOT NULL DEFAULT '0' COMMENT 'Status(0=Pending 1=Accepted 2=Rejected , 3 = Canceled)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications_logs`
--

INSERT INTO `notifications_logs` (`notification_id`, `sender_user_id`, `reciever_user_id`, `type`, `device_token`, `message`, `payload`, `status`, `invite_id`, `invite_notification_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 174, 128, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 1, NULL, 2, '2017-02-12 23:47:06', '2017-02-23 05:46:00', NULL),
(4, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 06:51:40', '2017-02-15 06:51:40', NULL),
(5, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 06:51:52', '2017-02-15 06:51:52', NULL),
(6, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 06:53:07', '2017-02-15 06:53:07', NULL),
(7, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 07:19:40', '2017-02-15 07:19:40', NULL),
(8, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 23:34:36', '2017-02-15 23:34:36', NULL),
(9, 174, 128, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 23:34:59', '2017-02-15 23:34:59', NULL),
(10, 174, 128, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 23:36:05', '2017-02-15 23:36:05', NULL),
(11, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 23:36:05', '2017-02-15 23:36:05', NULL),
(12, 174, 128, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 23:38:29', '2017-02-15 23:38:29', NULL),
(13, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 23:38:29', '2017-02-15 23:38:29', NULL),
(14, 174, 128, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 0, NULL, 0, '2017-02-15 23:42:57', '2017-02-15 23:42:57', NULL),
(15, 174, 185, 0, NULL, '<b>Aroma </b>  sent you a friend request.', NULL, 1, NULL, 0, '2017-02-15 23:42:57', '2017-02-16 03:40:20', NULL),
(16, 174, 185, 0, NULL, '<div style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Aroma </div><div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"> sent you a friend request.</div>', NULL, 0, NULL, 0, '2017-02-17 04:11:35', '2017-02-17 04:11:35', NULL),
(17, 174, 2, 0, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Aroma </span> sent you a friend request.</div>', NULL, 0, 11, 0, '2017-02-22 00:52:35', '2017-02-22 00:52:35', NULL),
(19, 174, 96, 0, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Aroma </span> sent you a friend request.</div>', NULL, 1, 13, 2, '2017-02-22 01:11:05', '2017-02-23 00:00:37', NULL),
(20, 174, 96, 0, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Aroma </span> sent you a friend request.</div>', NULL, 1, 1, 1, '2017-02-23 00:39:26', '2017-03-06 04:39:01', NULL),
(21, 174, 96, 0, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Aroma </span> sent you a friend request.</div>', NULL, 1, 2, 3, '2017-02-23 00:42:28', '2017-02-23 00:43:16', NULL),
(22, 128, 1, 2, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Peter Souz</span> booked your sessions.</div>', NULL, 0, NULL, 0, '2017-03-02 22:30:36', '2017-03-02 22:30:36', NULL),
(23, 128, 1, 2, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Peter Souz</span> booked your sessions.</div>', NULL, 0, NULL, 0, '2017-03-02 22:35:08', '2017-03-02 22:35:08', NULL),
(24, 128, 1, 2, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Peter Souz</span> booked your sessions.</div>', NULL, 0, NULL, 0, '2017-03-02 22:51:04', '2017-03-02 22:51:04', NULL),
(25, 1, 128, 3, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Jack Jonathan</span> canceled a sessions that is also credited in to y', NULL, 0, NULL, 0, '2017-03-02 22:53:37', '2017-03-02 22:53:37', NULL),
(26, 174, 174, 7, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Aroma </span>accepted your invitation</div>', NULL, 0, NULL, 0, '2017-03-06 04:39:01', '2017-03-06 04:39:01', NULL),
(27, 128, 1, 8, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Peter Souz</span> moved your booked session.</div>', NULL, 0, NULL, 0, '2017-03-08 00:44:34', '2017-03-08 00:44:34', NULL),
(28, 128, 1, 8, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Peter Souz</span> moved your booked session.</div>', NULL, 0, NULL, 0, '2017-03-08 00:45:33', '2017-03-08 00:45:33', NULL),
(29, 128, 1, 8, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Peter Souz</span> moved your booked session.</div>', NULL, 0, NULL, 0, '2017-03-08 00:45:58', '2017-03-08 00:45:58', NULL),
(30, 174, 174, 7, NULL, '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);"><span style="font-family:Akkurat;font-size:16px;letter-spacing:1pt;color:rgb(55,58,54);">Aroma </span> accepted your invitation</div>', NULL, 0, NULL, 0, '2017-03-17 04:29:19', '2017-03-17 04:29:19', NULL),
(31, 174, 210, 1, NULL, 'You Recieved a Highfive', NULL, 0, NULL, 0, '2017-05-22 04:50:03', '2017-05-22 04:50:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email Id of User',
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Token to reset Password',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the created date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('test1@yopmail.com', '$2y$10$dk0QX4QJgGeH4XF5.dusdu7yZr5wXp1Pm46CyFckAfWgjCrfDUp.q', '2016-12-18 12:51:20'),
('prashant2@yopmail.com', '$2y$10$CqiILpk/Ua9m7huUWuyyC.eES3GPsvOnYjMUkZi4z4TJ7UQw5G2u6', '2016-12-19 10:04:34'),
('jack@yopmail.com', '1cno98u5ibg8m816aj44e2qh0v3wl35617sxptdyf4kr1z', '2017-01-11 05:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `queue_jobs`
--

CREATE TABLE `queue_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_issues`
--

CREATE TABLE `report_issues` (
  `report_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `issue_id` int(11) NOT NULL COMMENT 'It is a foreign key to map Issue',
  `description` varchar(1000) NOT NULL COMMENT 'Description of Issue',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the Created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the Deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `report_issues`
--

INSERT INTO `report_issues` (`report_id`, `user_id`, `issue_id`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, 1, 'fgfgfgfggggrgg', '2016-11-21 04:34:00', '2016-11-21 04:34:00', NULL),
(4, 1, 1, 'Please solve this as soon as posibble.', '2016-11-21 04:34:50', '2016-11-21 04:34:50', NULL),
(5, 1, 1, 'Please solve this as soon as posibble.', '2016-11-21 04:45:05', '2016-11-21 04:45:05', NULL),
(8, 1, 1, 'Please solve this as soon as posibble.', '2016-11-21 04:47:28', '2016-11-21 04:47:28', NULL),
(9, 174, 2, 'Please solve this as soon as posibble.', '2017-02-13 23:26:31', '2017-02-13 23:26:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `session_prices`
--

CREATE TABLE `session_prices` (
  `session_price_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `expert_id` int(11) NOT NULL COMMENT 'Foreign key to map experts',
  `one_session` float NOT NULL COMMENT 'Cost of One Session',
  `introductory` float NOT NULL COMMENT 'Cost of Introductory Session',
  `ten_session` float NOT NULL COMMENT 'Price of Ten Session',
  `twenty_session` float NOT NULL COMMENT 'Cost of Twenty Sessions',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_prices`
--

INSERT INTO `session_prices` (`session_price_id`, `expert_id`, `one_session`, `introductory`, `ten_session`, `twenty_session`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 213, 1, 100, 0, 400, '2017-01-30 05:59:19', '2017-05-31 04:48:14', NULL),
(4, 1, 1, 100, 0, 400, '2017-01-30 05:59:19', '2017-05-31 05:18:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `type` tinyint(4) NOT NULL COMMENT 'Type of Setting(1=Terms & Conditions 2=Privacy Policy)',
  `description` text NOT NULL COMMENT 'Description of Setting',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `type`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '<p>Coming Soon</p>', '2016-12-26 05:52:27', '2017-04-19 09:20:18', NULL),
(2, 3, '100', '2017-04-19 09:41:06', '2017-04-19 13:25:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `first_name` varchar(50) NOT NULL COMMENT 'First Name of User',
  `last_name` varchar(50) NOT NULL COMMENT 'Last Name of User',
  `bio` text NOT NULL COMMENT 'Description about User',
  `address` varchar(1000) NOT NULL COMMENT 'Address of User',
  `expert_contact_number` varchar(15) NOT NULL COMMENT 'Contact Number of Expert',
  `email` varchar(50) NOT NULL COMMENT 'Email Address of User',
  `password` varchar(500) NOT NULL COMMENT 'Encrypted Password of User',
  `facebook_id` varchar(50) NOT NULL COMMENT 'Facebook Id ',
  `countryCode` varchar(10) NOT NULL COMMENT 'Country Code of User',
  `mobile` varchar(50) NOT NULL COMMENT 'Mobile Number of User',
  `nationality` varchar(255) NOT NULL COMMENT 'Nationality of User',
  `city` varchar(255) NOT NULL COMMENT 'City of User',
  `residence_country` varchar(100) NOT NULL COMMENT 'Name of the Country ',
  `gender` tinyint(4) NOT NULL COMMENT 'Gender of User(1=Male 2=Female)',
  `image` varchar(500) NOT NULL COMMENT 'Image Link of User',
  `expert_image` varchar(300) NOT NULL COMMENT 'Image URL of the Expert',
  `dob` date NOT NULL COMMENT 'Date of Birth of User',
  `activation_type` tinyint(4) DEFAULT NULL COMMENT 'Type of Activation(1=Cooperate 2=Insurance 3=Private)',
  `user_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Type of User(0=None,1=Regular 2=Plus 3=Expert 4=Admin)',
  `member_id` varchar(255) NOT NULL DEFAULT '0' COMMENT 'Member Id of User',
  `current_health_device_id` tinyint(4) NOT NULL COMMENT 'Id of Health Device(1=Fitbit 2=Apple iWatch 3=Google Fit)',
  `activation_code` varchar(255) NOT NULL COMMENT 'Activation Code of User',
  `activation_start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Activation Start Date ',
  `activation_expiry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Activation End Date ',
  `language` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Language of User(1=English 2=Arabic)',
  `latitude` decimal(20,6) NOT NULL DEFAULT '0.000000' COMMENT 'User''s Latitude',
  `longitude` decimal(20,6) NOT NULL DEFAULT '0.000000' COMMENT 'User''s Longitude',
  `reward_point` int(11) NOT NULL DEFAULT '0' COMMENT 'Rewards Points of user',
  `level_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Level of User(0=Blue 1=Silver 2=Gold)',
  `expert_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Type of Expert(0=Not Expert 1=Personal Trainer 2=Health Professional)',
  `vitality_age` int(11) NOT NULL DEFAULT '0' COMMENT 'Wellness Age of the User',
  `is_interested_for_expert` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Weather interested to become expert(0 = Not Interested, 1 = Interested , 2 = Expert Confirmation , 3 = Declined)',
  `working_location` varchar(500) NOT NULL COMMENT 'Working Location',
  `working_location_lat` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `working_location_long` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `working_speciality` varchar(1000) NOT NULL COMMENT 'Working Speciality',
  `work_id` int(11) DEFAULT NULL COMMENT 'Foreign Key to Master Work Table',
  `work_name` varchar(100) DEFAULT NULL COMMENT 'Name of Work',
  `website` varchar(500) NOT NULL COMMENT 'Website of the User',
  `certificate_validity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Validity of Certificate',
  `temp_password` varchar(500) NOT NULL COMMENT 'Temporary Password of User',
  `forget_password_count` int(11) NOT NULL DEFAULT '0' COMMENT 'Count for Forgot Password ',
  `wrong_signin_count` int(11) NOT NULL DEFAULT '0' COMMENT 'Count for Sign In Attempts',
  `wrong_signin_datetime` datetime DEFAULT NULL COMMENT 'Date time of last Sign In Attempt',
  `is_password_changed` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Weather Password Changed or not',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Account Verification Status(0=Not Verified 1=Verified)',
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Account Status(0=Not Blocked 1=Blocked)',
  `is_profile_completed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Weather Profile is completed or not ',
  `wellness_age_answers` text NOT NULL COMMENT 'Wellness age answers',
  `current_tier` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - Blue , 2 - Silver , 3 - Gold',
  `tier_start_week` int(11) DEFAULT NULL,
  `tier_start_year` int(11) DEFAULT NULL,
  `email_verify_token` varchar(500) NOT NULL COMMENT 'Token to verify email',
  `ecosystem_id` int(11) DEFAULT NULL COMMENT 'Foreign key to map ecosystem of User',
  `ecosystem_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '''1''=>Activated, ''0''=>Deactivated',
  `unique_bar_code` varchar(20) DEFAULT NULL COMMENT 'Unique Bar Code of the User',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time',
  `remember_token` varchar(500) NOT NULL DEFAULT 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `bio`, `address`, `expert_contact_number`, `email`, `password`, `facebook_id`, `countryCode`, `mobile`, `nationality`, `city`, `residence_country`, `gender`, `image`, `expert_image`, `dob`, `activation_type`, `user_type`, `member_id`, `current_health_device_id`, `activation_code`, `activation_start_date`, `activation_expiry_date`, `language`, `latitude`, `longitude`, `reward_point`, `level_id`, `expert_type`, `vitality_age`, `is_interested_for_expert`, `working_location`, `working_location_lat`, `working_location_long`, `working_speciality`, `work_id`, `work_name`, `website`, `certificate_validity`, `temp_password`, `forget_password_count`, `wrong_signin_count`, `wrong_signin_datetime`, `is_password_changed`, `is_verified`, `is_blocked`, `is_profile_completed`, `wellness_age_answers`, `current_tier`, `tier_start_week`, `tier_start_year`, `email_verify_token`, `ecosystem_id`, `ecosystem_status`, `unique_bar_code`, `created_at`, `updated_at`, `deleted_at`, `remember_token`) VALUES
(1, 'Jack', 'Jonathan', '', '', '7532079456', 'jack@yopmail.com', '$2y$10$0piVYEoI/.7VqvVPFKooEebHqsYuuTS8fw/hkUBS5RFR9nt59Z4Sm', '', '91', '7532079456', 'Indian', 'gurgaon', 'india', 2, '', '', '1989-03-27', 1, 1, '0', 1, 'ABDC', '2016-11-07 04:31:16', '0000-00-00 00:00:00', 1, '28.459500', '77.026600', 0, 0, 1, 25, 2, 'Dubai - United Arab Emirates', '28.633979', '74.872264', '', 1, '', 'http://yahoo.com', '0000-00-00 00:00:00', '', 0, 0, NULL, 0, 1, 0, 0, 'a:10:{s:6:"gender";s:1:"F";s:3:"age";s:2:"25";s:6:"height";s:3:"180";s:6:"weight";s:2:"79";s:15:"cigrattesPerDay";s:2:"10";s:19:"exerciseHourPerWeek";s:1:"0";s:17:"exerciseIntensity";s:1:"1";s:11:"eatingHabit";s:1:"5";s:12:"bloodPresure";s:1:"2";s:11:"stressLevel";s:1:"4";}', 3, NULL, NULL, '', 6, 1, '856944699931', '2016-11-06 23:01:16', '2017-04-21 10:09:54', NULL, 'e396rK3posf0U6TnYjLGBQ80wU3vE7TlOipWgHcgg0qdo31cwxDnEeaZlCEp'),
(2, 'Sandeep', 'Gupta', '', '', '', 'sandeep1@gmail.com', '$2y$10$E0tBT0J9HWzxUeQe6Gxp9umiy9LB6z3vvb1e3aeXLT59HiW6la5TK', 'efferfer233434', '0', '', '', '', '', 2, '42921492575461.png', '', '0000-00-00', 1, 2, '0', 1, '', '2016-11-07 04:35:02', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 900, 0, 2, 0, 2, 'Gurgaon', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 0, 1, 0, 0, '', 1, 14, 2017, 'fhz93uw4gxsye9m14inc2a6k5882j68t7bd901qv2orl6p', 4, 1, NULL, '2016-11-06 23:05:02', '2017-05-31 05:41:04', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(95, 'Benefit', 'Admin', '', '', '', 'admin.dev@yopmail.com', '$2y$10$e9/0ctxdzw6nyzID9niZ4uwcc4jpK.1tzRzdBQSF1C.s8PA4bohBe', '', '0', '', '', '', '', 0, '', '', '0000-00-00', NULL, 4, '0', 0, '', '2016-12-05 10:43:11', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 0, 0, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-05 10:43:11', '2017-06-05 05:24:50', NULL, 'GgnLGTjtKO5LmBBOWLdhwlvyJEvulUORkk02mEHHz2ZkXzkdKT9azcV0AOvO'),
(96, 'prit', '', '', '', '', 'pritam.tanwar@app.in', '$2y$10$Arw8ahnFr7LOOvqBykqw9OYC.7vkRcNClREQWtAhUeJPGOBZ90VYy', '', '0', '', 'Indian', 'abu dhabi', '', 1, '1480937356511.jpg', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-05 11:28:43', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, -11, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, 'a:10:{s:3:"age";s:3:"-21";s:12:"bloodPresure";s:1:"2";s:15:"cigrattesPerDay";s:2:"10";s:11:"eatingHabit";s:1:"3";s:19:"exerciseHourPerWeek";s:1:"0";s:17:"exerciseIntensity";s:1:"0";s:6:"gender";s:1:"M";s:6:"height";s:3:"179";s:11:"stressLevel";s:1:"6";s:6:"weight";s:2:"90";}', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-05 11:28:43', '2017-02-07 06:34:55', '2016-12-07 06:39:31', 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(97, 'Ashish', '', '', '', '', 'ihan.jain@app.in', '$2y$10$Pv1drkiaWPwd0jqwe1wStOae/79Uj9Q2x0qwllfPiGqWlWhueufHC', '', '0', '', 'Antiguans', 'fufufuf', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-06 05:41:08', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 3546, 1, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 1, 0, NULL, 1, 1, 0, 1, 'a:10:{s:3:"age";s:2:"-1";s:12:"bloodPresure";s:1:"0";s:15:"cigrattesPerDay";s:1:"0";s:11:"eatingHabit";s:1:"0";s:19:"exerciseHourPerWeek";s:1:"0";s:17:"exerciseIntensity";s:1:"0";s:6:"gender";s:1:"M";s:6:"height";s:3:"121";s:11:"stressLevel";s:4:"3538";s:6:"weight";s:1:"0";}', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-06 05:41:08', '2017-06-06 06:13:42', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(98, 'sbahjask', '', '', '', '', 'ankita.chopra@app.in', '$2y$10$x70cjVOoZbzl8k2sbEpgFe8ITNMkEmwRqdsqxjJzJp/MhDSyfwA/y', '', '0', '', 'Argentinean', 'zjsjzj', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-06 05:51:51', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 36, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, 'a:10:{s:3:"age";s:1:"3";s:12:"bloodPresure";s:1:"0";s:15:"cigrattesPerDay";s:1:"0";s:11:"eatingHabit";s:1:"0";s:19:"exerciseHourPerWeek";s:1:"0";s:17:"exerciseIntensity";s:1:"0";s:6:"gender";s:1:"M";s:6:"height";s:3:"242";s:11:"stressLevel";s:1:"1";s:6:"weight";s:3:"249";}', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-06 05:51:51', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(99, 'mohini goyal', '', '', '', '', 'a@yopmail.com', '$2y$10$dnqE2/JAF2xiBvzvVWHnD.UCRU3/A.p7hF/k1nYr5TlavCO3Fknxa', '', '0', '', 'Australian', 'tuututut', '', 2, '1481018140956.jpg', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-06 09:53:17', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, -3, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 1, 'a:10:{s:3:"age";s:2:"-1";s:12:"bloodPresure";s:1:"4";s:15:"cigrattesPerDay";s:1:"1";s:11:"eatingHabit";s:1:"4";s:19:"exerciseHourPerWeek";s:1:"1";s:17:"exerciseIntensity";s:1:"3";s:6:"gender";s:1:"M";s:6:"height";s:3:"121";s:11:"stressLevel";s:21:"000000000000000000000";s:6:"weight";s:1:"0";}', 1, NULL, NULL, '471lmdjvioa0g5rqe6xth1189syz0278u1p9wnb7943kcf', NULL, 1, NULL, '2016-12-06 09:53:17', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(100, '', '', '', '', '', 'ash5@yopmail.com', '$2y$10$w5WsDC4atQLRHg5IsfD0ReKtDjsDV5FuLUzdkUFvJ.anlBhlPtg/u', '', '0', '', '', '', '', 1, '1481020193473.jpg', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-06 10:25:21', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 2, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-06 10:25:21', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(101, 'prit', '', '', '', '', 'pritam.appster@gmail.com', '$2y$10$nKYT116g7oUIafRQ6acv9eeEIlb1fP/TN02eSo/eWUY1.BU.8c1H2', '', '0', '', 'Indian', 'abu dhabi', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-06 10:30:26', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 9, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 1, 'a:10:{s:3:"age";s:2:"-1";s:12:"bloodPresure";s:1:"0";s:15:"cigrattesPerDay";s:1:"0";s:11:"eatingHabit";s:1:"0";s:19:"exerciseHourPerWeek";s:1:"0";s:17:"exerciseIntensity";s:1:"0";s:6:"gender";s:1:"M";s:6:"height";s:3:"121";s:11:"stressLevel";s:1:"1";s:6:"weight";s:1:"0";}', 1, NULL, NULL, '1sowc00rbdnikpgy14l3661222jqz4h85uex8f9tv0m27a', NULL, 1, NULL, '2016-12-06 10:30:26', '2017-02-07 06:34:55', '2016-12-07 06:43:43', 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(102, '', '', '', '', '', 'ash6@yopmail.com', '$2y$10$JSIMwI0sacRJ8H1mhPsXl.OsKjN9gFufFxxKKA/XqyfFZrb2GCYRG', '', '0', '', '', '', '', 1, '1481027899546.jpg', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-06 12:35:53', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 2, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'z7a3d7f7p150ec3nsx24igly2oj11rh60tbm89quv54wk8', NULL, 1, NULL, '2016-12-06 12:35:53', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(103, 'Joe Marsh', '', '', '', '', '', '$2y$10$V6stkoIs26QQT21Nh8BTF.KiMgaAsNlVkbEsJX2O3N8J8JdtkIdQK', '360916797586539', '0', '', 'Indian', 'shjsjs', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-06 13:24:48', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, 'q1lp5kw6er4vt0i04j91c82mg0o3afu6n8z7y8x1s8d3hb', NULL, 1, NULL, '2016-12-06 13:24:48', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(104, 'Ashish', 'Kumar', '', '', '', 'ash7@yopmail.com', '$2y$10$3LYElUPjGt5H1aDwKj7G/eO/l3.k78aGxLIKU3wW.WHKcVbfVsyA.', '', '0', '', 'American', 'dubai', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-07 04:40:06', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-07 04:40:06', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(105, 'Ash', 'Kum', '', '', '', 'ash8@yopmail.com', '$2y$10$PP5G641o28bBsTlRG33atu8ZJH0m9TuweNdNcKIxtqBbOMj8KDQUK', '', '0', '', 'Colombian', 'Ajdjfnc', '', 2, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-07 05:13:13', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 4, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-07 05:13:13', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(106, '', '', '', '', '', '123@yopmail.com', '$2y$10$XvdiO2Uajo/ZVNhpdtKPFe6TgXZa2MNXe0guuMw/nGedaAk406oiK', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-07 05:55:19', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'w18101fmpq17l3028bd9crh41kvu9yn6ztx9j0e4g5saio', NULL, 1, NULL, '2016-12-07 05:55:19', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(107, '', '', '', '', '', 'g@g.com', '$2y$10$GdPWcLuXBF0kWUydsdnBJ.soLL9Gr55n9CjD5uWaIX3CrXSQcG6fy', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-07 05:58:09', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '1btwe01qv0rfhyk28xi7zpla49o82n643md91s0j8c9gu5', NULL, 1, NULL, '2016-12-07 05:58:09', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(108, 'pritam', '', '', '', '', 'appsterqa8@gmail.com', '$2y$10$inp1/SxoTNXhMqRYEDsQYuvYKagySu9OjYpzJfD4M0LemN9h/DVUe', '', '0', '', 'Indian', 'gurgaon', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-07 06:49:07', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 1, '', 1, NULL, NULL, 'py0j5nqs39931r80xb467m8avkf7g3142h14otulzewidc', NULL, 1, NULL, '2016-12-07 06:49:07', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(109, '', '', '', '', '', 'a@a.com', '$2y$10$N3/oU/7nSRPTN9FrQV35o.n3nnX9T275k9zSSsrEZP2f5y7QYWKze', '', '0', '', '', '', '', 1, '1481093995892.jpg', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-07 06:52:43', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'vu1g5i8t93o0a3762r3q9yc6dsfknmzbx84hjlwp0154e1', NULL, 1, NULL, '2016-12-07 06:52:43', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(110, 'prit', '', '', '', '', 'appsterqa9@gmail.com', '$2y$10$0qLCLZYEBeBxfQ2zxKlX2e4Uy0B0IpYgVfAVxrL.gaAQqZtuofqbi', '', '0', '', 'Indian', 'gurgaon', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-07 08:08:05', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-07 08:08:05', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(111, '', '', '', '', '', 'ashakhsa@yjshs.com', '$2y$10$EdnfdlX7VcUrTNSz5n5qCuQD9NeA2MJKCpPIecqojZGFpUPAmbT8O', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-07 08:32:35', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'n1ujq6mgh8rlcy5a5b310opz5w08d99549e2f1x7k4sitv', NULL, 1, NULL, '2016-12-07 08:32:35', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(112, '', '', '', '', '', 'rest1abc@app.in', '$2y$10$23NJ4Bxs4xpF4cEJzig1huy35s8RofXK.xTk0bhjvE1Fe4k8o9jw6', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:21:13', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'e44hdj3m19t12127zw0p8n1xcau4i38krloq7gfb6syv50', NULL, 1, NULL, '2016-12-07 09:21:13', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(113, '', '', '', '', '', 'rest2abc@app.in', '$2y$10$b3jo2vBAkTRsIfrecOYmkeN5HZtu8f1hr3mncsHGJA77FTiqJEnyK', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:24:16', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '51h2e5j6lzt08sp4cdkgn6yv1b8mao1q79irx10fw6u423', NULL, 1, NULL, '2016-12-07 09:24:16', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(114, '', '', '', '', '', 'rest3abc@app.in', '$2y$10$DHOmZ71goI/OGpeWMZzUdOBTy4XJZYAbubXT6OatFLJiLANt3q6PC', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:24:35', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '8422811763rfvmtns4b51cypkhl7i0qxad5gu1jz06wo9e', NULL, 1, NULL, '2016-12-07 09:24:35', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(115, '', '', '', '', '', 'rest4abc@app.in', '$2y$10$hyXv1v7Yd0.V98EQo2dN2OFIOPk/SMOFMP0hLMySE/G//axyJcAXm', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:25:06', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'm7ny19p8lf860oskua2740jw11hr350t2dzcxgv6beq14i', NULL, 1, NULL, '2016-12-07 09:25:06', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(116, '', '', '', '', '', 'rest5abc@app.in', '$2y$10$HvW0yhZienveIMXTC2RNqeFYJJxjjPaEkpWCwFEmnBZ1UHaDJd8zi', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:26:07', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'z4v968t682crlsik371ay77bpm4u12x51jefo01wq0hngd', NULL, 1, NULL, '2016-12-07 09:26:07', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(117, '', '', '', '', '', 'rest6abc@app.in', '$2y$10$52E74gmzGTHDXJ6H.dw5buQO06NWhcqNLKvkdt1.II93nIg8oSElO', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:27:07', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'gpsul4ne1f3aty46wr52x0i2h821877m810vbdo1qz9kcj', NULL, 1, NULL, '2016-12-07 09:27:07', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(118, '', '', '', '', '', 'rest7abc@app.in', '$2y$10$Ycm7fNunhCq2noJrMXZ8c.ttxAq2cYSseqXHzE1JG5le9mP6k.Uhy', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:29:04', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '641ecvq2nki3o18ux4ta485y1h04zb1s7gprmj029lwf9d', NULL, 1, NULL, '2016-12-07 09:29:04', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(119, '', '', '', '', '', 'rest8abc@app.in', '$2y$10$FZ86wk9nUyz.CxyOJXNGYO3FSvrBKsoHqBaERu5gN8PO6drbDBFNS', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:31:08', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'fv68hj5il11kcxm0ws83utyo74gz02n03rbe86dq1pa149', NULL, 1, NULL, '2016-12-07 09:31:08', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(120, '', '', '', '', '', 'rest9abc@app.in', '$2y$10$u/OZDuUGSbs62TrSfghvde.W4pJ2ciR58qU7Wl93NqlLHstBG2TMy', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '654321', '2016-12-07 09:35:57', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '7xy051034uq6m41h2o3deiafgcpl7158b1nzj8wks9rvt3', NULL, 1, NULL, '2016-12-07 09:35:57', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(121, '', '', '', '', '', 'sandeep3@yopmail.com', '$2y$10$6MBgV17kh5z1klkeUwQ./.dbuYWd0stW9tyLR80yYcf3OZO8wX6mK', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-07 18:12:24', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '3wjxz389c4ovuir4n411b0fytl68qem41dhag752k3p14s', NULL, 1, NULL, '2016-12-07 18:12:24', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(122, 'Prashant', 'Gautam', '', '', '', 'prashant@yopmail.com', '$2y$10$o0cVCL5gbkc63mfv8uNkPuLu.MyPuAA3Cx6Z9eCLr3x1DWVDWAdWS', '', '971', '(2) 587 4632', 'India', 'Abcd', '', 1, '', '', '1988-01-10', 1, 2, '0', 1, '123456', '2016-12-08 03:13:20', '0000-00-00 00:00:00', 0, '91.000000', '91.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-08 03:13:20', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(123, '', '', '', '', '', 'ash9@yopmail.com', '$2y$10$cnL.Zr5ZA996yg1twxztaeM7pG31hf4i4Acmbf2Erahbf/cqgpyRm', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-08 05:46:23', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 1, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-08 05:46:23', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(124, '', '', '', '', '', 'ash10@yopmail.com', '$2y$10$PKZAlia/807jBVM0dlIoa.Uiak0/GkW/qrkE2kTSayiujJe0KrmYu', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-08 07:16:47', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'aivkq0518ru4h36sc2f10j7peb9w4mznd87yxo1g114l8t', NULL, 1, NULL, '2016-12-08 07:16:47', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(125, '', '', '', '', '', 'rest10abc@app.in', '$2y$10$EHh.takgKritCpIfr85Fiu6IvtJ4BT0rXnyCVTUSa5ZbmJY8qbFvC', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 09:31:16', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '1joex0h18p7g141vqlyn56a8sct9bwik39zr4647umf2d8', NULL, 1, NULL, '2016-12-08 09:31:16', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(126, '', '', '', '', '', 'prashant1@yopmail.com', '$2y$10$ksdDioeiVPQSPFTACn3J7eugyP0JGMNj1W2jzbCoVhw8oCgW7tsM.', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 09:32:59', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'ubpa6g1h5891loy8z0vx9n47q578de341frwt21kcjm9is', NULL, 1, NULL, '2016-12-08 09:32:59', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(127, '', '', '', '', '', 'rest11abc@app.in', '$2y$10$4giQDrIaPZdQGldjOcnqYuKvUofJWeAZo4jvfEqZcSK.4HeTBp7Wq', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 09:39:57', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'uc1j492bl3o1parwx5vm88z869e1qknsdiy499thf0177g', NULL, 1, NULL, '2016-12-08 09:39:57', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(128, 'Prashant', 'Gautam', 'dcvdv', 'Address', '7532079456', 'jack@yopmail.com', '$2y$10$sHgsGuPQBwaU9zJCkHfYnugLMk2Xu4PLwXW1cunlDmjyr92lppUxO', '5546344556654545', '91', '7532079456', 'Indian', 'gurgaon', 'india', 1, '1488868972889.png', '', '1989-03-27', 1, 3, '0', 1, 'ABDC', '2016-12-08 09:47:20', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 200, 0, 1, 35, 0, 'Dubai - United Arab Emirates', '28.613900', '77.209000', '', 1, 'Hello', 'http://yahoo.com', '0000-00-00 00:00:00', '', 0, 1, NULL, 1, 1, 0, 1, '{"gender":"F","dob":"1991-01-01","height":"61","heightUnit":"1","weight":"30","weightUnit":"1","cigrattesPerDay":"20","exerciseHourPerWeek":"0","exerciseIntensity":"1","eatingHabit":"1","bloodPresure":"2","stressLevel":"10","sleepHour":"1","happiness":"4","diabetes":"2"}', 1, 5, 2017, '20yghqkps43cv1dx6i41ut9e441mbfr8lz0o80aj7w15n9', NULL, 1, NULL, '2016-12-08 09:47:20', '2017-04-05 05:27:29', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(129, '', '', '', '', '', 'rest12abc@app.in', '$2y$10$3Gyy7EsAGjD3jYxcAYl5lOU5xHu1DJ/nHpYfgPI9so.pq0Fd/kVCG', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 09:48:27', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'w8bnqm1144i3925ge75f9rxlcv16ps0utzhjya8d001ok7', NULL, 1, NULL, '2016-12-08 09:48:27', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(130, '', '', '', '', '', 'jack5@yopmail.com', '$2y$10$fPS6q8TeK75xKq9yYn9kSOLDOuWnq5Ozb8SuFFUVEzl8AKa3tS2Na', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 1, '0', 1, '', '2016-12-08 09:52:49', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '73b807198zaxfk9getiunl05svqphm946w46r2od1j1cy1', NULL, 1, NULL, '2016-12-08 09:52:49', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(131, '', '', '', '', '', 'rest13abc@app.in', '$2y$10$rWfaAc1EYPl2QUfzYjYp1uhxMR2NOBZJuQznligzVFqP7RqrDIO5G', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 09:58:29', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'jvq5ygd41x19sz11r0301ulp8h9k9atbfo6m12w74ine8c', NULL, 1, NULL, '2016-12-08 09:58:29', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(132, '', '', '', '', '', 'rest14abc@app.in', '$2y$10$5Tsowvlwpa1vVixljmRFZeP6LcY2xL.kpjdcsbShhSs/KxfX2ztbC', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 10:04:21', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '16kcga81vl9wq948r1d74zhu2fyximt65nj1o031sbe41p', NULL, 1, NULL, '2016-12-08 10:04:21', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(133, '', '', '', '', '', 'rest15abc@app.in', '$2y$10$UkZfeB3FDsL503meAYeUfObMBuVGmpLhPFTxxhubLY2Fg7hGt.je6', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 10:06:42', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'r616u187f5oh1ljmxzeg9iktbd0494w8yspn302cqa112v', NULL, 1, NULL, '2016-12-08 10:06:42', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(134, '', '', '', '', '', 'rest16abc@app.in', '$2y$10$4aTjuW4NkJJ3wfw0Q6dXJ.yZtpuP26LEUVdnyVvVVNGQ8v/WEdzBK', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 10:11:05', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '48175f9tvsn1zk268ely1483cqap0duixowbhg11rjm569', NULL, 1, NULL, '2016-12-08 10:11:05', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(135, '', '', '', '', '', 'rest17abc@app.in', '$2y$10$Bmy/onigq6q31VTm2zcyC.8iMK.1DLVqg12qUHtHz9R//Y0EYXoSO', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 10:14:56', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'vsqz3b40w2cueo89k11yf9760n6xd41pmr1i5gj8at29hl', NULL, 1, NULL, '2016-12-08 10:14:56', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(136, '', '', '', '', '', 'rest18abc@app.in', '$2y$10$wVgzmZff6dey87C4h8Qb5uYf8ONI5skOsvdJHiFHRTs8406AtExo.', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 10:15:19', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'c39afli1oje811411w24r1t9vdqk6g0ybuzp2m5xn8s79h', NULL, 1, NULL, '2016-12-08 10:15:19', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(137, '', '', '', '', '', 'rest19abc@app.in', '$2y$10$7w5Kdqs/vqsIT42Whuc3AujylicB25XjCyc3DXTsCruT5/t9Bdn2C', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-08 10:21:01', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'jk4f1qtd36881ima541o64c17pu2zg19e0rh2ylwsxnbv9', NULL, 1, NULL, '2016-12-08 10:21:01', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(138, '', '', '', '', '', 'tanwarpritam21@gmail.com', '$2y$10$a8jokOMaqpQj1lfI0KTee.HCzSg8bHrdGExZiDzcZ8UeIG1XQmXVq', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 2, 2, '0', 1, '123456', '2016-12-08 10:55:07', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '853ef94as7v00b2ryj11nogq4pu151mkzlx78thc46dw9i', NULL, 1, NULL, '2016-12-08 10:55:07', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(139, 'Prashant', 'Gautam', '', '', '', 'prashant2@yopmail.com', '$2y$10$BNkQTAkzyp6.0.ReEVUyZOUQ4w/OxdISlSFjBmiLWF.pS1..Jp0oy', '', '971', '9854558965', 'Indian', 'Abu Dhabi', '', 1, '1482128146247.png', '', '1988-01-10', 1, 2, '0', 1, '123456', '2016-12-08 11:03:36', '0000-00-00 00:00:00', 0, '91.000000', '91.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 1, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-08 11:03:36', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(140, '', '', '', '', '', 'ash11@yjshs.com', '$2y$10$p6NmSee6OtPQqRGqmJMRqei1CvtjSJ2g5JxEnnvN5BKruTTqme4NW', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-09 08:26:10', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '0bp3fv8germiy1916klj77o54zqx7d1n2tu8hsc4192a0w', NULL, 1, NULL, '2016-12-09 08:26:10', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(141, 'Prashant', 'Gautam', '', '', '', 'prashant3@yopmail.com', '$2y$10$2SK/7i3UyASF8ft3/jgXM.Nlzr0d5Zpvs0qzYSYBCsbCGyWWhtfvS', '', '971', '(2) 541 3698', 'India', 'Dubai', '', 1, '1481273021116.png', '', '1998-01-10', 1, 2, '0', 1, '123456', '2016-12-09 08:41:24', '0000-00-00 00:00:00', 0, '91.000000', '91.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-09 08:41:24', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(142, '', '', '', '', '', 'rest21abc@app.in', '$2y$10$AAkKhhdThrI38m1aWPNQyeOZYWS0Nw/UXgqkL43PaMlPA/dTweWh6', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-09 08:44:19', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '0sr3cidnoa191pe28l74mzb2hu1f7vyt5w93g0j856kqx4', NULL, 1, NULL, '2016-12-09 08:44:19', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(143, '', '', '', '', '', 'rest21abc@kapp.in', '$2y$10$mp9ES6soPeJvzgws6B9RGeBB5PoeC39K7yIOeDvA2/QvepDS4I2Ia', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-09 08:44:41', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '8yhd8n123jqe3i4700tr1wf59vsap7bo4x6m118kczl2ug', NULL, 1, NULL, '2016-12-09 08:44:41', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(144, '', '', '', '', '', 'ash12@yopmail.com', '$2y$10$edaIDFG1v5tr9X5DgKT/qeKwbzfPkerW6s62.7hcH0iWJR.Si9biC', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-09 10:08:17', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '97oluvdeanm8j9w6zp05ti40g3rkq12bc8h8172f1sx74y', NULL, 1, NULL, '2016-12-09 10:08:17', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(146, '', '', '', '', '', 'abc@zxx.com', '$2y$10$s20XbhQd74r6B2vlWHK/4OAnyfQkqtf5DRlMIDSkHhAXvN4.ZBJGq', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-13 08:54:32', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '6gtuj76y401k9d8h9o28iepnv53417clw1mrzfxq12b2sa', NULL, 1, NULL, '2016-12-13 08:54:32', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(147, '', '', '', '', '', 'ankitac862@gmail.com', '$2y$10$4TWZ6pwcttouGXnHcgAtlen3ZAAlxbPVredo6RCWfaWNh8LtDtk2q', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-13 08:55:11', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-13 08:55:11', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(149, 'Ashish', 'Kumar', '', '', '', 'aditya.arya143@gmail.com', '$2y$10$Hh4LIl2vEKkHZhJnP7hFV.dW.rOYoC.5Vk6LlPUIn1UsBnySClgZe', '1210864025645558', '0', '', 'Argentinean', 'Zgdhhdh', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-13 10:53:39', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-13 10:53:39', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(150, '', '', '', '', '', 'ash11@yopmail.com', '$2y$10$38Q7he54cqC.cVS.aDvkEumzlsmlWlR4xp06i.jsOk6O0eOTuwQFe', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-13 11:04:43', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '14m43kbth019jf15w6vxg8z7p2i326ysou8adqn7ec80lr', NULL, 1, NULL, '2016-12-13 11:04:43', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(151, '', '', '', '', '', 'prashant4@yopmail.com', '$2y$10$8Az.2lWrnkuKxNAUbfDMku6jFTwdUr.4q.bIbafqo9geEc6bFvLWG', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-14 08:34:06', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-14 08:34:06', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(152, '', '', '', '', '', '12355@yopmail.com', '$2y$10$PWITYISVTgfF47PMbRHnf.3Xfnif/mroPl/caZLVoejlAryoKIqAG', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 1, '0', 1, '', '2016-12-14 09:01:26', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '41y06z50qef781x86983kni0sadjtg4rob2pmv71u6hwlc', NULL, 1, NULL, '2016-12-14 09:01:26', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(153, '', '', '', '', '', 'dd@yopmail.com', '$2y$10$4iDadadUT1s6W9mELh0dYuYsqc/yAx7hxa9.cWDDvGIWa1Li7UMna', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 1, '0', 1, '', '2016-12-14 09:33:05', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'gua085mjhws28pbry7c6l1ti1f5v8ed1397qz4n7x09ok4', NULL, 1, NULL, '2016-12-14 09:33:05', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(154, '', '', '', '', '', 'ash11ddhdh@yjshs.com', '$2y$10$G8uq3J7ZKA0r.1U9c00HOej9.hOKv.thvg9RMGL4mgd6jmHaEOT0y', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-14 09:57:40', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '0w5lcin4a3o269mb8f7z9s1gdx7h0v4k816te1p40jrquy', NULL, 1, NULL, '2016-12-14 09:57:40', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(155, '', '', '', '', '', 'dd2@yopmail.com', '$2y$10$0Ijqzf73xZu.WE0XOVSfsO849c2hipCpXWzoM7l3wOBXF5iEGZMTe', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-14 10:03:58', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'mtsh8z10glkno488e0b97y2fxrj7u8i1d3pc61wa9345qv', NULL, 1, NULL, '2016-12-14 10:03:58', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(156, '', '', '', '', '', 'dfdsf@yopmail.com', '$2y$10$48RLuHAFvrwlI6OfpAx.E.JxgOb7NqmLS.g4Bk.5x1.LTpzLBBLPu', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-14 10:13:56', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'k6fqm8ytg378sczj2lp14r00xiuvbn4941h5a716w1oed3', NULL, 1, NULL, '2016-12-14 10:13:56', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(157, '', '', '', '', '', '000@yopmail.com', '$2y$10$vbTMo5MoXLoPBWbIBzRlq.YVJsuWrO2PxH/AiNycHU1MAPZjM9.Ta', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-14 10:19:52', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '18q174wmls2tik697cf59g21e1n30by8jdxuropa4h70zv', NULL, 1, NULL, '2016-12-14 10:19:52', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(158, '', '', '', '', '', '', '$2y$10$mKNy05Mcf7EFv/ilx0a/m.1qjGibWZBfslaGC7QTwdfwR0mD2H5cy', '1742442752742317', '0', '', '', '', '', 1, '', '', '0000-00-00', 2, 2, '0', 1, '123456', '2016-12-14 10:58:32', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'fhar6wc21i4myn25b3d34811gz91e1v70tlqjus1opkx78', NULL, 1, NULL, '2016-12-14 10:58:32', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(159, '', '', '', '', '', 'rt@yopmail.com', '$2y$10$RYXdUal9C8eaReWDzu5HmuiVm.eu5HIao4BZvOW7TSMHf2wyxljfe', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-15 04:49:13', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'lbov33kset624ux177f7zar581813dwjinqycp49m0h7g5', NULL, 1, NULL, '2016-12-15 04:49:13', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(160, '', '', '', '', '', 'test@yopmail.com', '$2y$10$FnLJDm.DQMG9DmUa7WY3wew.mZFosUEbnRMVUYnUDeZ9JcrZMudxC', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-15 05:54:34', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 1, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'z84p10kgfd68oi7ctq53h271b4l49unx217rs1yvmwa8je', NULL, 1, NULL, '2016-12-15 05:54:34', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(161, '', '', '', '', '', 'test1@yopmail.com', '$2y$10$jE8yE2Srje2WATTfZgCDbe9KWqhEpYU/.uHfkPhilnir7rGcKZafy', '', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, '123456', '2016-12-15 05:55:30', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 5, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '8lvtai3og73s0zd1e8ck4q91ubh2yf4j61nx5m8r0p137w', NULL, 1, NULL, '2016-12-15 05:55:30', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(162, '', '', '', '', '', 'latesh.garg@app.in', '$2y$10$ytlqqv4ppOec33DDhW8tZOjiiYN5wCHL9.ebAqB6qThwz6u2jRyXm', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-15 11:03:58', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-15 11:03:58', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(163, '', '', '', '', '', '1236@yopmail.com', '$2y$10$3cgY9LZQUsI7S.RdCzl/kODE96TuZWVvYDJmTSki8Kenwa3P4Du0W', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-16 07:13:05', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '51t8prx8847v1zmj80eowk2usfn7dq31il45236hayb9gc', NULL, 1, NULL, '2016-12-16 07:13:05', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(164, '', '', '', '', '', '12367@yopmail.com', '$2y$10$Xq/avE7clV8bPkW1NrZPReHjcdeHX3fWP/g5mhx4DzKjqjz0J.tBq', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-16 07:15:53', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '5tx9a448fdmgw6s10kyvcqz21nhe71u7328j3oibr5l8p5', NULL, 1, NULL, '2016-12-16 07:15:53', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(165, '', '', '', '', '', 'ayush.gupta@app.in', '$2y$10$AJXFHmnK54g8sg.r3oPVUe6LSxxVNwODIvDnI3dgKG7rP4LIwOuBu', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-16 07:25:32', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '4uohz28b2l38r7qx74161d05tf1w9apjmcisvye813kg3n', NULL, 1, NULL, '2016-12-16 07:25:32', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(166, '', '', '', '', '', 'preeti.bhatia@app.in', '$2y$10$UGs1aQl..1O1bWuICGbM/efEhr1nvimKAcpUtRbAqflFkbqk5nP5W', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-18 02:39:19', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'n14sfql8ue0jr6b8958oa3yd2gim9570txcvw2kh1z4p27', NULL, 1, NULL, '2016-12-18 02:39:19', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(167, '', '', '', '', '', 'test2@yopmail.com', '$2y$10$OI83Lw6gbzLXkWEwED95uOraFwYzP.NZYJz9Vz2QWVtCC7SFPI3Bm', '', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-18 12:52:49', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'qwp9y4bx4628au8mr1oncksizh25716l03f59ted0g5jv6', NULL, 1, NULL, '2016-12-18 12:52:49', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(168, 'Prashant', 'Gautam', '', '', '', 'prashant5@yopmail.com', '$2y$10$oeN60ALBF.q/Z1Dh2bp.W.CWAAG3MmAsrO1O20DxrsYCbKexb4oF.', '', '971', '9865328874', 'Indian', 'Abu Dhabi', '', 1, '1482117190854.png', '', '1987-01-10', NULL, 1, '0', 1, '', '2016-12-19 03:11:17', '0000-00-00 00:00:00', 0, '91.000000', '91.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-19 03:11:17', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(169, 'Hrsshrjgsjgdhdkxjgjzgzjf', 'Fuxutxditsigxigxgiohcohcohcohcihccjigcgcigicgicgic', '', '', '', 'mohini.goyal@app.in', '$2y$10$rWOPBvROX9sQOvAkweC6XuZ5MSfu8uloIwTG/SB.UO0bXdPvzquEa', '', '971', '2583695666325', 'Indian', 'Karnalkhxchkchkckkhcckhkhckgxhckchkhkxlhclhclhxbcclhxkbxbkxbkxlbxxhlxhlxhlxlhxhlxlhxx', '', 2, '1482129500120.png', '', '2016-07-20', NULL, 1, '0', 1, '', '2016-12-19 06:35:37', '0000-00-00 00:00:00', 0, '91.000000', '91.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-19 06:35:37', '2017-02-07 06:34:55', NULL, 'GcJjEuzqEAxBZYKDtp6lsRgZZFOjyGh9ZgzKvT1s4l8Ly2UxKFSjphBCIK9l'),
(170, 'Prashantha', 'Gautamm', '', '', '', 'prashant6@yopmail.com', '$2y$10$5rYUpa0.64guQ1GsRUNjk.oDU0rGAjCdueyO7XjX9tDrVI6LmSeF.', '', '971', '9876543210', 'Afghani', 'Abu Dhabi', '', 1, '1482136503886.png', '', '1992-12-19', NULL, 1, '0', 1, '', '2016-12-19 08:33:56', '0000-00-00 00:00:00', 0, '91.000000', '91.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-19 08:33:56', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(171, 'Pritam', 'Tanwar', '', '', '', '', '$2y$10$8uXaZ9CiAu3iPdR3.wLk0OBVsHR27g49IGw8fg2YedQ2rfULfzTuK', '2177853965772423', '0', '', 'Indian', 'Asdfgh', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-19 10:27:39', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-19 10:27:39', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(172, 'Tanwar', 'Pritam', '', '', '', 'appsterqa13@yopmail.com', '$2y$10$.3WGM0z1qZA53tKv30gBHuPcdtvedM5DrWFy4kjkTx829Yx0PMio6', '', '0', '', 'Indian', 'Hello', '', 1, '', '', '0000-00-00', NULL, 1, '0', 1, '', '2016-12-19 10:42:59', '0000-00-00 00:00:00', 2, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 1, '', 1, NULL, NULL, '', NULL, 1, NULL, '2016-12-19 10:42:59', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(173, 'Jack', 'kakran', 'dsmalksmdkasmdkksad ajkdnknaskdnkasnkjdnas', 'Address', '454646347652343', 'sandeep12345@gmail.com', '$2y$10$LXduTtSKJT5gcuInwYX3vefoC2eTji0/ol9CUKr1Xpbb8kQh8iaWi', '', '91', '9808210210', 'Indian', 'Gurgaon', 'India', 1, '', '', '1987-09-09', 1, 2, '0', 1, '123456', '2016-12-21 10:21:43', '0000-00-00 00:00:00', 1, '28.556160', '77.100282', 0, 0, 2, 62, 0, 'Dubai', '28.459500', '77.026600', 'Doctor', 0, '', 'http://yahoo.com', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 1, '{"gender":"F","dob":"1989-03-27","height":"180","heightUnit":"1","weight":"79","weightUnit":"1","cigrattesPerDay":"100","exerciseHourPerWeek":"5","exerciseIntensity":"1","eatingHabit":"5","bloodPresure":"2","stressLevel":"4","happiness":"4"}', 1, NULL, NULL, '10n5r433m2j1bi31l4y0s8f28xotw6eha7dcgv9zqkpu57', NULL, 1, NULL, '2016-12-21 04:51:43', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(174, 'Jack', 'kakran', '', '', '', 'sandeep123456@gmail.com', '$2y$10$nu9ZF5F4wzClq2QMpacfceqTKdvDPwcYYy9NjGDPJXe7WijyvEkg2', '', '+91', '9808210210', 'Indian', 'Gurgaon', 'India', 1, 'jack7@gmail.com', 'jack7@gmail.com', '1987-09-09', 3, 2, '0', 1, '5O5IPI', '2016-12-22 09:28:48', '0000-00-00 00:00:00', 0, '91.000000', '91.000000', 160, 0, 0, 20, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 1, '{"gender":"F","dob":"1991-01-01","height":"61","heightUnit":"1","weight":"30","weightUnit":"1","cigrattesPerDay":"20","exerciseHourPerWeek":"0","exerciseIntensity":"1","eatingHabit":"1","bloodPresure":"2","stressLevel":"10","sleepHour":"1","happiness":"4","diabetes":"2"}', 2, 17, 2017, 'h8n9eq2jp23f084a8iv5kxr1zotmgdb219yc3s4w69l8u7', 4, 1, NULL, '2016-12-22 03:58:48', '2017-05-22 05:10:02', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(178, '', '', '', '', '', 'jack71@gmail.com', '', '45435254454545', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 5, '0', 1, '', '2017-01-13 03:40:38', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2017-01-12 22:10:38', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(179, '', '', '', '', '', 'sandeep11@gmail.com', '$2y$10$2qCab6tCT1FWKRfIWDxJVOM7GoiCB6i.ZVW9k.l9rvuCmOZp4Ngvy', '12323343434', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, 'ABDC', '2017-01-16 06:34:49', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '96qme3ilb82z8xk144ygj51hp4va4s4wc80987to5udrfn', NULL, 1, NULL, '2017-01-16 01:04:49', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(180, '', '', '', '', '', 'sandeep112@gmail.com', '$2y$10$ts4lPu6r6SqICEOO0MJXA.MOnnUHCqauOiMlFkcT6xP2A4mnM/DT6', '12323343434', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, 'ABDC', '2017-01-16 06:51:04', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'q5ylbvs8fno9p8mz6de144w3h9utkr5a01x7444ci46gj2', NULL, 1, NULL, '2017-01-16 01:21:04', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(181, '', '', '', '', '', 'sandeep1121@gmail.com', '$2y$10$07QisntmgHHe7tGkI7c/tuYEiV05TcGLi0atv3wqWkeho44in9dXS', '12323343434', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, 'ABDC', '2017-01-16 06:51:48', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'st4qp85r6l998n8cw45bdauykzg4vo3mh5i011efx20j74', NULL, 1, NULL, '2017-01-16 01:21:48', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd');
INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `bio`, `address`, `expert_contact_number`, `email`, `password`, `facebook_id`, `countryCode`, `mobile`, `nationality`, `city`, `residence_country`, `gender`, `image`, `expert_image`, `dob`, `activation_type`, `user_type`, `member_id`, `current_health_device_id`, `activation_code`, `activation_start_date`, `activation_expiry_date`, `language`, `latitude`, `longitude`, `reward_point`, `level_id`, `expert_type`, `vitality_age`, `is_interested_for_expert`, `working_location`, `working_location_lat`, `working_location_long`, `working_speciality`, `work_id`, `work_name`, `website`, `certificate_validity`, `temp_password`, `forget_password_count`, `wrong_signin_count`, `wrong_signin_datetime`, `is_password_changed`, `is_verified`, `is_blocked`, `is_profile_completed`, `wellness_age_answers`, `current_tier`, `tier_start_week`, `tier_start_year`, `email_verify_token`, `ecosystem_id`, `ecosystem_status`, `unique_bar_code`, `created_at`, `updated_at`, `deleted_at`, `remember_token`) VALUES
(182, '', '', '', '', '', 'sandeep11212@gmail.com', '$2y$10$0YtRy9eh924IC0S2S3lv8ussVMruQkeWefT.tzTCNTvauwCq3H1Xq', '12323343434', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, 'ABDC', '2017-01-16 06:52:30', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '338opnuz50w4a2vhmdbiqt9gr11k4746f60jc21el98xys', NULL, 1, NULL, '2017-01-16 01:22:30', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(183, '', '', '', '', '', 'sandeep112121@gmail.com', '$2y$10$8T7SfYmhzwEG5KzylTiFb.Ov/ZadH3YWpq2zcC4o/4eZbuPkjrkYu', '12323343434', '0', '', '', '', '', 1, '', '', '0000-00-00', 1, 2, '0', 1, 'ABDC', '2017-01-16 06:52:54', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 1, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '8c16r23wgp4n8ivq14f36tj4b8ya7uho90l8semd925xkz', NULL, 1, NULL, '2017-01-16 01:22:54', '2017-02-07 06:34:55', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(184, '', '', '', '', '', 's.swati1018@gmail.com', '$2y$10$MORgEUIf8cRYAss4gNGRE.SUNkuvwUYKiwgxYhGHq4VIg1Heu0D/W', '1737255616593455', '0', '', '', '', '', 1, '', '', '0000-00-00', 0, 1, '0', 1, '', '2017-01-17 06:16:57', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 400, 0, 0, 0, 0, '', '0.000000', '0.000000', '', 0, '', '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, 2, 2017, '3w3yc4hxiequs6zv902l13t87m34gnp184f8kj5d36broa', NULL, 1, NULL, '2017-01-17 00:46:57', '2017-02-07 00:43:28', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(185, '', '', '', '', '', 'jack71@gmail.com', '', '36091679758653911111', '0', '', '', '', '', 1, '', '', '0000-00-00', NULL, 5, '0', 1, '', '2017-02-06 06:44:33', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2017-02-06 01:14:33', '2017-03-31 05:18:29', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(186, '', '', '', '', '', 'jack7123@gmail.com', '$2y$10$.98x3E/MoaCGSZZT/.kz4eqdkT5QEoA711eK6bpBjlOfr5EUyv.ty', '', '0', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-03-24 07:01:08', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', NULL, 1, NULL, '2017-03-24 07:01:08', '2017-03-24 07:01:08', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(192, '', '', '', '', '', 'jack77777@gmail.com', '$2y$10$yQBkL5pNxZHVQBWFP0hAh.lIGaGraOehiwqtSQjKWSkjDsn8fnJnu', '', '', '', '', '', '', 0, '', '', '0000-00-00', 1, 2, '0', 0, 'XU6OBH', '2017-03-29 09:33:48', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 2, NULL, 0, 1, 0, 0, '', 1, NULL, NULL, 'q7e02fx65g8j24sulab1t3c0ynmoz8k8pi90v1hw9r470d', 4, 1, NULL, '2017-03-29 09:33:48', '2017-05-22 07:43:47', '2017-05-22 07:43:47', 'K0C5Vl6PjbSMG56002e5a8fhaqhswtFO0FKmdg83GEYQq2dpCeO3OeJijtBr'),
(193, '', '', '', '', '', 'jack89@gmail.com', '$2y$10$yao9JjnBZEBR05uq7yPBxOOcBQo9F45NgjdY7TgQBd5Ou32e812gK', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-03-31 05:18:34', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'fn0zy1mto3q1gd4xr93595hw7kj2c64li401p87uva9bes', NULL, 1, NULL, '2017-03-31 05:18:34', '2017-03-31 06:43:21', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(194, '', '', '', '', '', 'jack71@gmail.com', '$2y$10$JUcog9LGe049UVoHeVRzYuDLACYgR8pUqqbnVhB0EJeW0S3qXnkdG', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-03-31 06:43:53', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'qzj8bk2dit31gc9ew01fa9ym34r674p2s9v5x34o0u6lhn', NULL, 1, NULL, '2017-03-31 06:43:53', '2017-03-31 06:54:19', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(195, '', '', '', '', '', 'jack@yopmail.com', '$2y$10$zRL1O9gGj4UVQ9j8nvZAmuDW3Cym6f3/WDYC3OcSnwdjBGn0w8fz2', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-03-31 06:55:13', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'bnq407w3a1oy41d833h01c435j29pls9fkzvxugri9me6t', NULL, 1, NULL, '2017-03-31 06:55:13', '2017-03-31 07:05:42', '2017-03-31 07:05:42', 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(196, '', '', '', '', '', 'jack7@gmail.com', '$2y$10$a4D5kpZ4L/tQuaiu7Z/ZUeBkzBqnN1QPzXP0i7z4Nz2np.Iw2oFm2', '4546463476523434', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-03-31 07:05:42', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 1, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'bzqjrw3ph447gf6kvald4893019scyium2nx5te9o14920', NULL, 1, NULL, '2017-03-31 07:05:42', '2017-05-02 07:02:21', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(197, '', '', '', '', '', 'jack7123123@gmail.com', '$2y$10$cjtw2r5wKHKMUHWTI17FounvpNgJFQns4BFkd9nlkdXysLckqUA.G', '', '', '', '', '', '', 0, '', '', '0000-00-00', 1, 1, '0', 0, '', '2017-04-04 07:03:11', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'y45c2b1qv9xhrpki8u9nsmz80j37e16tf24gwa3dl9191o', NULL, 1, '278246568626', '2017-04-04 07:03:11', '2017-04-04 07:03:11', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(198, '', '', '', '', '', 'jack.john11@app.in', '$2y$10$vr/G50QR352TyxgaqBv98eFmwN4Jtl.rf6zsjC2iAk.DUnu.gjHAG', '', '', '', '', '', '', 0, '', '', '0000-00-00', 1, 1, '0', 0, '', '2017-04-17 05:14:46', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, '9yzeog9k60p05libf7a64sxw188u6t3q0r4d242chmjnv1', NULL, 1, '435608692872', '2017-04-17 05:14:46', '2017-04-21 08:47:24', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(209, '', '', '', '', '', 'jack.john12@app.in', '$2y$10$cpfsgIHrbJUyW/Z9esQKJOYp/UmbxMEvlabmPPjP.RQfjKWDvfH/.', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 1, '0', 0, '', '2017-04-21 09:08:57', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'v7h41fk4taq7jg5nwbop0289lz36duyx5s2cei39m177r6', 1, 1, NULL, '2017-04-21 09:08:57', '2017-04-24 06:09:30', '2017-04-24 06:09:30', 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(210, 'Jack', 'Kakran', '', '', '', 'jack@yopmail.com', '$2y$10$mN.WILZTIgLLphsShclM1emHS5dGPXeRelwpeNl4khETcPAn8WkTi', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-04-24 06:09:30', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'n91ly8ox7bg1hr063e0pv41qc2s017jwi3k4u459zmdaft', NULL, 1, NULL, '2017-04-24 06:09:30', '2017-05-22 09:13:41', NULL, 'h38Rxx6XU3cDqOQDiNtDOiIU353HGYxjIR10DDINuUHDOFtUHuZKdlkpWLde'),
(211, '', '', '', '', '', 'jack.john123@app.in', '$2y$10$XCXSO47.CwKNyqvViWbRqu1jvW3S57Tzi/2N.qy2eIQ01E8ZtX3sK', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-05-22 09:13:47', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'l4z5f81uor9v4g4nij63s947dy1qm2xcp4w4aeb05kt72h', NULL, 1, NULL, '2017-05-22 07:43:47', '2017-06-06 06:17:25', '2017-05-30 10:02:39', 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(212, '', '', '', '', '', 'Jackkak@gmail.com', '$2y$10$lNRXnmmLWwEzhwv/ubDkVeqSovB607HT5YGKWkLL3JMNXmmvXKrm.', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-05-30 11:32:36', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '91qe445ruf260khwv3j7yis9t359z6bxg4cdp8n11ma6lo', NULL, 1, NULL, '2017-05-30 10:02:36', '2017-05-30 10:02:51', '2017-05-30 10:02:51', 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(213, '', '', '', '', '', 'jack.john123@app.in', '$2y$10$JHd0ksj4QN/DFk66cP6NK.dygQVdac9MAc62VFMZ7ColM1WnDCkny', '', '', '', '', '', '', 0, '', '', '0000-00-00', NULL, 5, '0', 0, '', '2017-05-30 11:32:49', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, 'mp132y7b49zk4h93s981og4cidrtqna1096vfl5uw6xj6e', NULL, 1, NULL, '2017-05-30 10:02:49', '2017-06-06 06:18:03', NULL, '6G0596vsMW4ujMNyeYcKGVrLuXfIEsADjBO1hcFIjdMs7W71OWfO2eqjmhFF'),
(214, '', '', '', '', '', 'jack.john321@app.in', '$2y$10$ZUTAE.oZFNOhzPsQoA6BY.sRz7.URPfuGbVczeJS5IOFO8b036rBi', '', '', '', '', '', '', 0, '', '', '0000-00-00', 0, 2, '0', 0, '7GW0VM', '2017-06-06 06:47:12', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 0, 0, 0, '', 1, NULL, NULL, 'mr74j1z40617e6h392p8wos36ga5kvdb1q9cinuxfy2tl3', 4, 1, '452933882897', '2017-06-06 05:17:12', '2017-06-06 06:52:51', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd'),
(215, '', '', '', '', '', 'jack@yopmail.com', '$2y$10$0O1i9he2/ZJHZDrcjwXihu1dihICbQCnjy5fjrW6aG0Onth/APAXC', '', '', '', '', '', '', 0, '', '', '0000-00-00', 0, 2, '0', 0, '7GW0VM', '2017-06-06 06:52:58', '0000-00-00 00:00:00', 1, '0.000000', '0.000000', 0, 0, 0, 0, 0, '', '0.000000', '0.000000', '', NULL, NULL, '', '0000-00-00 00:00:00', '', 0, 0, NULL, 1, 1, 0, 0, '', 1, NULL, NULL, '', 4, 1, '914810701729', '2017-06-06 05:22:58', '2017-06-06 07:12:43', NULL, 'dsdsdsdsjdjsdjnsjdnsdnsndnsdsdsdsdsdsdsdsd');

-- --------------------------------------------------------

--
-- Table structure for table `user_bookings`
--

CREATE TABLE `user_bookings` (
  `booking_id` int(11) NOT NULL COMMENT 'Primary Key of table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `expert_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users(expert)',
  `date` date DEFAULT NULL COMMENT 'Date of booking',
  `start_time` time NOT NULL COMMENT 'Start Time of Booking',
  `end_time` time NOT NULL COMMENT 'End Time of Booking',
  `booking_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Status of Booking(1=Confirmed , 2 - Cancelled)',
  `is_feedback_recieved` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - Not Received , 1 - Received',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_bookings`
--

INSERT INTO `user_bookings` (`booking_id`, `user_id`, `expert_id`, `date`, `start_time`, `end_time`, `booking_status`, `is_feedback_recieved`, `created_at`, `updated_at`, `deleted_at`) VALUES
(23, 128, 1, '2017-04-04', '03:10:10', '07:10:10', 1, 0, '2017-03-03 04:21:03', '2017-03-02 22:53:37', NULL),
(24, 128, 128, '2017-05-29', '07:10:10', '08:10:10', 1, 0, '2017-03-03 04:21:03', '2017-03-08 00:44:34', NULL),
(25, 128, 1, '2017-03-10', '07:10:10', '08:10:10', 1, 0, '2017-03-03 04:21:03', '2017-03-08 00:44:34', NULL),
(26, 128, 1, '2017-03-10', '07:10:10', '08:10:10', 1, 1, '2017-03-03 04:21:03', '2017-04-10 12:51:48', NULL),
(27, 128, 1, '2017-04-06', '07:10:10', '08:10:10', 1, 1, '2017-03-03 04:21:03', '2017-04-10 12:43:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_conversations`
--

CREATE TABLE `user_conversations` (
  `conversation_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `sender_user_id` int(11) NOT NULL COMMENT 'Its a foreign key to map sender users',
  `receiver_user_id` int(11) NOT NULL COMMENT 'Its a foreign key to map receiver users',
  `message` varchar(500) NOT NULL COMMENT 'Conversation Message',
  `timestamp` varchar(50) NOT NULL COMMENT 'Timestamp',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_conversations`
--

INSERT INTO `user_conversations` (`conversation_id`, `sender_user_id`, `receiver_user_id`, `message`, `timestamp`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 174, 103, 'hello', '1495688268.541539', '2017-05-25 03:21:12', '2017-05-25 06:06:47', NULL),
(2, 174, 103, 'hello', '1495688268.241539', '2017-05-25 03:29:28', '2017-05-25 06:06:52', NULL),
(3, 103, 174, 'hello', '1495688372.59312', '2017-05-25 03:29:32', '2017-05-25 06:10:03', NULL),
(4, 174, 103, 'hello', '1495688168.241539', '2017-05-25 03:29:28', '2017-05-25 06:06:52', NULL),
(5, 174, 103, 'hello', '1495702902.287621', '2017-05-25 07:31:42', '2017-05-25 07:31:42', NULL),
(6, 174, 103, 'hello', '1495703082.032076', '2017-05-25 07:34:42', '2017-05-25 07:34:42', NULL),
(7, 174, 103, 'hello', '1495703088.397476', '2017-05-25 07:34:48', '2017-05-25 07:34:48', NULL),
(8, 174, 103, 'hello', '1495703369.457211', '2017-05-25 07:39:29', '2017-05-25 07:39:29', NULL),
(9, 174, 103, 'hello', '1495703450.878089', '2017-05-25 07:40:50', '2017-05-25 07:40:50', NULL),
(10, 174, 103, 'hello', '1495703468.391127', '2017-05-25 07:41:08', '2017-05-25 07:41:08', NULL),
(11, 174, 103, 'hello', '1495703484.31605', '2017-05-25 07:41:24', '2017-05-25 07:41:24', NULL),
(12, 174, 103, 'hello', '1495703519.409684', '2017-05-25 07:41:59', '2017-05-25 07:41:59', NULL),
(13, 174, 103, 'hello', '1495703567.660567', '2017-05-25 07:42:47', '2017-05-25 07:42:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_feedback`
--

CREATE TABLE `user_feedback` (
  `feedback_id` int(11) NOT NULL COMMENT 'Primary key of the table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `expert_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users(expert)',
  `booking_id` int(11) NOT NULL COMMENT 'Foreign Key to Map booking ',
  `rating` int(11) NOT NULL COMMENT 'Rating given by User ',
  `comment` varchar(1000) NOT NULL COMMENT 'Comment as  a feedback',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the Modified date time ',
  `deleted_at` int(11) DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_feedback`
--

INSERT INTO `user_feedback` (`feedback_id`, `user_id`, `expert_id`, `booking_id`, `rating`, `comment`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 28, 3, 'Good', '2016-12-07 10:36:48', '2017-04-10 10:28:11', NULL),
(2, 1, 2, 0, 5, 'Good', '2016-12-07 10:37:04', '2016-12-08 03:59:49', NULL),
(3, 1, 1, 0, 3, 'Good', '2016-12-07 10:36:48', '2016-12-08 03:59:20', NULL),
(5, 128, 128, 28, 3, '', '2017-04-10 12:39:06', '2017-04-10 12:39:06', NULL),
(6, 128, 1, 28, 3, '', '2017-04-10 12:42:40', '2017-04-10 12:42:40', NULL),
(7, 128, 1, 27, 3, '', '2017-04-10 12:43:28', '2017-04-10 12:43:28', NULL),
(8, 128, 1, 26, 3, '', '2017-04-10 12:51:48', '2017-04-10 12:51:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_garmin_data`
--

CREATE TABLE `user_garmin_data` (
  `user_garmin_data_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `user_id` int(11) NOT NULL COMMENT 'Its a foreign Key to map User',
  `steps` decimal(10,0) NOT NULL COMMENT 'Its a number of steps',
  `distance_in_meters` decimal(10,0) NOT NULL COMMENT 'Its a distance travelled in meters',
  `active_kilocalories` decimal(10,0) NOT NULL COMMENT 'Active Kilo Calories',
  `start_time` datetime NOT NULL COMMENT 'Start Time',
  `end_time` datetime NOT NULL COMMENT 'End Time',
  `overall_response` text NOT NULL COMMENT 'Its a overall response of Garmin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_garmin_data`
--

INSERT INTO `user_garmin_data` (`user_garmin_data_id`, `user_id`, `steps`, `distance_in_meters`, `active_kilocalories`, `start_time`, `end_time`, `overall_response`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 128, '804', '187', '5', '2017-05-23 10:17:16', '2017-05-23 10:17:54', '"[{\\"summaryId\\":\\"sd1879b1-59237b80-6\\",\\"activityType\\":\\"WALKING\\",\\"activeKilocalories\\":5,\\"steps\\":804,\\"distanceInMeters\\":187.41,\\"durationInSeconds\\":293,\\"activeTimeInSeconds\\":860,\\"startTimeInSeconds\\":1495497600,\\"startTimeOffsetInSeconds\\":-18000,\\"moderateIntensityDurationInSeconds\\":5349360,\\"vigorousIntensityDurationInSeconds\\":285060,\\"floorsClimbed\\":2,\\"minHeartRateInBeatsPerMinute\\":62,\\"maxHeartRateInBeatsPerMinute\\":99,\\"averageHeartRateInBeatsPerMinute\\":69,\\"timeOffsetHeartRateSamples\\":{\\"10230\\":65,\\"12229\\":77,\\"14808\\":80,\\"10232\\":77,\\"4889\\":62},\\"stepsGoal\\":7834,\\"netKilocaloriesGoal\\":10521,\\"intensityDurationGoalInSeconds\\":305160,\\"floorsClimbedGoal\\":9,\\"averageStressLevel\\":28,\\"maxStressLevel\\":10,\\"stressDurationInSeconds\\":980,\\"restStressDurationInSeconds\\":173,\\"activityStressDurationInSeconds\\":65,\\"lowStressDurationInSeconds\\":41,\\"mediumStressDurationInSeconds\\":69,\\"highStressDurationInSeconds\\":45}]"', '2017-05-26 09:05:31', '2017-05-26 09:05:31', NULL),
(2, 128, '804', '187', '5', '2017-05-23 10:17:16', '2017-05-23 10:17:54', '"[{\\"summaryId\\":\\"sd1879b1-59237b80-6\\",\\"activityType\\":\\"WALKING\\",\\"activeKilocalories\\":5,\\"steps\\":804,\\"distanceInMeters\\":187.41,\\"durationInSeconds\\":293,\\"activeTimeInSeconds\\":860,\\"startTimeInSeconds\\":1495497600,\\"startTimeOffsetInSeconds\\":-18000,\\"moderateIntensityDurationInSeconds\\":5349360,\\"vigorousIntensityDurationInSeconds\\":285060,\\"floorsClimbed\\":2,\\"minHeartRateInBeatsPerMinute\\":62,\\"maxHeartRateInBeatsPerMinute\\":99,\\"averageHeartRateInBeatsPerMinute\\":69,\\"timeOffsetHeartRateSamples\\":{\\"10230\\":65,\\"12229\\":77,\\"14808\\":80,\\"10232\\":77,\\"4889\\":62},\\"stepsGoal\\":7834,\\"netKilocaloriesGoal\\":10521,\\"intensityDurationGoalInSeconds\\":305160,\\"floorsClimbedGoal\\":9,\\"averageStressLevel\\":28,\\"maxStressLevel\\":10,\\"stressDurationInSeconds\\":980,\\"restStressDurationInSeconds\\":173,\\"activityStressDurationInSeconds\\":65,\\"lowStressDurationInSeconds\\":41,\\"mediumStressDurationInSeconds\\":69,\\"highStressDurationInSeconds\\":45}]"', '2017-05-26 09:18:58', '2017-05-26 09:18:58', NULL),
(3, 128, '804', '187', '5', '2017-05-23 10:17:16', '2017-05-23 10:17:54', '"[{\\"summaryId\\":\\"sd1879b1-59237b80-6\\",\\"activityType\\":\\"WALKING\\",\\"activeKilocalories\\":5,\\"steps\\":804,\\"distanceInMeters\\":187.41,\\"durationInSeconds\\":293,\\"activeTimeInSeconds\\":860,\\"startTimeInSeconds\\":1495497600,\\"startTimeOffsetInSeconds\\":-18000,\\"moderateIntensityDurationInSeconds\\":5349360,\\"vigorousIntensityDurationInSeconds\\":285060,\\"floorsClimbed\\":2,\\"minHeartRateInBeatsPerMinute\\":62,\\"maxHeartRateInBeatsPerMinute\\":99,\\"averageHeartRateInBeatsPerMinute\\":69,\\"timeOffsetHeartRateSamples\\":{\\"10230\\":65,\\"12229\\":77,\\"14808\\":80,\\"10232\\":77,\\"4889\\":62},\\"stepsGoal\\":7834,\\"netKilocaloriesGoal\\":10521,\\"intensityDurationGoalInSeconds\\":305160,\\"floorsClimbedGoal\\":9,\\"averageStressLevel\\":28,\\"maxStressLevel\\":10,\\"stressDurationInSeconds\\":980,\\"restStressDurationInSeconds\\":173,\\"activityStressDurationInSeconds\\":65,\\"lowStressDurationInSeconds\\":41,\\"mediumStressDurationInSeconds\\":69,\\"highStressDurationInSeconds\\":45}]"', '2017-05-26 09:20:13', '2017-05-26 09:20:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_garmin_information`
--

CREATE TABLE `user_garmin_information` (
  `user_garmin_information_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `user_access_token` varchar(100) NOT NULL COMMENT 'User Access Taken of Garmin',
  `user_token_secret` varchar(100) NOT NULL COMMENT 'User Token Secret of Garmin',
  `user_id` int(11) NOT NULL COMMENT 'Its a foreign Key to map User',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_garmin_information`
--

INSERT INTO `user_garmin_information` (`user_garmin_information_id`, `user_access_token`, `user_token_secret`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '67ae3fe5-9c52-4756-930c-3cbaece76c52', 'dTghB4I70Gp5EBZKrHLPCIx1oFvc5B0oXqw', 128, '2017-05-26 10:35:24', '2017-05-26 10:48:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_gyms`
--

CREATE TABLE `user_gyms` (
  `user_gym_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key to map users',
  `master_gym_id` int(11) NOT NULL COMMENT 'Foreign key to map gyms',
  `checkin_beacon_id` int(11) DEFAULT NULL COMMENT 'Beacon id when check In',
  `checkout_beacon_id` int(11) DEFAULT NULL COMMENT 'Beacon id when check Out',
  `checkin_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Check In Date Time',
  `checkout_at` timestamp NULL DEFAULT NULL COMMENT 'Check Out Date Time',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_gyms`
--

INSERT INTO `user_gyms` (`user_gym_id`, `user_id`, `master_gym_id`, `checkin_beacon_id`, `checkout_beacon_id`, `checkin_at`, `checkout_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 174, 1, 3, NULL, '2017-03-17 10:20:22', NULL, '2017-03-15 03:43:24', '2017-05-19 04:40:10', NULL),
(2, 174, 1, 2, 2, '2017-03-17 10:36:22', NULL, '2017-03-16 03:49:09', '2017-03-16 04:41:17', NULL),
(3, 174, 2, 3, NULL, '2017-03-17 10:38:00', NULL, '2017-03-17 10:16:08', '2017-03-17 10:38:00', NULL),
(4, 174, 1, 3, 2, '2017-03-17 10:48:55', '2017-03-17 10:48:55', '2017-03-17 10:19:08', '2017-03-17 10:48:55', NULL),
(5, 174, 2, 3, NULL, '2017-03-20 04:15:11', NULL, '2017-03-20 04:15:11', '2017-03-20 04:15:11', NULL),
(6, 174, 2, 3, 3, '2017-03-21 09:37:58', '2017-03-22 09:35:56', '2017-03-21 05:23:20', '2017-03-21 09:37:58', NULL),
(9, 174, 2, 3, 3, '2017-03-22 10:26:25', '2017-03-22 09:35:56', '2017-03-22 10:26:15', '2017-03-22 10:26:25', NULL),
(10, 174, 2, 3, NULL, '2017-03-24 03:55:56', NULL, '2017-03-24 03:55:56', '2017-03-24 03:55:56', NULL),
(11, 174, 2, 3, NULL, '2017-03-28 06:53:45', NULL, '2017-03-28 06:53:45', '2017-03-28 06:53:45', NULL),
(12, 174, 2, 3, 3, '2017-04-04 04:15:33', '2017-04-04 04:15:33', '2017-04-04 04:10:04', '2017-04-04 04:15:33', NULL),
(13, 2, 2, 3, 3, '2017-04-04 04:17:33', '2017-04-04 04:17:33', '2017-04-04 04:17:05', '2017-04-04 04:17:33', NULL),
(14, 2, 2, 3, 3, '2017-04-18 10:21:33', '2017-04-18 10:21:33', '2017-04-18 10:19:42', '2017-04-18 10:21:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_health_devices`
--

CREATE TABLE `user_health_devices` (
  `health_id` int(11) NOT NULL COMMENT 'Primary key of the table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `calories_burned` float NOT NULL DEFAULT '0' COMMENT 'Number of Calories Burned',
  `distance_covered` float NOT NULL DEFAULT '0' COMMENT 'Distance covered',
  `steps` int(11) NOT NULL DEFAULT '0' COMMENT 'Number of Steps',
  `gym_visits` int(11) NOT NULL DEFAULT '0' COMMENT 'Number Gym Visits',
  `date` date NOT NULL COMMENT 'Date of Data',
  `hour_key` int(11) DEFAULT NULL COMMENT 'Its a key for which data has been saved(1-23)',
  `pt_sessions` int(11) NOT NULL COMMENT 'Number of PT Sessions',
  `week_number` int(11) NOT NULL COMMENT 'Week number of the Year',
  `sync_time` varchar(200) NOT NULL,
  `health_device_name` varchar(200) DEFAULT NULL COMMENT 'Name of the Health Device Device',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_health_devices`
--

INSERT INTO `user_health_devices` (`health_id`, `user_id`, `calories_burned`, `distance_covered`, `steps`, `gym_visits`, `date`, `hour_key`, `pt_sessions`, `week_number`, `sync_time`, `health_device_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, 2, 12431, 10, 10010, 1, '2017-05-19', NULL, 0, 16, '1273.0', NULL, '2017-05-15 04:53:40', '2017-05-23 10:28:40', NULL),
(16, 2, 12431, 10, 100100, 0, '2017-05-01', NULL, 0, 21, '1273.0', NULL, '2017-05-23 02:54:24', '2017-05-23 10:29:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_health_provider_insurance`
--

CREATE TABLE `user_health_provider_insurance` (
  `id` int(11) NOT NULL COMMENT 'Primary key of the table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `attribute_id` int(11) NOT NULL COMMENT 'It is a foreign key to map Service Provider',
  `text` varchar(1000) DEFAULT NULL COMMENT 'Description about the Service provider',
  `is_interested` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Weather useris interested in service provider or not',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_health_provider_insurance`
--

INSERT INTO `user_health_provider_insurance` (`id`, `user_id`, `attribute_id`, `text`, `is_interested`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 1, 'Hello', 1, '2016-12-06 05:27:28', '2016-12-06 05:27:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_highfive`
--

CREATE TABLE `user_highfive` (
  `highfive_id` int(11) NOT NULL COMMENT 'Primary key of the table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `for_user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users(reciever)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_highfive`
--

INSERT INTO `user_highfive` (`highfive_id`, `user_id`, `for_user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 1, '2016-12-01 04:12:00', '2016-12-01 04:12:00', NULL),
(11, 1, 2, '2016-12-12 06:14:33', '2016-12-12 06:14:33', NULL),
(14, 174, 210, '2017-05-11 04:39:11', '2017-05-11 04:39:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_invites`
--

CREATE TABLE `user_invites` (
  `invite_id` int(11) NOT NULL COMMENT 'Primary key of the table',
  `user_id` int(11) NOT NULL COMMENT 'It is a foreign key to map users',
  `invited_user_id` int(11) DEFAULT NULL COMMENT 'Foreign Key to Map invited user',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Status(0=Pending 1=Accepted 2=Rejected , 3 = Canceled)',
  `is_withdrawn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Weather invite withdrawn or not',
  `notification_id` int(11) DEFAULT NULL COMMENT 'Foreign Key to Map Notifications',
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - No , 1 - Yes',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kept the created date time ',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Kept the Modified date time ',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Kept the deleted date time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_invites`
--

INSERT INTO `user_invites` (`invite_id`, `user_id`, `invited_user_id`, `status`, `is_withdrawn`, `notification_id`, `is_blocked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 174, 1, 1, 1, 20, 1, '2017-02-23 00:39:26', '2017-03-06 04:39:01', NULL),
(2, 1, 174, 3, 0, 21, 1, '2017-02-23 00:42:28', '2017-03-02 05:49:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_points_history`
--

CREATE TABLE `user_points_history` (
  `point_history_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key to map users',
  `points` int(11) NOT NULL COMMENT 'Number of points earned/redeemed',
  `type` tinyint(4) NOT NULL COMMENT '1 - Earned , 2 - Redeemed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `de` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_points_history`
--

INSERT INTO `user_points_history` (`point_history_id`, `user_id`, `points`, `type`, `created_at`, `updated_at`, `de`) VALUES
(1, 2, 100, 1, '2017-05-18 06:37:52', '2017-04-21 10:49:48', NULL),
(2, 2, 100, 1, '2017-04-11 06:39:30', '2017-04-11 06:39:30', NULL),
(3, 174, 70, 2, '2017-04-11 06:46:04', '2017-04-11 06:46:04', NULL),
(4, 2, 100, 1, '2017-04-18 10:09:19', '2017-04-18 10:09:19', NULL),
(5, 2, 100, 1, '2017-04-18 10:11:19', '2017-04-18 10:11:19', NULL),
(6, 2, 100, 1, '2017-04-18 10:21:35', '2017-04-18 10:21:35', NULL),
(7, 2, 100, 1, '2016-05-18 06:37:52', '2017-04-21 10:54:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_rewards`
--

CREATE TABLE `user_rewards` (
  `user_reward_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key to map users',
  `master_reward_id` int(11) NOT NULL COMMENT 'Foreign key to map rewards',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_rewards`
--

INSERT INTO `user_rewards` (`user_reward_id`, `user_id`, `master_reward_id`, `created_at`) VALUES
(9, 174, 4, '2017-04-12 04:58:52'),
(13, 174, 3, '2017-04-24 06:01:25'),
(15, 174, 1, '2017-06-06 04:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `user_sessions_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key to map users',
  `expert_id` int(11) NOT NULL COMMENT 'Foreign key to map expert(users)',
  `sessions_available` int(11) NOT NULL DEFAULT '0' COMMENT 'Number of sessions available of the expert',
  `introductory_available` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Introductory session available or not (1 - Available , 0 - Not Available)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`user_sessions_id`, `user_id`, `expert_id`, `sessions_available`, `introductory_available`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 174, 1, 20, 1, '2017-02-28 05:37:59', '2017-04-17 09:15:09', NULL),
(2, 128, 128, 30, 0, '2017-03-03 00:12:30', '2017-05-02 06:52:21', NULL),
(3, 174, 2, 120, 0, '2017-05-01 11:38:36', '2017-05-01 11:44:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE `user_transactions` (
  `transaction_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `price` float NOT NULL COMMENT 'Price of Transaction',
  `transaction_payment_id` varchar(200) DEFAULT NULL COMMENT 'Auto Generated Unique Order Id',
  `number_of_sessions` int(11) NOT NULL COMMENT 'Number of sessions added or deleted',
  `type_of_session` varchar(100) NOT NULL COMMENT 'Either introductory or something else',
  `expert_id` int(11) NOT NULL COMMENT 'Primary key to map experts (users)',
  `user_id` int(11) NOT NULL COMMENT 'Primary key to map users',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Modified Date Time',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Date Time',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - Initiated , 2 - Success , 3 - Failure',
  `transaction_response` text NOT NULL COMMENT 'Serialised response of the transaction'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_transactions`
--

INSERT INTO `user_transactions` (`transaction_id`, `price`, `transaction_payment_id`, `number_of_sessions`, `type_of_session`, `expert_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `status`, `transaction_response`) VALUES
(1, 1, 'abcwdd12233422', 10, '', 1, 1, '2017-03-06 05:19:53', '2017-03-06 05:19:53', NULL, 1, ''),
(2, 1, 'abcwdd12233422', 10, '', 1, 1, '2017-03-06 05:22:44', '2017-03-06 05:22:44', NULL, 1, ''),
(3, 1, 'LS447WA3N0XFKIN00MEZ', 30, 'introductory', 2, 174, '2017-04-27 06:08:58', '2017-05-01 11:44:09', NULL, 2, '{"order_id":"LS447WA3N0XFKIN00MEZ","tracking_id":"106002054488","bank_ref_no":"556865","order_status":"Success","failure_message":"","payment_mode":"Credit Card","card_name":"MasterCard","status_code":"null","status_message":"Approved","currency":"AED","amount":"6.0","billing_name":"Jack Garg","billing_address":"No address","billing_city":"Delhi","billing_state":"","billing_zip":"1222009","billing_country":"Comoros","billing_tel":"9818808233","billing_email":"GargJack2011@gmail.com","delivery_name":"","delivery_address":"","delivery_city":"","delivery_state":"","delivery_zip":"","delivery_country":"","delivery_tel":"","merchant_param1":"","merchant_param2":"","merchant_param3":"","merchant_param4":"","merchant_param5":"","vault":"N","offer_type":"null","offer_code":"null","discount_value":"0.0","mer_amount":"6.0","eci_value":"06","card_holder_name":"Jack Garg\\u000b\\u000b\\u000b\\u000b\\u000b\\u000b\\u000b\\u000b\\u000b\\u000b\\u000b"}');

-- --------------------------------------------------------

--
-- Table structure for table `user_wallets`
--

CREATE TABLE `user_wallets` (
  `user_wallet_id` int(11) NOT NULL COMMENT 'Its a primary Key of the table',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key to map users',
  `master_reward_id` int(11) NOT NULL COMMENT 'Foreign key to map rewards',
  `expiry_date` date NOT NULL COMMENT 'Expiry Date of Reward',
  `tier` int(11) NOT NULL DEFAULT '1' COMMENT 'tier of the reward at the time while added to wallet',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Date Time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_wallets`
--

INSERT INTO `user_wallets` (`user_wallet_id`, `user_id`, `master_reward_id`, `expiry_date`, `tier`, `created_at`, `updated_at`) VALUES
(3, 2, 1, '2017-06-08', 1, '2017-04-12 05:35:18', '2017-05-31 10:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `user_wellness_answers`
--

CREATE TABLE `user_wellness_answers` (
  `user_wellness_answer_id` int(11) NOT NULL COMMENT 'Primary Key of the Table',
  `gender` varchar(50) NOT NULL COMMENT 'Gender of the User',
  `dob` date NOT NULL COMMENT 'Date of birth of the User',
  `height` float NOT NULL COMMENT 'Height of the User',
  `height_unit` int(11) NOT NULL COMMENT '1 - cm , 2 - feet',
  `weight` float NOT NULL COMMENT 'Weight of the user',
  `weight_unit` int(11) NOT NULL COMMENT '1 - kg , 2 - lbs',
  `cigrattes_per_day` float NOT NULL COMMENT 'Number of Cigarets per day ',
  `exercise_hour_per_week` int(11) NOT NULL COMMENT 'Excercise hour per week',
  `exercise_intensity` int(11) NOT NULL COMMENT 'Exercise Intensity of User',
  `eating_habit` int(11) NOT NULL COMMENT 'Eating Habit of the User',
  `blood_presure` int(11) NOT NULL COMMENT 'Blood Pressure of the User',
  `stress_level` int(11) NOT NULL COMMENT 'Stress Level of the User',
  `sleep_hour` float NOT NULL COMMENT 'Number of sleep hours',
  `happiness` int(11) NOT NULL COMMENT 'Happiness (scale 1-4) ',
  `diabetes` int(11) NOT NULL COMMENT 'Diabetes (Yes = 1, No = 2, Don’t Know = 3)',
  `wellness_age` float NOT NULL COMMENT 'Wellness Age of the of the User ',
  `user_id` int(11) NOT NULL COMMENT 'Foreign key to map user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created Datetime',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated Datetime',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted Datetime'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_wellness_answers`
--

INSERT INTO `user_wellness_answers` (`user_wellness_answer_id`, `gender`, `dob`, `height`, `height_unit`, `weight`, `weight_unit`, `cigrattes_per_day`, `exercise_hour_per_week`, `exercise_intensity`, `eating_habit`, `blood_presure`, `stress_level`, `sleep_hour`, `happiness`, `diabetes`, `wellness_age`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'F', '1991-01-01', 61, 1, 30, 1, 20, 2, 1, 1, 2, 10, 1, 4, 2, 20, 2, '2017-04-06 10:12:13', '2017-04-21 10:09:09', NULL),
(2, 'F', '1991-01-01', 61, 1, 30, 1, 1, 3, 1, 2, 2, 10, 1, 4, 2, 20, 1, '2017-04-12 10:12:13', '2017-04-21 10:09:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_invites`
--
ALTER TABLE `app_invites`
  ADD PRIMARY KEY (`app_invite_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ecosystem_features`
--
ALTER TABLE `ecosystem_features`
  ADD PRIMARY KEY (`ecosystem_feature_id`),
  ADD KEY `ecosystem_id` (`ecosystem_id`),
  ADD KEY `feature_id` (`feature_id`);

--
-- Indexes for table `ecosystem_rewards`
--
ALTER TABLE `ecosystem_rewards`
  ADD PRIMARY KEY (`ecosystem_reward_id`),
  ADD KEY `ecosystem_id` (`ecosystem_id`),
  ADD KEY `master_merchant_id` (`master_merchant_id`),
  ADD KEY `master_reward_id` (`master_reward_id`);

--
-- Indexes for table `ecosystem_works`
--
ALTER TABLE `ecosystem_works`
  ADD PRIMARY KEY (`ecosystem_feature_id`),
  ADD KEY `ecosystem_id` (`ecosystem_id`),
  ADD KEY `work_id` (`work_id`);

--
-- Indexes for table `expert_calendar`
--
ALTER TABLE `expert_calendar`
  ADD PRIMARY KEY (`calendar_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `expert_health_categories`
--
ALTER TABLE `expert_health_categories`
  ADD PRIMARY KEY (`expert_health_id`),
  ADD KEY `expert_id` (`expert_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `expert_qualifications`
--
ALTER TABLE `expert_qualifications`
  ADD PRIMARY KEY (`qualification_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `get_helps`
--
ALTER TABLE `get_helps`
  ADD PRIMARY KEY (`help_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`goal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue_jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `master_activation_codes`
--
ALTER TABLE `master_activation_codes`
  ADD PRIMARY KEY (`code_id`);

--
-- Indexes for table `master_beacons`
--
ALTER TABLE `master_beacons`
  ADD PRIMARY KEY (`master_beacon_id`),
  ADD KEY `master_gym_id` (`master_gym_id`);

--
-- Indexes for table `master_ecosystems`
--
ALTER TABLE `master_ecosystems`
  ADD PRIMARY KEY (`ecosystem_id`),
  ADD KEY `subadmin_user_id` (`subadmin_user_id`);

--
-- Indexes for table `master_features`
--
ALTER TABLE `master_features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `master_gyms`
--
ALTER TABLE `master_gyms`
  ADD PRIMARY KEY (`master_gym_id`),
  ADD KEY `master_work_id` (`master_work_id`);

--
-- Indexes for table `master_health_categories`
--
ALTER TABLE `master_health_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `master_health_providers_insurances`
--
ALTER TABLE `master_health_providers_insurances`
  ADD PRIMARY KEY (`attribute_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `master_issues`
--
ALTER TABLE `master_issues`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `master_merchants`
--
ALTER TABLE `master_merchants`
  ADD PRIMARY KEY (`master_merchant_id`);

--
-- Indexes for table `master_rewards`
--
ALTER TABLE `master_rewards`
  ADD PRIMARY KEY (`master_reward_id`),
  ADD KEY `master_merchant_id` (`master_merchant_id`);

--
-- Indexes for table `master_works`
--
ALTER TABLE `master_works`
  ADD PRIMARY KEY (`work_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications_logs`
--
ALTER TABLE `notifications_logs`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `sender_user_id` (`sender_user_id`),
  ADD KEY `reciever_user_id` (`reciever_user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `queue_jobs`
--
ALTER TABLE `queue_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue_jobs_queue_reserved_at_index` (`queue`,`reserved_at`);

--
-- Indexes for table `report_issues`
--
ALTER TABLE `report_issues`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `issue_id` (`issue_id`);

--
-- Indexes for table `session_prices`
--
ALTER TABLE `session_prices`
  ADD PRIMARY KEY (`session_price_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_bookings`
--
ALTER TABLE `user_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expert_id` (`expert_id`),
  ADD KEY `expert_id_2` (`expert_id`);

--
-- Indexes for table `user_conversations`
--
ALTER TABLE `user_conversations`
  ADD PRIMARY KEY (`conversation_id`),
  ADD KEY `sender_user_id` (`sender_user_id`),
  ADD KEY `receiver_user_id` (`receiver_user_id`);

--
-- Indexes for table `user_feedback`
--
ALTER TABLE `user_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `source_user_id` (`user_id`,`expert_id`),
  ADD KEY `destination_user_id` (`expert_id`);

--
-- Indexes for table `user_garmin_data`
--
ALTER TABLE `user_garmin_data`
  ADD PRIMARY KEY (`user_garmin_data_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_garmin_information`
--
ALTER TABLE `user_garmin_information`
  ADD PRIMARY KEY (`user_garmin_information_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_gyms`
--
ALTER TABLE `user_gyms`
  ADD PRIMARY KEY (`user_gym_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `master_gym_id` (`master_gym_id`);

--
-- Indexes for table `user_health_devices`
--
ALTER TABLE `user_health_devices`
  ADD PRIMARY KEY (`health_id`),
  ADD UNIQUE KEY `uniqueindex` (`user_id`,`date`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_health_provider_insurance`
--
ALTER TABLE `user_health_provider_insurance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `user_highfive`
--
ALTER TABLE `user_highfive`
  ADD PRIMARY KEY (`highfive_id`),
  ADD KEY `user_id` (`user_id`,`for_user_id`),
  ADD KEY `for_user_id` (`for_user_id`);

--
-- Indexes for table `user_invites`
--
ALTER TABLE `user_invites`
  ADD PRIMARY KEY (`invite_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `invited_user_id` (`invited_user_id`);

--
-- Indexes for table `user_points_history`
--
ALTER TABLE `user_points_history`
  ADD PRIMARY KEY (`point_history_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD PRIMARY KEY (`user_reward_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `master_reward_id` (`master_reward_id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`user_sessions_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `user_wallets`
--
ALTER TABLE `user_wallets`
  ADD PRIMARY KEY (`user_wallet_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `master_reward_id` (`master_reward_id`);

--
-- Indexes for table `user_wellness_answers`
--
ALTER TABLE `user_wellness_answers`
  ADD PRIMARY KEY (`user_wellness_answer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_invites`
--
ALTER TABLE `app_invites`
  MODIFY `app_invite_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table', AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'It is act as primary key of devices', AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `ecosystem_features`
--
ALTER TABLE `ecosystem_features`
  MODIFY `ecosystem_feature_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `ecosystem_rewards`
--
ALTER TABLE `ecosystem_rewards`
  MODIFY `ecosystem_reward_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `ecosystem_works`
--
ALTER TABLE `ecosystem_works`
  MODIFY `ecosystem_feature_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table';
--
-- AUTO_INCREMENT for table `expert_calendar`
--
ALTER TABLE `expert_calendar`
  MODIFY `calendar_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'It is act as primary key of expert_calendar';
--
-- AUTO_INCREMENT for table `expert_health_categories`
--
ALTER TABLE `expert_health_categories`
  MODIFY `expert_health_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table';
--
-- AUTO_INCREMENT for table `expert_qualifications`
--
ALTER TABLE `expert_qualifications`
  MODIFY `qualification_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `get_helps`
--
ALTER TABLE `get_helps`
  MODIFY `help_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of the Table', AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master_activation_codes`
--
ALTER TABLE `master_activation_codes`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `master_beacons`
--
ALTER TABLE `master_beacons`
  MODIFY `master_beacon_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `master_ecosystems`
--
ALTER TABLE `master_ecosystems`
  MODIFY `ecosystem_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `master_features`
--
ALTER TABLE `master_features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `master_gyms`
--
ALTER TABLE `master_gyms`
  MODIFY `master_gym_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `master_health_categories`
--
ALTER TABLE `master_health_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `master_health_providers_insurances`
--
ALTER TABLE `master_health_providers_insurances`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `master_issues`
--
ALTER TABLE `master_issues`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `master_merchants`
--
ALTER TABLE `master_merchants`
  MODIFY `master_merchant_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `master_rewards`
--
ALTER TABLE `master_rewards`
  MODIFY `master_reward_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `master_works`
--
ALTER TABLE `master_works`
  MODIFY `work_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications_logs`
--
ALTER TABLE `notifications_logs`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `queue_jobs`
--
ALTER TABLE `queue_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_issues`
--
ALTER TABLE `report_issues`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `session_prices`
--
ALTER TABLE `session_prices`
  MODIFY `session_price_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=216;
--
-- AUTO_INCREMENT for table `user_bookings`
--
ALTER TABLE `user_bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of table', AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `user_conversations`
--
ALTER TABLE `user_conversations`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user_feedback`
--
ALTER TABLE `user_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table', AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_garmin_data`
--
ALTER TABLE `user_garmin_data`
  MODIFY `user_garmin_data_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_garmin_information`
--
ALTER TABLE `user_garmin_information`
  MODIFY `user_garmin_information_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_gyms`
--
ALTER TABLE `user_gyms`
  MODIFY `user_gym_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user_health_devices`
--
ALTER TABLE `user_health_devices`
  MODIFY `health_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table', AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `user_health_provider_insurance`
--
ALTER TABLE `user_health_provider_insurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_highfive`
--
ALTER TABLE `user_highfive`
  MODIFY `highfive_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user_invites`
--
ALTER TABLE `user_invites`
  MODIFY `invite_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key of the table', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_points_history`
--
ALTER TABLE `user_points_history`
  MODIFY `point_history_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_rewards`
--
ALTER TABLE `user_rewards`
  MODIFY `user_reward_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `user_sessions_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_transactions`
--
ALTER TABLE `user_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_wallets`
--
ALTER TABLE `user_wallets`
  MODIFY `user_wallet_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Its a primary Key of the table', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_wellness_answers`
--
ALTER TABLE `user_wellness_answers`
  MODIFY `user_wellness_answer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key of the Table', AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_invites`
--
ALTER TABLE `app_invites`
  ADD CONSTRAINT `app_invites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `ecosystem_features`
--
ALTER TABLE `ecosystem_features`
  ADD CONSTRAINT `ecosystem_features_ibfk_1` FOREIGN KEY (`ecosystem_id`) REFERENCES `master_ecosystems` (`ecosystem_id`),
  ADD CONSTRAINT `ecosystem_features_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `master_features` (`feature_id`);

--
-- Constraints for table `ecosystem_rewards`
--
ALTER TABLE `ecosystem_rewards`
  ADD CONSTRAINT `ecosystem_rewards_ibfk_1` FOREIGN KEY (`master_merchant_id`) REFERENCES `master_merchants` (`master_merchant_id`),
  ADD CONSTRAINT `ecosystem_rewards_ibfk_2` FOREIGN KEY (`master_reward_id`) REFERENCES `master_rewards` (`master_reward_id`);

--
-- Constraints for table `ecosystem_works`
--
ALTER TABLE `ecosystem_works`
  ADD CONSTRAINT `ecosystem_works_ibfk_1` FOREIGN KEY (`ecosystem_id`) REFERENCES `master_ecosystems` (`ecosystem_id`),
  ADD CONSTRAINT `ecosystem_works_ibfk_2` FOREIGN KEY (`work_id`) REFERENCES `master_works` (`work_id`);

--
-- Constraints for table `expert_calendar`
--
ALTER TABLE `expert_calendar`
  ADD CONSTRAINT `expert_calendar_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `expert_health_categories`
--
ALTER TABLE `expert_health_categories`
  ADD CONSTRAINT `expert_health_categories_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `expert_health_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `master_health_categories` (`category_id`);

--
-- Constraints for table `expert_qualifications`
--
ALTER TABLE `expert_qualifications`
  ADD CONSTRAINT `expert_qualifications_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `get_helps`
--
ALTER TABLE `get_helps`
  ADD CONSTRAINT `get_helps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `master_beacons`
--
ALTER TABLE `master_beacons`
  ADD CONSTRAINT `master_beacons_ibfk_1` FOREIGN KEY (`master_gym_id`) REFERENCES `master_gyms` (`master_gym_id`);

--
-- Constraints for table `master_ecosystems`
--
ALTER TABLE `master_ecosystems`
  ADD CONSTRAINT `master_ecosystems_ibfk_1` FOREIGN KEY (`subadmin_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `master_gyms`
--
ALTER TABLE `master_gyms`
  ADD CONSTRAINT `master_gyms_ibfk_1` FOREIGN KEY (`master_work_id`) REFERENCES `master_works` (`work_id`);

--
-- Constraints for table `master_rewards`
--
ALTER TABLE `master_rewards`
  ADD CONSTRAINT `master_rewards_ibfk_1` FOREIGN KEY (`master_merchant_id`) REFERENCES `master_merchants` (`master_merchant_id`);

--
-- Constraints for table `notifications_logs`
--
ALTER TABLE `notifications_logs`
  ADD CONSTRAINT `notifications_logs_ibfk_1` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notifications_logs_ibfk_2` FOREIGN KEY (`reciever_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `report_issues`
--
ALTER TABLE `report_issues`
  ADD CONSTRAINT `report_issues_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `report_issues_ibfk_2` FOREIGN KEY (`issue_id`) REFERENCES `master_issues` (`issue_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `session_prices`
--
ALTER TABLE `session_prices`
  ADD CONSTRAINT `session_prices_ibfk_1` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `session_prices_ibfk_2` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `session_prices_ibfk_3` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_bookings`
--
ALTER TABLE `user_bookings`
  ADD CONSTRAINT `user_bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_bookings_ibfk_2` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_conversations`
--
ALTER TABLE `user_conversations`
  ADD CONSTRAINT `user_conversations_ibfk_1` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_conversations_ibfk_2` FOREIGN KEY (`receiver_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_feedback`
--
ALTER TABLE `user_feedback`
  ADD CONSTRAINT `user_feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_feedback_ibfk_2` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_garmin_data`
--
ALTER TABLE `user_garmin_data`
  ADD CONSTRAINT `user_garmin_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_garmin_information`
--
ALTER TABLE `user_garmin_information`
  ADD CONSTRAINT `user_garmin_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_gyms`
--
ALTER TABLE `user_gyms`
  ADD CONSTRAINT `user_gyms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_gyms_ibfk_2` FOREIGN KEY (`master_gym_id`) REFERENCES `master_gyms` (`master_gym_id`);

--
-- Constraints for table `user_health_devices`
--
ALTER TABLE `user_health_devices`
  ADD CONSTRAINT `user_health_devices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_health_provider_insurance`
--
ALTER TABLE `user_health_provider_insurance`
  ADD CONSTRAINT `user_health_provider_insurance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_health_provider_insurance_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `master_health_providers_insurances` (`attribute_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_highfive`
--
ALTER TABLE `user_highfive`
  ADD CONSTRAINT `user_highfive_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_highfive_ibfk_2` FOREIGN KEY (`for_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_invites`
--
ALTER TABLE `user_invites`
  ADD CONSTRAINT `user_invites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_invites_ibfk_2` FOREIGN KEY (`invited_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_points_history`
--
ALTER TABLE `user_points_history`
  ADD CONSTRAINT `user_points_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD CONSTRAINT `user_rewards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_rewards_ibfk_2` FOREIGN KEY (`master_reward_id`) REFERENCES `master_rewards` (`master_reward_id`);

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_sessions_ibfk_2` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD CONSTRAINT `user_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_transactions_ibfk_2` FOREIGN KEY (`expert_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_wellness_answers`
--
ALTER TABLE `user_wellness_answers`
  ADD CONSTRAINT `user_wellness_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
