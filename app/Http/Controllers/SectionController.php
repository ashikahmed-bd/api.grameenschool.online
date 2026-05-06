<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Resources\SectionResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SectionController extends Controller
{

    public function index(Course $course)
    {
        $sections = $course->sections()
            ->withCount(['lectures', 'quizzes'])
            ->orderBy('sort_order')
            ->get();

        return SectionResource::collection($sections);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'icon' => 'nullable|file|image|max:2048',
        ]);

        $section = $course->sections()->create([
            'title' => $request->title,
            'sort_order' => $course->sections()->max('sort_order') + 1,
        ]);

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('sections', config('app.disk'));
            $section->update(['icon' => $path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Section Created Success',
        ], Response::HTTP_CREATED);
    }

    public function dragged(Request $request, Course $course)
    {
        $sections = $course->sections()->orderBy('sort_order')->get();

        $sections->each(function ($section, $index) {
            $section->update(['sort_order' => $index + 1]);
        });

        return SectionResource::collection(
            $course->sections()->with('lectures')->orderBy('sort_order')->get()
        );
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Section $section)
    {
         $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|file|image|max:2048',
        ]);

        $section->update([
            'title' => $request->title,
            'sort_order' => $request->sort_order ?? $section->sort_order,
        ]);

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('sections', config('app.disk'));
            $section->update(['icon' => $path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Section Updated Successful',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Section $section)
    {
        if ($section->icon && Storage::disk($section->disk)->exists($section->icon)) {
            Storage::disk($section->disk)->delete($section->icon);
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section Deleted Successful',
        ]);
    }
}
