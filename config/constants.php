<?php

return [

    //USEFUL CONSTATNTS
    'BROWSERTITLE' => 'Dallas',
    'BANK_TITLE' => 'Dallas',
    'COMMON_ERROR_MESSAGE' => [
        '404' => 'PAGE NOT FOUND',
        '403' => 'SORRY !!! ACCESS FORBIDDEN'
    ],
    'TODAYSDATE' => date('Y-m-d'),
    'TODAYSDATETIME' => date('Y-m-d H:i:s'),
    'FILE_SIZE'=>
    [
        'PHOTOS_SIZE'=>1024, //size in kb
    ],
    'OPTION_VALUE'=>
    [
        'OPTION_VALUE_YES'=>"YES",
        'OPTION_VALUE_NO'=>"NO",
    ],
    'REFERAL_COINS_DEFAULT'=> 50,
    'FILE_UPLOAD_PATH' =>[
        'PROFILE_PIC_UPLOAD_PATH' => public_path() . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "organizations",
        'INSIGHTS_UPLOAD_PATH' => public_path() . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "insights",
    ],
    'FILE_UPLOAD_NAME' =>[
        'ORG_LOGO_DEFAULT_FILE_NAME'=>"bible-cross-logo1.png"
    ],
    'FILE_DOWNLOAD_PATH' =>[
         'PROFILE_PIC_DOWNLOAD_PATH' => url('assets/uploads/organizations'),
         'INSIGHTS_DOWNLOAD_PATH' => url('assets/uploads/insights'),
    ],
    "ATTEDENCE_LOCK" => [
        "BEFORE" => 15, // in minutes
        "AFTER" => 5 // in minutes
    ],
    'CURRENCYCODE' => 'USD'    

];
