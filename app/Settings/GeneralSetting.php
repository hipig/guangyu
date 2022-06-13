<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public string $background_image;

    public static function group(): string
    {
        return 'general';
    }
}
