<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class GroupMember extends Model
{
    protected $table = 'group_members';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'orgId', 'group_id', 'isUser', 'user_id', 'role', 'email', 'first_name', 'middle_name', 'last_name', 'full_name', 'mobile_no', 'message',
                            'member_since', 'createdBy', 'created_at', 'updated_at', 'deleted_at'];

    public function group(){
        return $this->belongsTo('App\Models\Group');
    }

    public static function membersList($groupId,$search){
        $result = self::select('group_members.id', 'users.id as user_id',
          DB::raw("(CASE group_members.isUser WHEN '1' THEN users.first_name ELSE group_members.first_name  END)  as first_name"),
          'users.last_name','users.email','users.mobile_no')
                        ->addSelect("member_since","group_members.role")
                  ->leftJoin("users","users.id","=","group_members.user_id")
        /* ->orderBy("created_at","desc") */;
        if ($search != "") {
            $result->where(function($query)use($search) {



                return $query->where('users.first_name', 'LIKE', "%$search%");
                                //->orWhere('eventDesc', 'LIKE', "%$search%");

                //echo date("d m y",(int)$search);
            });
        }
        $result->where("group_members.group_id",$groupId);
        $result->where('group_members.orgId', '=', Auth::user()->orgId);
        return $result;
    }

    public static function membersListForAttdedence($groupId,$eventId){
        $result = self::select('group_members.id', 'users.id as user_id','users.first_name','users.last_name','users.email','users.mobile_no')
                  ->addSelect("member_since","group_members.role")
                  ->addSelect("group_events_attendance.id as att")
                  ->leftJoin("users","users.id","=","group_members.user_id")
                  ->leftJoin('group_events_attendance', function($join)use($eventId)
                  {
                      $join->on('group_events_attendance.group_member_id', '=', 'group_members.id');
                      $join->where('group_events_attendance.event_id','=', $eventId);
                  });


        $result->where("group_members.group_id",$groupId);
        $result->where('group_members.orgId', '=', Auth::user()->orgId);
        return $result;
    }
}
