<?php
return [
'app_id' => env('ZEGO_APP_ID'),
'server_secret' => env('ZEGO_SERVER_SECRET'),
'token_expire' => env('ZEGO_TOKEN_EXPIRE', 3600), // seconds
];
