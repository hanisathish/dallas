<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use DateTime;
use Auth;

class PaymentGatewayParameters extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;

    protected $table = 'payment_gateway_parameters';
    protected $primaryKey = 'parameter_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['payment_gateway_id', 'parameter_name', 'validation_type', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];
	
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
     * @Function name : selectFromPaymentGatewayParameters
     * @Purpose : Select from PaymentGatewayParameters data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 26, 2019
     */
    public static function selectFromPaymentGatewayParameters($whereArray) {
        $query = PaymentGatewayParameters::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updatePaymentGatewayParameters
     * @Purpose : Update PaymentGatewayParameters data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 26, 2019
     */
    public static function updatePaymentGatewayParameters($update_details, $whereArray) {
        PaymentGatewayParameters::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deletePaymentGatewayParameters
     * @Purpose : delete PaymentGatewayParameters data based on  where array
     * @Added by : Santhosh
     * @Added Date : Dec 26, 2019 
     */
    public static function deletePaymentGatewayParameters($whereArray) {
        PaymentGatewayParameters::where($whereArray)->delete();
    }
	
	
	/**
    * @Function name : crudPaymentGatewayParameters
    * @Purpose : crud PaymentGatewayParameters heads based on  array
    * @Added by : Santhosh
    * @Added Date : Dec 26, 2019
    */
	
    public static function crudPaymentGatewayParameters($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = PaymentGatewayParameters::query();
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
    * @Function name : getPaymentGatewayParameterValues
    * @Purpose : getPaymentGatewayParameterValues heads based on  array
    * @Added by : Santhosh
    * @Added Date : Dec 27, 2019
    */
	
	public static function getPaymentGatewayParameterDetails($payment_gateway_id,$orgId) {
		
		//SELECT `payment_gateway_parameters`.`parameter_id`,`payment_gateway_parameters`.`payment_gateway_id`,`payment_gateway_parameters`.`parameter_name`, `store_payment_gateway_values`.`payment_gateway_parameter_id`, `store_payment_gateway_values`.`payment_gateway_parameter_value`  FROM `payment_gateway_parameters` LEFT JOIN store_payment_gateway_values on `store_payment_gateway_values`.`payment_gateway_id` = `payment_gateway_parameters`.`payment_gateway_id` where `store_payment_gateway_values`.`payment_gateway_id` = '1' and `store_payment_gateway_values`.`orgId` = '1' group by `payment_gateway_parameters`.`parameter_id`	
         
		//DB::enableQueryLog();
		
        $result = PaymentGatewayParameters::select('parameter_id','payment_gateway_id','parameter_name')
		        ->addSelect("store_payment_gateway_values.payment_gateway_id","store_payment_gateway_values.payment_gateway_parameter_id","store_payment_gateway_values.payment_gateway_parameter_value")
                ->leftJoin("store_payment_gateway_values", "store_payment_gateway_values.payment_gateway_id", '=', "payment_gateway_parameters.payment_gateway_id")
                ->where('store_payment_gateway_values.payment_gateway_id', '=', $payment_gateway_id)
                ->where('store_payment_gateway_values.orgId', '=', $orgId)
                ->groupBy("store_payment_gateway_values.payment_values_id")
                ->get();
				
		//dd(DB::getQueryLog($result->get()));
		
        return $result;
    }
	

}
