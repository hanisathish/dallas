<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    /** 
        * The table associated with the model
    */
    protected $table = "households";

    protected $fillable = [
        'id', 'orgId', 'hhPrimaryUserId', 'name', 'created_at', 'updated_at', 'deletedBy', 'deleted_at'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('isPrimary');
    }
}
