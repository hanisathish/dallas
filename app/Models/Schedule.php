<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'scheduling';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'title', 'orgId', 'event_date', 'event_id', 'is_manual_schedule', 'assign_ids', 'notification_flag', 'team_id', 'createdBy', 'created_at', 'updatedBy'];

    // Created By Lokesh 19-09-2019
    public function event()
    {
        return $this->belongsTo('App\Models\Events', 'event_id', 'eventId');
    }

    public function volunteer(){
        return $this->belongsTo("App\Models\MasterLookupData", "type_of_volunteer", "mldId");
    }

    // Created By Lokesh 25-09-2019
    public function users(){
        return $this->hasMany("App\Models\SchedulingUser", 'scheduling_id');
    }


    /**
    * @Function name : crudSchedule
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudSchedule($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = Schedule::query();//select('scheduling.id as scheduling_id','scheduling.title', 'scheduling.orgId','scheduling.is_manual_schedule','scheduling.notification_flag','scheduling.team_id');
        
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
