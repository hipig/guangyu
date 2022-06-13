<?php

namespace App\Admin\Actions\Dictionary;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Config extends RowAction
{
    public $name = '配置';

    public function href()
    {
        return "dictionary-items?dictionary_id=" . $this->getKey();
    }

}
