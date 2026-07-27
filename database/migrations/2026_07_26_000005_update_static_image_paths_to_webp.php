<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->replaceExtensions('profiles', 'profile_image');
        $this->replaceExtensions('educations', 'image');
        $this->replaceExtensions('experiences', 'logo');
        $this->replaceExtensions('certificates', 'image');
        $this->replaceExtensions('projects', 'thumbnail');
        $this->replaceExtensions('projects', 'images');
        $this->replaceExtensions('gallery_items', 'image');

        DB::table('site_settings')
            ->where('key', 'pattern_image')
            ->whereNotNull('value')
            ->update(['value' => DB::raw("REPLACE(REPLACE(value, '.jpg', '.webp'), '.png', '.webp')")]);
    }

    public function down(): void
    {
        // WebP paths are intentionally retained because the original files are removed.
    }

    private function replaceExtensions(string $table, string $column): void
    {
        DB::table($table)
            ->whereNotNull($column)
            ->where($column, 'like', '/images/%')
            ->update([$column => DB::raw("REPLACE(REPLACE({$column}, '.jpg', '.webp'), '.png', '.webp')")]);
    }
};
