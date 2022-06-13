<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;

class StoreController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('选号商城')
            ->body(view('admin.store'));
    }
}
