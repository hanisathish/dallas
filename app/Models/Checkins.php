<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Checkins extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;

    protected $table = 'checkins';
    protected $primaryKey = 'chId';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['eventId', 'user_id', 'chINDateTime', 'chOUTDateTime', 'chKind', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public static function listCheckins($search = array()) {
        $eventId = $search['eventId'];
        $searchText = $search['searchText'];
        $chekins = self::select('chId','eventId','checkins.user_id','chINDateTime','chOUTDateTime','chKind','users.first_name', 'users.last_name',"users.profile_pic","users.life_stage")
                ->where("eventId", "=", $eventId)
                ->join("users","users.id","=","checkins.user_id")
                ->orderBy("checkins.created_at","desc");
        if($searchText!="")  {
            $chekins->where(function($query)use($searchText) {
                                           /** @var $query Illuminate\Database\Query\Builder  */
                                           return $query->where('users.first_name', 'LIKE', '%'.$searchText.'%')
                                               ->orWhere('users.last_name', 'LIKE', '%'.$searchText.'%');
                                       });
        }      
        return $chekins;
    }
    
    public static function getChildProfileDetails($eventId,$userId,$checkinId) {
        $result = self::select('checkins.eventId', 'events.eventName','users.first_name','users.middle_name','users.last_name',"users.mobile_no","users.profile_pic")
                ->join("events","events.eventId","=","checkins.eventId")
                ->join("users","users.id","=","checkins.user_id")
                ->where("checkins.eventId", $eventId)
                ->where("checkins.user_id", $userId)
                ->where("checkins.chId", $checkinId)
                ->first();

        return $result;
    }

}
