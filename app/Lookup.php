<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
   /** 
    * The table associated with the model
   */
  protected $table = "master_lookup_data";

  public static function memberQueryData($orgId, $keys){    
    $data = Lookup::select('mldId', 'orgId', 'mldKey', 'mldValue', 'mldType', 'mldOption')
                ->where('orgId', $orgId)
                ->whereIn('mldKey', $keys)
                ->orderBy('mldValue', 'asc')
                ->get();
    return Lookup::filterData($data, $keys);
  }

  public static function filterData($data, $keys){
    $res = [];
    foreach($data as $row){
        foreach($keys as $key){
            if($row->mldKey == $key){
                if($key == "grade_name"){
                    $res['grade_id'][] = $row;
                }else {
                    $res[$key][] = $row;
                }
            }
        }
    }
    return $res;
  }
  
}