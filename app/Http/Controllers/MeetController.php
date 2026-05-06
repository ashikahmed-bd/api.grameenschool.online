<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Meet;
use App\Enums\MeetStatus;
use App\Enums\MeetProvider;
use Illuminate\Http\Request;
use App\Services\ZoomService;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Services\GoogleMeetService;
use App\Http\Resources\MeetResource;
use Symfony\Component\HttpFoundation\Response;

class MeetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $liveClass = Meet::with(['course', 'host'])->orderByDesc('start_time')->paginate();
        return MeetResource::collection($liveClass);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'host_id' => 'required|exists:users,id',
            'topic' => ['required', 'string', 'max:255'],
            'start_date'  => ['required', 'date'],
            'start_time'  => ['required', 'date_format:H:i'],
            'duration' => 'required|integer|min:1|max:1440',
            'provider' => ['required', 'string', Rule::enum(MeetProvider::class)],
            'status' => ['required', 'string'],
        ]);

        try {
            $startDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $request->start_date . ' ' . $request->start_time,
                config('app.timezone')
            );

            $endDateTime = (clone $startDateTime)->addMinutes((int) $request->duration);

            if ($request->provider === 'zoom') {
                $zoom = app(ZoomService::class)->createMeeting([
                    'topic' => $request->topic,
                    'start_time' => $startDateTime->toIso8601String(),
                    'duration' => $request->duration,
                ]);

                Meet::create([
                    'topic'      => $request->topic,
                    'start_time' => $startDateTime->format('Y-m-d H:i:s'),
                    'end_time'   => $endDateTime->format('Y-m-d H:i:s'),
                    'course_id'  => $request->course_id ?? null,
                    'host_id'    => $request->host_id ?? null,
                    'provider'   => MeetProvider::ZOOM,
                    'meeting_id' => $zoom['id'],
                    'join_url'   => $zoom['join_url'],
                    'host_url'   => $zoom['start_url'],
                    'status'     => $request->status,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Meeting Created successfully',
                ], Response::HTTP_CREATED);
            }

            if ($request->provider === 'google_meet') {
                $user = $request->user();

                if (!$user->google_token) {
                    return response()->json([
                        'error' => 'Google not connected'
                    ], 403);
                }

                $service = new GoogleMeetService($user->google_token);

                $event = $service->createMeeting([
                    'topic'      => $request->topic,
                    'start_time' =>  $startDateTime,
                    'end_time'   => $endDateTime,
                ]);

                // Save updated token after refresh
                $user->update([
                    'google_token' => $service->getToken(),
                ]);

                Meet::create([
                    'topic'      => $event['summary'],
                    'start_time' => $startDateTime->format('Y-m-d H:i:s'),
                    'end_time'   => $endDateTime->format('Y-m-d H:i:s'),
                    'course_id'  => $request->course_id ?? null,
                    'host_id'    => $request->host_id ?? null,
                    'provider'   => MeetProvider::GOOGLE_MEET,
                    'meeting_id' => $event['event_id'],
                    'join_url'   => $event['join_url'],
                    'host_url'   => $event['join_url'],
                    'status'     => $request->status,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Google Meet created successfully',
                    'data'    => $event
                ], Response::HTTP_CREATED);
            }

            return response()->json([
                'message' => 'Invalid provider. Please use "google_meet" or "zoom".'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while creating meeting',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meet = Meet::query()->findOrFail($id);
        return MeetResource::make($meet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meet = Meet::query()->findOrFail($id);

        $meet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Live class deleted successfully',
        ], Response::HTTP_OK);
    }

    public function join(string $id)
    {
        $meet = Meet::query()->findOrFail($id);

        $meet->update([
            'status' => MeetStatus::STARTED,
        ]);
        return MeetResource::make($meet);
    }
}
