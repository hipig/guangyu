<?php

namespace App\Admin\Forms;

use App\Settings\GeneralSetting;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Setting extends Form
{
    protected $setting;

    /**
     * The form title.
     *
     * @var string
     */
    public $title = '网站设置';

    public function __construct($data = [])
    {
        $this->setting = app(GeneralSetting::class);
        parent::__construct($data);
    }

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        if ($request->hasFile('background_image')) {
            $image = $request->background_image;
            $storage = Storage::disk(config('admin.upload.disk'));
            $directory = "images";
            $name = $image->getClientOriginalName();
            if ($storage->exists("$directory/$name")) {
                $name = md5(uniqid()).'.'.$image->getClientOriginalExtension();
            }
            $path = $storage->putFileAs($directory, $image, $name);
            $this->setting->background_image = $path;
            $this->setting->save();
        }

        admin_success('更新设置成功!');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->image('background_image', '背景图片');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'background_image' => $this->setting->background_image
        ];
    }
}
