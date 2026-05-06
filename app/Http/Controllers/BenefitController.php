<?php

namespace App\Http\Controllers;

use App\Enums\Provider;
use App\Models\Benefit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\BenefitResource;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $benefits = Benefit::query()->orderBy('sort_order')->get();
        return BenefitResource::collection($benefits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'banner'      => ['required', 'file', 'image', 'mimes:jpg,png,webp', 'max:1024'],
            'provider'    => ['required', 'string', Rule::enum(Provider::class)],
            'video_id'    => 'required|string|max:255',
            'sort_order'  => 'nullable|integer',
        ]);

        $benefit = new Benefit();
        $benefit->title = $request->title;
        $benefit->description = $request->description;
        $benefit->provider = $request->provider;
        $benefit->video_id = $request->video_id;
        $benefit->sort_order = $request->sort_order;
        if ($request->hasFile('banner')) {
            $pathUrl = $request->file('banner')->store('benefits', config('app.disk'));
            Image::read($request->file('banner'))->resize(1280, 720)->save(Storage::disk(config('app.disk'))->path($pathUrl));
            $benefit->banner = $pathUrl;
        }
        $benefit->save();

        return response()->json([
            'success' => true,
            'message' => 'Benefit created successfully',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Benefit $benefit)
    {
        return BenefitResource::make($benefit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Benefit $benefit)
    {
        $benefit->title = $request->title;
        $benefit->description = $request->description;
        $benefit->provider = $request->provider;
        $benefit->video_id = $request->video_id;
        $benefit->sort_order = $request->sort_order;
        if ($request->hasFile('banner')) {
            if (Storage::disk($benefit->disk)->exists($benefit->banner)) {
                Storage::disk($benefit->disk)->delete($benefit->banner);
            }
            $pathUrl = $request->file('banner')->store('benefits', config('app.disk'));
            Image::read($request->file('banner'))->resize(1280, 720)->save(Storage::disk(config('app.disk'))->path($pathUrl));
            $benefit->banner = $pathUrl;
        }
        $benefit->save();

        return response()->json([
            'success' => true,
            'message' => 'Benefit updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Benefit $benefit)
    {
        if (Storage::disk($benefit->disk)->exists($benefit->banner)) {
            Storage::disk($benefit->disk)->delete($benefit->banner);
        }

        $benefit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Benefit deleted successfully',
        ], Response::HTTP_OK);
    }


    public function getBenefits()
    {
        $benefits = Cache::remember('homepage_benefits', 3600, function () {
            return Benefit::query()
                ->orderBy('sort_order')
                ->get();
        });

        return response()->json([
            'title' => setting('benefits.title') ?? '',
            'overview' => setting('benefits.overview') ?? '',
            'items' => BenefitResource::collection($benefits),
        ]);
    }
}
