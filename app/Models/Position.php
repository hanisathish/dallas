<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Position extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'position';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'orgId', 'name', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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

    /**
     * @Function name : selectFromPosition
     * @Purpose : Select from Position data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromPosition($whereArray) {
        $query = Position::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updatePosition
     * @Purpose : Update Position data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updatePosition($update_details, $whereArray) {
        Position::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deletePosition
     * @Purpose : delete Position data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deletePosition($whereArray) {
        Position::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudPosition
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudPosition($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = Position::query();
        if($whereArray){
            $query->where($whereArray);
        }
        if($whereInArray){
            foreach($whereInArray as $key=>$value){
                $whereInFiltered = array_filter($value);
                $query->whereIn($key,$whereInFiltered);
            }
        }
        if($whereNotInArray){
            foreach($whereNotInArray as $key=>$value){
                $whereNotInFiltered = array_filter($value);
                $query->whereNotIn($key,$whereNotInFiltered);
            }
        }
        if($whereNotNullArray){
            foreach($whereNotNullArray as $value){
                $query->whereNotNull($value);
            }            
        }
        if($whereNullArray){
            foreach($whereNullArray as $value){
                $query->whereNull($value);
            }            
        }
        
        if($update_details){
            $query->update($update_details);
        }elseif($delete){
            $query->delete();
        }elseif($select){
            return $query;
        }
    }

    /**
    * @Function name : selectPositionDetail
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectPositionDetail($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = Position::select('position.id','position.orgId', 'position.name');

        if($whereArray){
            $query->where($whereArray);
        }
        if($whereInArray){
            foreach($whereInArray as $key=>$value){
                $whereInFiltered = array_filter($value);
                $query->whereIn($key,$whereInFiltered);
            }
        }
        if($whereNotInArray){
            foreach($whereNotInArray as $key=>$value){
                $whereNotInFiltered = array_filter($value);
                $query->whereNotIn($key,$whereNotInFiltered);
            }
        }
        if($whereNotNullArray){
            foreach($whereNotNullArray as $value){
                $query->whereNotNull($value);
            }
        }
        if($whereNullArray){
            foreach($whereNullArray as $value){
                $query->whereNull($value);
            }
        }
 
        return $query;
    }

    /**
    * @Function name : loadTeamPositions
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function loadTeamPositions($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = Position::select('scheduling_user.id as scheduling_user_id', 'team.name as team_name','team.id as team_id','position.id as positionid','position.name as position_name','users.id as usersid','users.first_name');

        $query->leftJoin('team_has_position', function($join) {
            $join->on("team_has_position.position_id", "=", "position.id");
        });

        $query->leftJoin('team', function($join) {
            $join->on("team.id", "=", "team_has_position.team_id");
        });

        $query->leftJoin('scheduling_user', function($join) {
            $join->on("scheduling_user.position_id", "=", "position.id");
            $join->on("scheduling_user.team_id", "=", "team.id");
        });

        $query->leftJoin('users', function($join) {
            $join->on("users.id", "=", "scheduling_user.user_id");
        });

        if($whereArray){
            $query->where($whereArray);
        }
        if($whereInArray){
            foreach($whereInArray as $key=>$value){
                $whereInFiltered = array_filter($value);
                $query->whereIn($key,$whereInFiltered);
            }
        }
        if($whereNotInArray){
            foreach($whereNotInArray as $key=>$value){
                $whereNotInFiltered = array_filter($value);
                $query->whereNotIn($key,$whereNotInFiltered);
            }
        }
        if($whereNotNullArray){
            foreach($whereNotNullArray as $value){
                $query->whereNotNull($value);
            }
        }
        if($whereNullArray){
            foreach($whereNullArray as $value){
                $query->whereNull($value);
            }
        }
        $query->groupBy("team_has_position.team_id","team_has_position.position_id");
        return $query;
    }


    /**
    * @Function name : loadMemberWithPositions
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function loadMemberWithPositions($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        DB::enableQueryLog();
        $query = UserMaster::select('scheduling_user.id as scheduling_user_id', 'users.id as usersid','users.first_name','user_has_position.position_id');

        $query->leftJoin('user_has_position', function($join) use($data) {
            $join->on("user_has_position.user_id", "=", "users.id");
            if($data['position_id'] != null){
                //$join->on("user_has_position.position_id", "=", $data["position_id"]);
                $join->where('user_has_position.position_id', '=', $data["position_id"]);
            }
        });


        $query->leftJoin('scheduling_user', function($join) {
            $join->on("scheduling_user.position_id", "=", "user_has_position.position_id");
            $join->on("scheduling_user.user_id", "=", "users.id");
        });
 

        
        if($whereArray){
            $query->where($whereArray);
        }
        if($whereInArray){
            foreach($whereInArray as $key=>$value){
                $whereInFiltered = array_filter($value);
                $query->whereIn($key,$whereInFiltered);
            }
        }
        if($whereNotInArray){
            foreach($whereNotInArray as $key=>$value){
                $whereNotInFiltered = array_filter($value);
                $query->whereNotIn($key,$whereNotInFiltered);
            }
        }
        if($whereNotNullArray){
            foreach($whereNotNullArray as $value){
                $query->whereNotNull($value);
            }
        }
        if($whereNullArray){
            foreach($whereNullArray as $value){
                $query->whereNull($value);
            }
        }
        if($data['groupBy'] != null){
            $query->groupBy($data['groupBy']);    
        }
        
        if($data['orderBy'] != null){
            foreach($data['orderBy'] as $key=>$value){
                //$orderByFiltered = array_filter($value);
                $query->orderBy($key,$value);
            }
        }
        //dd(DB::getQueryLog($query->get()));
        
        return $query;
    }
}
