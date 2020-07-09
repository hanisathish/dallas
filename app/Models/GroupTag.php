<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTag extends Model
{
    protected $table = 'group_tags';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'group_id', 'tag_id', 'createdBy', 'created_at', 'updated_at', 'deleted_at'];
}