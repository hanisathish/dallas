-- Oct 16 2020
SET FOREIGN_KEY_CHECKS=0;

TRUNCATE `attendance_count`;
TRUNCATE `checkins`;
TRUNCATE `comm_details`;
TRUNCATE `comm_masters`;
TRUNCATE `contact_group`;
TRUNCATE `contact_group_map`;
TRUNCATE `contact_list`;
TRUNCATE `cron_batch_email`;
TRUNCATE `events`;
TRUNCATE `event_attedance`;
TRUNCATE `forms`;
TRUNCATE `form_submissions`;
TRUNCATE `giving`;
TRUNCATE `groups`;
TRUNCATE `group_enrolls`;
TRUNCATE `group_events`;
TRUNCATE `group_events_attendance`;
TRUNCATE `group_members`;
TRUNCATE `group_resources`;
TRUNCATE `group_tags`;
TRUNCATE `group_types`;
TRUNCATE `households`;
TRUNCATE `household_user`;
TRUNCATE `insights`;
TRUNCATE `locations`;
TRUNCATE `model_has_roles`;
TRUNCATE `organization`;
TRUNCATE `pastor_board`;
TRUNCATE `position`;
TRUNCATE `resources`;
TRUNCATE `rooms`;
TRUNCATE `schedules`;
TRUNCATE `schedule_service_users_count`;
TRUNCATE `scheduling`;
TRUNCATE `scheduling_user`;
TRUNCATE `sendsms`;
TRUNCATE `store_payment_gateway_values`;
TRUNCATE `tags`;
TRUNCATE `tag_groups`;
TRUNCATE `tbl_customer`;
TRUNCATE `team`;
TRUNCATE `team_has_position`;
TRUNCATE `user_has_position`;
SET FOREIGN_KEY_CHECKS=1;

 -- delete FROM `comm_templates` where org_id!=0;

INSERT INTO `comm_templates` (`id`, `tag`, `name`, `subject`, `body`, `org_id`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 'welcome', 'Welcome Email', 'Welcome Email Sujbect', 'Welcome Email Body', 0, NULL, '2019-08-21 12:31:18', NULL, '0000-00-00 00:00:00', NULL, NULL),
(2, 'household_added', 'household_added name', 'household_added subj', 'household_added body', 0, NULL, '2019-08-21 12:31:18', NULL, '0000-00-00 00:00:00', NULL, NULL),
(3, 'event_added', 'event_added name', 'event_added sub ', 'event_added body', 0, NULL, '2019-08-21 12:31:35', NULL, '0000-00-00 00:00:00', NULL, NULL),
(4, 'schedule_auto_notify', 'Auto Scheduling Notification', 'Event scheduled', 'Your have been placed on the schedule. (Auto assigned)', 0, NULL, '2019-09-27 09:04:53', NULL, NULL, NULL, NULL),
(5, 'schedule_manual_notify', 'Scheduling event', 'Event Scheduled', 'Your Event has been scheduled, please follow the below mentioned details.', 0, NULL, '2019-09-27 09:04:53', NULL, NULL, NULL, NULL),
(6, 'schedule_confirmation', 'Schedule confirmation', 'Schedule Confirmation', 'You have been placed on the schedule for the following dates. To respond or simply view this schedule, click the appropriate button below.', 0, NULL, '2019-09-27 09:04:53', NULL, NULL, NULL, NULL),
(7, 'schedule_reminder', 'Schedule Remind', 'Schedule Remind', 'A Reminder that your event has been scheduled for below listed dates.', 0, NULL, '2019-09-27 09:04:53', NULL, NULL, NULL, NULL),
(8, 'schedule_check_out_notification_to_guest', 'Schedule check out notification to guest', 'Event Schedule Notification', 'This is notify that event has been scheduled.thank_you_for_service', 0, NULL, '2019-09-27 09:04:53', NULL, NULL, NULL, NULL),
(9, 'thank_you_for_service', 'Thanks for your service', 'Thanks for Service', 'Thanks for attending the below listed event.', 0, NULL, '2019-09-27 09:04:53', NULL, NULL, NULL, NULL),
(10, 'schedule_cancelled', 'Schedule cancelled', 'Schedule cancelled', 'sorry to inform you that. Your scheduled event has been canceled. For further information contact administrator.', 0, NULL, '2019-09-27 09:04:53', NULL, NULL, NULL, NULL),
(11, 'message', 'Message', 'Message Sujbect', 'Message Body', 0, NULL, '2019-08-21 12:31:18', NULL, '0000-00-00 00:00:00', NULL, NULL),
(12, 'birthday', 'Birthday Email', 'Birthday Email Sujbect', 'Birthday Email Body', 0, NULL, '2020-07-15 13:15:48', NULL, NULL, NULL, NULL),
(13, 'anniversary', 'Anniversary Email', 'Anniversary Email Sujbect', 'Anniversary Email Body', 0, NULL, '2020-07-15 13:15:48', NULL, NULL, NULL, NULL),
(14, 'group_member_signup', 'Group Member Signup Email', 'Group Member Signup Email Sujbect', 'Birthday Email Body', 0, NULL, '2020-07-15 13:15:48', NULL, NULL, NULL, NULL),
(15, 'group_member_event_reminder', 'Group Member Event Reminder Email', 'Group Member Event Reminder Email Sujbect', 'Birthday Email Body', 0, NULL, '2020-07-15 13:15:48', NULL, NULL, NULL, NULL),
(16, 'event_child_checkin_notify', 'Event Child Checkin Notify Email', 'Event Child Checkin Notify Email Sujbect', 'Event Child Checkin Notify Email Body', 0, NULL, '2020-07-15 13:15:48', NULL, NULL, NULL, NULL),
(17, 'notify_member_make_leader', 'Made as a Leader', 'Made as a Leader', 'Made as a Leader for group', 0, NULL, '2019-08-21 12:31:18', NULL, '0000-00-00 00:00:00', NULL, NULL);

