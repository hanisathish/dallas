<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommTemplate extends Model
{
    /** 
        * The table associated with the model
    */
    /** PLEASE MAKE SURE AFTER CLEAR THE DATABASE BELOW LISTED DEFAULT ROWS ADDED OR NOT. 
     * 1 welcome
     * 2 household_added
     * 3 event_added
     * 4 schedule_auto_notify
     * 5 schedule_manual_notify
     * 6 schedule_confirmation
     * 7 schedule_reminder
     * 8 schedule_check_out_notification_to_guest
     * 9 thank_you_for_service
     * 10 schedule_canceled
    */
    protected $table = "comm_templates";
    
    protected $fillable = [
        'id', 'tag', 'name', 'subject', 'body', 'org_id',
        'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'
    ];
}
