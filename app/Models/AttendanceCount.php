<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AttendanceCount extends Model
{
	use SoftDeletes;
    protected $table = 'attendance_count';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'orgId', 'event_id', 'event_date', 'male_count', 'female_count', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];
	
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
     * @Function name : selectFromAttendanceCount
     * @Purpose : Select from AttendanceCount data based on where array
     * @Added by : Santhosh
     * @Added Date : Jan 20, 2020
     */
    public static function selectFromAttendanceCount($whereArray) {
		 
		//DB::enableQueryLog();
		 
        $query = AttendanceCount::where($whereArray);
        
		//dd(DB::getQueryLog($query->get()));
		
		return $query;
    }

    /**
     * @Function name : updateAttendanceCount
     * @Purpose : Update AttendanceCount data based on where array
     * @Added by : Santhosh
     * @Added Date : Jan 20, 2020
     */
    public static function updateAttendanceCount($update_details, $whereArray) {
        AttendanceCount::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteAttendanceCount
     * @Purpose : delete AttendanceCount data based on  where array
     * @Added by : Santhosh
     * @Added Date : Jan 20, 2020
     */
    public static function deleteAttendanceCount($whereArray) {
        AttendanceCount::where($whereArray)->delete();
    }
     
	
    /**
    * @Function name : selectEventAttendanceCountList
    * @Purpose : selectEventAttendanceCountList heads based on  array
    * @Added by : Santhosh
    * @Added Date : Jan 20, 2020
    */
	
	public static function selectEventAttendanceCountList($orgId) {
	
		//DB::enableQueryLog();
		
        $result = self::select('attendance_count.id','attendance_count.male_count','attendance_count.female_count','attendance_count.event_date','events.eventName','organization.orgName')
                  ->leftJoin("events","events.eventId","=","attendance_count.event_id")                 
                  ->leftJoin("organization","organization.orgId","=","attendance_count.orgId")                
				  ->where('attendance_count.orgId', '=', $orgId);
				  
        //dd(DB::getQueryLog($result->get()));
		
        return $result;
		
    }

	
    
    /**
    * @Function name : crudAttendanceCount
    * @Purpose : crud AttendanceCount heads based on  array
    * @Added by : Santhosh
    * @Added Date : Jan 20, 2020
    */
    public static function crudAttendanceCount($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = AttendanceCount::query();
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
    
}
