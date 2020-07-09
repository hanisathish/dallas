<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $table = 'form_submissions';
    protected $primaryKey = 'id';

    protected $fillable = [  'id', 'orgId', 'form_id', 'profile_fileds', 'general_fields', 'created_at', 'updated_at'];

    public function form(){
        return $this->belongsTo('App\Models\Form');
    }
}
