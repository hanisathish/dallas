<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupEnroll extends Model
{
    protected $table = 'group_enrolls';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'group_id', 'email', 'first_name', 'middle_name', 'last_name', 'full_name', 'mobile_no', 'message', 
                            'createdBy', 'created_at', 'updated_at', 'deleted_at'];
    
    public function group(){
        return $this->belongsTo('App\Models\Group');
    }
}
