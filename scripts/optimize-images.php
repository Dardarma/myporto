<?php

declare(strict_types=1);

$imagesDirectory = realpath(__DIR__.'/../public/images');
$deleteOriginals = in_array('--delete-originals', $argv, true);

if ($imagesDirectory === false || ! extension_loaded('gd')) {
    fwrite(STDERR, "The public/images directory and PHP GD extension are required.\n");
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($imagesDirectory, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (! $file->isFile() || ! in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png'], true)) {
        continue;
    }

    $source = $file->getRealPath();
    $target = preg_replace('/\.(jpe?g|png)$/i', '.webp', $source);
    $image = match (strtolower($file->getExtension())) {
        'jpg', 'jpeg' => imagecreatefromjpeg($source),
        'png' => imagecreatefrompng($source),
    };

    if ($image === false || ! imagewebp($image, $target, 78)) {
        fwrite(STDERR, "Failed to optimize {$source}\n");
        exit(1);
    }

    if ($deleteOriginals && realpath(dirname($source)) !== false
        && str_starts_with(realpath(dirname($source)), $imagesDirectory)) {
        unlink($source);
    }

    echo str_replace($imagesDirectory, 'public/images', $target).PHP_EOL;
}
