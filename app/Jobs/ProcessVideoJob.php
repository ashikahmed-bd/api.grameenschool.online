<?php

namespace App\Jobs;

use App\Enums\VideoStatus;
use App\Events\VideoUploadProgress;
use App\Models\Video;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Format\Video\X264;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Throwable;

class ProcessVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public Video $video;

    public int $timeout = 7200;
    public int $tries = 2;


    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function handle(): void
    {
        $this->video->refresh();

        $this->video->update([
            'status'     => VideoStatus::PROCESSING,
            'progress'   => 0,
            'started_at' => now(),
            'failure'    => null,
        ]);

        // Validate temp file exists first
        if (!Storage::disk($this->video->temp_disk)->exists($this->video->temp_path)) {
            throw new \Exception("Temp video not found: {$this->video->temp_path}");
        }

        $media = FFMpeg::fromDisk($this->video->temp_disk)
            ->open($this->video->temp_path);

        $duration = (int) $media->getDurationInSeconds();

        $this->video->lecture?->update([
            'duration' => round($duration / 60, 2),
        ]);


        $midBitrate = (new X264('aac'))->setKiloBitrate(500);
        $highBitrate = (new X264('aac'))->setKiloBitrate(1000);
        $stream_name = uniqid(true) . config('app.videos.extension');

        FFMpeg::fromDisk($this->video->temp_disk)
            ->open($this->video->temp_path)
            ->addFilter(function (VideoFilters $filters) {
                $filters->resize(new \FFMpeg\Coordinate\Dimension(640, 480));
            })
            ->exportForHLS()
            // ->export()
            ->onProgress(function ($progress) {
                $this->video->update(['progress' => $progress]);
                Log::info("Video {$this->video->id} progress: {$progress}%");
                // broadcast(new VideoUploadProgress($this->video->refresh()->lecture));
            })
            ->addFormat($midBitrate, fn($media) => $media->scale(720, 480))
            ->addFormat($highBitrate, fn($media) => $media->scale(1280, 720))
            ->toDisk($this->video->stream_disk)
            // ->inFormat(new \FFMpeg\Format\Video\X264)
            ->save("{$this->video->lecture->course_id}/{$stream_name}");

        $this->video->update([
            'duration'    => $duration,
            'stream_name' => $stream_name,
            'progress'    => 100,
            'status'      => VideoStatus::SUCCESSFUL,
            'ended_at'    => now(),
            'failure'     => null,
        ]);

        // broadcast(new VideoUploadProgress($this->video->refresh()->lecture));

        FFMpeg::cleanupTemporaryFiles();

        // clean uploaded tmp file
        if (Storage::disk($this->video->temp_disk)->exists($this->video->temp_path)) {
            Storage::disk($this->video->temp_disk)->delete($this->video->temp_path);
        }
    }

    public function failed(Throwable $exception): void
    {
        $this->video->refresh();

        $this->video->update([
            'status'   => VideoStatus::FAILED,
            'ended_at' => now(),
            'failure'  => $exception->getMessage(),
        ]);

        $this->video->lecture?->update([
            'duration' => 0,
        ]);

        Log::error('Video progress failed', [
            'video_id' => $this->video->id,
            'error'    => $exception->getMessage(),
        ]);
    }
}
