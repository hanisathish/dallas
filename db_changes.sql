

ALTER TABLE `comm_templates` CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL;

/*24 aug 2019 sathish added*/
ALTER TABLE `users` ADD `full_name` TEXT NULL DEFAULT NULL AFTER `nick_name` ;

/*24 aug 2019 ananth added*/
ALTER TABLE `checkins` CHANGE `chKind` `chKind` ENUM('Regular','Guest','Volunteer') NULL DEFAULT 'Regular' COMMENT 'user type with \'Regular\',\'Guest\',\'Volunteer\'';

/*25 aug 2019 sathish*/

ALTER TABLE `events` ADD `eventShowTime` TIME NULL DEFAULT NULL AFTER `eventCheckin` ;
ALTER TABLE `events` ADD `orgId` BIGINT( 20 ) NULL DEFAULT NULL AFTER `eventId` ;

/*25 Aug 2019 Lokesh*/
ALTER TABLE `comm_masters` ADD `name` TEXT NULL DEFAULT NULL AFTER `tag`;

/*31 Aug 2019 Sathish for the rooms and resources*/


--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `approval_group` text,
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
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(255) DEFAULT NULL,
  `room_owner` varchar(255) DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `room_desc` text,
  `room_image` text,
  `group_id` bigint(20) DEFAULT NULL,
  `building_number` varchar(150) DEFAULT NULL,
  `room_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,2=Inactive',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--added by ananth
ALTER TABLE `resources` ADD `orgId` INT(11) NOT NULL AFTER `id`;
ALTER TABLE `rooms` ADD `orgId` INT(11) NOT NULL AFTER `id`

--added by ananth
INSERT INTO `master_lookup_data` (`mldId`, `orgId`, `mldKey`, `mldValue`, `mldType`, `mldOption`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES (NULL, '0', 'resource_category', 'Electronic', 'A', '4', NULL, '2019-08-23 03:33:55', NULL, '2019-08-23 03:33:55', NULL, NULL);


--added by ananth
INSERT INTO `master_lookup_data` (`mldId`, `orgId`, `mldKey`, `mldValue`, `mldType`, `mldOption`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES (NULL, '0', 'room_group', 'Group1', 'A', '4', NULL, '2019-08-23 03:33:55', NULL, '2019-08-23 03:33:55', NULL, NULL);

ALTER TABLE `events` ADD `eventRoom` INT(11) NULL AFTER `eventLocation`, ADD `eventResource` INT(11) NULL AFTER `eventRoom`;

--------------- Dynamic forms Table Structure
CREATE TABLE IF NOT EXISTS `forms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `fields` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--------------- Dynamic form_submissions Table Structure
CREATE TABLE IF NOT EXISTS `form_submissions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(20) DEFAULT NULL,
  `form_id` bigint(20) DEFAULT NULL,
  `profile_fields` varchar(1000) DEFAULT NULL,
  `general_fields` varchar(1000) DEFAULT NULL,
  `fields` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

------------------ Altering FORM table
ALTER TABLE `forms` ADD `is_active` INT NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - deactive' AFTER `fields`;

------------------ Altering FORM table and adding profile_fields Column
ALTER TABLE `forms` ADD `profile_fields` VARCHAR(250) NULL AFTER `fields`;

------------------ Altering form_submissions Table and dropping fields column
ALTER TABLE `form_submissions` DROP `fields`;

------------------ Altering FORM table and adding general_fields Column Lokesh
ALTER TABLE `forms` ADD `general_fields` VARCHAR(500) NULL DEFAULT NULL AFTER `profile_fields`;

-----07-Sep-2019  Sathish
ALTER TABLE `resources` ADD `room_id` BIGINT( 20 ) NULL DEFAULT NULL AFTER `approval_group` ;
ALTER TABLE `resources` CHANGE `approval_group` `approval_group` INT( 20 ) NULL DEFAULT NULL COMMENT 'From ''roles'' table role id resepective of orgId';

ALTER TABLE `rooms` ADD `approval_group` INT( 20 ) NULL DEFAULT NULL COMMENT 'From ''''roles'''' table role id resepective of orgId' AFTER `building_number` ;
ALTER TABLE `resources` ADD `quantity` INT( 20 ) NULL DEFAULT NULL AFTER `approval_group` ;

------ 09-Sep-2019 Lokesh
ALTER TABLE `forms` CHANGE `fields` `fields` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

--11 Sep 2019 Sathish
DROP TABLE `groups`, `group_has_tags`, `group_tag_element`, `group_tag_header`, `group_type`;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `master_lookup_data` (`mldId`, `orgId`, `mldKey`, `mldValue`, `mldType`, `mldOption`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES (NULL, '0', 'pastor_board', 'Electronic', 'A', '1', NULL, CURRENT_TIMESTAMP, NULL, '0000-00-00 00:00:00', NULL, NULL), (NULL, '0', 'pastor_board', 'Home Care', 'A', '1', NULL, CURRENT_TIMESTAMP, NULL, '0000-00-00 00:00:00', NULL, NULL);


---------
-- DROPPING GROUPS RELATED TABLES 12-09-2019 LOKESH
---------
DROP TABLE `group_types`;
DROP TABLE `groups`;
DROP TABLE `group_events`;
DROP TABLE `group_enrolls`;
DROP TABLE `group_members`;
DROP TABLE `group_resources`;
DROP TABLE `tag_groups`;
DROP TABLE `tags`;
DROP TABLE `group_tags`;
DROP TABLE `group_events_attendace`;

---------
-- NEWLY UPDATED GROUPS RELATED TABLES 12-09-2019 LOKESH
---------
-- STRUCTURE FOR "group_types" table, 12-09-2019 LOKESH
CREATE TABLE IF NOT EXISTS `group_types` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `orgId` BIGINT(20) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `d_isPublic` BOOLEAN NULL DEFAULT TRUE COMMENT '0=Disable, 1=Enable',
    `d_meeting_schedule` TEXT NULL,
    `d_description` TEXT NULL,
    `d_location` VARCHAR(255) NULL,
    `d_contact_email` VARCHAR(75) NULL,
    `d_visible_leaders_fields` TEXT NULL COMMENT 'Stored in serialized formate',
    `d_visible_members_fields` TEXT NULL COMMENT 'Stored in serialized Formate',
    `d_is_enroll_autoClose` BOOLEAN NOT NULL DEFAULT FALSE,
    `d_enroll_autoClose_on` DATE NULL DEFAULT NULL,
    `d_is_enroll_autoClose_count` BOOLEAN NOT NULL DEFAULT FALSE,
    `d_enroll_autoClose_count` INT(15) NULL DEFAULT NULL COMMENT 'Max attendendies per group',
    `d_is_enroll_notify_count` BOOLEAN NOT NULL DEFAULT FALSE,
    `d_enroll_notify_count` INT(15) NULL DEFAULT NULL,
    `d_can_leaders_search_people` BOOLEAN NOT NULL DEFAULT TRUE,
    `d_is_event_public` BOOLEAN NOT NULL DEFAULT TRUE,
    `d_is_event_remind` BOOLEAN NOT NULL DEFAULT TRUE,
    `d_event_remind_before` INT(5) NOT NULL,
    `d_can_leaders_take_attendance` BOOLEAN NOT NULL DEFAULT TRUE,
    `d_enroll_status` BOOLEAN NOT NULL DEFAULT TRUE,
    `d_enroll_msg` VARCHAR(255) NOT NULL,
    `d_leader_visibility_publicly` BOOLEAN NOT NULL DEFAULT TRUE,
    `createdBy` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedBy` text,
    `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
    `deletedBy` text,
    `deleted_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- STRUCTURE FOR "groups" table, 12-09-2019 LOKESH
