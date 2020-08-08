<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


class ContactGroupMap extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */
    // use SoftDeletes;
    protected $table = 'contact_group_map';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'contact_list_id', 'contact_group_id', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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
     * @Function name : selectFromContactGroupMap
     * @Purpose : Select from ContactGroupMap data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromContactGroupMap($whereArray) {
        $query = ContactGroupMap::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateContactGroupMap
     * @Purpose : Update ContactGroupMap data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updateContactGroupMap($update_details, $whereArray) {
        ContactGroupMap::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteContactGroupMap
     * @Purpose : delete ContactGroupMap data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deleteContactGroupMap($whereArray) {
        ContactGroupMap::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudContactGroupMap
    * @Purpose : crud meeting based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudContactGroupMap($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = ContactGroupMap::query();
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
