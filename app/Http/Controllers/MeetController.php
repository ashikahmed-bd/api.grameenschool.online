<?php

namespace App\Http\Controllers;

use App\Enums\MeetProvider;
use App\Enums\MeetStatus;
use App\Http\Resources\MeetResource;
use App\Models\Course;
use App\Models\Meet;
use App\Models\User;
use App\Services\GoogleMeetService;
use App\Services\ZoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MeetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $liveClass = Meet::with(['course', 'host'])->orderByDesc('time')->paginate();
        return MeetResource::collection($liveClass);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'course_id' => 'nullable|exists:courses,hashid',
            'host_id' => 'required|exists:users,hashid',
            'topic' => ['required', 'string', 'max:255'],
            'date'  => ['required', 'date'],
            'time'  => ['required', 'date_format:H:i'],
            'provider' => ['required', 'string', Rule::enum(MeetProvider::class)],
            'status' => ['required', 'string'],
        ]);

        $startDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->date . ' ' . $request->time,
            config('app.timezone')
        );

        $endDateTime = (clone $startDateTime)->addMinutes((int) $request->duration);

        $zoom = app(ZoomService::class)->createMeeting([
            'topic' => $request->topic,
            'start_time' => $startDateTime->toIso8601String(),
            'duration' => 120,
        ]);

        Meet::create([
            'course_id'  => Course::getId($request->course_id) ?? null,
            'host_id'    => User::getId($request->host_id) ?? null,

            'topic'      => $request->topic,
            'date' => $startDateTime->format('Y-m-d H:i:s'),
            'time'   => $endDateTime->format('Y-m-d H:i:s'),
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

    public function join(Meet $meet)
    {
        $meet->update([
            'status' => MeetStatus::STARTED,
        ]);
        return MeetResource::make($meet);
    }
}
