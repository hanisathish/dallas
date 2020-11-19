-- phpMyAdmin SQL Dump
-- version 4.0.10deb1ubuntu0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 16, 2020 at 08:28 AM
-- Server version: 5.6.33-0ubuntu0.14.04.1
-- PHP Version: 7.1.20-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dallaslivenew`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE IF NOT EXISTS `apps` (
  `appId` int(20) NOT NULL AUTO_INCREMENT,
  `appName` varchar(250) DEFAULT NULL,
  `appPath` varchar(255) DEFAULT NULL,
  `appStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,2=Inactive',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`appId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `apps`
--

INSERT INTO `apps` (`appId`, `appName`, `appPath`, `appStatus`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 'accounts', 'accounts', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL),
(2, 'check-ins', 'checkins', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL),
(3, 'giving', 'giving', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL),
(4, 'groups', 'groups', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL),
(5, 'people', 'people', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL),
(6, 'registrations', 'registrations', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL),
(7, 'resources', 'resources', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL),
(8, 'services', 'services', 1, NULL, '2019-07-15 21:02:37', NULL, '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_count`
--

CREATE TABLE IF NOT EXISTS `attendance_count` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `event_id` bigint(20) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `male_count` int(10) DEFAULT NULL,
  `female_count` int(10) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `checkins`
--

CREATE TABLE IF NOT EXISTS `checkins` (
  `chId` bigint(20) NOT NULL AUTO_INCREMENT,
  `eventId` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `chINDateTime` timestamp NULL DEFAULT NULL,
  `chOUTDateTime` timestamp NULL DEFAULT NULL,
  `chKind` enum('Regular','Guest','Volunteer') DEFAULT 'Regular' COMMENT 'user type with ''Regular'',''Guest'',''Volunteer''',
  `notify_user_id` bigint(20) DEFAULT NULL,
  `guest_f_name` varchar(255) DEFAULT NULL,
  `guest_l_name` varchar(255) DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `guest_mobile` varchar(255) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`chId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comm_details`
--

CREATE TABLE IF NOT EXISTS `comm_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `comm_master_id` bigint(20) NOT NULL,
  `to_user_id` bigint(20) NOT NULL,
  `read_status` varchar(255) NOT NULL DEFAULT 'UNREAD' COMMENT 'Read status:READ,UNREAD',
  `delete_status` varchar(255) NOT NULL DEFAULT 'UNDELETED' COMMENT 'Message status:DELETED,UNDELETED',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comm_masters`
--

CREATE TABLE IF NOT EXISTS `comm_masters` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `comm_template_id` bigint(20) DEFAULT NULL,
  `org_id` bigint(20) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Email,2=Notification',
  `tag` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `name` text,
  `subject` mediumtext,
  `body` mediumtext,
  `from_user_id` bigint(20) DEFAULT NULL COMMENT 'From UserId',
  `related_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comm_templates`
--

CREATE TABLE IF NOT EXISTS `comm_templates` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `subject` text,
  `body` text,
  `org_id` bigint(20) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `comm_templates`
--

INSERT INTO `comm_templates` (`id`, `tag`, `name`, `subject`, `body`, `org_id`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 'welcome', 'Welcome Email', 'Welcome Email Sujbect', 'Welcome Email Body', 0, NULL, '2019-08-21 07:01:18', NULL, '0000-00-00 00:00:00', NULL, NULL),
(2, 'household_added', 'household_added name', 'household_added subj', 'household_added body', 0, NULL, '2019-08-21 07:01:18', NULL, '0000-00-00 00:00:00', NULL, NULL),
(3, 'event_added', 'event_added name', 'event_added sub ', 'event_added body', 0, NULL, '2019-08-21 07:01:35', NULL, '0000-00-00 00:00:00', NULL, NULL),
(4, 'schedule_auto_notify', 'Auto Scheduling Notification', 'Event scheduled', 'Your have been placed on the schedule. (Auto assigned)', 0, NULL, '2019-09-27 03:34:53', NULL, NULL, NULL, NULL),
(5, 'schedule_manual_notify', 'Scheduling event', 'Event Scheduled', 'Your Event has been scheduled, please follow the below mentioned details.', 0, NULL, '2019-09-27 03:34:53', NULL, NULL, NULL, NULL),
(6, 'schedule_confirmation', 'Schedule confirmation', 'Schedule Confirmation', 'You have been placed on the schedule for the following dates. To respond or simply view this schedule, click the appropriate button below.', 0, NULL, '2019-09-27 03:34:53', NULL, NULL, NULL, NULL),
(7, 'schedule_reminder', 'Schedule Remind', 'Schedule Remind', 'A Reminder that your event has been scheduled for below listed dates.', 0, NULL, '2019-09-27 03:34:53', NULL, NULL, NULL, NULL),
(8, 'schedule_check_out_notification_to_guest', 'Schedule check out notification to guest', 'Event Schedule Notification', 'This is notify that event has been scheduled.thank_you_for_service', 0, NULL, '2019-09-27 03:34:53', NULL, NULL, NULL, NULL),
(9, 'thank_you_for_service', 'Thanks for your service', 'Thanks for Service', 'Thanks for attending the below listed event.', 0, NULL, '2019-09-27 03:34:53', NULL, NULL, NULL, NULL),
(10, 'schedule_cancelled', 'Schedule cancelled', 'Schedule cancelled', 'sorry to inform you that. Your scheduled event has been canceled. For further information contact administrator.', 0, NULL, '2019-09-27 03:34:53', NULL, NULL, NULL, NULL),
(11, 'message', 'Message', 'Message Sujbect', 'Message Body', 0, NULL, '2019-08-21 07:01:18', NULL, '0000-00-00 00:00:00', NULL, NULL),
(12, 'birthday', 'Birthday Email', 'Birthday Email Sujbect', 'Birthday Email Body', 0, NULL, '2020-07-15 07:45:48', NULL, NULL, NULL, NULL),
(13, 'anniversary', 'Anniversary Email', 'Anniversary Email Sujbect', 'Anniversary Email Body', 0, NULL, '2020-07-15 07:45:48', NULL, NULL, NULL, NULL),
(14, 'group_member_signup', 'Group Member Signup Email', 'Group Member Signup Email Sujbect', 'Birthday Email Body', 0, NULL, '2020-07-15 07:45:48', NULL, NULL, NULL, NULL),
(15, 'group_member_event_reminder', 'Group Member Event Reminder Email', 'Group Member Event Reminder Email Sujbect', 'Birthday Email Body', 0, NULL, '2020-07-15 07:45:48', NULL, NULL, NULL, NULL),
(16, 'event_child_checkin_notify', 'Event Child Checkin Notify Email', 'Event Child Checkin Notify Email Sujbect', 'Event Child Checkin Notify Email Body', 0, NULL, '2020-07-15 07:45:48', NULL, NULL, NULL, NULL),
(17, 'notify_member_make_leader', 'Made as a Leader', 'Made as a Leader', 'Made as a Leader for group', 0, NULL, '2019-08-21 07:01:18', NULL, '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_group`
--

CREATE TABLE IF NOT EXISTS `contact_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `orgId` bigint(20) NOT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact_group_map`
--

CREATE TABLE IF NOT EXISTS `contact_group_map` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contact_list_id` bigint(20) NOT NULL,
  `contact_group_id` bigint(20) NOT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact_list`
--

CREATE TABLE IF NOT EXISTS `contact_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `c_email` text NOT NULL,
  `c_f_name` varchar(255) DEFAULT NULL,
  `c_l_name` varchar(255) DEFAULT NULL,
  `orgId` bigint(20) NOT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cron_batch_email`
--

CREATE TABLE IF NOT EXISTS `cron_batch_email` (
  `cron_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique cron_batch_email',
  `recipient_user_id` bigint(20) DEFAULT NULL,
  `orgId` bigint(20) NOT NULL,
  `subject` mediumtext COMMENT 'Subject of the email',
  `message` mediumtext COMMENT 'Message body of the email',
  `recipient` mediumtext COMMENT 'To recipient for the email',
  `cc_recipient` mediumtext COMMENT 'CC recipient for the email',
  `files_offset` mediumtext COMMENT 'Count of files in the attachments in seriliazed format',
  `file_attach` mediumtext COMMENT 'Full path of files in the attachments in seriliazed format',
  `send_status` int(1) NOT NULL DEFAULT '0' COMMENT '0 => not yet sent, 1=> sent,2=>error',
  `sent_from` varchar(100) DEFAULT NULL COMMENT 'Name of the sender',
  `sent_from_email` varchar(255) DEFAULT NULL COMMENT 'Email address of the sender',
  `send_dts` datetime DEFAULT NULL COMMENT 'Created Date and time of the message',
  `mail_error` mediumtext COMMENT 'Error message if sending email fails',
  `subaccount_id` varchar(50) DEFAULT NULL COMMENT 'Sub account id of the regions',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cron_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventId` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `eventName` varchar(250) DEFAULT NULL,
  `eventFreq` varchar(250) DEFAULT NULL COMMENT 'Daily,Weekly,None',
  `eventDesc` text,
  `eventCreatedDate` date DEFAULT NULL,
  `eventCheckin` time DEFAULT NULL,
  `eventShowTime` time DEFAULT NULL,
  `eventStartCheckin` time DEFAULT NULL,
  `eventEndCheckin` time DEFAULT NULL,
  `eventLocation` text,
  `eventRoom` int(11) DEFAULT NULL,
  `eventResource` int(11) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`eventId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_attedance`
--

CREATE TABLE IF NOT EXISTS `event_attedance` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `user_id` bigint(22) DEFAULT NULL,
  `event_id` bigint(22) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `gender` varchar(150) DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `fields` varchar(1000) DEFAULT NULL,
  `profile_fields` varchar(250) DEFAULT NULL,
  `general_fields` varchar(500) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - deactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

CREATE TABLE IF NOT EXISTS `form_submissions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `form_id` bigint(20) DEFAULT NULL,
  `profile_fields` varchar(1000) DEFAULT NULL,
  `general_fields` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `giving`
--

CREATE TABLE IF NOT EXISTS `giving` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `orgId` bigint(20) DEFAULT NULL,
  `event_id` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `payment_gateway_id` bigint(20) DEFAULT NULL COMMENT 'payment_gateway.payment_gateway_id',
  `other_payment_method_id` bigint(20) DEFAULT NULL COMMENT 'other_payment_methods.other_payment_method_id',
  `amount` varchar(25) DEFAULT NULL,
  `pay_mode` varchar(100) DEFAULT NULL COMMENT 'Credit,Debit',
  `purpose_note` text,
  `transaction_date` datetime DEFAULT NULL COMMENT 'Date on which transaction was done',
  `transaction_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Status of transaction 1 => submitted, 2 = > confirmed 3=> declined/error',
  `customer_id` text COMMENT 'customer_id response sent from payment gateway',
  `token_id` text COMMENT 'token id from payment Gateway',
  `submited_datetime` datetime DEFAULT NULL,
  `confirmed_date` datetime DEFAULT NULL,
  `final_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Submitted,2=InProgress,3=Confirmed,4=Declined/Rejected',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) NOT NULL,
  `groupType_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `notes` text,
  `image_path` text,
  `meeting_schedule` text,
  `isPublic` tinyint(1) DEFAULT '1' COMMENT '0=Disable, 1=Enable',
  `location` varchar(255) DEFAULT NULL,
  `is_enroll_autoClose` tinyint(1) NOT NULL DEFAULT '0',
  `enroll_autoClose_on` date DEFAULT NULL,
  `is_enroll_autoClose_count` tinyint(1) NOT NULL DEFAULT '0',
  `enroll_autoClose_count` int(15) DEFAULT NULL COMMENT 'Max attendendies per group',
  `is_enroll_notify_count` tinyint(1) NOT NULL DEFAULT '0',
  `enroll_notify_count` int(15) DEFAULT NULL,
  `contact_email` varchar(75) DEFAULT NULL,
  `visible_leaders_fields` text COMMENT 'Stored in serialized formate',
  `visible_members_fields` text COMMENT 'Stored in serialized Formate',
  `can_leaders_search_people` tinyint(1) NOT NULL DEFAULT '1',
  `can_leaders_take_attendance` tinyint(1) NOT NULL DEFAULT '1',
  `is_event_remind` tinyint(1) NOT NULL DEFAULT '1',
  `event_remind_before` int(5) DEFAULT '0',
  `enroll_status` tinyint(1) NOT NULL DEFAULT '1',
  `enroll_msg` varchar(255) DEFAULT NULL,
  `leader_visibility_publicly` tinyint(1) NOT NULL DEFAULT '1',
  `is_event_public` tinyint(1) NOT NULL DEFAULT '1',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_enrolls`
--

CREATE TABLE IF NOT EXISTS `group_enrolls` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(22) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `mobile_no` int(15) DEFAULT NULL,
  `message` text,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_events`
--

CREATE TABLE IF NOT EXISTS `group_events` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(22) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `isMutiDay_event` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `repeat` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text,
  `is_event_remind` tinyint(1) NOT NULL DEFAULT '1',
  `event_remind_before` varchar(255) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_events_attendance`
--

CREATE TABLE IF NOT EXISTS `group_events_attendance` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `event_id` bigint(22) DEFAULT NULL,
  `group_member_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE IF NOT EXISTS `group_members` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) NOT NULL,
  `group_id` bigint(22) DEFAULT NULL,
  `isUser` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=User, 2=Enrolled User',
  `user_id` bigint(20) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=Leader, 2=Member',
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `message` text,
  `member_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_resources`
--

CREATE TABLE IF NOT EXISTS `group_resources` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(22) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=File, 2=URL Path',
  `source` text,
  `description` text,
  `visibility` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Only for Leaders / Admins, 2=ALL',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_tags`
--

CREATE TABLE IF NOT EXISTS `group_tags` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(22) DEFAULT NULL,
  `tag_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_types`
--

CREATE TABLE IF NOT EXISTS `group_types` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `isPublic` tinyint(1) NOT NULL DEFAULT '1',
  `d_isPublic` tinyint(1) DEFAULT '1' COMMENT '0=Disable, 1=Enable',
  `d_meeting_schedule` text,
  `d_description` text,
  `d_location` varchar(255) DEFAULT NULL,
  `d_contact_email` varchar(75) DEFAULT NULL,
  `d_visible_leaders_fields` text COMMENT 'Stored in serialized formate',
  `d_visible_members_fields` text COMMENT 'Stored in serialized Formate',
  `d_is_enroll_autoClose` tinyint(1) NOT NULL DEFAULT '0',
  `d_enroll_autoClose_on` date DEFAULT NULL,
  `d_is_enroll_autoClose_count` tinyint(1) NOT NULL DEFAULT '0',
  `d_enroll_autoClose_count` int(15) DEFAULT NULL COMMENT 'Max attendendies per group',
  `d_is_enroll_notify_count` tinyint(1) NOT NULL DEFAULT '0',
  `d_enroll_notify_count` int(15) DEFAULT NULL,
  `d_can_leaders_search_people` tinyint(1) NOT NULL DEFAULT '1',
  `d_is_event_public` tinyint(1) NOT NULL DEFAULT '1',
  `d_is_event_remind` tinyint(1) NOT NULL DEFAULT '1',
  `d_event_remind_before` int(5) DEFAULT NULL,
  `d_can_leaders_take_attendance` tinyint(1) NOT NULL DEFAULT '1',
  `d_enroll_status` tinyint(1) NOT NULL DEFAULT '1',
  `d_enroll_msg` varchar(255) DEFAULT NULL,
  `d_leader_visibility_publicly` tinyint(1) NOT NULL DEFAULT '1',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `households`
--

CREATE TABLE IF NOT EXISTS `households` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) NOT NULL,
  `hhPrimaryUserId` bigint(20) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `household_user`
--

CREATE TABLE IF NOT EXISTS `household_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `household_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `isPrimary` tinyint(2) NOT NULL DEFAULT '2',
  `createdBy` bigint(20) DEFAULT NULL,
  `updatedBy` text,
  `deletedBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `insights`
--

CREATE TABLE IF NOT EXISTS `insights` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(22) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=File, 2=URL Path',
  `source` text,
  `description` text,
  `visibility` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Only for Leaders / Admins, 2=ALL',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail_config`
--

CREATE TABLE IF NOT EXISTS `mail_config` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `mail_driver` text,
  `mail_host` text,
  `mail_port` text,
  `mail_username` text,
  `mail_password` text,
  `mail_encryption` text,
  `mail_from_name` text,
  `mail_from_address` text,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mail_config`
--

INSERT INTO `mail_config` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_from_name`, `mail_from_address`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 'sendmail', 'site.org', '465', 'bot@site.org', '123456', 'tls', 'CreateWebinarLocal', 'bot@site.org', NULL, '2020-05-27 13:23:34', NULL, '2020-05-28 10:13:21', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_lookup_data`
--

CREATE TABLE IF NOT EXISTS `master_lookup_data` (
  `mldId` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `mldKey` varchar(150) DEFAULT NULL,
  `mldValue` varchar(200) DEFAULT NULL,
  `mldType` enum('A','B') NOT NULL DEFAULT 'A' COMMENT ' A=Master Code,B=Organization Added Code',
  `mldOption` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Edit - Delete, 2=Edit - No Delete,3=No Edit - Delete,4=No Edit - No Delete',
  `mldOrder` int(10) NOT NULL DEFAULT '0',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mldId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `master_lookup_data`
--

INSERT INTO `master_lookup_data` (`mldId`, `orgId`, `mldKey`, `mldValue`, `mldType`, `mldOption`, `mldOrder`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 0, 'school_name', 'High School', 'A', 1, 0, NULL, '2019-07-10 01:21:10', NULL, '2019-07-16 01:09:52', NULL, NULL),
(2, 0, 'school_name', 'Middle School', 'A', 1, 0, NULL, '2019-07-10 01:30:06', NULL, '2019-07-16 01:09:52', NULL, NULL),
(3, 0, 'name_prefix', 'Mr.', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(4, 0, 'name_prefix', 'Mrs.', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(5, 0, 'name_prefix', 'Ms.', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(6, 0, 'name_prefix', 'Miss', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(7, 0, 'name_prefix', 'Dr.', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(8, 0, 'name_prefix', 'Rev.', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(9, 0, 'name_suffix', 'Jr.', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(10, 0, 'name_suffix', 'Sr.', 'A', 1, 0, NULL, '2019-07-10 01:30:07', NULL, '2019-07-16 01:09:52', NULL, NULL),
(11, 0, 'name_suffix', 'Ph.D.', 'A', 1, 0, NULL, '2019-07-10 01:30:08', NULL, '2019-07-16 01:09:52', NULL, NULL),
(12, 0, 'name_suffix', 'II', 'A', 1, 0, NULL, '2019-07-10 01:30:08', NULL, '2019-07-16 01:09:52', NULL, NULL),
(13, 0, 'name_suffix', 'III', 'A', 1, 0, NULL, '2019-07-10 01:30:08', NULL, '2019-07-16 01:09:52', NULL, NULL),
(14, 0, 'membership_inactive_reason', 'Moved', 'A', 1, 0, NULL, '2019-07-10 01:30:08', NULL, '2019-07-16 01:09:52', NULL, NULL),
(15, 0, 'membership_inactive_reason', 'New Church', 'A', 1, 0, NULL, '2019-07-10 01:30:08', NULL, '2019-07-16 01:09:52', NULL, NULL),
(16, 0, 'membership_inactive_reason', 'Deceased', 'A', 4, 0, NULL, '2019-07-10 01:30:08', NULL, '2019-07-16 01:09:52', NULL, NULL),
(17, 0, 'marital_status', 'Single', 'A', 1, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(18, 0, 'marital_status', 'Married', 'A', 4, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(19, 0, 'marital_status', 'Widowed', 'A', 1, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(20, 0, 'membership_status', 'Member', 'A', 1, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(21, 0, 'membership_status', 'Regular Attender', 'A', 1, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(22, 0, 'membership_status', 'Visitor', 'A', 1, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(23, 0, 'membership_status', 'Participant', 'A', 1, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(24, 0, 'membership_status', 'In Progress', 'A', 1, 0, NULL, '2019-07-10 01:30:09', NULL, '2019-07-16 01:09:52', NULL, NULL),
(25, 0, 'grade_name', 'Pre-K', 'A', 4, 0, NULL, '2019-07-10 02:13:30', NULL, '2019-07-16 01:09:52', NULL, NULL),
(26, 0, 'grade_name', 'K', 'A', 4, 0, NULL, '2019-07-10 02:13:30', NULL, '2019-07-16 01:09:52', NULL, NULL),
(27, 0, 'grade_name', '1st', 'A', 4, 0, NULL, '2019-07-10 02:13:30', NULL, '2019-07-16 01:09:52', NULL, NULL),
(28, 0, 'grade_name', '2nd', 'A', 1, 0, NULL, '2019-07-10 02:13:30', NULL, '2019-07-16 01:09:52', NULL, NULL),
(29, 0, 'grade_name', '3rd', 'A', 4, 0, NULL, '2019-07-10 02:13:30', NULL, '2019-07-16 01:09:52', NULL, NULL),
(30, 0, 'room_group', 'Group1', 'A', 4, 0, NULL, '2019-08-22 05:33:55', NULL, '2019-08-22 05:33:55', NULL, NULL),
(31, 0, 'resource_category', 'Electronic', 'A', 4, 0, NULL, '2019-08-22 05:33:55', NULL, '2019-08-22 05:33:55', NULL, NULL),
(32, 0, 'pastor_board', 'Electronic', 'A', 1, 0, NULL, '2019-09-10 22:35:01', NULL, '0000-00-00 00:00:00', NULL, NULL),
(33, 0, 'pastor_board', 'Home Care', 'A', 1, 0, NULL, '2019-09-10 22:35:01', NULL, '0000-00-00 00:00:00', NULL, NULL),
(34, 0, 'school_name', 'Elementary', 'A', 1, 0, NULL, '2019-07-10 01:21:10', NULL, '2019-07-16 01:09:52', NULL, NULL),
(35, 0, 'school_name', 'Daycare', 'A', 1, 0, NULL, '2019-07-10 01:30:06', NULL, '2019-07-16 01:09:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 1),
(7, '2019_05_06_061007_create_permission_tables', 1),
(8, '2019_05_06_061659_create_posts_table', 1),
(9, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(10, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(11, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(12, '2016_06_01_000004_create_oauth_clients_table', 2),
(13, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0267f3a9c90be6f61a1a4b14b309bc6bf9b080563b3ae15c084daa6a2394f38e78f488a4a3d13833', 7, 1, 'dallas', '[]', 0, '2020-08-30 14:08:22', '2020-08-30 14:08:22', '2021-08-30 19:38:22'),
('06b92c66f47f1b09e8cb6e1ee32778a80108bdb62e83718771fd3b2163b707491784dba739514418', 1, 1, 'dollar', '[]', 0, '2019-08-28 13:13:18', '2019-08-28 13:13:18', '2020-08-29 00:13:18'),
('0a2d222035873ece26def9b31cdb77282f4b1c45efd98819de67f0b2d34837d1f7403f88dccb3b3b', 7, 1, 'dallas', '[]', 0, '2020-10-04 17:00:58', '2020-10-04 17:00:58', '2021-10-04 22:30:58'),
('0d61ed80db33fe1aa5e153100ae879bb44c12644aad237106c470b656356dd5c6779d6c8b9f894a8', 1, 1, 'dollar', '[]', 0, '2019-09-05 14:45:25', '2019-09-05 14:45:25', '2020-09-06 01:45:25'),
('0d627e6a09ab0b838eb39f509d07a6dde788504eb4caa526fe3e14b06847ea8240e936c45f90108c', 2, 1, 'dollar', '[]', 0, '2020-08-08 07:32:33', '2020-08-08 07:32:33', '2021-08-08 13:02:33'),
('0fd5c8dc43845d73972b409c3730b1c32133490ebf3be9485b4ba89aa6f9b5fcaa37438f2274efa0', 1, 1, 'dollar', '[]', 0, '2019-09-02 03:15:09', '2019-09-02 03:15:09', '2020-09-02 14:15:09'),
('10d19dda2a143035ff12b598a06c0f38303c787d0c52c7ccdc4095f8be2fdc6133a68a934834f68d', 6, 1, 'dallas', '[]', 0, '2020-08-15 05:23:12', '2020-08-15 05:23:12', '2021-08-15 10:53:12'),
('1121dbd9f08153249fa70f3f5d19de4966298b748bcaf10658ac243d3f8f8192051face574569e07', 2, 1, 'dallas', '[]', 0, '2020-09-27 14:52:45', '2020-09-27 14:52:45', '2021-09-27 20:22:45'),
('13f8338c1f2fbf01a0d3e28b44290be8079a78676fd22aa9780c4fb0fd89ed75c05ea958ec00925e', 2, 1, 'dollar', '[]', 0, '2020-08-08 10:52:31', '2020-08-08 10:52:31', '2021-08-08 16:22:31'),
('148f2179b77ce62b254831e034be049f730b3b7458da3b76477785459309691b1d02ac045c6f2f9d', 6, 1, 'dallas', '[]', 0, '2020-08-15 10:51:51', '2020-08-15 10:51:51', '2021-08-15 16:21:51'),
('158da917efef217661d3f1743b01e1cf123b7560650a466d44826eb768f230375b9aa576a984ce2f', 7, 1, 'dallas', '[]', 0, '2020-10-04 13:07:13', '2020-10-04 13:07:13', '2021-10-04 18:37:13'),
('15ad2f0f8bf28053724b2b8e5c90f73d4411b185560e435d5b8a992b341862f3ffb923ba4e46a100', 2, 1, 'dollar', '[]', 0, '2020-07-25 02:25:28', '2020-07-25 02:25:28', '2021-07-25 07:55:28'),
('19272c2e52d3f4bf9c452415fef1cc3e2a23e3ddf2bb36eb4955393b6b5399abe289bec13b157272', 1, 1, 'dollar', '[]', 0, '2019-08-24 14:44:52', '2019-08-24 14:44:52', '2020-08-25 01:44:52'),
('1a163468922c8f47df6ecd61d52b138e6c9358ca8b688e7bf08424be46080391bce625936ff4a9fd', 11, 1, 'dallas', '[]', 0, '2020-10-01 10:12:30', '2020-10-01 10:12:30', '2021-10-01 15:42:30'),
('21cde2988fbe0ebdc951ccd1deda5a49fe5d7fb3f59c10ca1fac3830c133bbf47e870e2c46ec8036', 2, 1, 'dallas', '[]', 0, '2020-09-08 14:05:44', '2020-09-08 14:05:44', '2021-09-08 19:35:44'),
('222790afe790a87da2add79370bdec55c2ea3fc097541ad88b4e46e438b51ec0463e33b70f486c9f', 2, 1, 'dallas', '[]', 0, '2020-08-31 06:36:05', '2020-08-31 06:36:05', '2021-08-31 12:06:05'),
('2d29e100b686baa8d92c5c7f10e3aa5b6cc5673dc59c8f052bcfb512c9d1b7b9c3e4751f2f9924da', 9, 1, 'dollar', '[]', 0, '2019-09-01 22:38:44', '2019-09-01 22:38:44', '2020-09-02 09:38:44'),
('2e04c56a1b67d9e38312748d9489a1fba0dcd9740a1017e688807e4bb309ea86489059424170c269', 2, 1, 'dallas', '[]', 0, '2020-09-02 01:04:38', '2020-09-02 01:04:38', '2021-09-02 06:34:38'),
('2f19d7165ec35d648312802e301d7e7126c38f437ffc008ccd82e2f674e46ac8e6b5c58b0c20f352', 2, 1, 'dallas', '[]', 0, '2020-08-30 14:44:25', '2020-08-30 14:44:25', '2021-08-30 20:14:25'),
('352cf1202ff51315eaf8b0780103f98e078a167905398063eeb324c8a449fd96f00562efcd5d1741', 1, 1, 'dollar', '[]', 0, '2020-06-19 02:21:02', '2020-06-19 02:21:02', '2021-06-19 07:51:02'),
('395097f26173b486b65a44d89ebafe6720d001f283bb1a553b64d31648017c72e70755ddc773162e', 7, 1, 'dallas', '[]', 0, '2020-10-02 02:08:19', '2020-10-02 02:08:19', '2021-10-02 07:38:19'),
('3ccb814d74998b15b6990aeccd5d9192a0429e9a8a1e41793e37dca4faa274eba3448febb38e8183', 2, 1, 'dallas', '[]', 0, '2020-10-01 09:52:44', '2020-10-01 09:52:44', '2021-10-01 15:22:44'),
('402ab601017494b14bc09382e0965ecd1e5e5e351aae8cd067ffb41f057e7f5232c7a9bb37348bc0', 8, 1, 'dollar', '[]', 0, '2019-09-01 22:37:33', '2019-09-01 22:37:33', '2020-09-02 09:37:33'),
('414c7179fc45aa1a31c9daa3d825d65b80ec8c516c37dcc18ad6adfe25d8e9c3736b20d725160115', 7, 1, 'dallas', '[]', 0, '2020-10-03 03:04:23', '2020-10-03 03:04:23', '2021-10-03 08:34:23'),
('455877b653904f9c6048523a34715a018cef4d976c791e5f5cab7dfa5ce0409820ac15e772a3256d', 1, 1, 'dollar', '[]', 0, '2019-09-01 18:23:49', '2019-09-01 18:23:49', '2020-09-02 05:23:49'),
('489118680f2e5a891c33f37be35cebff1d6aba3fd0af6bbf1883d9bcfefdeeace74abe40247de879', 2, 1, 'dallas', '[]', 0, '2020-08-13 15:07:48', '2020-08-13 15:07:48', '2021-08-13 20:37:48'),
('4ade27e90e3c49aa663abfcbd2791a380f289d148fcea14909a8e971fd4ba3588053b27941b206fd', 11, 1, 'dallas', '[]', 0, '2020-10-02 01:53:36', '2020-10-02 01:53:36', '2021-10-02 07:23:36'),
('4b7b9c8b03c7fb16cda7915fcdf2a7971120e698767da0b6fec546bf61ceadeebadd7f40b86a6c5f', 3, 1, 'dollar', '[]', 0, '2020-07-19 02:40:50', '2020-07-19 02:40:50', '2021-07-19 08:10:50'),
('4ecb26ff1a41a43542769c88385e6ba934337c54f5eb846c999da6c3bdaed2fe91cd1b1d8242e016', 2, 1, 'dallas', '[]', 0, '2020-09-21 03:48:31', '2020-09-21 03:48:31', '2021-09-21 09:18:31'),
('4f37a4d15af2df369a47c1dae67a2f6b19e744ab4c35a086f44920a8505d762dcc2df204144a2ab9', 2, 1, 'dallas', '[]', 0, '2020-08-29 12:26:32', '2020-08-29 12:26:32', '2021-08-29 17:56:32'),
('5b39a06ab0987f8950fc9a6583fd0e6c98f069bbdd58140bfa55eeaaff74821f32dc80f662203624', 2, 1, 'dallas', '[]', 0, '2020-08-28 14:26:13', '2020-08-28 14:26:13', '2021-08-28 19:56:13'),
('5bc5e37fc7ce9f2f5986bb11187ff79233e8c958373ac8aaa0a3c02c1e230c4209dbbd82984a8ff1', 1, 1, 'dollar', '[]', 0, '2020-07-09 14:09:42', '2020-07-09 14:09:42', '2021-07-09 19:39:42'),
('5c8d6686f47680f57136bad220373e32214897e9c6569c1144a70921389234ddde097fcbf9255499', 2, 1, 'dollar', '[]', 0, '2020-07-15 13:15:53', '2020-07-15 13:15:53', '2021-07-15 18:45:53'),
('619e62dbad9256f483cd8726b22d9cc3ac25f98f5410deff9d8b8af117881248d6c9be6d36c29dfd', 2, 1, 'dollar', '[]', 0, '2020-07-24 09:19:41', '2020-07-24 09:19:41', '2021-07-24 14:49:41'),
('63b94f40890ab3f17150f9471f314b44ee59aeed816fa58b6f3203157fd76308b2ab2540042623bd', 2, 1, 'dollar', '[]', 0, '2020-07-28 15:53:26', '2020-07-28 15:53:26', '2021-07-28 21:23:26'),
('685dbfec990ed843e61c63b17448880dcb4c30d003612ed9122435006d78105d69a0b6ffd1d19ca6', 1, 1, 'dollar', '[]', 0, '2019-09-01 17:22:04', '2019-09-01 17:22:04', '2020-09-02 04:22:04'),
('68d5dfb5aa8da7396c5d2063c2bd8e79bf9162682e6e26db04dabe2e74300b7cefcba3ddb831f71e', 2, 1, 'dollar', '[]', 0, '2020-08-08 02:05:08', '2020-08-08 02:05:08', '2021-08-08 07:35:08'),
('692d58ba1376cb3ebfc6dd7acd20e530c128286c7d668d2b77738f44fb4ad5aeed3a13b69526412c', 11, 1, 'dallas', '[]', 0, '2020-10-02 02:23:04', '2020-10-02 02:23:04', '2021-10-02 07:53:04'),
('70a730f66b7cb90fbda63dbf50ff82cd8c929298331d99957aa64c7963cce49b878b019f61f75cba', 2, 1, 'dollar', '[]', 0, '2020-08-08 05:21:56', '2020-08-08 05:21:56', '2021-08-08 10:51:56'),
('714c6e61bb08aa30d5d649b146e525661a1f0cce949c8e17a4f3e98d6c4438869e8b042ab7062a8b', 1, 1, 'dollar', '[]', 0, '2019-09-09 14:43:57', '2019-09-09 14:43:57', '2020-09-10 01:43:57'),
('76b825058ef909da602b57ce9889be0a80a6fddc41e7076307f9326082476240a002e5c2485180e9', 1, 1, 'dollar', '[]', 0, '2019-09-09 03:21:06', '2019-09-09 03:21:06', '2020-09-09 14:21:06'),
('7a64927dc3d31e440440f694937044c0ae4c529e8cfb58925066fe36c142d7b36c26fc2e372e8145', 1, 1, 'dollar', '[]', 0, '2019-09-03 05:26:57', '2019-09-03 05:26:57', '2020-09-03 16:26:57'),
('7ac3ff843d901f7b89c6c99e21e5e20c37cba5eb2850b8bc9bc98c2c5c34983fd30ffe99b977a545', 2, 1, 'dallas', '[]', 0, '2020-08-15 17:30:07', '2020-08-15 17:30:07', '2021-08-15 23:00:07'),
('7c30cbce0a6743331c674d86f532f65cafe3ce5fa871de7483d2eaccf55c9a42c14bb0674909b1d3', 1, 1, 'dollar', '[]', 0, '2019-08-25 02:00:40', '2019-08-25 02:00:40', '2020-08-25 13:00:40'),
('7c4e7ae14f805d84075f202bd13f93a3f35a2f4089c01d56bf1efd99dfb4ecba51bad33e7548f3bd', 3, 1, 'dollar', '[]', 0, '2020-07-16 09:27:35', '2020-07-16 09:27:35', '2021-07-16 14:57:35'),
('7e1d70bf3f288eb4c2f815d57e93290abd3f41fdda886045c1a0c4446e53008ffb1d1b0a263ddafb', 1, 1, 'dollar', '[]', 0, '2019-09-01 18:24:46', '2019-09-01 18:24:46', '2020-09-02 05:24:46'),
('7ecbd0409c4c3013d8cd56633d2db05c9fdcf93a25f2472f8e7489a92821656e5bf54b0da585cf88', 7, 1, 'dallas', '[]', 0, '2020-10-14 15:54:06', '2020-10-14 15:54:06', '2021-10-14 21:24:06'),
('8407ae545b6bf07952355ec3447c6a80208c6e8b09a7637f7bf5f4ddb6c9dcb99ce3d1fa4050098a', 1, 1, 'dollar', '[]', 0, '2019-08-24 16:35:54', '2019-08-24 16:35:54', '2020-08-25 03:35:54'),
('8644a422bd227a9019961f50c56cd961e81c7c07ff2b5696436e42180581399780031e3a2cce57b6', 7, 1, 'dallas', '[]', 0, '2020-10-13 02:32:46', '2020-10-13 02:32:46', '2021-10-13 08:02:46'),
('874fce2789ee30bb57af512f2c9620a6859023272a3541ccb0098256a1a2e6ce84f82ae452b498de', 2, 1, 'dollar', '[]', 0, '2020-08-07 14:49:36', '2020-08-07 14:49:36', '2021-08-07 20:19:36'),
('8b44238fb799fac83ff96a8f95a67c7a59bec9def1ea4f343fc8a096357ada16d0aa8ef7b6742b3b', 6, 1, 'dallas', '[]', 0, '2020-08-15 02:56:46', '2020-08-15 02:56:46', '2021-08-15 08:26:46'),
('8c31456e7bbf658c7c8bb76e25c3a9248256f57983b74776634b00eceee2712250b844195af2641f', 2, 1, 'dallas', '[]', 0, '2020-09-20 13:09:03', '2020-09-20 13:09:03', '2021-09-20 18:39:03'),
('8e6e0a66d422a34f6e5abcb8ba0690a0f0e7fa5a363b89714a7f4befb698bfec523174143a5e936b', 7, 1, 'dallas', '[]', 0, '2020-08-16 02:53:33', '2020-08-16 02:53:33', '2021-08-16 08:23:33'),
('8ea3423e87cb771ac54a2a04ba1a4a6da4d24b2fcce7cfe880b9851ad2ce5ded6712fd90abdd498d', 7, 1, 'dallas', '[]', 0, '2020-10-08 00:53:12', '2020-10-08 00:53:12', '2021-10-08 06:23:12'),
('8f3a62307ef49a447a7697ebb22d123c781763cf8c7074e29254116c377ac3b79801eea02310fe12', 3, 1, 'dollar', '[]', 0, '2020-07-18 07:19:13', '2020-07-18 07:19:13', '2021-07-18 12:49:13'),
('93aff0caaa1773157598fe8472d8cb4562d1bccefabdc1ca49ee45cfa21b57cbb75f48af7b642348', 3, 1, 'dollar', '[]', 0, '2020-07-17 09:34:19', '2020-07-17 09:34:19', '2021-07-17 15:04:19'),
('94bf3108327fb1a09f2193a0854c5294392373407c6290d0c9077d36fa367452c87795cee0b2d64f', 1, 1, 'dollar', '[]', 0, '2019-09-01 20:29:19', '2019-09-01 20:29:19', '2020-09-02 07:29:19'),
('9a22447a3e088ddac4fde89badb28c426aa78b1057c629fba5bc74428fbd9e6de4bd3892db7d3f96', 7, 1, 'dallas', '[]', 0, '2020-10-13 11:59:36', '2020-10-13 11:59:36', '2021-10-13 17:29:36'),
('9fb7901ee24bf717e60d45918baa40817ffcb9603cb0d25e846e89d973b399f9b3f6223a9d353cb9', 3, 1, 'dollar', '[]', 0, '2020-07-17 03:12:18', '2020-07-17 03:12:18', '2021-07-17 08:42:18'),
('a0d9faf26e1a298f88bb7fed1d6f251a460829507d5cb71e53b634e5dfc5d54571a5ea8fd1b4de27', 2, 1, 'dallas', '[]', 0, '2020-08-30 13:28:03', '2020-08-30 13:28:03', '2021-08-30 18:58:03'),
('a1723d73c4fff1baa97084ae43e45452e7397e24b863cda5950b203ba50101d201f5d4c7dabc195c', 1, 1, 'dollar', '[]', 0, '2019-08-27 15:42:17', '2019-08-27 15:42:17', '2020-08-28 02:42:17'),
('a7289273947fb30912e96af73341d2a4df9f451979d18dbdaa40962783ed62ff7190eff5938b4c90', 1, 1, 'dollar', '[]', 0, '2019-08-30 22:46:35', '2019-08-30 22:46:35', '2020-08-31 09:46:35'),
('a763f5cccb18f334b0ead96e7556b214ce88ee8bdb5889f8e1ea31a494e80e943345fb7004e25318', 2, 1, 'dollar', '[]', 0, '2020-08-08 05:20:55', '2020-08-08 05:20:55', '2021-08-08 10:50:55'),
('ac0c4a0bd329167a36cca88f04ee17a2eb0c60bc922f66df2c37dad460435223089f3a3582f3fc57', 2, 1, 'dollar', '[]', 0, '2020-08-12 10:42:08', '2020-08-12 10:42:08', '2021-08-12 16:12:08'),
('ae4b0a85b79ee136c4c2b10011817382e5b10799db049f00b440414d22b77c4bbc5acbf079653865', 2, 1, 'dallas', '[]', 0, '2020-08-15 02:19:53', '2020-08-15 02:19:53', '2021-08-15 07:49:53'),
('b03dc9faa8da7b54fee9b88872ce3fd8aaac8a08ad5b6cf199bc41c9ed6dcfdaf7fc5ab0c3cf2cd3', 7, 1, 'dallas', '[]', 0, '2020-10-03 16:19:05', '2020-10-03 16:19:05', '2021-10-03 21:49:05'),
('b325a8ac34ad1831cd13e14ba3dc5a9118694717d41a1395c2ea840bed16ccda4a364e97c18bb757', 1, 1, 'dollar', '[]', 0, '2020-07-15 12:49:48', '2020-07-15 12:49:48', '2021-07-15 18:19:48'),
('b3fb2ce98cc1d6518d52c1b4e39d0300dc5474a77185340d99e462007e78062c917b3c5bca1e1416', 2, 1, 'dallas', '[]', 0, '2020-09-01 14:34:38', '2020-09-01 14:34:38', '2021-09-01 20:04:38'),
('b5dbec6e13b7712c33b3443d43f2d12bfeea4b550b25f00fc7a5523c92a0790c01cd1ca4bbc25c28', 1, 1, 'dollar', '[]', 0, '2019-09-07 00:12:28', '2019-09-07 00:12:28', '2020-09-07 11:12:28'),
('b636031ceda0ac807ce2f355db0a1d77dcb4f2441a29798c6c0f0bfaee8d70c0975b3a6db5816ede', 3, 1, 'dollar', '[]', 0, '2020-07-15 13:26:23', '2020-07-15 13:26:23', '2021-07-15 18:56:23'),
('b69e127be462c513c69397723d70c99f7a6bc27b7cf57d9fd763dfd08d85e1842f47e9d3da6fb7eb', 2, 1, 'dallas', '[]', 0, '2020-08-16 02:52:41', '2020-08-16 02:52:41', '2021-08-16 08:22:41'),
('b7fea267b582ea4c6314b43b68a9feba06d844fa3c9301b75a862077528ec72e37e73ef4b16bb658', 3, 1, 'dollar', '[]', 0, '2020-07-18 12:29:37', '2020-07-18 12:29:37', '2021-07-18 17:59:37'),
('baefa5b4c70698404089905b8a498da903ef868d0708a4f5c62ab27878725eb6e1798fb5d8f0ae1f', 6, 1, 'dollar', '[]', 0, '2019-09-01 14:27:35', '2019-09-01 14:27:35', '2020-09-02 01:27:35'),
('bb86c418163c8e10f073be8612f60e48c490f37205ef83ff05ca6b84c36d2347c09088cd5d231691', 1, 1, 'dollar', '[]', 0, '2019-09-06 17:27:11', '2019-09-06 17:27:11', '2020-09-07 04:27:11'),
('c3ca2ec2385a4d0df920a089bd7f85740b32eaeed75bcf701ac24987484426a0a9b52ca6efac62fc', 2, 1, 'dallas', '[]', 0, '2020-10-01 01:01:18', '2020-10-01 01:01:18', '2021-10-01 06:31:18'),
('cdd8d6e92212d02e2f16c89dfcc0e179a357ae2950535deeb620cc65d7433a77115f22d97b2d1649', 2, 1, 'dallas', '[]', 0, '2020-08-15 05:22:06', '2020-08-15 05:22:06', '2021-08-15 10:52:06'),
('dd0ef34edb6a1ed137c3ab1a60933c16d406a67271a4ad2008f2086c888555f572b700460f4d9537', 7, 1, 'dallas', '[]', 0, '2020-10-03 14:00:40', '2020-10-03 14:00:40', '2021-10-03 19:30:40'),
('df4860253ea3867fa4d370db55e5b0cedfd0f8006c32bb82bad4dd478cc02ee39d2b01675c9470ef', 2, 1, 'dollar', '[]', 0, '2020-08-06 04:12:16', '2020-08-06 04:12:16', '2021-08-06 09:42:16'),
('df67f83cfd63e1f668dd8b49f41433d7f2c5de4f3127ec5c9b3f5e18d161ef239142f24d38897da9', 7, 1, 'dallas', '[]', 0, '2020-10-02 10:36:42', '2020-10-02 10:36:42', '2021-10-02 16:06:42'),
('e02af75d8169dd7d568bd9cfe79e3316b5f0759226f45395020fd12a1497efb97b60145bcd6536f3', 3, 1, 'dollar', '[]', 0, '2020-07-22 05:03:32', '2020-07-22 05:03:32', '2021-07-22 10:33:32'),
('e2ae6f5b7f8b22833e838ceb981f5c7170029264f14489ec02d81c956bb37550438ccdeca1f612df', 2, 1, 'dallas', '[]', 0, '2020-08-30 10:45:55', '2020-08-30 10:45:55', '2021-08-30 16:15:55'),
('e8291c7247bf92ffe2346d6f203cb767111124ea216ba1767d0b9a864d04669ae7f5c6d616492d53', 2, 1, 'dollar', '[]', 0, '2020-08-05 13:29:48', '2020-08-05 13:29:48', '2021-08-05 18:59:48'),
('e89cbd6cdebe4d93a0abd837cdb106d63dfbf74a11d24123b4bb0374c4be9fb9ed7f308383e79e17', 2, 1, 'dollar', '[]', 0, '2020-07-22 07:38:07', '2020-07-22 07:38:07', '2021-07-22 13:08:07'),
('eb4ad0974ddd03868c563530e1ae70adfed836ed34ef791fa4eb362eeb71d08a257aaa80ee815c0e', 7, 1, 'dallas', '[]', 0, '2020-10-16 01:39:16', '2020-10-16 01:39:16', '2021-10-16 07:09:16'),
('eb83c728ee3babf0a5690bae16cbe9ee16ba8b0cd01a7badd0111f350e22fc67380115c6e257da84', 2, 1, 'dallas', '[]', 0, '2020-09-01 04:54:23', '2020-09-01 04:54:23', '2021-09-01 10:24:23'),
('f12648fbd64903abc31f68fe2e1920c7dbb0b929863f141d51238acf2dc0d8ba6ffbbf80267f14ab', 7, 1, 'dallas', '[]', 0, '2020-10-02 02:35:54', '2020-10-02 02:35:54', '2021-10-02 08:05:54'),
('f350b8b75d21469eb1d3f423d51b8e27bd0a682362babbe9c9cb5726aa02d45b926ddc01796a02be', 2, 1, 'dallas', '[]', 0, '2020-08-25 03:20:16', '2020-08-25 03:20:16', '2021-08-25 08:50:16'),
('f565875e7d6449c2a9dd4feb381b254b8217ea04fc94c1ce362ead76e378124ecf97ff0efb3e0234', 1, 1, 'dollar', '[]', 0, '2019-09-08 13:56:11', '2019-09-08 13:56:11', '2020-09-09 00:56:11'),
('f5cd5950efe6b9c018081a9eb68109cdefcf0693dc9f83de836ec583fade8b109c179ce126c0c3eb', 3, 1, 'dollar', '[]', 0, '2020-07-16 06:47:30', '2020-07-16 06:47:30', '2021-07-16 12:17:30'),
('f5d647073a6a8706003e2b98d4a9eb0378cc6d976bec5627c06b34d5bbee3d9172fa93403b365171', 2, 1, 'dollar', '[]', 0, '2020-06-19 02:22:19', '2020-06-19 02:22:19', '2021-06-19 07:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'KTpGS8SGl59m7hYg24lfah08jwIvdGi4xmdwCRJl', 'http://localhost', 1, 0, 0, '2019-04-22 05:52:39', '2019-04-22 05:52:39'),
(2, NULL, 'Laravel Password Grant Client', '9beWRls9Vc1uMuBkuN0PT1ypowdrXmxnf27GVqha', 'http://localhost', 0, 1, 0, '2019-04-22 05:52:39', '2019-04-22 05:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-05-05 20:28:45', '2019-05-05 20:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `orgId` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgName` varchar(255) NOT NULL,
  `orgAddress` text,
  `orgAptUnitBox` text,
  `orgCity` varchar(255) DEFAULT NULL,
  `orgState` varchar(255) DEFAULT NULL,
  `orgPincode` varchar(100) DEFAULT NULL,
  `orgPhone` varchar(50) DEFAULT NULL,
  `orgLogo` text,
  `orgTimeZone` text,
  `orgTimeCountry` int(20) DEFAULT NULL,
  `orgTimeFormat` varchar(10) DEFAULT NULL,
  `orgDateFormat` varchar(255) DEFAULT NULL,
  `orgCurrency` varchar(150) DEFAULT NULL,
  `orgEmail` text,
  `orgWebsite` text,
  `orgTaxIdNo` varchar(150) DEFAULT NULL,
  `orgDomain` varchar(250) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`orgId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `other_payment_methods`
--

CREATE TABLE IF NOT EXISTS `other_payment_methods` (
  `other_payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_method_notes` text,
  `confirm_payment_method` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Deactive,1=Active  (When a student submits the registration fee method with flag 1 , the payment status will be marked as confirmed )',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0=Inactive,1=Active',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`other_payment_method_id`),
  KEY `orgId` (`orgId`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `other_payment_methods`
--

INSERT INTO `other_payment_methods` (`other_payment_method_id`, `orgId`, `payment_method`, `payment_method_notes`, `confirm_payment_method`, `status`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, NULL, 'Cash', 'other_payment_methods', 0, 1, NULL, '2019-12-12 22:27:02', NULL, '0000-00-00 00:00:00', NULL, NULL),
(2, NULL, 'Cheque', 'Cheque', 0, 1, NULL, '2019-12-12 22:27:02', NULL, '0000-00-00 00:00:00', NULL, NULL),
(3, 1, 'Cash Coupon', 'Cash Coupon', 0, 1, '2', '2020-08-07 14:54:19', NULL, '2020-08-07 14:54:19', NULL, NULL),
(4, 4, 'Cash Coupon', 'Cash Coupon', 0, 1, '7', '2020-10-02 02:09:13', NULL, '2020-10-02 02:09:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pastor_board`
--

CREATE TABLE IF NOT EXISTS `pastor_board` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `parent_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Post,2=News,3=Ads',
  `p_title` text,
  `p_description` text,
  `classified_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Buy,2=Sell',
  `p_category` bigint(22) DEFAULT NULL COMMENT 'Category from master_lookup table with pastor_board cat',
  `posted_date` datetime DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` text,
  `contact_phone` varchar(20) DEFAULT NULL,
  `cost` varchar(20) DEFAULT NULL,
  `image_path` text,
  `location_id` bigint(22) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,2-Inactive',
  `createdBy` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE IF NOT EXISTS `payment_gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID Primary Key',
  `payment_gateway_id` tinyint(1) DEFAULT NULL,
  `orgId` bigint(20) DEFAULT NULL,
  `gateway_name` varchar(50) NOT NULL COMMENT 'name of the gateway',
  `active` varchar(1) NOT NULL DEFAULT '1' COMMENT 'Status of the gateway, 1=Active,2=InActive',
  `createdBy` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `payment_gateway_id`, `orgId`, `gateway_name`, `active`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 1, NULL, 'Stripe', '1', NULL, '2020-08-07 09:23:20', NULL, '2020-08-07 09:26:29', NULL, NULL),
(2, 2, NULL, 'Paypal', '1', NULL, '2020-08-07 09:23:20', NULL, '2020-08-07 09:26:29', NULL, NULL),
(3, 3, NULL, 'Others', '1', NULL, '2020-08-07 09:23:20', NULL, '2020-08-07 09:26:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway_parameters`
--

CREATE TABLE IF NOT EXISTS `payment_gateway_parameters` (
  `parameter_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_gateway_id` int(11) NOT NULL,
  `parameter_name` varchar(50) NOT NULL,
  `validation_type` varchar(100) DEFAULT NULL COMMENT 'enter if specific validation is required except "required" validation',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`parameter_id`),
  KEY `payment_gateways_payment_gateway_parameters_FK1` (`payment_gateway_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payment_gateway_parameters`
--

INSERT INTO `payment_gateway_parameters` (`parameter_id`, `payment_gateway_id`, `parameter_name`, `validation_type`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 1, 'Public Key', 'text', NULL, '2020-08-07 14:53:32', NULL, '0000-00-00 00:00:00', NULL, NULL),
(2, 1, 'Secret Key', 'text', NULL, '2020-08-07 14:53:32', NULL, '0000-00-00 00:00:00', NULL, NULL),
(3, 2, 'Client Email Id', 'email', NULL, '2020-08-07 14:53:32', NULL, '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `orgId`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 0, 'Nextgen Checkin', 'web', '2019-05-05 08:21:47', '2019-05-05 08:21:47'),
(2, 0, 'Member Directory', 'web', '2019-05-05 08:21:47', '2019-05-05 08:21:47'),
(3, 0, 'Scheduling', 'web', '2019-05-05 08:21:47', '2019-05-05 09:13:48'),
(4, 0, 'Event management', 'web', '2019-05-05 08:21:47', '2019-05-05 08:21:47'),
(5, 0, 'Small Group', 'web', '2019-05-05 09:00:09', '2019-05-05 09:08:33'),
(6, 0, 'Accounting', 'web', '2019-05-05 09:00:21', '2019-05-05 09:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `item_desc` text,
  `location_id` bigint(20) DEFAULT NULL,
  `item_year` int(11) DEFAULT NULL,
  `item_model` varchar(100) DEFAULT NULL,
  `last_service_date` date DEFAULT NULL,
  `next_service_date` date DEFAULT NULL,
  `notification_period` varchar(200) NOT NULL,
  `item_photo` text,
  `coa` varchar(150) DEFAULT NULL,
  `rod` varchar(150) DEFAULT NULL,
  `approval_group` int(20) DEFAULT NULL COMMENT 'From ''roles'' table role id resepective of orgId',
  `quantity` int(20) DEFAULT NULL,
  `room_id` bigint(20) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT '0',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_tag` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `orgId`, `name`, `guard_name`, `role_tag`, `created_at`, `updated_at`) VALUES
(1, 0, 'Super Adminin', 'web', 'superadmin', '2019-05-05 02:52:07', '2019-05-05 02:52:07'),
(2, 0, 'Adminstrator', 'web', 'admin', '2019-05-05 02:52:08', '2019-08-24 21:27:41'),
(3, 0, 'Member', 'web', 'member', '2019-05-05 03:50:10', '2019-05-05 03:50:10'),
(4, 0, 'Volunteer', 'web', 'volunteer', '2019-07-25 23:18:18', '2019-07-25 23:18:18'),
(5, 0, 'Pastor', 'pastor', 'pastor', '2019-08-24 21:29:13', NULL),
(6, 0, 'First Time Guest', 'First Time Guest\r\n', 'firsttimeguest', '2019-08-24 21:29:13', NULL),
(7, 0, 'Inactive Member', 'Inactive Member', 'InactiveMember', '2019-08-24 21:29:52', NULL),
(8, 0, 'Checkin Volunteer', 'Checkin Volunteer', 'CheckinVolunteer', '2019-08-24 21:29:52', NULL),
(9, 0, 'Event Organizer', 'Event Organizer', 'EventOrganizer', '2019-08-24 21:30:12', NULL),
(10, 0, 'Production Manager', 'Production Manager', 'ProductionManager', '2019-08-24 21:30:12', NULL),
(11, 0, 'Accounts Admin', 'Accounts Admin', 'AccountsAdmin', '2019-08-24 21:30:29', NULL),
(12, 0, 'Visitor', 'Visitor', 'Visitor', '2019-08-24 21:30:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` int(11) NOT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `room_owner` varchar(255) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `room_desc` text,
  `room_image` text,
  `group_id` bigint(20) DEFAULT NULL,
  `building_number` varchar(150) DEFAULT NULL,
  `approval_group` int(20) DEFAULT NULL COMMENT 'From ''''roles'''' table role id resepective of orgId',
  `room_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,2=Inactive',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `s_title` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_service_users_count`
--

CREATE TABLE IF NOT EXISTS `schedule_service_users_count` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `scheduling_id` bigint(22) DEFAULT NULL,
  `team_id` bigint(22) DEFAULT NULL,
  `service_id` bigint(22) DEFAULT NULL,
  `user_count` int(10) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scheduling`
--

CREATE TABLE IF NOT EXISTS `scheduling` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `orgId` bigint(22) NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_id` bigint(22) DEFAULT NULL,
  `is_manual_schedule` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Auto scheduling, 2=Manual Scheduling',
  `assign_ids` text,
  `notification_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=None,2=SMS,3=Email,4=Both',
  `team_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `scheduling_user`
--

CREATE TABLE IF NOT EXISTS `scheduling_user` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) NOT NULL,
  `scheduling_id` bigint(22) NOT NULL,
  `team_id` bigint(22) DEFAULT NULL,
  `position_id` bigint(22) DEFAULT NULL,
  `user_id` bigint(22) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Pending, 2=Accepted, 3=Decline',
  `token` varchar(255) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sendsms`
--

CREATE TABLE IF NOT EXISTS `sendsms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `msg_sent_date` datetime DEFAULT NULL,
  `routetype` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'route=1 for promotional, route=4 for transactional SMS',
  `country` varchar(20) DEFAULT NULL,
  `sender_mobile` varchar(255) DEFAULT NULL,
  `receiver_mobile` varchar(255) DEFAULT NULL,
  `message` text,
  `sender_user_id` bigint(20) DEFAULT NULL,
  `receiver_user_id` bigint(20) DEFAULT NULL,
  `sms_response` text,
  `output` text,
  `request_id` text,
  `sms_sender_id` varchar(255) DEFAULT NULL,
  `unicode` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=English SMS,1=Unicode SMS',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Sent,2=Error',
  `del_status` text,
  `description` text,
  `json_data` text,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `store_payment_gateway_values`
--

CREATE TABLE IF NOT EXISTS `store_payment_gateway_values` (
  `payment_values_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID Primary Key',
  `orgId` bigint(20) DEFAULT NULL COMMENT 'Foreign key reference to organization',
  `payment_gateway_id` int(11) NOT NULL,
  `payment_gateway_parameter_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Foreign key reference to payment_gateway_parameters',
  `payment_gateway_parameter_value` varchar(200) NOT NULL COMMENT 'Values of the parameter to be passed to payment gateway',
  `active` varchar(1) NOT NULL DEFAULT '1' COMMENT 'Record status',
  `preferred_payment_gateway` int(1) NOT NULL DEFAULT '1' COMMENT '0 -> inactive, 1 - active',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`payment_values_id`),
  KEY `orgId` (`orgId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `tagGroup_id` bigint(22) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `order` tinyint(10) NOT NULL DEFAULT '0' COMMENT 'Listing order number for sorting',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_groups`
--

CREATE TABLE IF NOT EXISTS `tag_groups` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `isPublic` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Public, 0=Restricted',
  `isMultiple_select` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Multiple select, 0=single',
  `order` tinyint(10) NOT NULL DEFAULT '0' COMMENT 'Listing order number for sorting',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `CustomerID` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(250) NOT NULL,
  `Gender` varchar(30) NOT NULL,
  `Address` text NOT NULL,
  `City` varchar(250) NOT NULL,
  `PostalCode` varchar(30) NOT NULL,
  `Country` varchar(100) NOT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `team_has_position`
--

CREATE TABLE IF NOT EXISTS `team_has_position` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `team_id` bigint(22) DEFAULT NULL,
  `position_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `householdName` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_prefix` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `given_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nick_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` text COLLATE utf8mb4_unicode_ci,
  `user_full_name` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referal_code` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_suffix` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic` text COLLATE utf8mb4_unicode_ci,
  `dob` date DEFAULT NULL,
  `doa` date DEFAULT NULL,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_id` bigint(20) DEFAULT NULL,
  `life_stage` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT 'Adult' COMMENT 'Adult,Child',
  `mobile_no` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_phone_no` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_profile` text COLLATE utf8mb4_unicode_ci,
  `marital_status` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `medical_note` text COLLATE utf8mb4_unicode_ci,
  `congregration_status` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deletedBy` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `orgId`, `householdName`, `personal_id`, `name_prefix`, `given_name`, `first_name`, `last_name`, `middle_name`, `nick_name`, `full_name`, `user_full_name`, `email`, `username`, `email_verified_at`, `password`, `remember_token`, `referal_code`, `name_suffix`, `profile_pic`, `dob`, `doa`, `school_name`, `grade_id`, `life_stage`, `mobile_no`, `home_phone_no`, `gender`, `social_profile`, `marital_status`, `address`, `medical_note`, `congregration_status`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 0, 'superadmin name''s household', '0000000001', NULL, NULL, 'superadmin name', NULL, NULL, NULL, 'superadmin name', NULL, 'superadmin@superadmin.com', 'superadmin', NULL, '$2y$10$IFXAttkslNfMGxhYd8RsIeCGwq6CfyXcFqurV0.UnhpdiZLHVoimm', NULL, 'supekfhg', NULL, 's:316:"{"uploaded_path":"\\/var\\/www\\/html\\/dallas\\/public\\/assets\\/uploads\\/organizations\\/0\\/profile\\/","download_path":"http:\\/\\/localhost\\/dallas\\/public\\/assets\\/uploads\\/organizations\\/0\\/profile\\/","uploaded_file_name":"1590068045.png","original_filename":"1590068045.png","upload_file_extension":"png","file_size":0}";', '2020-09-01', NULL, NULL, NULL, 'Adult', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-22 22:10:47', NULL, '2020-05-21 08:04:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_position`
--

CREATE TABLE IF NOT EXISTS `user_has_position` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `user_id` bigint(22) DEFAULT NULL,
  `position_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
