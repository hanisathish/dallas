<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class GroupType extends Model
{
    protected $table = 'group_types';
    protected $primaryKey = 'id';

    protected $fillable = [  'id', 'orgId', 'name', 'description', 'd_isPublic', 'd_meeting_schedule', 'd_description', 'd_location',
        'd_contact_email', 'd_visible_leaders_fields', 'd_visible_members_fields', 'd_is_enroll_autoClose', 'd_enroll_autoClose_on',
        'd_is_enroll_autoClose_count', 'd_enroll_autoClose_count', 'd_is_enroll_notify_count', 'd_enroll_notify_count',
        'd_can_leaders_search_people', 'd_is_event_public', 'd_is_event_remind', 'd_event_remind_before', 'd_can_leaders_take_attendance',
        'd_enroll_status', 'd_enroll_msg', 'd_leader_visibility_publicly', 'created_at', 'updated_at', 'deleted_at'];

    /** Crated By Lokesh */
    public function groups(){
        return $this->hasMany('App\Models\Group', 'groupType_id');
    }

    public static function getGroupTypesList($search){
        $result = self::select('id', 'name', 'description','created_at')
        /* ->orderBy("created_at","desc") */;
        if ($search != "") {
            $result->where(function($query)use($search) {



                return $query->where('p_title', 'name', "%$search%")
                                ->orWhere('description', 'LIKE', "%$search%");

                //echo date("d m y",(int)$search);
            });
        }


        $result->where('orgId', '=', Auth::user()->orgId);

        return $result;
    }
	
	/**
     * @Function name : selectFromGroupType
     * @Purpose : Select from GroupType data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 03, 2019
     */
    public static function selectFromGroupType($whereArray) {
        $query = GroupType::where($whereArray);
        return $query;
    }
	
	
	 /**
    * @Function name : getallGroupTypesDetails
    * @Added by : Santhosh
    * @Added Date : Dec 12, 2019
    */

    public static function getallGroupTypesDetails() {

        //DB::enableQueryLog();
     				
		//select `group_types`.`id`,`group_types`.`name` as `group_type_name`, `groups`.`id`, `groups`.`groupType_id`, `groups`.`name`, `groups`.`description`, `groups`.`image_path` from `group_types` left join `groups` on `group_types`.`id` = `groups`.`groupType_id` group by `group_types`.`id`

        $groupDetails = self::select('group_types.id', 'group_types.name as group_type_name', 'group_types.description as group_type_description')
                            ->addSelect("groups.image_path as group_img","groups.id as groupid","groups.orgId as orgid")                            
                            ->leftJoin("groups","groups.groupType_id","=","group_types.id")
                            //->where("groups.image_path","IS NOT NULL");				
                            //->where("groups.image_path","!=","")
                            ->groupBy("group_types.id");						

        //dd(DB::getQueryLog($groupDetails->get()));

        return $groupDetails;
    }


}
