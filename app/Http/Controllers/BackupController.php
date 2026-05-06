<?php

namespace App\Http\Controllers;

use App\Jobs\BackupJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BackupController extends Controller
{

    public function index()
    {
        $disk = Storage::disk('local');

        $files = collect($disk->allFiles('backup'))
            ->filter(fn($file) => str_ends_with($file, '.zip'))
            ->sortByDesc(fn($file) => $disk->lastModified($file))
            ->map(fn($file) => [
                'file' => basename($file),
            ])
            ->values();

        return response()->json([
            'backups' => $files
        ]);
    }

    public function create()
    {
        Artisan::call('backup:run');

        return response()->json([
            'success' => true,
            'message' => 'Backup created successfully'
        ], Response::HTTP_CREATED);
    }

    public function download(string $file)
    {
        if (!$file || !Storage::disk('local')->exists("backup/{$file}")) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        $path = storage_path("app/backup/{$file}");

        return response()->download($path, $file, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        ]);
    }
}
