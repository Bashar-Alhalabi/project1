<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Teacher\CreateCallRequest;
use App\Models\Call;
use App\Services\Mobile\ZegoService;
use Illuminate\Support\Facades\DB;
class TeacherCallController extends Controller
{
    protected $zego;

    public function __construct(ZegoService $zego)
    {
        $this->zego = $zego;
    }

    /**
     * Teacher creates a video call.  Returns channel name and token.
     */
    public function store(CreateCallRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $teacher = auth()->user()->teacher;
                $channelName = $request->input('channel_name') ?? $this->zego->generateChannelName();
                $call = Call::create([
                    'channel_name' => $channelName,
                    'created_by' => $teacher->id,
                    'started_at' => now(),
                ]);
                $call->participants()->create([
                    'user_id' => auth()->id(),
                    'joined_at' => now(),
                ]);
                $token = $this->zego->generateToken(auth()->id());
                return response()->json([
                    'status' => true,
                    'message' => __('messages.call_created_successfully'),
                    'data' => [
                        'call_id' => $call->id,
                        'channel_name' => $call->channel_name,
                        'token' => $token,
                    ],
                ], 201);
            });
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => __('messages.unexpected_error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Teacher ends a call.
     */
    public function end(int $callId)
    {
        try {
            $call = Call::where('id', $callId)
                ->whereNull('ended_at')
                ->firstOrFail();
            $call->update([
                'ended_at' => now(),
            ]);
            return response()->json([
                'status' => true,
                'message' => __('messages.call_ended_successfully'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => __('messages.unexpected_error'),
            ], 500);
        }
    }
}