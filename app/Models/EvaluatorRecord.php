<?php

namespace App\Models;

use Illuminate\Support\Str;

class EvaluatorRecord extends Model
{
    protected $fillable = [
        'content'
    ];

    protected $casts = [
        'content' => 'json'
    ];

    protected $appends = [
        'content_result'
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            if (!$model->code) {
                $model->code = static::findAvailableCode();
                // 如果生成失败，则终止创建订单
                if (!$model->code) {
                    return false;
                }
            }
        });
    }


    public function getContentResultAttribute()
    {
        $result = ['编号：' . $this->code];
        $attributes = EvaluatorAttribute::query()->enable()->get();
        foreach ($attributes as $attribute) {
            if (isset($this->content[$attribute->key])) {
                $content = $this->content[$attribute->key];
                $row = "{$attribute->label}：";
                switch ($attribute->type) {
                    case EvaluatorAttribute::TYPE_RADIO:
                        $options = array_column($attribute->options, 'label', 'key');
                        $row .= $options[$content] ?? '';
                        break;
                    case EvaluatorAttribute::TYPE_CHECKBOX:
                        $options = array_column($attribute->options, 'label', 'key');
                        $optionsValue = [];
                        foreach ($content as $value) {
                            $optionsValue[] = $options[$value] ?? '';
                        }
                        $row .= join('，', $optionsValue);
                        break;
                    default:
                        $row .= $content;
                }
                $result[] = $row;
            }
        }

        return implode("\r\n", $result);
    }

    public static function findAvailableCode()
    {
        // 编号前缀
        for ($i = 0; $i < 10; $i++) {
            $code = Str::random();
            // 判断是否已经存在
            if (!static::query()->where('code', $code)->exists()) {
                return $code;
            }
        }
        \Log::warning('find record code failed');

        return false;
    }
}
