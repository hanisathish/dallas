<?php

return [

    'twilio' => [

        'default' => 'twilio',

        'connections' => [

            'twilio' => [

                /*
                |--------------------------------------------------------------------------
                | SID
                |--------------------------------------------------------------------------
                |
                | Your Twilio Account SID #
                |
                */

                'sid' => 'AC8584bfc31687da9513ff04c9fe195cfb', //Test - 'AC57975e85dd3e2a5f8e3d716d6e5fdbc5';

                /*
                |--------------------------------------------------------------------------
                | Access Token
                |--------------------------------------------------------------------------
                |
                | Access token that can be found in your Twilio dashboard
                |
                */

                'token' => '10e15516a6cfcae33a3c1544b7dd9817', //Test - 'baf58c076f735bdd1d0cb7507ab545bd';

                /*
                |--------------------------------------------------------------------------
                | From Number
                |--------------------------------------------------------------------------
                |
                | The Phone number registered with Twilio that your SMS & Calls will come from
                |
                */

                'from' => '+12052935653',  //Test - '+14848571412';

                /*
                |--------------------------------------------------------------------------
                | Verify Twilio's SSL Certificates
                |--------------------------------------------------------------------------
                |
                | Allows the client to bypass verifying Twilio's SSL certificates.
                | It is STRONGLY advised to leave this set to true for production environments.
                |
                */

                'ssl_verify' => false,
            ],
        ],
    ],
];
