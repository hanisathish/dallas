<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use DateTime;
use Auth;

class PastorBoard extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;

    protected $table = 'pastor_board';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['orgId','parent_type','p_title','p_description','classified_type','p_category','posted_date','contact_name','contact_email','contact_phone','cost','image_path','location_id','status','createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public static function listPost($search) {
        $result = self::select('id', 'p_title', 'p_description','contact_name','contact_email','contact_phone', 'image_path','posted_date')
        /* ->orderBy("created_at","desc") */;
        if ($search != "") {
            $result->where(function($query)use($search) {



                return $query->where('p_title', 'LIKE', "%$search%");
                                //->orWhere('eventDesc', 'LIKE', "%$search%");

                //echo date("d m y",(int)$search);
            });
        }


        $result->where('orgId', '=', Auth::user()->orgId);

        return $result;
    }

    public static function listAllPost($search) {
        $result = self::select(DB::raw('SQL_CALC_FOUND_ROWS  pastor_board.id'), 'p_title', 'p_description','classified_type','contact_name','contact_email','contact_phone', 'image_path','cost','posted_date','parent_type','pastor_board.createdBy','pastor_board.created_at')
                    ->addSelect(DB::raw("concat(users.first_name,COALESCE(users.last_name,'')) as created_user"))
                    ->join("users" ,"users.id","=","pastor_board.createdBy");
        /* ->orderBy("created_at","desc") */;
        if ($search != "") {
            $result->where(function($query)use($search) {



                return $query->where('p_title', 'LIKE', "%$search%")
                                ->orWhere('p_description', 'LIKE', "%$search%");

                //echo date("d m y",(int)$search);
            });
        }


        //$result->where('orgId', '=', Auth::user()->orgId);

        return $result;
    }





}
