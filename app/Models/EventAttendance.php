<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class EventAttendance extends Model  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'event_attedance';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'orgId', 'user_id', 'event_id', 'event_date', 'first_name', 'gender', 'attendance_date', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];
	
	
	public function event()
    {
        return $this->belongsTo('App\Models\Events', 'event_id', 'eventId');
    }
	

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
     * @Function name : selectFromEventAttendance
     * @Purpose : Select from EventAttendance data based on where array
     * @Added by : Santhosh
     * @Added Date : Jan 09, 2020
     */
    public static function selectFromEventAttendance($whereArray) {
        $query = EventAttendance::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateEventAttendance
     * @Purpose : Update EventAttendance data based on where array
     * @Added by : Santhosh
     * @Added Date : Jan 09, 2020
     */
    public static function updateEventAttendance($update_details, $whereArray) {
        EventAttendance::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteEventAttendance
     * @Purpose : delete EventAttendance data based on  where array
     * @Added by : Santhosh
     * @Added Date : Jan 09, 2020
     */
    public static function deleteEventAttendance($whereArray) {
        EventAttendance::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudEventAttendance
    * @Purpose : crud EventAttendance heads based on  array
    * @Added by : Santhosh
    * @Added Date : Jan 09, 2020
    */
    public static function crudEventAttendance($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = EventAttendance::query();
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
    * @Function name : getAttendanceList
    * @Purpose : getAttendanceList heads based on  array
    * @Added by : Santhosh
    * @Added Date : Jan 09, 2020
    */
	
	public static function getAttendanceList($start_date = null, $end_date = null, $event_id = null, $orgId = null) {
				
		//DB::enableQueryLog();
			
		
        $result = self::select('event_attedance.id','event_attedance.gender','event_attedance.attendance_date','event_attedance.event_id','events.eventName','organization.orgName',
		           DB::raw("(CASE WHEN event_attedance.user_id IS NULL THEN event_attedance.first_name ELSE users.first_name END) as userfullname"))
                  ->addSelect(DB::raw("DATE_FORMAT(event_attedance.attendance_date, '%m-%d-%Y') AS attendDate"))  
                  ->leftJoin("events","events.eventId","=","event_attedance.event_id")                 
                  ->leftJoin("organization","organization.orgId","=","event_attedance.orgId")                 
                  ->leftJoin("users","users.id","=","event_attedance.user_id");
				  
	    if($start_date!= null && $end_date!= null) {
			$result->whereRaw("date(event_attedance.attendance_date) >= '" . $start_date . "' AND date(event_attedance.attendance_date) <= '" . $end_date . "'");
		}		
		
		if($event_id!= null || $event_id!= "") {
			$result->where('event_attedance.event_id','=', $event_id);
		}
		//if($orgId!= null || $orgId!= "") {
            $result->where('event_attedance.orgId','=', $orgId);
        //}
		if($start_date!= null && $end_date!= null && $event_id!= null) {
			
         $result->whereRaw("date(event_attedance.attendance_date) >= '" . $start_date . "' AND date(event_attedance.attendance_date) <= '" .$end_date. "'")->where('event_attedance.event_id',$event_id);
          		   		
		}
		
	
        //dd(DB::getQueryLog($result->get()));
		
        return $result;
		
    }


    /**
    * @Function name : getEventAttendanceList
    * @Purpose : getEventAttendanceList heads based on  array
    * @Added by : Santhosh
    * @Added Date : Jan 09, 2020
    */
	
	public static function getEventAttendanceList($eventid) {
	
		//DB::enableQueryLog();
		
        $result = self::select('event_attedance.id','event_attedance.gender','event_attedance.event_date','event_attedance.event_id','event_attedance.user_id','events.eventName','organization.orgName',
		           DB::raw("(CASE WHEN event_attedance.user_id IS NULL THEN event_attedance.first_name ELSE users.first_name END) as first_name"))
                  ->addSelect(DB::raw("DATE_FORMAT(event_attedance.attendance_date, '%m-%d-%Y') AS attendance_date"))  
                  ->leftJoin("events","events.eventId","=","event_attedance.event_id")                 
                  ->leftJoin("organization","organization.orgId","=","event_attedance.orgId")                 
                  ->leftJoin("users","users.id","=","event_attedance.user_id")
				  ->where('event_attedance.id', '=', $eventid);
				  
        //dd(DB::getQueryLog($result->get()));
		
        return $result;
		
    }
	
	
}
