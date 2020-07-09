<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagGroup extends Model
{
    protected $table = 'tag_groups';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'orgId', 'name', 'isPublic', 'isMultiple_select', 'order', 'createdBy', 'created_at', 'updated_at', 'deleted_at'];

    public function tags(){
        return $this->hasMany('App\Models\Tag', 'tagGroup_id');
    }
}