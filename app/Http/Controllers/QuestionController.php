<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Lecture $lecture)
    {
        $lecture->load(['questions.user']);

        $questions = $lecture->questions()
            ->with('user:id,name,avatar')
            ->latest()
            ->paginate(10);
        return QuestionResource::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Lecture $lecture)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $lecture->questions()->create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'body' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Question created successfully'
        ], Response::HTTP_CREATED);
    }


    public function show(Lecture $lecture, Question $question)
    {
        if ($question->lecture_id !== $lecture->id) {
            return response()->json([
                'message' => 'Question does not belong to this lecture',
            ], 403);
        }

        return QuestionResource::make($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecture $lecture, Question $question)
    {
        if ($question->lecture_id !== $lecture->id) {
            return response()->json([
                'message' => 'Question does not belong to this lecture',
            ], 403);
        }

        $request->validate([
            'body'  => 'required|string',
        ]);

        $question->update([
            'body' => $request->body,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Question updated successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $lecture, Question $question)
    {
        if ($question->lecture_id !== $lecture->id) {
            return response()->json([
                'message' => 'Question does not belong to this lecture',
            ], 403);
        }

        $question->delete();

        return response()->json([
            'message' => 'Question deleted successfully',
        ]);
    }
}
