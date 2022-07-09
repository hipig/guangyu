<?php

namespace App\Models;

use App\Models\Concerns\HasRank;
use App\Models\Concerns\HasStatus;

class EvaluatorAttribute extends Model
{
    use HasRank, HasStatus;

    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_INPUT = 'input';
    const TYPE_TEXTAREA = 'textarea';
    public static $typeMap = [
        self::TYPE_RADIO => '单选框',
        self::TYPE_CHECKBOX => '复选框',
        self::TYPE_INPUT => '文本框',
        self::TYPE_TEXTAREA => '多行文本框',
    ];

    public static $needOptionTypeMap = [
        self::TYPE_RADIO,
        self::TYPE_CHECKBOX
    ];

    const CACHE_KEY = 'group:evaluator_attributes';

    protected $fillable = [
        'name',
        'type',
        'options',
        'value',
        'is_compute',
        'rank',
        'status'
    ];

    protected $casts = [
        'is_compute' => 'boolean'
    ];

    public function getOptionsAttribute($value)
    {
        return array_values(json_decode($value, true) ?? []);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode(array_values($value));
    }
}
