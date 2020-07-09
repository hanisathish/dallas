<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "/api/people/member/households/get-users-search",
        "/api/people/member/households/create-new",
        "/api/people/member/households/remove-household",
        "/api/people/member/households/update-household",
        "/api/people/member/{personal_id}/get_messages",
        "/settings/communication/getOrgTemplates",
        "/api/people/member/{personal_id}/get_messages/{master_id}",
        "/api/settings/forms/manage/{form_id}",
        "/api/settings/forms/manage",
        "/api/form/submission",
        "/api/groups/typesList",
        "/api/groups/tagsListWithGroups",
        "/api/groups/createOrUpdateTagGroup",
        "/api/groups/tags/createOrUpdateTag",
        "/api/groups/tags/updateTagsOrder",
        "/api/groups/tags/updateTagGroupsOrder",
        "/api/settings/schedule/createRelatedData",
        "/api/settings/schedule/getAssignedMembersList",
        "/api/settings/schedule/getMemberSearchList",
        "/api/settings/schedule/storeOrUpdateSchedule",
        "/api/hosting/groups/typesList"
    ];
}
