<?php
$domain = "dev.prgmsolutions.com";
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//Route::get('public_site/add_student/{fair_domain}', function() {
//        return redirect("public_site/add_student");
//    });
//Route::get('login', 'PassportController@login_page');

Route::post('login', [ 'as' => 'login', 'uses' => 'PassportController@login_page']);

Route::get('api/login', function () {
    return redirect("login");
});


Route::post('org_register', 'PassportController@organizationRegister');
Route::post('member_register', 'PassportController@memberRegister');
Route::post('forgot_password', 'PassportController@userForgotPassword');
Route::get('changecustomerpassword/{id}', 'PassportController@changeCustomerPassword');
Route::post('customerpwdstore', 'PassportController@customerPwdStore');


Route::post('check_unique_org_domain', 'PassportController@checkOrganizationDomain');
Route::post('check_unique_email', 'PassportController@checkUniqueEmail');
Route::post('check_unique_email_per_org', 'PassportController@checkUniqueEmailPerOrganization');



Route::group(array('domain' => '{org_domain}.'.$domain), function() {

    Route::group( ['middleware' => ['get_org_detail']], function() {

        Route::get('/login', 'PassportController@login_page');
        Route::get('/login/{org_domain}', function() {
        return redirect("login");
        });
        //Route::get('/login/{org_domain}', 'PassportController@login_page');


        Route::get('/register', 'PassportController@register');
        Route::get('/register/{org_domain}', function() {
        return redirect("register");
        });
        //Route::get('/register/{org_domain}', 'PassportController@register');


        /*
        Route::get('/', function() {
        //return redirect()->route('subdomain.test');
        //return redirect("http://churchsoftwares.info/public");
        });
        Route::get('/{org_domain}', function() {
        return redirect("/");
        });
        */
    });
});

Route::get('/', 'WebsiteController@index');

Route::group( ['middleware' => ['get_org_detail']], function() {
    Route::get('/login', 'PassportController@login_page');
    Route::get('/login/{org_domain}', 'PassportController@login_page');

    Route::get('/register', 'PassportController@register');
    Route::get('/register/{org_domain}', 'PassportController@register');
	
	Route::get('/forgotpassword', 'PassportController@forgotpassword');
    Route::get('/forgotpassword/{org_domain}', 'PassportController@forgotpassword');

	//Route::post('/forgot_password', 'PassportController@userForgotPassword');
	//Route::post('/forgot_password/{org_domain}', 'PassportController@userForgotPassword');
});



Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'PassportController@logout');



//Route::get('auth.register', 'PassportController@register');

Route::post('webapp/login', 'PassportController@login');


Route::post('site_login', 'PassportController@login');

Route::get('webapp/logout/{orgDomain}', 'PassportController@logout');
Route::get('logout/superadmin', 'PassportController@superadmin_logout');

Route::get('webapp/signup', 'WebsiteController@signup');

Route::group( ['middleware' => ['auth']], function() {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    //Route::resource('posts', 'PostController');
    Route::resource('permissions','PermissionController');
});





Route::group( ['middleware' => ['auth','has_permission']], function() {

});

Route::group( ['middleware' => ['auth','App\Http\Middleware\PermissionMiddleware']], function() {
   Route::resource('posts', 'PostController');
});


//people

Route::get('people/profile_list', 'UserController@userProfilePage');
Route::get('people/change_password', 'UserController@userChangePassword');
Route::post('people/change_password', 'UserController@userChangePassword');
Route::get('people/profile_update', 'UserController@userProfileUpdate');
Route::get('people/member_directory', 'UserController@index');
Route::get('people/member_create', 'UserController@create');
Route::get('people/{personal_id}', 'UserController@view');
Route::get('people/{personal_id}/messages', 'CommunicationController@messages');
Route::get('get_usermaster_data', 'UserController@getUserData');
Route::post('store_update', 'UserController@storeUserProfile')->name('profile.store');
Route::post('store', 'UserController@userMasterStore');


// Members Directory
Route::get('/people/member/management/{personal_id?}', 'MemberController@createOrEdit');
Route::post('/people/member/management/{personal_id?}', 'MemberController@storeOrUpdate');
Route::get('/people/member/{personal_id}', 'MemberController@viewMember');

//Member position
Route::get('/people/position/{personal_id}', 'MemberController@viewPosition');
Route::post('/update_user_positions', 'Settings\PositionController@storeOrUpdateUserHasPos');


