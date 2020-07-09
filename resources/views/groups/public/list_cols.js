let tables = [
    { name : "groups",
      fields: [
            {
                orgId: 2,
                groupType_id: 2,
                name: "Marriage Enrichment",
                note: "This group has a note! These don't show up anywhere but here on the administrative side of groups. Group members can't see them.",
                description: "This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they're meeting each week. If the group is closed it means we're full this season, but don't worry – this class starts up again every 3 months.",
                image_path: null,
                isPublic: true,
                location: "#234, 4th cross, 5th Main, MG Road, Bangalore"
            },
            {
                orgId: 2,
                groupType_id: 2,
                name: "Financial Freedom",
                note: "This group has a note! These don't show up anywhere but here on the administrative side of groups. Group members can't see them.",
                description: "This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they're meeting each week. If the group is closed it means we're full this season, but don't worry – this class starts up again every 3 months.",
                image_path: null,
                isPublic: true,
                location: "#234, 4th cross, 5th Main, MG Road, Mysore"
            },
            {
                orgId: 2,
                groupType_id: 2,
                name: "Personality Development",
                note: "This group has a note! These don't show up anywhere but here on the administrative side of groups. Group members can't see them.",
                description: "This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they're meeting each week. If the group is closed it means we're full this season, but don't worry – this class starts up again every 3 months.",
                image_path: null,
                isPublic: true,
                location: "#234, 4th cross, 5th Main, MG Road, Mangalore"
            }
        ]
    },
    { name : "group_tags",
      fields: [
            {
                group_id: 1,
                tag_id: 2
            },
            {
                group_id: 1,
                tag_id: 2
            },
            {
                group_id: 1,
                tag_id: 2
            },
            {
                group_id: 1,
                tag_id: 2
            },
            {
                group_id: 1,
                tag_id: 2
            },
            {
                group_id: 1,
                tag_id: 2
            },
            {
                group_id: 1,
                tag_id: 2
            }
        ]
    },
    { name : "group_events",
      fields: [
            {
                group_id: 2,
                title: "New Event",
                isMultiDay_evnet: true,
                start_date: "2019-09-30",
                end_date: "2019-10-01",
                start_time: "01:00",
                end_time: "17:00",
                repeat: true,
                location: "#234, 4th cross, 5th Main, MG Road, Bangalore",
                description: "This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they're meeting each week. If the group is closed it means we're full this season, but don't worry – this class starts up again every 3 months."
            },
            {
                group_id: 2,
                title: "Weekend Event",
                isMultiDay_evnet: true,
                start_date: "2019-09-30",
                end_date: "2019-10-01",
                start_time: "01:00",
                end_time: "17:00",
                repeat: true,
                location: "#234, 4th cross, 5th Main, MG Road, Bangalore",
                description: "This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they're meeting each week. If the group is closed it means we're full this season, but don't worry – this class starts up again every 3 months."
            },
            {
                group_id: 2,
                title: "Attitude Event",
                isMultiDay_evnet: true,
                start_date: "2019-09-30",
                end_date: "2019-10-01",
                start_time: "01:00",
                end_time: "17:00",
                repeat: true,
                location: "#234, 4th cross, 5th Main, MG Road, Bangalore",
                description: "This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they're meeting each week. If the group is closed it means we're full this season, but don't worry – this class starts up again every 3 months."
            },
        ]
    },
]

let requiredTables = ["group_types", "tag_groups", "tags"];
let requiredTableUpdates = ["groups", "group_tags", "group_events"];



