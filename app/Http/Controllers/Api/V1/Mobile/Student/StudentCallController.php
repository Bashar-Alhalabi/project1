<?php

namespace App\Http\Controllers\Api\V1\Mobile\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\JoinCallRequest;
use App\Models\Call;
use App\Services\Mobile\ZegoService;

class StudentCallController extends Controller
{
    protected $zego;

    public function __construct(ZegoService $zego)
    {
        $this->zego = $zego;
    }

    public function join(JoinCallRequest $request)
    {
        try {
            $call = Call::where('id', $request->call_id)
                        ->whereNull('ended_at')
                        ->firstOrFail();
            $user  = auth()->user();
            $participant = $call->participants()
                                ->where('user_id', $user->id)
                                ->first();
            if (!$participant) {
                $participant = $call->participants()->create([
                    'user_id'   => $user->id,
                    'joined_at' => now(),
                ]);
            }
            $token = $this->zego->generateToken($user->id);
            return response()->json([
                'status'  => true,
                'message' => __('messages.call_joined_successfully'),
                'data'    => [
                    'call_id'      => $call->id,
                    'channel_name' => $call->channel_name,
                    'token'        => $token,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => __('messages.unexpected_error'),
            ], 500);
        }
    }
}