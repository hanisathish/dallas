<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Giving extends Model  {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'giving';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'user_id', 'orgId', 'event_id', 'email', 'first_name', 'middle_name', 'last_name', 'full_name', 'mobile_no', 'payment_gateway_id', 'other_payment_method_id', 'amount',
	'pay_mode', 'purpose_note', 'transaction_date', 'transaction_status', 'customer_id', 'token_id', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];
	
	
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
     * @Function name : selectFromGiving
     * @Purpose : Select from Giving data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 18, 2019
     */
    public static function selectFromGiving($whereArray) {
        $query = Giving::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateGiving
     * @Purpose : Update Giving data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 18, 2019
     */
    public static function updateGiving($update_details, $whereArray) {
        Giving::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteGiving
     * @Purpose : delete Giving data based on  where array
     * @Added by : Santhosh
     * @Added Date : Dec 18, 2019
     */
    public static function deleteGiving($whereArray) {
        Giving::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudGiving
    * @Purpose : crud Giving heads based on  array
    * @Added by : Santhosh
    * @Added Date : Dec 18, 2019
    */
    public static function crudGiving($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = Giving::query();
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
    * @Function name : getGivingList
    * @Purpose : getGivingList heads based on  array
    * @Added by : Santhosh
    * @Added Date : Jan 08, 2020
    */
	
	public static function getGivingList($orgId){
		
		//DB::enableQueryLog();
		
        $result = self::select('payment_gateways.gateway_name','giving.amount','giving.pay_mode','giving.orgId', 'events.eventName','other_payment_methods.payment_method','organization.orgName',
		          DB::raw("(CASE WHEN giving.user_id IS NULL THEN giving.first_name ELSE users.first_name END) as userfullname"))
                  ->addSelect(DB::raw(" CASE giving.transaction_status WHEN '1' THEN 'Submitted' WHEN '2' THEN 'Confirmed' WHEN '3' THEN 'Declined/Error' END AS transaction_status"))
                  ->addSelect(DB::raw(" CASE giving.final_status WHEN '1' THEN 'Submitted' WHEN '2' THEN 'InProgress' WHEN '3' THEN 'Confirmed'  WHEN '4' THEN 'Declined/Rejected' END AS final_status"))	
                  ->addSelect(DB::raw("DATE_FORMAT(giving.transaction_date, '%m-%d-%Y %h:%i:%S') AS transDate"))
                  ->addSelect(DB::raw(" CASE giving.type WHEN '1' THEN 'Donation' WHEN '2' THEN 'Event' END AS type"))				  
                  ->leftJoin("events","events.eventId","=","giving.event_id")                 
                  ->leftJoin("organization","organization.orgId","=","giving.orgId")                 
                  ->leftJoin("users","users.id","=","giving.user_id")                 
                  ->leftJoin("other_payment_methods","other_payment_methods.other_payment_method_id","=","giving.other_payment_method_id")
				  ->leftJoin('payment_gateways', function($join)
                  {
                      $join->on('payment_gateways.payment_gateway_id', '=', 'giving.payment_gateway_id');                     
                      $join->on('payment_gateways.orgId', '=', 'giving.orgId');                     
                  })
                  ->where('giving.orgId', '=', $orgId);

        //dd(DB::getQueryLog($result->get()));
		
        return $result;
    }
	
	
}
