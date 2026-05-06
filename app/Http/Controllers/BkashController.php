<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BkashService;

class BkashController extends Controller
{
    protected BkashService $bkashService;

    public function __construct(BkashService $bkashService)
    {
        $this->bkashService = $bkashService;
    }

    /**
     * Handle Bkash payment callback
     */
    public function callback(Request $request)
    {
        return $this->bkashService->callback($request);
    }
}
