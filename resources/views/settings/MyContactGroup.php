<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


class MyContactGroup extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'contact_group';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'group_name', 'orgId', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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
     * @Function name : selectFromMyContactGroup
     * @Purpose : Select from MyContactGroup data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromMyContactGroup($whereArray) {
        $query = MyContactGroup::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateMyContactGroup
     * @Purpose : Update MyContactGroup data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updateMyContactGroup($update_details, $whereArray) {
        MyContactGroup::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteMyContactGroup
     * @Purpose : delete MyContactGroup data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deleteMyContactGroup($whereArray) {
        MyContactGroup::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudMyContactGroup
    * @Purpose : crud meeting based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudMyContactGroup($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = MyContactGroup::query();
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
    * @Function name : selectMyContactGroupDetail
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectMyContactGroupDetail($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = MyContactGroup::select('contact_group.id', 'contact_group.group_name',
                DB::raw('(select count(contact_group_map.`contact_group_id`) from contact_group_map where contact_group_map.`contact_group_id`=contact_group.id) as grpcontactcount'));

        $query->leftJoin('contact_list', function($join) {
            $join->on("contact_group.id", "=", "contact_list.id");
        });

        $query->leftJoin('contact_group_map', function($join) {
            $join->on("contact_group_map.contact_list_id", "=", "contact_list.id");
            $join->on("contact_group.id", "=", "contact_group_map.contact_group_id");
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

    /**
    * @Function name : selectGroupContactsList
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectGroupContactsList($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = MyContactGroup::select('contact_group_map.id', 'contact_group.group_name',
                'contact_list.c_email','contact_list.c_f_name','contact_list.c_l_name');

        $query->leftJoin('contact_group_map', function($join) {
            
            $join->on("contact_group.id", "=", "contact_group_map.contact_group_id");
        });

        $query->leftJoin('contact_list', function($join) {
            
            $join->on("contact_group_map.contact_list_id", "=", "contact_list.id");
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
