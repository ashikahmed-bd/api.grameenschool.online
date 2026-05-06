<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\Homework;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\HomeworkResource;
use App\Http\Resources\SubmissionResource;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, Lecture $lecture)
    {
        if ($lecture->course_id !== $course->id) {
            return response()->json(['message' => 'Lecture does not belong to this course'], 404);
        }

        $homeworks = $lecture->homeworks()->latest()->paginate(10);

        return HomeworkResource::collection($homeworks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course, Lecture $lecture)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_at' => 'nullable|date',
            'max_marks' => 'nullable|integer|min:0',
            'type' => 'required|in:text,file,both',
        ]);

        $lecture->homeworks()->create([
            'course_id' => $lecture->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
        ]);

        return response()->json([
            'message' => 'Homework created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Lecture $lecture, Homework $homework)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_at' => 'nullable|date',
            'max_marks' => 'nullable|integer|min:0',
            'type' => 'required|in:text,file,both',
        ]);


        // Ensure the homework belongs to this lecture
        if ($homework->lecture_id !== $lecture->id) {
            return response()->json([
                'message' => 'Homework does not belong to this lecture'
            ], 404);
        }

        $homework->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'due_at' => $request->due_at,
            'max_marks' => $request->max_marks,
        ]);

        return response()->json([
            'message' => 'Homework updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lecture $lecture, Homework $homework)
    {

        // Delete associated submissions' files individually
        foreach ($homework->submissions as $submission) {
            if ($submission->file_path && Storage::disk($course->disk)->exists($submission->file_path)) {
                Storage::disk($course->disk)->delete($submission->file_path);
            }
            $submission->delete(); // Delete the submission record
        }

        $homework->delete();

        return response()->json([
            'message' => 'Homework deleted successfully',
        ]);
    }

    public function submit(Request $request, Course $course, Lecture $lecture, Homework $homework)
    {
        $request->validate([
            'answer' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
        ]);

        // Prevent duplicate submission
        if ($homework->submissions()->where('user_id', auth()->id())->exists()) {
            return response()->json([
                'message' => 'You have already submitted this homework',
            ], 422);
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('homeworks', config('app.disk'));
        }

        $homework->submissions()->create([
            'user_id' => auth()->id(),
            'answer' => $data['answer'] ?? null,
            'file_path' => $filePath ?? null,
        ]);

        return response()->json([
            'message' => 'Homework submitted successfully',
        ], 201);
    }


    public function submissions(Course $course, Lecture $lecture, Homework $homework)
    {
        $submissions = $homework->submissions()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return SubmissionResource::collection($submissions);
    }


    public function grade(Request $request, Course $course, Lecture $lecture, Submission $submission)
    {
        $request->validate([
            'marks' => 'required|integer|min:0',
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'marks' => $request->marks,
            'feedback' => $request->feedback ?? null,
            'graded_at' => now(),
        ]);

        return response()->json([
            'message' => 'Homework graded successfully',
        ]);
    }
}