// Households Api's List
Route::get('/api/people/member/households/{personal_id}', 'MemberController@getHouseholderList');
Route::post('/api/people/member/households/get-users-search', 'MemberController@getHhUserSearch');
Route::post("/api/people/member/households/create-new", 'MemberController@createNewHousehold');
Route::post("/api/people/member/households/remove-household", 'MemberController@removeHousehold');
Route::post("/api/people/member/households/update-household", 'MemberController@updateHousehold');

//Role
Route::get('role_management', 'RoleController@index');
Route::get('role_create', 'RoleController@create');

//communication
Route::get('/people/member/{personal_id}/messages', 'Settings\CommunicationController@userCommunicationsIndex');
Route::get('/api/people/member/{personal_id}/get_messages', 'Settings\CommunicationController@getUserCommunications');
Route::get('/api/people/member/{personal_id}/get_messages/{master_id}', 'Settings\CommunicationController@getUserCommunication');

// Settings => Communication
Route::get("/settings/communication", 'Settings\CommunicationController@getList');
Route::get("/settings/communication/getOrgTemplates/{template_id?}", 'Settings\CommunicationController@getOrgTemplates');
Route::post("/settings/communication/getOrgTemplates", 'Settings\CommunicationController@updateOrgTemplate');

// Settings => Forms
Route::get("/settings/forms", "Settings\FormController@formIndex");
Route::get("/settings/forms/{form_id}/submissions", "Settings\FormController@formSubmissionsIndex")->name('form.submissions');
Route::get("/settings/forms/{form_id}/submissions/{submission_id}", "Settings\FormController@formSubmissionDetails");
Route::get('/settings/forms/{form_id}/submissions/{submission_id}/delete', "Settings\FormController@deleteSubmission");
Route::get("/settings/forms/{form_id}/fields", "Settings\FormController@formFields")->name('form.fields');
Route::get("/settings/forms/{form_id}/settings", "Settings\FormController@formSettings")->name('form.settings');
Route::get("/settings/forms/{form_id}/changeStatus", "Settings\FormController@changeStatus");
Route::get("/settings/forms/manage/{form_id?}", "Settings\FormController@createOrEdit");
Route::get("/api/settings/forms", 'Settings\FormController@getFormsList');
Route::get("/form/submission/{form_id}", "Settings\FormController@getFormSubmission");
Route::post("/api/form/submission", "Settings\FormController@storeFormSubmission");
Route::get("/api/form/submissions/list/{form_id}", "Settings\FormController@getFormSubmissionsList");
Route::post("/api/settings/forms/manage/{form_id?}", 'Settings\FormController@storeOrUpdate');
Route::get('/api/settings/forms/content/{form_id}', 'Settings\FormController@getFormDetails');

// Settings => Schedulling
Route::get("/settings/schedulling", "Settings\SchedullingController@schedullingIndex")->name('schedule.list');
Route::get("/settings/schedulling/notifications", "Settings\SchedullingController@notificationList")->name('schedule.notifications');
Route::get("/api/settings/schedule/list", 'Settings\SchedullingController@getScheduleList');
Route::get("/api/settings/schedule/notificationsList/{template_id?}", 'Settings\SchedullingController@getNotificationsList');
Route::get("/settings/schedulling/manage/{schedule_id?}", 'Settings\SchedullingController@createOrEditPage');
Route::post("/api/settings/schedule/createRelatedData", 'Settings\SchedullingController@createRelatedData');
Route::post("/api/settings/schedule/getAssignedMembersList", "Settings\SchedullingController@getAssignedMembersList");
Route::post("/api/settings/schedule/getMemberSearchList", "Settings\SchedullingController@getMemberSearchList");
Route::post("/api/settings/schedule/storeOrUpdateSchedule", "Settings\SchedullingController@storeOrUpdateSchedule");
Route::get("/settings/schedulling/{schedule_id}", "Settings\SchedullingController@schedullingDetails");
Route::post("/settings/position/load_schedule_positions", "Settings\PositionController@loadTeamPositions");
Route::post("/settings/position/load_member_on_ass_schedule", "Settings\PositionController@loadMemberWithPositions");
Route::post("/settings/position/manual_assign_user_schedule", "Settings\PositionController@manualAssignUserSchdule");

//Route::post("/settings/schedulling/store", "Settings\PositionController@storeOrUpdateSchedule");
Route::post('/settings/schedulling/store', 'Settings\SchedullingController@storeOrUpdateSchedule')->name('settings.schedulling.store');

//checkin
Route::get('checkin/{eventId}', 'CheckinController@index');
//Route::get('checkin', 'CheckinController@index');
Route::get('checkin/adult', 'CheckinController@adultCheckin');
Route::get('checkin/child', 'CheckinController@childCheckin');
Route::get('checkin/notification', 'CheckinController@notificationCheckin');
Route::get('checkin/report', 'CheckinController@reportCheckin');

