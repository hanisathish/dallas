<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use DateTime;
use Auth;

class PaymentGateways extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;

    protected $table = 'payment_gateways';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['payment_gateway_id','orgId','gateway_name','active','createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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
	

    public static function listPaymentGatewaysValues($orgId) {
		
		//DB::enableQueryLog();
		
        $result = DB::table(DB::raw("(SELECT id, payment_gateway_id, orgId, gateway_name, active, CASE active WHEN '1' THEN 'Active' ELSE 'InActive' END AS active_status  FROM `payment_gateways` WHERE orgId = ".$orgId." UNION SELECT id, payment_gateway_id, orgId, gateway_name, active, CASE active WHEN '1' THEN 'Active' ELSE 'InActive' END AS active_status FROM `payment_gateways` WHERE orgId IS NULL and payment_gateway_id not in (SELECT payment_gateway_id FROM `payment_gateways` WHERE orgId = ".$orgId." ) ORDER BY id ) as payment_gateways_values"));
			
		//dd(DB::getQueryLog($result->get()));
		
	    return $result;

    }
	
	
	/**
     * @Function name : selectFromPaymentGateways
     * @Purpose : Select from PaymentGateways data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 27, 2019
     */
    public static function selectFromPaymentGateways($whereArray) {
		
		//DB::enableQueryLog();
		
        $query = PaymentGateways::where($whereArray);
		
		//dd(DB::getQueryLog($query->get()));
		
        return $query;
    }

    /**
     * @Function name : updatePaymentGateways
     * @Purpose : Update PaymentGateways data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 27, 2019
     */
    public static function updatePaymentGateways($update_details, $whereArray) {
        PaymentGateways::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deletePaymentGateways
     * @Purpose : delete PaymentGateways data based on  where array
     * @Added by : Santhosh
     * @Added Date : Dec 27, 2019 
     */
    public static function deletePaymentGateways($whereArray) {
        PaymentGateways::where($whereArray)->delete();
    }
	
	
	/**
    * @Function name : crudPaymentGateways
    * @Purpose : crud PaymentGateways heads based on  array
    * @Added by : Santhosh
    * @Added Date : Dec 27, 2019
    */
	
    public static function crudPaymentGateways($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = PaymentGateways::query();
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
