<?php

namespace App\Models\Concerns;


trait HasRank
{
    public function scopeRank($query, $direction = 'asc')
    {
        $query->orderBy('rank', $direction);
    }
}
