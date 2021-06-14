<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Discog Token
    |--------------------------------------------------------------------------
    |
    | You'll need a token otherwise you'll be rate limited to 25 request per
    | minute. Find your token here: https://www.discogs.com/settings/developers
    | after you've create an app.
    |
    */

    'DISCOGS_TOKEN' => 'YOUR_TOKEN',

    /*
    |--------------------------------------------------------------------------
    | Discogs Consumer Key
    |--------------------------------------------------------------------------
    |
    | OAuth consumer key
    | After you have created an application  navigate to this link:
    | https://www.discogs.com/settings/developers and click on the settings
    | button next to you app to reveal the key and secret
    |
    |
    */

    'DISCOGS_CONSUMER_KEY' => 'YOUR_CONSUMER_KEY',

    /*
    |--------------------------------------------------------------------------
    | Discogs Consumer Secret
    |--------------------------------------------------------------------------
    |
    | OAuth consumer secret
    | After you have created an application from this page link:
    | https://www.discogs.com/settings/developers and click on the settings
    | button next to you app to reveal the key and secret
    |
    */

    'DISCOGS_CONSUMER_SECRET' => 'YOUR_CONSUMER_SECRET',

    /*
    |--------------------------------------------------------------------------
    | Discogs Version
    |--------------------------------------------------------------------------
    |
    | Currently, Discogs API only supports one version: v2. However, you can specify
    | a version in your requests to future-proof your application. By adding an
    | Accept header with the version and media type, you can guarantee your
    | requests will receive data from the correct version you develop your app on.
    | I've set this to v2 by default until a new version.
    */

    'DISCOGS_VERSION' => 'v2',

    /*
    |--------------------------------------------------------------------------
    | Discogs Media Type
    |--------------------------------------------------------------------------
    |
    | If you are requesting information from an endpoint that may have text
    | formatting in it, you can choose which kind of formatting you want to
    | be returned by changing that section of the Accept header.
    | Discogs currently support 3 types: html, plaintext, discogs
    | I've set this to discogs by default.
    |
    */

    'DISCOGS_MEDIA_TYPE' => 'discogs',

    /*
    |--------------------------------------------------------------------------
    | Discogs User Agent
    |--------------------------------------------------------------------------
    |
    | User Agent
    |
    */

    'DISCOGS_USER_AGENT' => 'Orin/0.1 +http://orin.xyrotech.com',

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    |
    | Username associate with Discog Token / Consumer Key/Secret
    | The name associated with the discogs account
    |
    */

    'USERNAME' => 'USERNAME',
    'TEST_NAME' => 'TEST NAME',
];
