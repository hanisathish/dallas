<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SendSMS extends Model
{
    /** 
        * The table associated with the model
    */
    protected $table = "sendsms";
    
    /**
     * read_status => default= UNREAD, enum -> ['READ', 'UNREAD']
     * delete_status => default->UNDELETED, enum -> ['DELETED', 'UNDELETED']
     */
    protected $fillable = [
          'id', 'orgId', 'msg_sent_date', 'routetype', 'country', 'sender_mobile', 'receiver_mobile', 'message', 'sender_user_id', 'receiver_user_id', 'sms_response', 'output', 'request_id', 'sms_sender_id', 'unicode', 'status', 'del_status', 'description', 'json_data', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'
    ];


    /**
    * @Function name : selectSendSMSDetail
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectSendSMSDetail($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = SendSMS::select('*')
                    ->addSelect(DB::raw("(CASE WHEN sendsms.status='1' THEN 'Sent' ELSE 'Error' END) as smsstatus"))  ;

        
        // $query->leftJoin('scheduling_user', function($join) {
        //     $join->on("scheduling_user.position_id", "=", "position.id");
        //     $join->on("scheduling_user.team_id", "=", "team.id");
        // });

        // $query->leftJoin('users', function($join) {
        //     $join->on("users.id", "=", "scheduling_user.user_id");
        // });

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
        
        if($data != null){
            if($data['groupBy'] != null){
                $query->groupBy($data['groupBy']);    
            }
            if($data['orderBy'] != null){
                foreach($data['orderBy'] as $key=>$value){
                    //$orderByFiltered = array_filter($value);
                    $query->orderBy($key,$value);
                }
            }    
        }

        return $query;
    }
}
