<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommDetail extends Model
{
    /** 
        * The table associated with the model
    */
    protected $table = "comm_details";
    
    /**
     * read_status => default= UNREAD, enum -> ['READ', 'UNREAD']
     * delete_status => default->UNDELETED, enum -> ['DELETED', 'UNDELETED']
     */
    protected $fillable = [
        'id', 'comm_master_id', 'to_user_id', 'read_status', 'delete_status', 
        'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'
    ];
}
