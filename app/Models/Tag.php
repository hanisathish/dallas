<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'tagGroup_id', 'name', 'order', 'createdBy', 'created_at', 'updated_at', 'deleted_at'];

    public function tagGroup(){
        return $this->belongsTo('App\Models\TagGroup', 'tagGroup_id');
    }
    
    public function groups(){
        return $this->belongsToMany('App\Models\Group');
    }

}