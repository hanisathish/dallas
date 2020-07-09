<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class MasterLookupData extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'master_lookup_data';
    protected $primaryKey = 'mldId';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['mldId', 'orgId', 'mldKey', 'mldValue', 'mldType', 'mldOption', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @Function name : selectFromMasterLookupData
     * @Purpose : Select from MasterLookupData data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromMasterLookupData($whereArray) {
        $query = MasterLookupData::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateMasterLookupData
     * @Purpose : Update MasterLookupData data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updateMasterLookupData($update_details, $whereArray) {
        MasterLookupData::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteMasterLookupData
     * @Purpose : delete MasterLookupData data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deleteMasterLookupData($whereArray) {
        MasterLookupData::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudMasterLookupData
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudMasterLookupData($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = MasterLookupData::query();
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

    // Added by Lokesh 19-09-2019
    public function schedule(){
        return $this->belongsTo("App\Models\Schedule", "type_of_volunteer", "mldId");
    }
}