Route::post('people/list', 'UserController@getUsersList');
Route::post('checkin/log-checkin', 'CheckinController@logCheckin');
Route::post('checkin/log-checkout', 'CheckinController@logCheckout');
Route::post('checkin/list', 'CheckinController@checkInList');
Route::get('checkins/printChildProfile', 'CheckinController@getChildProfile');

//Auth::routes();


//events
Route::get('events', 'EventsController@index');
Route::get('events/create_page', 'EventsController@createPage');
Route::post('events/store', 'EventsController@store')->name('events.store');
Route::post('events/list', 'EventsController@listEvents');
Route::get('events/edit/{id}', 'EventsController@edit');
Route::get('events/get_events_upon_date/{eventDate}', 'EventsController@getEventsUponDate');


Route::post('user_profile_file_upload', 'UserController@userProfileFileUpload');

// Settings => Resource
Route::get("/settings/asset_management/resources", "Settings\AssetController@index");
Route::get("/resource/create_page", "Settings\AssetController@createResourcePage");
Route::post('resource/store', 'Settings\AssetController@store')->name('resource.store');
Route::post('resource/list', 'Settings\AssetController@resourceList');
Route::get('resource/edit/{id}', 'Settings\AssetController@edit');


// Settings => Resource
Route::get("/settings/asset_management/rooms", "Settings\RoomController@index");
Route::get("/rooms/create_page", "Settings\RoomController@createRoomPage");
Route::post('rooms/store', 'Settings\RoomController@store')->name('room.store');
Route::post('rooms/list', 'Settings\RoomController@roomList');
Route::get('rooms/edit/{id}', 'Settings\RoomController@edit');

//paster board
Route::get("/pastor_board", "PastorBoardController@index");
Route::get("/pastor_board/manage", "PastorBoardController@manage");
Route::get("/pastor_board/create_post_page", "PastorBoardController@createPostPage");
Route::post('pastor_board/store', 'PastorBoardController@store')->name('pastor_board.store');
Route::post('pastor_board/manage/postList', 'PastorBoardController@managePostList');
Route::post('pastor_board/postList', 'PastorBoardController@postList');
Route::get('pastor_board/edit/{id}', 'PastorBoardController@edit');


Route::get("/settings/fbwall", "Settings\RoomController@fbwall");

// GROUPS
Route::get("/groups", "Groups\GroupController@groupsList")->name('groups');
Route::get("/groups/reports", "Groups\GroupTypesController@reports")->name('groups.reports');
Route::get("/groups/events", "Groups\GroupTypesController@events")->name('groups.events');
Route::get("/groups/resources", "Groups\GroupTypesController@resources")->name('groups.resources');
Route::get("/groups/types", "Groups\GroupTypesController@groupTypes")->name("groups.types");
Route::get("/groups/tags", "Groups\TagsController@tagsIndex")->name("groups.tags");
Route::get("/groups/people", "Groups\PeopleController@peopleIndex")->name("groups.people");
Route::get("/groups/people/list", "Groups\PeopleController@peopleList")->name("groups.people.list");
Route::get("/api/groups/typesList", "Groups\GroupTypesController@apiGetTypes");
Route::get("/api/groups/tagsListWithGroups", "Groups\TagsController@getGroupsListWithTags");
Route::post("/api/groups/createOrUpdateTagGroup", "Groups\TagsController@createOrUpdateTagGroup");
Route::get("/api/groups/tags/deleteGroup/{tagGroup_id}", "Groups\TagsController@deleteTagGroup");
Route::post("/api/groups/tags/createOrUpdateTag", "Groups\TagsController@createOrUpdateTag");
Route::get("/api/groups/tags/deleteTag/{tag_id}", "Groups\TagsController@deleteTag");
Route::post("/api/groups/tags/updateTagsOrder", "Groups\TagsController@updateTagsOrder");
Route::post("/api/groups/tags/updateTagGroupsOrder", "Groups\TagsController@updateTagGroupsOrder");

Route::post("/groups/groupsListPagination", "Groups\GroupController@groupsListPagination");
Route::get("/groups/details/{id}", "Groups\GroupController@groupDetails");
Route::get("/groups/details/{id}/{type}", "Groups\GroupController@groupDetails");
Route::post("/groups/settings/store", "Groups\GroupController@groupStoreSettings")->name("group_settings.store");
Route::post("/groups/settings/image/store", "Groups\GroupController@groupStoreImage")->name("group_settings.image.store");

