<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use DateTime;
use Auth;

class PaymentMethodOthers extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;

    protected $table = 'other_payment_methods';
    protected $primaryKey = 'other_payment_method_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['orgId','payment_method','payment_method_notes','confirm_payment_method','status','createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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
     * @Function name : selectFromPaymentMethodOthers
     * @Purpose : Select from PaymentMethodOthers data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 27, 2019
     */
    public static function selectFromPaymentMethodOthers($whereArray) {
		
		//DB::enableQueryLog();
		
        $query = PaymentMethodOthers::where($whereArray);
		
		//dd(DB::getQueryLog($query->get()));
		
        return $query;
    }

    /**
     * @Function name : updatePaymentMethodOthers
     * @Purpose : Update PaymentMethodOthers data based on where array
     * @Added by : Santhosh
     * @Added Date : Dec 27, 2019
     */
    public static function updatePaymentMethodOthers($update_details, $whereArray) {
        PaymentMethodOthers::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deletePaymentMethodOthers
     * @Purpose : delete PaymentMethodOthers data based on  where array
     * @Added by : Santhosh
     * @Added Date : Dec 27, 2019 
     */
    public static function deletePaymentMethodOthers($whereArray) {
        PaymentMethodOthers::where($whereArray)->delete();
    }
	
	
	/**
    * @Function name : crudPaymentMethodOthers
    * @Purpose : crud PaymentMethodOthers heads based on  array
    * @Added by : Santhosh
    * @Added Date : Dec 27, 2019
    */
	
    public static function crudPaymentMethodOthers($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = PaymentMethodOthers::query();
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

	 public static function listOtherPaymentGateways($orgId) {
		
		//DB::enableQueryLog();
		
        $result = DB::table(DB::raw("(SELECT other_payment_method_id, orgId, payment_method, payment_method_notes, status  FROM `other_payment_methods` WHERE orgId = ".$orgId." UNION SELECT other_payment_method_id, orgId, payment_method, payment_method_notes, status FROM `other_payment_methods` WHERE orgId IS NULL"));
			
		//dd(DB::getQueryLog($result->get()));
		
	    return $result;

    }
	
	
	/**
    * @Function name : listOtherPaymentGatewaysMethods
    * @Purpose : listOtherPaymentGatewaysMethods heads based on  array
    * @Added by : Santhosh
    * @Added Date : Dec 27, 2019
    */
	
	public static function listOtherPaymentGatewaysMethods($search) {
		
		//DB::enableQueryLog();
		
        $result = self::select('other_payment_method_id', 'payment_method', 'payment_method_notes', 'status');
		
        if ($search != "") {
            $result->where(function($query)use($search) {
                return $query->where('payment_method', 'LIKE', "%$search%");

            });
        }
		
        $result->where('orgId', '=', Auth::user()->orgId);
        		
		//dd(DB::getQueryLog($result->get()));

        return $result;
    }
	
	
	

}
