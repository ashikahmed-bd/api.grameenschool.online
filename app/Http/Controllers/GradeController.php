<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getGrades()
    {
        $grades = Grade::query()
            ->with([
                'batches' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('year', 'desc')
                        ->with(['groups' => function ($q) {
                            $q->where('is_active', true)
                                ->orderBy('sort_order');
                        }]);
                },
            ])
            ->orderBy('sort_order', 'asc')
            ->get();

        return GradeResource::collection($grades);
    }
}