Route::post("/groups/store", "Groups\GroupController@groupStore")->name("groups.store");
Route::get("/groups/create/form", "Groups\GroupController@groupCreateForm");

Route::post("/groups/members/list", "Groups\GroupController@membersList");
Route::post("/groups/member/store", "Groups\GroupController@groupAddMember")->name("group.member.store");
Route::get("/groups/members/add", "Groups\GroupController@addMembers");
Route::post("/groups/members/getUsersList", "Groups\GroupController@getUsersList");
Route::post("/groups/members/action", "Groups\GroupController@memberAction");

Route::get("/groups/events/add","Groups\GroupController@addEvents");
Route::post("/groups/events/store", "Groups\GroupController@groupAddEvents")->name("group.events.store");
Route::post("/groups/events/list", "Groups\GroupController@eventsList");
Route::get('groups/events/edit/{id}', 'Groups\GroupController@editEvent');
Route::get('groups/events/mark-attendence/{id}', 'Groups\GroupController@markAttendence');
Route::post('groups/events/submit-attendence', 'Groups\GroupController@submitAttendence');


Route::get("/groups/resources/add","Groups\GroupController@addResources");
Route::post("/groups/resources/store", "Groups\GroupController@groupAddResources")->name("group.resources.store");
Route::post("/groups/resources/list", "Groups\GroupController@resourcesList");
Route::get('groups/resources/edit/{id}', 'Groups\GroupController@editResources');


// Insights
Route::get("/groups/insights/add","Groups\GroupController@addInsights");
Route::post("/groups/insights/store", "Groups\GroupController@groupAddInsights")->name("group.insights.store");
Route::post("/groups/insights/list", "Groups\GroupController@insightList");
Route::get('groups/insights/edit/{id}', 'Groups\GroupController@editInsights');




//groupTypes
Route::post("/groups/types/groupTypesList", "Groups\GroupTypesController@groupTypesList");
Route::get("/groups/types/create_group_types_page", "Groups\GroupTypesController@createGroupTypesPage");
Route::post("/groups/types/store", "Groups\GroupTypesController@store")->name("group_type.store");
Route::get("/groups/types/defaults/{id}", "Groups\GroupTypesController@groupDefaults");

Route::get("/groups/join_group", "Groups\PublicController@JoinGroupPage");
Route::post('groups/storejoinGroup', 'Groups\PublicController@storeJoinGroupRequest')->name('groups.storejoinGroup');



//group attedence
Route::post("/groups/attedence/list", "Groups\GroupController@attedenceList");
Route::post("/groups/attedence/get_event_dates", "Groups\GroupController@getEventDates");


//Groups publishing publicly
//OLD Route::get("/{orgDomain}/hosting/groups/{group_type?}", "Groups\PublicController@getGroupsListTemplate");
//OLD Route::post("/api/hosting/groups/typesList", "Groups\PublicController@getGroupsLists");

Route::get("/{orgDomain}/groups", "Groups\PublicController@getGroupsListTemplate");
Route::get("/{orgDomain}/groups/list/{group_id}", "Groups\PublicController@getAllGroups");
Route::get("/{orgDomain}/groups/list/{group_id}/{group_name}", "Groups\PublicController@getAllGroupsDetail");


//Positions
Route::get("/settings/position", "Settings\PositionController@positionIndex")->name('position.list');
Route::post("/settings/position/list", "Settings\PositionController@getPositionList");
Route::get("/settings/get_position_by_id", "Settings\PositionController@getPositionById");
Route::post("/position_data_insert", "Settings\PositionController@storeOrUpdatePosition");
Route::get("/settings/position_data_delete", "Settings\PositionController@deletePositionById");

//Settings => Team
Route::get("/settings/team", "Settings\TeamController@teamIndex")->name('team.list');
Route::post("/settings/team/list", "Settings\TeamController@getTeamList");
Route::get("/settings/get_team_by_id", "Settings\TeamController@getTeamById");
Route::post("/team_data_insert", "Settings\TeamController@storeOrUpdateTeam");
Route::get("/settings/team_data_delete", "Settings\TeamController@deleteTeamById");

//settings - location
Route::get("/settings/location", "Settings\LocationController@index");
Route::post("/settings/location/list", "Settings\LocationController@list");
Route::get("/settings/location/addPage", "Settings\LocationController@addPage");
Route::post("/settings/location/store", "Settings\LocationController@store")->name('location.store');
Route::get('settings/location/edit/{id}', 'Settings\LocationController@editLocation');


