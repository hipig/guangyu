<?php

namespace App\Models\Concerns;

use App\Models\Model;

trait HasStatus
{
    public function scopeEnable($query)
    {
        $query->where('status', Model::STATUS_ENABLE);
    }

    public function scopeDisable($query)
    {
        $query->where('status', Model::STATUS_DISABLE);
    }
}
