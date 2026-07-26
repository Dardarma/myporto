<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images' => 'array',
        ];
    }

    public function stacks(): HasMany
    {
        return $this->hasMany(ProjectStack::class)->orderBy('sort_order');
    }
}