//settings - Payment Gateways
Route::get("/settings/payment_gateways", "Settings\PaymentGatewaysController@index");
Route::post("/settings/payment_gateways/list", "Settings\PaymentGatewaysController@list");
Route::post("/settings/payment_gateways/store", "Settings\PaymentGatewaysController@storeOrUpdate")->name('payment.store');
Route::get('settings/payment_gateways/edit/{id}', 'Settings\PaymentGatewaysController@editPaymentGateways');


//settings - Payment Others
Route::get("/settings/payment_others", "Settings\PaymentMethodOthersController@index");
Route::post("/settings/payment_others/list", "Settings\PaymentMethodOthersController@list");
Route::get("/settings/payment_others/addPaymentPage", "Settings\PaymentMethodOthersController@addPaymentPage");
Route::post("/settings/payment_others/store", "Settings\PaymentMethodOthersController@store")->name('paymentothers.store');
Route::get('settings/payment_others/edit/{id}', 'Settings\PaymentMethodOthersController@editPaymentMethodOther');


// settings - organization
Route::get('settings/church_settings', 'Settings\LocationController@churchSettings');
Route::post('settings/store_church_settings', 'Settings\LocationController@storeChurchSettings')->name('church.store');


// settings - givings
Route::get("/settings/givings", "Settings\GivingController@givingIndex")->name('giving.list');
Route::get('/settings/givings/list', 'Settings\GivingController@getGivingList');
Route::get("/settings/givings/manage/{giving_id?}", 'Settings\GivingController@createOrEditPage');
Route::post('/settings/givings/store', 'Settings\GivingController@storeOrUpdateGivings')->name('givings.store');


//settings - Organization Listing
Route::get("/settings/organization", "Settings\OrganizationController@index")->name('organization.list');
Route::get("/settings/organization/list", "Settings\OrganizationController@getOrganizationList");
Route::get("/settings/organization/manage/{org_id?}", 'Settings\OrganizationController@createOrEditPage');
Route::post("/settings/organization/store", "Settings\OrganizationController@organizationRegister")->name('organization.store');
Route::post('settings/organization/save/{org_id}', 'Settings\OrganizationController@store');
Route::get("/settings/organization_data_delete", "Settings\OrganizationController@deleteOrganizationById");

//attendance
Route::get("/attendance", "EventAttendanceController@attendanceIndex")->name('attendance.list');
//Route::get('/attendance/list', 'EventAttendanceController@getAttendanceList');
Route::get('/attendance/list/{start_date?}/{end_date?}/{event_id?}', 'EventAttendanceController@getAttendanceList');
Route::get("/attendance/manage/{attend_id?}", 'EventAttendanceController@createOrEditPage');
Route::post('/attendance/store', 'EventAttendanceController@store')->name('attendance.store');
Route::get('/attendance/edit/{attend_id?}', 'EventAttendanceController@editEvent');
Route::get("/attendance/eventattedance_data_delete", "EventAttendanceController@deleteEventAttendanceById");

// Insights
// Route::get("/settings/givings", "Settings\GivingController@givingIndex")->name('giving.list');
// Route::get('/settings/givings/list', 'Settings\GivingController@getGivingList');
// Route::get("/settings/givings/manage/{giving_id?}", 'Settings\GivingController@createOrEditPage');
// Route::post('/settings/givings/store', 'Settings\GivingController@storeOrUpdateGivings')->name('givings.store');


//Route::get("/insights/manage", "InsightsController@index")->name('insights.manage');
//Route::get("insights/add","InsightsController@addInsights");
//Route::post("insights/store", "InsightsController@store")->name("insights.store");
//Route::get("/insights/list", "InsightsController@insightList");
//Route::get('insights/edit/{id}', 'InsightsController@editInsights');



//Insights
Route::get("/insights/manage", "InsightsController@insightIndex");
Route::post("/insights/list", "InsightsController@getInsightList");
Route::get("/insights/get_insight_by_id", "InsightsController@getInsightById");
Route::post("/insight_data_insert", "InsightsController@storeOrUpdateInsight");
Route::get("/insights/insight_data_delete", "InsightsController@deleteInsightById");


//EventAttendance

Route::get("/eventattendance/manage", "EventAttendanceController@eventattendanceIndex");
Route::post("/eventattendance/list", "EventAttendanceController@getEventAttendanceCountList");
Route::get("/eventattendance/get_event_attendance_by_id", "EventAttendanceController@getAttendanceCountById");
Route::post("/eventattendance_data_insert", "EventAttendanceController@storeOrUpdateAttendanceCount");
Route::get("/eventattendance/eventattendance_data_delete", "EventAttendanceController@deleteAttendanceCountById");