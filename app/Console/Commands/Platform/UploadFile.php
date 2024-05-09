<?php

namespace App\Console\Commands\Platform;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class UploadFile extends Command
{
    protected $signature = 'platform:upload-file';

    protected $description = 'Test uploading file to Google Cloud Storage';

    public function handle()
    {
        $fileName = Carbon::now()->toIso8601String();

        Storage::disk('gcs')->put("/example/$fileName.txt", 'Hello, world!');

        return 0;
    }
}
