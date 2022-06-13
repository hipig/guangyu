<?php

namespace App\Admin\Actions\Dictionary;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class Back extends Action
{
    public $name = '返回字典';

    protected $selector = '.back-dictionaries';

    public function handle(Request $request)
    {
        return $this->response()->redirect('dictionaries');
    }

    public function html()
    {
        return "<a class='back-dictionaries btn btn-sm btn-default'><i class='fa fa-database'></i> 返回字典</a>";
    }
}
