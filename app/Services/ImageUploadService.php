<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageUploadService
{
    public function store(UploadedFile $file): string
    {
        $path = 'portfolio/'.Str::uuid().'.webp';

        $image = Image::read($file)
            ->scaleDown(width: 1920, height: 1920);

        Storage::disk('public')->put($path, (string) $image->toWebp(quality: 80));

        return '/storage/'.$path;
    }

    public function delete(?string $url): void
    {
        if (! $url || ! str_starts_with($url, '/storage/portfolio/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($url, '/storage/'));
    }
}
