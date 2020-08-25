<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CronBatchEmail
 */
class CronBatchEmail extends Model
{
    protected $table = 'cron_batch_email';

    protected $primaryKey = 'cron_id';

	public $timestamps = false;

    protected $fillable = [
        'cron_id', 'recipient_user_id', 'orgId', 'subject', 'message', 'recipient', 'cc_recipient', 'files_offset', 'file_attach', 'send_status', 'sent_from', 'sent_from_email', 'send_dts', 'mail_error', 'subaccount_id', 'createdBy', 'created_at', 'updatedBy', 'updated_at', 'deletedBy', 'deleted_at'
    ];

    protected $guarded = [];
    
    /*
    * Function name : selectEmails
    * Purpose       : To select the cron emails
    * Added by      : Sukanya
    * Added Date    : June 20, 2016
    */
    public static function selectEmails() {
        
        $query = CronBatchEmail::where('send_status', 0)
                 ->limit(2)
                 ->orderBy('cron_id','ASC')
                 ->get();
        
        if (count($query) > 0) {
            return $query->toArray();
        } else {
            return "failure";
        }
    }
    
    /*
    * Function name : updateCron
    * Purpose       : To update the cron emails
    * Added by      : Sukanya
    * Added Date    : June 20, 2016
    */
    public static function updateCron($update_details, $cron_id) {
        CronBatchEmail::where('cron_id', $cron_id)
        ->update($update_details);
    }

        
}