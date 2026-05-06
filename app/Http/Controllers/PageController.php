<?php

namespace App\Http\Controllers;

use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function getPages(Request $request)
    {
        $pages = Cache::remember('pages', now()->addMinutes(60), function () {
            return Page::query()
                ->where('public', true)
                ->orderBy('order')
                ->get()
                ->groupBy('type');
        });

        return $pages->map(function ($items) {
            return PageResource::collection($items);
        });
    }

    public function pageDetails(string $slug)
    {
        $page = Page::query()->where('slug', $slug)->where('public', true)->firstOrFail();
        return PageResource::make($page);
    }
}
