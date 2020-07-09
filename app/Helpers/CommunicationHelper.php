<?php
namespace App\Helpers;

use App\Models\CommTemplate;
use App\Models\CommMaster;
use App\Models\CommDetail;

class CommunicationHelper {
/**
 * Pre-defined Communication Templates List List
 * 1 welcome
 * 2 household_added
 * 3 event_added
 * 4 schedule_auto_notify
 * 5 schedule_manual_notify
 * 6 schedule_confirmation
 * 7 schedule_reminder
 * 8 schedule_check_out_notification_to_guest
 */
    /**
     * @Purpose : creating user communications and updating comm_master and comm_details(pivoteTable) tables
     * PARAMETERS LIST
     * tag : Tag name using to pick comm table from comm_template table
     * orgId: using for pick template with using respective tag name
     * type: [1=> Email comm, 2 => Natification], default notification
     * createdUserId: loggedin user id
     * toUserIdsArray: 
     */ 
    public static function generateCommunications($tag='', $orgId, $type =2, $createdUserId, $ToUserIdsArray, $related_id = null){
        $template = CommTemplate::where('tag', $tag)->where('org_id', $orgId)->first();
        if(empty($template)){
            $template = (new static)->addCommTemplateToOrg($tag, $orgId);
        }

        $commMaster = CommMaster::create([
                        'comm_template_id' => $template->id,
                        'org_id' => $orgId,
                        'type' => $type,
                        'tag' => $template->tag,
                        'name' => $template->name,
                        'subject' => $template->subject,
                        'body' => $template->body,
                        'from_user_id' => $createdUserId,
                        'related_id' => $related_id
                    ]);

        $attachUsers = [];
        foreach($ToUserIdsArray as $userId){
            $attachUsers[$userId] = ['read_status' => "UNREAD", "delete_status" => "UNDELETED"];
        }
        $commMaster->users()->attach($attachUsers);
    }

    /**
     * Creating a New communication template, If Template not created for respective org
     */
    public static function addCommTemplateToOrg($tag, $orgId){
        $template = CommTemplate::where('tag', $tag)->where('org_id', 0)->first();
        $newTemplate = CommTemplate::create([
                            'tag' => $template->tag,
                            'name' => $template->name,
                            'subject' => $template->subject,
                            'body' => $template->body,
                            'org_id' => $orgId
                        ]);
        return $newTemplate;
    }
}