let groups_insert_query = "INSERT INTO `groups` (`id`, `orgId`, `groupType_id`, `name`, `description`, `notes`, `image_path`, `meeting_schedule`, `isPublic`, `location`, `is_enroll_autoClose`, `enroll_autoClose_on`, `is_enroll_autoClose_count`, `enroll_autoClose_count`, `is_enroll_notify_count`, `enroll_notify_count`, `contact_email`, `visible_leaders_fields`, `visible_members_fields`, `can_leaders_search_people`, `can_leaders_take_attendance`, `is_event_remind`, `event_remind_before`, `enroll_status`, `enroll_msg`, `leader_visibility_publicly`, `is_event_public`, `createdBy`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES (NULL, '2', '2', 'Marriage Enrichment', 'This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they\'re meeting each week. If the group is closed it means we\'re full this season, but don\'t worry – this class starts up again every 3 months.', 'This group has a note! These don\'t show up anywhere but here on the administrative side of groups. Group members can\'t see them.', NULL, NULL, '1', '#234, 4th cross, 5th Main, MG Road, Bangalore', '0', NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '1', '1', '1', '', '1', '', '1', '1', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '2', 'Financial Freedom', 'This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they\'re meeting each week. If the group is closed it means we\'re full this season, but don\'t worry – this class starts up again every 3 months.', 'This group has a note! These don\'t show up anywhere but here on the administrative side of groups. Group members can\'t see them.', NULL, NULL, '1', '#234, 4th cross, 5th Main, MG Road, Mysore', '0', NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '1', '1', '1', '', '1', '', '1', '1', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '2', 'Personality Development', 'This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they\'re meeting each week. If the group is closed it means we\'re full this season, but don\'t worry – this class starts up again every 3 months.', 'This group has a note! These don\'t show up anywhere but here on the administrative side of groups. Group members can\'t see them.', NULL, NULL, '1', '#234, 4th cross, 5th Main, MG Road, Mangalore', '0', NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '1', '1', '1', '', '1', '', '1', '1', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '2', 'Personality Improvement', 'This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they\'re meeting each week. If the group is closed it means we\'re full this season, but don\'t worry – this class starts up again every 3 months.', 'This group has a note! These don\'t show up anywhere but here on the administrative side of groups. Group members can\'t see them.', NULL, NULL, '1', '#234, 4th cross, 5th Main, MG Road, Mangalore', '0', NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '1', '1', '1', '', '1', '', '1', '1', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL)";
let group_tabs_insert_query = "INSERT INTO `group_tags` (`id`, `group_id`, `tag_id`, `createdBy`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES (NULL, '1', '2', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '1', '4', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '1', '5', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '1', '8', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '1', '9', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '5', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '3', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '3', '2', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '3', '8', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '9', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '1', '9', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '4', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '5', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '6', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '2', '8', NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL)";
let group_events_insert_query = "INSERT INTO `group_events` (`id`, `group_id`, `title`, `isMutiDay_event`, `start_date`, `end_date`, `start_time`, `end_time`, `repeat`, `location`, `description`, `is_event_remind`, `event_remind_before`, `createdBy`, `updatedBy`, `updated_at`, `deletedBy`, `deleted_at`) VALUES (NULL, '1', 'Weekend Event', '1', '2019-09-28', '2019-09-30', '09:00:00', '19:00:00', NULL, '#234, 4th cross, 5th Main, MG Road, Bangalore', 'This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they\'re meeting each week. If the group is closed it means we\'re full this season, but don\'t worry – this class starts up again every 3 months.', '1', NULL, NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '1', 'Attitude Event', '1', '2019-09-28', '2019-09-29', '13:00:00', '15:00:00', NULL, '#234, 4th cross, 5th Main, MG Road, Bangalore', 'This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they\'re meeting each week. If the group is closed it means we\'re full this season, but don\'t worry – this class starts up again every 3 months.', '1', NULL, NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL), (NULL, '1', 'New Event', '1', '2019-09-29', '2019-10-02', '05:00:00', '13:00:00', NULL, '#234, 4th cross, 5th Main, MG Road, Bangalore\"', 'This class is held weekly, during the first service hour on Sundays. Meet in the church lobby to find a listing of all the classes and where they\'re meeting each week. If the group is closed it means we\'re full this season, but don\'t worry – this class starts up again every 3 months.', '1', NULL, NULL, NULL, '0000-00-00 00:00:00.000000', NULL, NULL)";