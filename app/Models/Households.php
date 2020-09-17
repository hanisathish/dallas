<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Households extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'households';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [  'id', 'orgId', 'hhPrimaryUserId', 'name', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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
     * @Function name : selectFromHouseholds
     * @Purpose : Select from Households data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromHouseholds($whereArray) {
        $query = Households::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateHouseholds
     * @Purpose : Update Households data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updateHouseholds($update_details, $whereArray) {
        Households::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteHouseholds
     * @Purpose : delete Households data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deleteHouseholds($whereArray) {
        Households::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudHouseholds
    * @Purpose : crud on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudHouseholds($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = Households::query();
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
    * @Function name : crudHouseholdsData
    * @Purpose : crud on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudHouseholdsData($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = Households::select('*');
        $query->leftJoin('household_user', function($join) {
            $join->on("household_user.household_id", "=", "households.id");
        });
        
        $query->leftJoin('users', function($join) {
            $join->on("household_user.user_id", "=", "users.id");
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
