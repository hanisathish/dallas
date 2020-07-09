<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommMaster extends Model
{
    /** 
        * The table associated with the model
    */
    protected $table = "comm_masters";
    
    protected $fillable = [
        'id', 'comm_template_id', 'org_id', 'type', 'tag', 'name', 'subject', 'body', 'from_user_id', 'related_id',
        'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'
    ];

    public function users(){
        return $this->belongsToMany('App\User', 'comm_details', 'comm_master_id', 'to_user_id')
                    ->withPivot('read_status', 'delete_status', 'created_at');
    }

    public function createdUser(){
        return $this->belongsTo('App\User', 'from_user_id');
    }
}
