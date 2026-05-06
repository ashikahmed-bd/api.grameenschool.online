<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return response()->json([
        'message' => 'API Server is running successfully.',
        'status' => 'success',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});

