<?php

namespace App\Http\Controllers\Api\V1\Mobile\Agora;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Agora\TokenGenerateRequest;
use Illuminate\Http\Request;
use Peterujah\Agora\Agora;
use Peterujah\Agora\Builders\RtcToken;
use Peterujah\Agora\User as AgoraUser;
use Peterujah\Agora\Roles;

class TokenController extends Controller
{
    public function generate(TokenGenerateRequest $request)
    {
        // 2) Load credentials from .env
        $appId = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = $request['channel'];
        $uid = $request['uid'];

        // 3) Compute expiration (e.g. 1 hour from now)
        $currentTs = now()->timestamp;
        $expireTs = $currentTs + 3600;

        // 4) Initialize Agora client
        $client = new Agora($appId, $appCertificate);
        $client->setExpiration($expireTs);

        // 5) Prepare Agora user
        $agoraUser = (new AgoraUser($uid))
            ->setChannel($channelName)
            ->setRole(Roles::RTC_PUBLISHER)
            ->setPrivilegeExpire($expireTs);

        // 6) Build the token
        $token = RtcToken::buildTokenWithUid($client, $agoraUser);

        // 7) Return JSON payload
        return response()->json([
            'appId' => $appId,
            'token' => $token,
            'channel' => $channelName,
            'uid' => $uid,
        ]);
    }
}
