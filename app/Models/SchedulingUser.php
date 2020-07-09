<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulingUser extends Model
{
    protected $table = 'scheduling_user';
    protected $primaryKey = 'id';
    
    protected $fillable = [  'id', 'orgId', 'scheduling_id', 'team_id', 'position_id', 'user_id', 'status', 'token', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

    // Created By Lokesh 25-09-2019
    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule', 'scheduling_id');
    }

    public function user(){
        return $this->belongsTo("App\user", "user_id");
    }
}
