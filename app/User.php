<?php

namespace App;
use DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable;

    use HasRoles;
    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'id', 'orgId', 'householdName', 'personal_id', 'name_prefix', 'given_name', 'first_name', 'last_name', 'middle_name', 'nick_name', 'full_name', 'user_full_name', 'email', 'username', 'email_verified_at', 'password', 'remember_token', 'referal_code', 'name_suffix', 'profile_pic', 'dob', 'doa', 'school_name', 'grade_id', 'life_stage', 'mobile_no', 'home_phone_no', 'gender', 'social_profile', 'marital_status', 'street_address', 'apt_address', 'city_address', 'state_address', 'zip_address', 'medical_note', 'congregration_status', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @Function name : selectFromUserCustom
     * @Purpose : Select from 'users' table data based on where array
     * @Added by : Sathish
     * @Added Date : May, 20, 2019
     */
    public static function selectFromUserCustom($whereArray) {
        
        $query = User::select('users.id as user_id','users.first_name as user_name','users.email as user_email','roles.id as user_role_id','roles.name as user_role_name','roles.role_tag as user_role_tag','users.orgId','organization.orgName','organization.orgDomain','users.personal_id');
        $query->leftJoin('model_has_roles', function($join) {
            $join->on('model_has_roles.model_id', "=", 'users.id');
        });
        $query->leftJoin('roles', function($join) {
            $join->on('roles.id', "=", 'model_has_roles.role_id');
        });
        $query->leftJoin('organization', function($join) {
            $join->on('organization.orgId', "=", 'users.orgId');
        });
        if ($whereArray) {
            $query->where($whereArray);
        }
        $query->groupBy('user_id');
        return $query;
    }
    
    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function households(){
        return $this->belongsToMany('App\Household')->withPivot('isPrimary');
    }

    public function communications(){
        return $this->belongsToMany('App\Models\CommMaster', 'comm_details', 'to_user_id', 'comm_master_id')
                    ->withPivot('read_status', 'delete_status', 'created_at');
    }

    public function createdCommunications(){
        return $this->belongsTo('App\Models\CommMaster');
    }

    public function schedules(){
        return $this->hasMany('App\Models\SchedulingUser');
    }
}
