<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';
    protected $primaryKey = 'id';

    protected $fillable = [  'id', 'orgId', 'title', 'description', 'fields', 'profile_fields', 'general_fields', 'is_active', 'created_at', 'updated_at'];

    public function submissions(){
        return $this->hasMany('App\Models\FormSubmission');
    }
}
