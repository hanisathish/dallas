<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


class MyContact extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'contact_list';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [  'id', 'c_email', 'c_f_name', 'c_l_name', 'orgId', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

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
     * @Function name : selectFromMyContact
     * @Purpose : Select from MyContact data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromMyContact($whereArray) {
        $query = MyContact::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateMyContact
     * @Purpose : Update MyContact data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updateMyContact($update_details, $whereArray) {
        MyContact::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteMyContact
     * @Purpose : delete MyContact data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deleteMyContact($whereArray) {
        MyContact::where($whereArray)->delete();
    }
     
    
    /**
    * @Function name : crudMyContact
    * @Purpose : crud meeting based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudMyContact($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = MyContact::query();
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
    * @Function name : selectMyContactDetail
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectMyContactDetail($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        DB::enableQueryLog();
        $query = MyContact::select('contact_list.id', 'contact_list.c_email', 
                'contact_list.c_f_name', 'contact_list.c_l_name', DB::raw('group_concat(contact_group.group_name) as group_name') 
                );

        $query->leftJoin('contact_group_map', function($join) {
            $join->on("contact_group_map.contact_list_id", "=", "contact_list.id");
            
        });

        $query->leftJoin('contact_group', function($join) {
            // $join->on("contact_group.id", "=", "contact_list.id");
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
        // dd(DB::getQueryLog($query->get()));
        return $query;
    }
  

    /**
    * @Function name : selectShowAddContactsList
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectShowAddContactsList($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = MyContact::select('contact_list.id',
                'contact_list.c_email','contact_list.c_f_name','contact_list.c_l_name');

        $query->leftJoin('contact_group_map', function($join) {
            $join->on("contact_group_map.contact_list_id", "!=", "contact_list.id");
            
        });

        // $query->leftJoin('contact_group', function($join) {
        //     $join->on("contact_group.id", "=", "contact_group_map.contact_group_id");
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

    /**
    * @Function name : selectMyContactUserDetail
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectMyContactUserDetail($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        DB::enableQueryLog();
        $query = ContactGroupMap::select('users.id', 'users.email', 
                'users.first_name', 'users.last_name', 'users.mobile_no', DB::raw('group_concat(DISTINCT contact_group.group_name) as group_name') 
                );

        $query->leftJoin('users', function($join) {
            $join->on("contact_group_map.contact_list_id", "=", "users.id");
            
        });

        $query->leftJoin('contact_group', function($join) {
            // $join->on("contact_group.id", "=", "contact_list.id");
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
        // dd(DB::getQueryLog($query->get()));
        return $query;
    }
}
