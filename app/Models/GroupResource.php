<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;

class GroupResource extends Model
{
    protected $table = 'group_resources';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'group_id', 'name', 'type', 'source', 'description', 'visibility', 'createdBy', 'created_at', 'updated_at', 'deleted_at'];

    public function group(){
        return $this->belongsTo('App\Models\Group');
    }

    public static function resourceList($groupId,$search){
        $result = self::select("group_resources.id",'group_resources.name',"group_resources.type","source","group_resources.description","group_resources.visibility","group_resources.updated_at")

                  ->leftJoin("groups","groups.id","=","group_resources.group_id")
        /* ->orderBy("created_at","desc") */;
        if ($search != "") {
            $result->where(function($query)use($search) {



                return $query->where('group_resources.name', 'LIKE', "%$search%");
                                //->orWhere('eventDesc', 'LIKE', "%$search%");

                //echo date("d m y",(int)$search);
            });
        }
        $result->where("group_resources.group_id",$groupId);
        $result->where('groups.orgId', '=', Auth::user()->orgId);
        return $result;
    }
}
