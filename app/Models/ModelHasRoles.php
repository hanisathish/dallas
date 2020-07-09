<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class ModelHasRoles extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'model_has_roles';
    //protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'role_id', 'model_type', 'model_id'];

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
    protected $dates = [];

    /**
     * @Function name : selectFromModelHasRoles
     * @Purpose : Select from ModelHasRoles data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromModelHasRoles($whereArray) {
        $query = ModelHasRoles::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateModelHasRoles
     * @Purpose : Update ModelHasRoles data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updateModelHasRoles($update_details, $whereArray) {
        ModelHasRoles::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteModelHasRoles
     * @Purpose : delete ModelHasRoles data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deleteModelHasRoles($whereArray) {
        ModelHasRoles::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudModelHasRoles
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudModelHasRoles($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = ModelHasRoles::query();
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