CREATE TABLE IF NOT EXISTS `groups` (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
    `orgId` BIGINT(20) NOT NULL,
    `groupType_id` BIGINT(20) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `notes` text,
    `image_path` text,
    `meeting_schedule` TEXT NULL,
    `isPublic` BOOLEAN NULL DEFAULT TRUE COMMENT '0=Disable, 1=Enable',
    `location` VARCHAR(255) NULL,
    `is_enroll_autoClose` BOOLEAN NOT NULL DEFAULT FALSE,
    `enroll_autoClose_on` DATE NULL DEFAULT NULL,
    `is_enroll_autoClose_count` BOOLEAN NOT NULL DEFAULT FALSE,
    `enroll_autoClose_count` INT(15) NULL DEFAULT NULL COMMENT 'Max attendendies per group',
    `is_enroll_notify_count` BOOLEAN NOT NULL DEFAULT FALSE,
    `enroll_notify_count` INT(15) NULL DEFAULT NULL,
    `contact_email` VARCHAR(75) NULL,
    `visible_leaders_fields` TEXT NULL COMMENT 'Stored in serialized formate',
    `visible_members_fields` TEXT NULL COMMENT 'Stored in serialized Formate',
    `can_leaders_search_people` BOOLEAN NOT NULL DEFAULT TRUE,
    `can_leaders_take_attendance` BOOLEAN NOT NULL DEFAULT TRUE,
    `is_event_remind` BOOLEAN NOT NULL DEFAULT TRUE,
    `event_remind_before` INT(5) NOT NULL,
    `enroll_status` BOOLEAN NOT NULL DEFAULT TRUE,
    `enroll_msg` VARCHAR(255) NOT NULL,
    `leader_visibility_publicly` BOOLEAN NOT NULL DEFAULT TRUE,
    `is_event_public` BOOLEAN NOT NULL DEFAULT TRUE,
    `createdBy` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedBy` text,
    `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
    `deletedBy` text,
    `deleted_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- STRUCTURE FOR 'group_events' table, 12-09-2019 LOKESH
CREATE TABLE IF NOT EXISTS `group_events` (
    `id` bigint(22) NOT NULL AUTO_INCREMENT,
    `group_id` bigint(22) DEFAULT NULL,
    `title` varchar(150) NOT NULL,
    `isMutiDay_event` BOOLEAN NOT NULL DEFAULT TRUE,
    `start_date` date DEFAULT NULL,
    `end_date` date DEFAULT NULL,
    `start_time` time DEFAULT NULL,
    `end_time` time DEFAULT NULL,
    `repeat` varchar(255) DEFAULT NULL,
    `location` VARCHAR(255) NULL,
    `description` text,
    `is_event_remind` BOOLEAN NOT NULL DEFAULT TRUE,
    `event_remind_before` varchar(255) DEFAULT NULL,
    `createdBy` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedBy` text,
    `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
    `deletedBy` text,
    `deleted_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- STRUCTURE FOR "group_entrolls" table, 12-09-2019 LOKESH
CREATE TABLE IF NOT EXISTS `group_enrolls` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(22) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `mobile_no` int(15) NULL,
  `message` text,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- STRUCTURE FOR "group_members" table, 12-09-2019 LOKESH
CREATE TABLE IF NOT EXISTS `group_members` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `group_id` bigint(22) DEFAULT NULL,
  `isUser` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=User, 2=Enrolled User',
  `role` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1=Leader, 2=Member',
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `mobile_no` int(15) NULL,
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

-- STRUCTURE FOR "group_resources" table, 12-09-2019 LOKESH
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

-- STRUCTURE FOR "tag_groups" table, 12-09-2019 LOKESH
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

-- STRUCTURE FOR "tags" table, 12-09-2019 LOKESH
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

-- STRUCTURE FOR "group_tags" table, 12-09-2019 LOKESH
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

-- STRUCTURE FOR "group_events_attendance" table, 12-09-2019 LOKESH
CREATE TABLE IF NOT EXISTS `group_events_attendance` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `event_id` bigint(22) DEFAULT NULL,
  `group_member_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- UPDATING 'group_members' table, 13-09-2019 LOKESH
ALTER TABLE `group_members` ADD `user_id` BIGINT(20) NULL AFTER `isUser`;
ALTER TABLE `group_members` ADD `orgId` BIGINT(20) NOT NULL AFTER `id`;
ALTER TABLE `group_types` ADD `isPublic` BOOLEAN NOT NULL DEFAULT TRUE AFTER `description`;

--added by ananth
ALTER TABLE `pastor_board` ADD `createdBy` INT(11) NOT NULL AFTER `status`, ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `createdBy`, ADD `updatedBy` INT(11) NULL AFTER `created_at`, ADD `updated_at` DATETIME on update CURRENT_TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `updatedBy`, ADD `deletedBy` INT(11) NULL AFTER `updated_at`, ADD `deleted_at` DATETIME NULL AFTER `deletedBy`;

---
ALTER TABLE `group_types` CHANGE `d_enroll_autoClose_on` `d_enroll_autoClose_on` DATE NULL;
ALTER TABLE `group_types` CHANGE `d_event_remind_before` `d_event_remind_before` INT(5) NULL;
ALTER TABLE `group_types` CHANGE `d_enroll_msg` `d_enroll_msg` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

--18 Sep 2019 Sathish


--
-- Table structure for table `scheduling`
--

CREATE TABLE IF NOT EXISTS `scheduling` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `s_title` varchar(255) DEFAULT NULL,
  `s_date` date DEFAULT NULL,
  `s_time` time DEFAULT NULL,
  `eventId` bigint(22) DEFAULT NULL,
  `location_id` bigint(22) DEFAULT NULL,
  `building_block` bigint(22) DEFAULT NULL,
  `type_of_volunteer` bigint(22) DEFAULT NULL,
  `notification_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=None,2=SMS,3=Email,4=Both',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

----
-- Altering scheduling Table with following changes - LOKESH
----
ALTER TABLE `scheduling` CHANGE `s_title` `title` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `scheduling` CHANGE `s_date` `date` DATE NULL DEFAULT NULL;
ALTER TABLE `scheduling` CHANGE `s_time` `time` TIME NULL DEFAULT NULL;
ALTER TABLE `scheduling` CHANGE `eventId` `event_id` BIGINT(22) NULL DEFAULT NULL;
ALTER TABLE `scheduling` ADD `checker_count` BIGINT(20) NOT NULL AFTER `type_of_volunteer`;
ALTER TABLE `scheduling` ADD `is_auto_schedule` BOOLEAN NOT NULL DEFAULT TRUE AFTER `checker_count`;
ALTER TABLE `scheduling` ADD `is_manual_schedule` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_auto_schedule`;
ALTER TABLE `scheduling` ADD `assign_ids` TEXT NULL AFTER `is_manual_schedule`;
ALTER TABLE `scheduling` ADD `orgId` BIGINT(22) NOT NULL AFTER `title`;



--
-- Table structure for table `scheduling_user` created By LOKESH 25-09-2019
--
CREATE TABLE `scheduling_user`(
  `id` BIGINT(22) NOT NULL AUTO_INCREMENT,
  `orgId` BIGINT(22) NOT NULL,
  `scheduling_id` BIGINT(22) NOT NULL,
  `user_id` BIGINT(22) NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Pending, 2=Accepted, 3=Decline',
  `createdBy` text,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` TEXT NOT NULL,
  `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deletedBy` TEXT NOT NULL,
  `deleted_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE = InnoDB;

--
-- Alter Scheduling Table - Lokesh 25-09-2019
--
ALTER TABLE `scheduling` DROP `is_auto_schedule`;
ALTER TABLE `scheduling` CHANGE `is_manual_schedule` `is_manual_schedule` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=Auto scheduling, 2=Manual Scheduling';
ALTER TABLE `scheduling_user` ADD `token` VARCHAR(255) NULL DEFAULT NULL AFTER `status`;

--
-- Alter Comm_masters Table - Lokesh 26-09-2019
--
ALTER TABLE `comm_masters` CHANGE `comm_template_id` `comm_template_id` BIGINT(20) NULL;
ALTER TABLE `comm_masters` ADD `related_id` BIGINT(22) NULL AFTER `from_user_id`;
ALTER TABLE `scheduling_user` DROP `createdBy`;
ALTER TABLE `scheduling_user` ADD `token` VARCHAR(255) NOT NULL AFTER `status`;
ALTER TABLE `scheduling_user` ADD `createdBy` TEXT NULL AFTER `token`;
ALTER TABLE `scheduling_user` CHANGE `updatedBy` `updatedBy` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `scheduling_user` CHANGE `deletedBy` `deletedBy` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

--
-- Adding default Schedule notifications - Lokesh 26-09-2019
--
INSERT INTO `comm_templates`(
    `id`,
    `tag`,
    `name`,
    `subject`,
    `body`,
    `org_id`,
    `createdBy`,
    `updatedBy`,
    `updated_at`,
    `deletedBy`,
    `deleted_at`
)
VALUES(
    NULL,
    'schedule_auto_notify',
    'Auto Scheduling Notification',
    'Event scheduled',
    'Your have been placed on the schedule. (Auto assigned)',
    '0',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
),(
    NULL,
    'schedule_manual_notify',
    'Scheduling event',
    'Event Scheduled',
    'Your Event has been scheduled, please follow the below mentioned details.',
    '0',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
),(
    NULL,
    'schedule_confirmation',
    'Schedule confirmation',
    'Schedule Confirmation',
    'You have been placed on the schedule for the following dates. To respond or simply view this schedule, click the appropriate button below.',
    '0',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
),(
    NULL,
    'schedule_reminder',
    'Schedule Remind',
    'Schedule Remind',
    'A Reminder that your event has been scheduled for below listed dates.',
    '0',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
),(
    NULL,
    'schedule_check_out_notification_to_guest',
    'Schedule check out notification to guest',
    'Event Schedule Notification',
    'This is notify that event has been scheduled.thank_you_for_service',
    '0',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
),(
    NULL,
    'thank_you_for_service',
    'Thanks for your service',
    'Thanks for Service',
    'Thanks for attending the below listed event.',
    '0',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
),
(
    NULL,
    'schedule_cancelled',
    'Schedule cancelled',
    'Schedule cancelled',
    'sorry to inform you that. Your scheduled event has been canceled. For further information contact administrator.',
    '0',
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
);

/*  03-Oct - 2019 Sathish*/
ALTER TABLE `scheduling`
  DROP `location_id`,
  DROP `building_block`,
  DROP `type_of_volunteer`,
  DROP `checker_count`;

ALTER TABLE `scheduling`
  DROP `date`,
  DROP `time`;

-- Table structure for table `service`
CREATE TABLE `service` (
  `id` bigint(22) NOT NULL,
  `orgId` bigint(22) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `service`  ADD PRIMARY KEY (`id`);

ALTER TABLE `service`  MODIFY `id` bigint(22) NOT NULL AUTO_INCREMENT;

-- Table structure for table `team`
CREATE TABLE `team` (
  `id` bigint(22) NOT NULL,
  `orgId` bigint(22) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `team`  ADD PRIMARY KEY (`id`);
ALTER TABLE `team`  MODIFY `id` bigint(22) NOT NULL AUTO_INCREMENT;

-- Table structure for table `team_has_service`
CREATE TABLE `team_has_service` (
  `id` bigint(22) NOT NULL,
  `team_id` bigint(22) DEFAULT NULL,
  `service_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `team_has_service`  ADD PRIMARY KEY (`id`);
ALTER TABLE `team_has_service`  MODIFY `id` bigint(22) NOT NULL AUTO_INCREMENT;

-- Table structure for table `schedule_service_users_count`
CREATE TABLE `schedule_service_users_count` (
  `id` bigint(22) NOT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `schedule_service_users_count`  ADD PRIMARY KEY (`id`);
ALTER TABLE `schedule_service_users_count`  MODIFY `id` bigint(22) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scheduling_user` ADD `service_id` BIGINT(22) NULL DEFAULT NULL AFTER `scheduling_id`;

-- Ananth 22 Oct 2019
ALTER TABLE `group_events_attendance` CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL;

-- Sathish 25-Oct-2019
 RENAME TABLE `service` TO `position`;
 ALTER TABLE `team_has_service` CHANGE `service_id` `position_id` BIGINT(22) NULL DEFAULT NULL;
  RENAME TABLE `team_has_service` TO `team_has_position`;

--
-- Table structure for table `user_has_position`
--

CREATE TABLE `user_has_position` (
  `id` bigint(22) NOT NULL,
  `orgId` bigint(22) DEFAULT NULL,
  `user_id` bigint(22) DEFAULT NULL,
  `position_id` bigint(22) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `user_has_position`
--
ALTER TABLE `user_has_position`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `user_has_position`
--
ALTER TABLE `user_has_position`
  MODIFY `id` bigint(22) NOT NULL AUTO_INCREMENT;



  ALTER TABLE `groups` CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL DEFAULT NULL;


--Sathish 03 Nov 2019

ALTER TABLE `scheduling` ADD `team_id` BIGINT( 22 ) NULL DEFAULT NULL AFTER `notification_flag` ;

-- Ananth 03 Nov 2019

ALTER TABLE `groups` CHANGE `event_remind_before` `event_remind_before` INT(5) NOT NULL DEFAULT '0', CHANGE `enroll_msg` `enroll_msg` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `groups` CHANGE `event_remind_before` `event_remind_before` INT(5) NULL DEFAULT '0';

--ananth 6 nov  location table

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--- ---

-- Sathish 07 Nov 2019

ALTER TABLE `scheduling_user` CHANGE `service_id` `position_id` BIGINT(22) NULL DEFAULT NULL; 

ALTER TABLE `scheduling_user` ADD `team_id` BIGINT(22) NULL DEFAULT NULL AFTER `scheduling_id`; 

-- Sathish - Ananth forgot  - 10 Nov 2019
ALTER TABLE `locations` ADD `orgId` BIGINT( 22 ) NULL DEFAULT NULL AFTER `id` ;

--Sathish 21-Nov 2019
ALTER TABLE `scheduling_user` CHANGE `user_id` `user_id` BIGINT( 22 ) NULL DEFAULT NULL ;

--Sathish 01-Dec-2019
ALTER TABLE `scheduling` ADD `event_date` DATE NULL DEFAULT NULL AFTER `orgId` ;

-- Sathish 09 Dec 2019

ALTER TABLE `group_members` CHANGE `mobile_no` `mobile_no` VARCHAR( 15 ) NULL DEFAULT NULL ;

--Sathish 12-Dec 2019

--
-- Table structure for table `payment_mode`
--

CREATE TABLE IF NOT EXISTS `payment_mode` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `pm_name` varchar(255) DEFAULT NULL,
  `pm_desc` text,
  `pm_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active,2=Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `giving`
--

CREATE TABLE IF NOT EXISTS `giving` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `payment_gateways`
--

CREATE TABLE IF NOT EXISTS `payment_gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID Primary Key',
  `gateway_name` varchar(50) NOT NULL COMMENT 'name of the gateway',
  `active` varchar(1) NOT NULL COMMENT 'Status of the gateway',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `payment_gateways` (`id`, `gateway_name`, `active`) VALUES
(1, 'Stripe', '1'),
(2, 'Paypal', '1'),
(3, 'Others', '1');


CREATE TABLE IF NOT EXISTS `payment_gateway_parameters` (
  `parameter_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_gateway_id` int(11) NOT NULL,
  `parameter_name` varchar(50) NOT NULL,
  `validation_type` varchar(100) DEFAULT NULL COMMENT 'enter if specific validation is required except "required" validation',
  PRIMARY KEY (`parameter_id`),
  KEY `payment_gateways_payment_gateway_parameters_FK1` (`payment_gateway_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `payment_gateway_parameters`
--

INSERT INTO `payment_gateway_parameters` (`parameter_id`, `payment_gateway_id`, `parameter_name`, `validation_type`) VALUES
(1, 1, 'Public Key', 'text'),
(2, 1, 'Secret Key', 'text'),
(3, 2, 'Client Email Id', 'email');



--
-- Table structure for table `store_payment_gateway_values`
--

CREATE TABLE `store_payment_gateway_values` (
  `payment_values_id` int(11) NOT NULL COMMENT 'Unique ID Primary Key',
  `orgId` bigint(20) DEFAULT NULL COMMENT 'Foreign key reference to organization',
  `payment_gateway_id` int(11) NOT NULL,
  `payment_gateway_parameter_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Foreign key reference to payment_gateway_parameters',
  `payment_gateway_parameter_value` varchar(200) NOT NULL COMMENT 'Values of the parameter to be passed to payment gateway',
  `active` varchar(1) NOT NULL DEFAULT '1' COMMENT 'Record status',
  `preferred_payment_gateway` int(1) NOT NULL DEFAULT '0' COMMENT '0 -> inactive, 1 - active',
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `store_payment_gateway_values`
--
ALTER TABLE `store_payment_gateway_values`
  ADD PRIMARY KEY (`payment_values_id`),
  ADD KEY `orgId` (`orgId`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `store_payment_gateway_values`
--
ALTER TABLE `store_payment_gateway_values`
  MODIFY `payment_values_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID Primary Key';


--
-- Table structure for table `other_payment_methods`
--

CREATE TABLE `other_payment_methods` (
  `other_payment_method_id` int(11) NOT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `other_payment_methods`
--

INSERT INTO `other_payment_methods` (`other_payment_method_id`, `orgId`, `payment_method`, `payment_method_notes`, `confirm_payment_method`, `status`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, NULL, 'Cash', 'other_payment_methods', 0, 1, NULL, '2019-12-13 03:57:02', NULL, '0000-00-00 00:00:00', NULL, NULL),
(2, NULL, 'Cheque', 'Cheque', 0, 1, NULL, '2019-12-13 03:57:02', NULL, '0000-00-00 00:00:00', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `other_payment_methods`
--
ALTER TABLE `other_payment_methods`
  ADD PRIMARY KEY (`other_payment_method_id`),
  ADD KEY `orgId` (`orgId`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `other_payment_methods`
--
ALTER TABLE `other_payment_methods`
  MODIFY `other_payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


--
-- Table structure for table `store_payment_transactions`
--

CREATE TABLE `store_payment_transactions` (
  `id` int(11) NOT NULL COMMENT 'Unique ID Primary Key',
  `orgId` bigint(20) DEFAULT NULL COMMENT 'Foreign key reference to organization',
  `student_id` int(11) NOT NULL COMMENT 'Foreign key reference to student_id for which students the dues are paid',
  `student_personal_info_id` int(11) NOT NULL COMMENT 'student personal info id to track payments for each student',
  `user_type` int(11) NOT NULL DEFAULT '1' COMMENT '1=>STUDENT,2=>JUDGE',
  `payment_fees_id` int(11) DEFAULT NULL COMMENT 'payment done for',
  `payment_gateway_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 -> none',
  `transaction_date` datetime DEFAULT NULL COMMENT 'Date on which transaction was done',
  `transaction_status` tinyint(1) DEFAULT NULL COMMENT 'Status of transaction 1 => submitted, 2 = > confirmed 3=> declined/error',
  `customer_id` varchar(50) DEFAULT NULL COMMENT 'customer_id response sent from payment gateway',
  `token_id` varchar(50) DEFAULT NULL COMMENT 'token id from payment Gateway',
  `payment_type` int(1) DEFAULT NULL COMMENT '1 => payment gateway, 2 => Check , 3 => Cash, 4=> purchase order, 5 => other',
  `other` varchar(250) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `manual_payment_details` varchar(250) DEFAULT NULL COMMENT 'if the payment is done via cash/cheque then related details will be saved here',
  `payment_gateway_return_data` mediumtext COMMENT 'Payment gateway return/postback data',
  `amount_paid` decimal(10,2) DEFAULT NULL COMMENT 'Amount already paid',
  `admin_status` tinyint(1) DEFAULT NULL COMMENT 'Status of transaction 0 => none 1 => submitted, 2 = > confirmed 3=> declined/error',
  `final_payment_flag` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=>Old payment,1=>Final payment',
  `submit_date` datetime DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `modified_user_type` varchar(25) DEFAULT NULL,
  `last_updated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `student_individual_payment_status` int(11) NOT NULL DEFAULT '0' COMMENT 'student individual payment status',
  `st_type` int(11) NOT NULL DEFAULT '1' COMMENT 'Student ordering for team student, default it will be 1',
  `rule_show_flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Not Shown,2=Rule Shown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `store_payment_transactions`
--
ALTER TABLE `store_payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `region_id` (`orgId`),
  ADD KEY `payment_fees_id` (`payment_fees_id`),
  ADD KEY `payment_gateway_id` (`payment_gateway_id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `store_payment_transactions`
--
ALTER TABLE `store_payment_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID Primary Key';  

ALTER TABLE `giving` ADD `orgId` BIGINT( 20 ) NULL DEFAULT NULL AFTER `user_id` ,
ADD `event_id` BIGINT( 20 ) NULL DEFAULT NULL AFTER `orgId` ,
ADD `email` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `event_id` ,
ADD `first_name` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `email` ,
ADD `middle_name` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `first_name` ,
ADD `last_name` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `middle_name` ,
ADD `full_name` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `last_name` ,
ADD `mobile_no` VARCHAR( 20 ) NULL DEFAULT NULL AFTER `full_name` ,
ADD `payment_mode_id` BIGINT( 20 ) NULL DEFAULT NULL AFTER `mobile_no` ,
ADD `sub_payment_mode_id` BIGINT( 20 ) NULL DEFAULT NULL AFTER `payment_mode_id` ,
ADD `amount` VARCHAR( 25 ) NULL DEFAULT NULL AFTER `sub_payment_mode_id` ;  

ALTER TABLE `giving` ADD `pay_mode` VARCHAR( 100 ) NULL DEFAULT NULL COMMENT 'Credit,Debit' AFTER `amount` ,
ADD `purpose_note` TEXT NULL DEFAULT NULL AFTER `pay_mode` ;


ALTER TABLE `giving` ADD `createdBy` TEXT NULL DEFAULT NULL AFTER `purpose_note`, ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `createdBy`, ADD `updatedBy` TEXT NULL DEFAULT NULL AFTER `created_at`, ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL AFTER `updatedBy`, ADD `deletedBy` TEXT NULL DEFAULT NULL AFTER `updated_at`, ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `deletedBy`; 

--Santhosh 19 Dec 2019

ALTER TABLE `giving` ADD `type` TINYINT(1) NOT NULL AFTER `id`;

CREATE TABLE insights AS SELECT * FROM group_resources

ALTER TABLE `insights` CHANGE `id` `id` BIGINT(22) NOT NULL;

ALTER TABLE `insights` CHANGE `id` `id` BIGINT(22) NOT NULL AUTO_INCREMENT;

-- Sathish - 26Dec 2019
ALTER TABLE `payment_gateways` ADD `orgId` BIGINT(20) NULL DEFAULT NULL AFTER `id`; 

ALTER TABLE `payment_gateways` ADD `pg_id` TINYINT(1) NULL DEFAULT NULL AFTER `id`; 

ALTER TABLE `payment_gateways` CHANGE `pg_id` `payment_gateway_id` TINYINT(1) NULL DEFAULT NULL; 

-- Santhosh 26 Dec 2019

ALTER TABLE `payment_gateways` ADD `createdBy` INT(11) NULL DEFAULT NULL AFTER `active`; 

ALTER TABLE `payment_gateways` ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `createdBy`;

ALTER TABLE `payment_gateways` ADD `updatedBy` INT(11) NULL DEFAULT NULL AFTER `created_at`; 

ALTER TABLE `payment_gateways` ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `updatedBy`;

ALTER TABLE `payment_gateways` ADD `deletedBy` INT(11) NULL AFTER `updated_at`, ADD `deleted_at` TIMESTAMP NULL AFTER `deletedBy`; 


ALTER TABLE `payment_gateway_parameters` ADD `createdBy` TEXT NULL DEFAULT NULL AFTER `validation_type`, ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `createdBy`, ADD `updatedBy` TEXT NULL DEFAULT NULL AFTER `created_at`, ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL AFTER `updatedBy`, ADD `deletedBy` TEXT NULL DEFAULT NULL AFTER `updated_at`, ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `deletedBy` 

--Sathish 27 Dec 2019

DROP TABLE `store_payment_transactions`;

ALTER TABLE `giving` ADD `transaction_date` DATETIME NULL DEFAULT NULL COMMENT 'Date on which transaction was done' AFTER `purpose_note`, ADD `transaction_status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT 'Status of transaction 1 => submitted, 2 = > confirmed 3=> declined/error' AFTER `transaction_date`, ADD `customer_id` TEXT NULL DEFAULT NULL COMMENT 'customer_id response sent from payment gateway' AFTER `transaction_status`, ADD `token_id` TEXT NULL DEFAULT NULL COMMENT 'token id from payment Gateway' AFTER `customer_id`, ADD `submited_datetime` DATETIME NULL DEFAULT NULL AFTER `token_id`, ADD `confirmed_date` DATETIME NULL DEFAULT NULL AFTER `submited_datetime`; 

DROP TABLE `payment_mode`;

ALTER TABLE `giving` CHANGE `payment_mode_id` `payment_gateway_id` BIGINT(20) NULL DEFAULT NULL COMMENT 'payment_gateway.payment_gateway_id', CHANGE `sub_payment_mode_id` `other_payment_method_id` BIGINT(20) NULL DEFAULT NULL COMMENT 'other_payment_methods.other_payment_method_id'; 

ALTER TABLE `giving` ADD `final_status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=Submitted,2=InProgress,3=Confirmed,4=Declined/Rejected' AFTER `confirmed_date`; 


-- Santhosh 27 Dec 2019

ALTER TABLE `payment_gateways` CHANGE `active` `active` VARCHAR(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT 'Status of the gateway'; 

-- Sathish 28 Dec 2019

UPDATE `payment_gateways` SET `payment_gateway_id` = '1' WHERE `payment_gateways`.`id` =1;
UPDATE `payment_gateways` SET `payment_gateway_id` = '2' WHERE `payment_gateways`.`id` =2;
UPDATE `payment_gateways` SET `payment_gateway_id` = '3' WHERE `payment_gateways`.`id` =3;

-- Sathish 05 Jan 2020

ALTER TABLE `payment_gateways` CHANGE `active` `active` VARCHAR( 1 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT 'Status of the gateway, 1=Active,2=InActive';

-- Sathish 07 Jan 2020

ALTER TABLE `store_payment_gateway_values` CHANGE `preferred_payment_gateway` `preferred_payment_gateway` INT( 1 ) NOT NULL DEFAULT '1' COMMENT '0 -> inactive, 1 - active';

-- Santhosh 08 Jan 2020

ALTER TABLE `users` ADD `updatedBy` INT(11) NULL DEFAULT NULL AFTER `created_at`;

-- Sathish 09 Jan 2020


--
-- Table structure for table `event_attedance`
--

CREATE TABLE IF NOT EXISTS `event_attedance` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `orgId` bigint(22) DEFAULT NULL,
  `user_id` bigint(22) DEFAULT NULL,
  `event_id` bigint(22) DEFAULT NULL,
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


-- Santhosh 08 Jan 2020

ALTER TABLE `event_attedance` ADD `event_date` date NULL DEFAULT NULL AFTER `event_id`;

-- ignore above sql

-- Sathish 20 Jan 2020


--
-- Table structure for table `attendance_count`
--

CREATE TABLE `attendance_count` (
  `id` bigint(20) NOT NULL,
  `orgId` bigint(22) DEFAULT NULL,
  `event_id` bigint(20) DEFAULT NULL,
  `male_count` int(10) DEFAULT NULL,
  `female_count` int(10) DEFAULT NULL,
  `createdBy` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedBy` text,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deletedBy` text,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_count`
--
ALTER TABLE `attendance_count`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_count`
--
ALTER TABLE `attendance_count`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
  

-- Santhosh 20 Jan 2020
  
ALTER TABLE `attendance_count` ADD `event_date` DATE NULL AFTER `event_id`; 

-- Santhosh 23 Jan 2020

INSERT INTO `comm_templates` (`id`, `tag`, `name`, `subject`, `body`, `org_id`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES (NULL, 'forgot_password', 'Forgot Password', 'Forgot Password', 'Click the link below and you will be redirected to a page from which you can set a new password.', '0', NULL, CURRENT_TIMESTAMP, NULL, NULL, NULL, NULL);


-- Santhosh 23 Jan 2020

ALTER TABLE `comm_details` CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NULL; 