<?php

namespace App\Http\Controllers;

use App\Enums\LectureType;
use App\Enums\Provider;
use App\Enums\VideoStatus;
use App\Http\Requests\LectureRequest;
use App\Http\Resources\LectureResource;
use App\Http\Resources\SectionResource;
use App\Jobs\ProcessVideoJob;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Section;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Symfony\Component\HttpFoundation\Response;

class LectureController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course, Section $section)
    {
        $lecture = $section->lectures()->create([
            'course_id' => $course->id,
            'title' => $request->title,
            'type' => null,
            'sort_order' => $section->lectures()->max('sort_order') + 1,
        ]);

        return LectureResource::make($lecture->fresh());
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Lecture $lecture)
    {
        if ($lecture->course_id !== $course->id) {
            abort(404);
        }

        return response()->json([
            'id' => $lecture->id,
            'title' => $lecture->title,
            'slug' => $lecture->slug,
            'video_type' => $lecture->video_type,
            'video_url' => $lecture->video_url,
            'video_duration' => $lecture->video_duration,
            'is_preview' => $lecture->is_preview,
            'materials' => $lecture->materials,
            'section' => $lecture->section,
            'next_lesson_id' => optional($lecture->nextLesson())->id,
            'previous_lesson_id' => optional($lecture->previousLesson())->id,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(LectureRequest $request, Course $course, Lecture $lecture)
    {
        $lecture->update([
            'title' => $request->title,
            'type' => $request->type ?? LectureType::VIDEO,
            'body' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lecture Updated Success',
        ], Response::HTTP_OK);
    }


    public function dragged(Request $request, Course $course)
    {
        $sections = $course->sections()->with('lectures')->get();

        $sections->each(function ($section) {
            $section->lectures->sortBy('sort_order')->values()->each(function ($lecture, $index) {
                $lecture->update(['sort_order' => $index + 1]);
            });
        });

        return SectionResource::collection(
            $course->sections()->with('lectures')->orderBy('sort_order')->get()
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lecture $lecture)
    {
        $lecture->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lecture deleted successfully.',
        ]);
    }


    public function article(Request $request, Course $course, Lecture $lecture)
    {
        $lecture->update([
            'body' => $request->body,
            'duration' => Lecture::calculateArticleReadingTime($request->body),
            'type' => LectureType::TEXT,
        ]);

        // delete any video for this lecture if it exists
        if ($lecture->video()->exists()) {
            $lecture->video->delete();
        }

        return $lecture->refresh();
    }

    public function video(Request $request, Course $course, Lecture $lecture)
    {

        $request->validate([
            'video_id' => ['required', 'string'],
            'provider' => ['required', 'string'],
        ]);

        $lecture->video()->updateOrCreate(
            ['lecture_id' => $lecture->id],
            [
                'title' => $lecture->title,
                'video_id' => $request->video_id,
                'provider' => $request->provider,
            ]
        );

        $duration = 0;

        if ($request->provider === 'youtube') {
            $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'id' => $request->video_id,
                'part' => 'contentDetails',
                'key' => config('services.youtube.api_key'),
            ]);

            if ($response->successful()) {
                $items = $response->json('items');
                $iso = data_get($items, '0.contentDetails.duration');

                if ($iso) {
                    $d = new \DateInterval($iso);
                    $duration = (($d->d * 24 + $d->h) * 60 + $d->i) * 60 + $d->s;
                }
            }
        } elseif ($request->provider === 'vimeo') {
            $response = Http::get('https://vimeo.com/api/oembed.json', [
                'url' => 'https://vimeo.com/' . $request->video_id,
            ]);

            if ($response->successful()) {
                $duration = (int) $response->json('duration', 0);
            }
        }

        $lecture->update([
            'type' => LectureType::VIDEO,
            'body' => null,
            'duration' => $duration,
        ]);

        return LectureResource::make($lecture->refresh());
    }
}
