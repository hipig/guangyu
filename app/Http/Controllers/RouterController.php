<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RouterController extends Controller
{
    public function __invoke()
    {
        $mainBg = Storage::disk('upload')->url(app(GeneralSetting::class)->background_image);
        $config = [
            'app_name' => config('app.name'),
            'path' => '/',
            'api_url' => config('app.api_url'),
            'main_bg' => $mainBg
        ];

        return view('router', compact('config'));
    }
}
