<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupEventAttendance extends Model
{
    protected $table = 'group_events_attendance';
    protected $primaryKey = 'id';

    protected $fillable = [  'id', 'event_id', 'group_member_id', 'createdBy', 'created_at', 'updated_at', 'deleted_at'];
}