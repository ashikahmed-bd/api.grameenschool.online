<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoticeRequest;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\NotificationResource;
use App\Jobs\SendNoticeNotificationJob;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::query()->with(['creator', 'course'])->orderByDesc('created_at')->paginate();
        return NoticeResource::collection($notices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoticeRequest $request)
    {
        $notice = Notice::query()->create([
            'title' => $request->title,
            'body' => $request->body,
            'type' => $request->type,
            'target' => $request->target,
            'published' => $request->published ?? false,
            'created_by' => Auth::id(),

        ]);

        SendNoticeNotificationJob::dispatch($notice);

        return response()->json([
            'success' => true,
            'message' => 'Notice created successfully',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        return NoticeResource::make($notice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoticeRequest $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        //
    }



    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }


    public function notifications(Request $request)
    {
        $notifications = auth()->user()
            ->notifications()
            ->whereNull('read_at')
            ->orderBy('created_at')
            ->get();

        return response()->json($notifications);
    }
}
