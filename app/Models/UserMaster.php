<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;
class UserMaster extends Model  {



    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
         'id', 'orgId', 'householdName', 'personal_id', 'name_prefix', 'given_name', 'first_name', 'last_name', 'middle_name', 'nick_name', 'email', 'username', 'email_verified_at', 'password', 'remember_token', 'referal_code', 'name_suffix', 'profile_pic', 'dob', 'doa', 'school_name', 'grade_id', 'life_stage', 'mobile_no', 'home_phone_no', 'gender', 'social_profile', 'marital_status', 'address', 'medical_note', 'congregration_status', 'created_at', 'updated_at', 'deletedBy', 'deleted_at'
        ];

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
     * @Function name : selectFromUserMaster
     * @Purpose : Select from UserMaster data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function selectFromUserMaster($whereArray) {
        $query = UserMaster::where($whereArray);
        return $query;
    }

    /**
     * @Function name : updateUserMaster
     * @Purpose : Update UserMaster data based on where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function updateUserMaster($update_details, $whereArray) {
        UserMaster::where($whereArray)->update($update_details);
    }

    /**
     * @Function name : deleteUserMaster
     * @Purpose : delete UserMaster data based on  where array
     * @Added by : Sathish
     * @Added Date : Jul 13, 2018
     */
    public static function deleteUserMaster($whereArray) {
        UserMaster::where($whereArray)->delete();
    }


    /**
    * @Function name : crudUserMaster
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudUserMaster($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$update_details=null,$delete=null,$select=null) {
        $query = UserMaster::query();

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
    * @Function name : crudUserMasterDetail
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function crudUserMasterDetail($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null) {
        $query = UserMaster::query();
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

        return $query;
    }


    /**
    * @Function name : selectUserMasterDetail
    * @Purpose : crud account heads based on  array
    * @Added by : Sathish
    * @Added Date : Nov 07, 2018
    */
    public static function selectUserMasterDetail($whereArray=null,$whereInArray=null,$whereNotInArray=null,$whereNotNullArray=null,$whereNullArray=null,$data=null) {
        $query = UserMaster::select(
            DB::raw('DATE_FORMAT(users.updated_at, "%d-%m-%Y %l:%i %p") AS updated_at_format'),
            DB::raw('DATE_FORMAT(users.created_at, "%d-%m-%Y %l:%i %p") AS created_at_format'),
            'users.id as user_id','users.orgId','householdName','personal_id','profile_pic',
            'email','first_name','last_name','middle_name','nick_name','given_name','name_suffix',
            'name_prefix',DB::raw('DATE_FORMAT(users.dob, "%d-%m-%Y") AS dob_format'),
            DB::raw('DATE_FORMAT(users.doa, "%d-%m-%Y") AS doa_format'),
            DB::raw('(select mldValue from master_lookup_data where master_lookup_data.mldKey="school_name" and master_lookup_data.orgId=users.orgId and master_lookup_data.mldId=users.school_name)  AS school_name_format'),
            DB::raw('(select mldValue from master_lookup_data where master_lookup_data.mldKey="grade_name" and master_lookup_data.orgId=users.orgId and master_lookup_data.mldId=users.grade_id)  AS grade_name_format'),
            DB::raw('(select mldValue from master_lookup_data where master_lookup_data.mldKey="name_suffix" and master_lookup_data.orgId=users.orgId and master_lookup_data.mldId=users.name_suffix)  AS name_suffix_format'),
            DB::raw('(select mldValue from master_lookup_data where master_lookup_data.mldKey="name_prefix" and master_lookup_data.orgId=users.orgId and master_lookup_data.mldId=users.name_prefix)  AS name_prefix_format'),
            DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'),'life_stage','mobile_no',
            'gender','marital_status','address','medical_note','social_profile','full_name');

        $query->leftJoin('model_has_roles', function($join) {
            $join->on("model_has_roles.model_id", "=", "users.id");
        });
        $query->leftJoin('roles', function($join) {
            $join->on("roles.orgId", "=", "users.orgId");
            $join->on("model_has_roles.role_id", "=", "roles.id");
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

        $query->groupBy('users.id');
        return $query;
    }


    public static function getUserListForAutocomplete($search, $eventId = "") {
        $user = self::select('id', 'first_name', 'last_name')
                ->addSelect("checkins.chId")
                ->leftJoin("checkins", "checkins.user_id", '=', "users.id")
                ->where(function($query)use($search) {
                    /** @var $query Illuminate\Database\Query\Builder  */
                    return $query->where('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                })
                 ->where('orgId', '=', Auth::user()->orgId)
                  ->groupBy("checkins.user_id")
                ->get();
        return $user;
    }

}