-- delete FROM `master_lookup_data` where orgId!=0;



INSERT INTO `master_lookup_data` (`mldId`, `orgId`, `mldKey`, `mldValue`, `mldType`, `mldOption`, `mldOrder`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 0, 'school_name', 'High School', 'A', 1, 0, NULL, '2019-07-10 06:51:10', NULL, '2019-07-16 06:39:52', NULL, NULL),
(2, 0, 'school_name', 'Middle School', 'A', 1, 0, NULL, '2019-07-10 07:00:06', NULL, '2019-07-16 06:39:52', NULL, NULL),
(3, 0, 'name_prefix', 'Mr.', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(4, 0, 'name_prefix', 'Mrs.', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(5, 0, 'name_prefix', 'Ms.', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(6, 0, 'name_prefix', 'Miss', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(7, 0, 'name_prefix', 'Dr.', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(8, 0, 'name_prefix', 'Rev.', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(9, 0, 'name_suffix', 'Jr.', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(10, 0, 'name_suffix', 'Sr.', 'A', 1, 0, NULL, '2019-07-10 07:00:07', NULL, '2019-07-16 06:39:52', NULL, NULL),
(11, 0, 'name_suffix', 'Ph.D.', 'A', 1, 0, NULL, '2019-07-10 07:00:08', NULL, '2019-07-16 06:39:52', NULL, NULL),
(12, 0, 'name_suffix', 'II', 'A', 1, 0, NULL, '2019-07-10 07:00:08', NULL, '2019-07-16 06:39:52', NULL, NULL),
(13, 0, 'name_suffix', 'III', 'A', 1, 0, NULL, '2019-07-10 07:00:08', NULL, '2019-07-16 06:39:52', NULL, NULL),
(14, 0, 'membership_inactive_reason', 'Moved', 'A', 1, 0, NULL, '2019-07-10 07:00:08', NULL, '2019-07-16 06:39:52', NULL, NULL),
(15, 0, 'membership_inactive_reason', 'New Church', 'A', 1, 0, NULL, '2019-07-10 07:00:08', NULL, '2019-07-16 06:39:52', NULL, NULL),
(16, 0, 'membership_inactive_reason', 'Deceased', 'A', 4, 0, NULL, '2019-07-10 07:00:08', NULL, '2019-07-16 06:39:52', NULL, NULL),
(17, 0, 'marital_status', 'Single', 'A', 1, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(18, 0, 'marital_status', 'Married', 'A', 4, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(19, 0, 'marital_status', 'Widowed', 'A', 1, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(20, 0, 'membership_status', 'Member', 'A', 1, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(21, 0, 'membership_status', 'Regular Attender', 'A', 1, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(22, 0, 'membership_status', 'Visitor', 'A', 1, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(23, 0, 'membership_status', 'Participant', 'A', 1, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(24, 0, 'membership_status', 'In Progress', 'A', 1, 0, NULL, '2019-07-10 07:00:09', NULL, '2019-07-16 06:39:52', NULL, NULL),
(25, 0, 'grade_name', 'Pre-K', 'A', 4, 0, NULL, '2019-07-10 07:43:30', NULL, '2019-07-16 06:39:52', NULL, NULL),
(26, 0, 'grade_name', 'K', 'A', 4, 0, NULL, '2019-07-10 07:43:30', NULL, '2019-07-16 06:39:52', NULL, NULL),
(27, 0, 'grade_name', '1st', 'A', 4, 0, NULL, '2019-07-10 07:43:30', NULL, '2019-07-16 06:39:52', NULL, NULL),
(28, 0, 'grade_name', '2nd', 'A', 1, 0, NULL, '2019-07-10 07:43:30', NULL, '2019-07-16 06:39:52', NULL, NULL),
(29, 0, 'grade_name', '3rd', 'A', 4, 0, NULL, '2019-07-10 07:43:30', NULL, '2019-07-16 06:39:52', NULL, NULL),
(30, 0, 'room_group', 'Group1', 'A', 4, 0, NULL, '2019-08-22 11:03:55', NULL, '2019-08-22 11:03:55', NULL, NULL),
(31, 0, 'resource_category', 'Electronic', 'A', 4, 0, NULL, '2019-08-22 11:03:55', NULL, '2019-08-22 11:03:55', NULL, NULL),
(32, 0, 'pastor_board', 'Electronic', 'A', 1, 0, NULL, '2019-09-11 04:05:01', NULL, '0000-00-00 00:00:00', NULL, NULL),
(33, 0, 'pastor_board', 'Home Care', 'A', 1, 0, NULL, '2019-09-11 04:05:01', NULL, '0000-00-00 00:00:00', NULL, NULL),
(34, 0, 'school_name', 'Elementary', 'A', 1, 0, NULL, '2019-07-10 06:51:10', NULL, '2019-07-16 06:39:52', NULL, NULL),
(35, 0, 'school_name', 'Daycare', 'A', 1, 0, NULL, '2019-07-10 07:00:06', NULL, '2019-07-16 06:39:52', NULL, NULL);

-- delete FROM `payment_gateways` where orgId!=0;
-- TRUNCATE payment_gateways;

INSERT INTO `payment_gateways` (`id`, `payment_gateway_id`, `orgId`, `gateway_name`, `active`, `createdBy`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 1, NULL, 'Stripe', '1', NULL, '2020-08-07 14:53:20', NULL, '2020-08-07 14:56:29', NULL, NULL),
(2, 2, NULL, 'Paypal', '1', NULL, '2020-08-07 14:53:20', NULL, '2020-08-07 14:56:29', NULL, NULL),
(3, 3, NULL, 'Others', '1', NULL, '2020-08-07 14:53:20', NULL, '2020-08-07 14:56:29', NULL, NULL);


-- delete FROM `permissions` where orgId!=0;

SET FOREIGN_KEY_CHECKS =0;
TRUNCATE `permissions` ;
SET FOREIGN_KEY_CHECKS =1;

INSERT INTO `permissions` (`id`, `orgId`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 0, 'Nextgen Checkin', 'web', '2019-05-05 13:51:47', '2019-05-05 13:51:47'),
(2, 0, 'Member Directory', 'web', '2019-05-05 13:51:47', '2019-05-05 13:51:47'),
(3, 0, 'Scheduling', 'web', '2019-05-05 13:51:47', '2019-05-05 14:43:48'),
(4, 0, 'Event management', 'web', '2019-05-05 13:51:47', '2019-05-05 13:51:47'),
(5, 0, 'Small Group', 'web', '2019-05-05 14:30:09', '2019-05-05 14:38:33'),
(6, 0, 'Accounting', 'web', '2019-05-05 14:30:21', '2019-05-05 14:38:37');

-- delete FROM `roles` where orgId!=0;

SET FOREIGN_KEY_CHECKS =0;
TRUNCATE `roles` ;
SET FOREIGN_KEY_CHECKS =1;

INSERT INTO `roles` (`id`, `orgId`, `name`, `guard_name`, `role_tag`, `created_at`, `updated_at`) VALUES
(1, 0, 'Super Adminin', 'web', 'superadmin', '2019-05-05 08:22:07', '2019-05-05 08:22:07'),
(2, 0, 'Adminstrator', 'web', 'admin', '2019-05-05 08:22:08', '2019-08-25 02:57:41'),
(3, 0, 'Member', 'web', 'member', '2019-05-05 09:20:10', '2019-05-05 09:20:10'),
(4, 0, 'Volunteer', 'web', 'volunteer', '2019-07-26 04:48:18', '2019-07-26 04:48:18'),
(5, 0, 'Pastor', 'pastor', 'pastor', '2019-08-25 02:59:13', NULL),
(6, 0, 'First Time Guest', 'First Time Guest\r\n', 'firsttimeguest', '2019-08-25 02:59:13', NULL),
(7, 0, 'Inactive Member', 'Inactive Member', 'InactiveMember', '2019-08-25 02:59:52', NULL),
(8, 0, 'Checkin Volunteer', 'Checkin Volunteer', 'CheckinVolunteer', '2019-08-25 02:59:52', NULL),
(9, 0, 'Event Organizer', 'Event Organizer', 'EventOrganizer', '2019-08-25 03:00:12', NULL),
(10, 0, 'Production Manager', 'Production Manager', 'ProductionManager', '2019-08-25 03:00:12', NULL),
(11, 0, 'Accounts Admin', 'Accounts Admin', 'AccountsAdmin', '2019-08-25 03:00:29', NULL),
(12, 0, 'Visitor', 'Visitor', 'Visitor', '2019-08-25 03:00:29', NULL);


-- delete FROM `users` where  orgId!=0;

SET FOREIGN_KEY_CHECKS =0;
TRUNCATE `users` ;
SET FOREIGN_KEY_CHECKS =1;

INSERT INTO `users` (`id`, `orgId`, `householdName`, `personal_id`, `name_prefix`, `given_name`, `first_name`, `last_name`, `middle_name`, `nick_name`, `full_name`, `user_full_name`, `email`, `username`, `email_verified_at`, `password`, `remember_token`, `referal_code`, `name_suffix`, `profile_pic`, `dob`, `doa`, `school_name`, `grade_id`, `life_stage`, `mobile_no`, `home_phone_no`, `gender`, `social_profile`, `marital_status`, `address`, `medical_note`, `congregration_status`, `created_at`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES
(1, 0, 'superadmin name''s household', '0000000001', NULL, NULL, 'superadmin name', NULL, NULL, NULL, 'superadmin name', NULL, 'superadmin@superadmin.com', 'superadmin', NULL, '$2y$10$IFXAttkslNfMGxhYd8RsIeCGwq6CfyXcFqurV0.UnhpdiZLHVoimm', NULL, 'supekfhg', NULL, 's:316:"{"uploaded_path":"\\/var\\/www\\/html\\/dallas\\/public\\/assets\\/uploads\\/organizations\\/0\\/profile\\/","download_path":"http:\\/\\/localhost\\/dallas\\/public\\/assets\\/uploads\\/organizations\\/0\\/profile\\/","uploaded_file_name":"1590068045.png","original_filename":"1590068045.png","upload_file_extension":"png","file_size":0}";', '2020-09-01', NULL, NULL, NULL, 'Adult', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-23 03:40:47', NULL, '2020-05-21 13:34:05', NULL, NULL);


INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, '', 1);