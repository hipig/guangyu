<?php

namespace App\Models;


use App\Jobs\GenerateGoodsCover;
use App\Models\Concerns\HasOperator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Goods extends Model
{
    use HasFactory, HasOperator;

    // 系统平台
    const PLATFORM_ANDROID = 1;
    const PLATFORM_IOS = 2;
    public static $platformMap = [
        self::PLATFORM_ANDROID => '安卓',
        self::PLATFORM_IOS => 'IOS',
    ];

        // 账号类型
    const ACCOUNT_TYPE_EMAIL = 1;
    const ACCOUNT_TYPE_PHONE = 2;
    const ACCOUNT_TYPE_HUAWEI = 3;
    const ACCOUNT_TYPE_IOS = 4;
    const ACCOUNT_TYPE_XIAOMI = 5;
    const ACCOUNT_TYPE_VIVO = 6;
    const ACCOUNT_TYPE_OPPO = 7;
    const ACCOUNT_TYPE_B = 8;
    public static $accountTypeMap = [
        self::ACCOUNT_TYPE_EMAIL => '邮箱账号',
        self::ACCOUNT_TYPE_PHONE => '手机账号',
        self::ACCOUNT_TYPE_HUAWEI => '华为渠道服',
        self::ACCOUNT_TYPE_IOS => '苹果ID',
        self::ACCOUNT_TYPE_XIAOMI => '小米渠道服',
        self::ACCOUNT_TYPE_VIVO => 'VIVO渠道服',
        self::ACCOUNT_TYPE_OPPO => 'OPPO渠道服',
        self::ACCOUNT_TYPE_B => 'B服',
    ];

    // 身高
    const HEIGHT_OTHER = 0;
    const HEIGHT_SHORT = 1;
    const HEIGHT_NOTHING = 2;
    const HEIGHT_ZERO = 3;
    public static $heightMap = [
        self::HEIGHT_OTHER => '其他',
        self::HEIGHT_SHORT => '永矮',
        self::HEIGHT_NOTHING => '永无',
        self::HEIGHT_ZERO => '0身高',
    ];

    // 上架状态
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;
    public static $statusMap = [
        self::STATUS_ENABLE => '上架',
        self::STATUS_DISABLE => '下架',
    ];

    // 特价状态
    const SPECIAL_STATUS_ON = 1;
    const SPECIAL_STATUS_OFF = 2;
    public static $specialStatusMap = [
        self::SPECIAL_STATUS_ON => '是',
        self::SPECIAL_STATUS_OFF => '否',
    ];

    protected $fillable = [
        'no',
        'platform',
        'account_type',
        'candle_count',
        'love_count',
        'wing_count',
        'cost_price',
        'min_price',
        'fixed_price',
        'progress_rate',
        'height',
        'description',
        'screenshot_images',
        'is_generated_cover',
        'status',
        'sale_status',
        'operate_remark',
    ];

    protected $casts = [
        'screenshot_images' => 'array',
        'is_generated_cover' => 'boolean',
    ];

    protected $appends = [
        'cover_url',
        'platform_text',
        'account_type_text',
        'height_text',
        'screenshot_images_url'
    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            dispatch(new GenerateGoodsCover($model));
        });
    }

    public function getCoverUrlAttribute()
    {
        $path = "{$this->no}.jpg";
        return Storage::disk('cover')->url($path);
    }

    public function getPlatformTextAttribute()
    {
        return self::$platformMap[$this->platform] ?? '';
    }

    public function getAccountTypeTextAttribute()
    {
        return self::$accountTypeMap[$this->account_type] ?? '';
    }

    public function getHeightTextAttribute()
    {
        return self::$heightMap[$this->height] ?? '';
    }

    public function getScreenshotImagesUrlAttribute()
    {
        $storage = Storage::disk('upload');
        $imagesUrl = [];
        $images = $this->screenshot_images ?? [];
        foreach ($images as $image) {
            list($width, $height) = getimagesize($storage->path($image));
            $imagesUrl[] = [
                'src' => $storage->url($image),
                'width' => $width,
                'height' => $height
            ];
        }
        return $imagesUrl;
    }

    public function maps()
    {
        return $this->belongsToMany(GoodsAttribute::class, 'goods_finish_maps', 'goods_id', 'attribute_id');
    }

    public function seasons()
    {
        return $this->belongsToMany(GoodsAttribute::class, 'goods_finish_seasons', 'goods_id', 'attribute_id');
    }

    public function giftBags()
    {
        return $this->belongsToMany(GoodsAttribute::class, 'goods_gift_bags', 'goods_id', 'attribute_id');
    }

    public function hotItems()
    {
        return $this->belongsToMany(GoodsAttribute::class, 'goods_hot_items', 'goods_id', 'attribute_id');
    }

    public static function findAvailableNo()
    {
        // 编号前缀
        $prefix = 'G';
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find store no failed');

        return false;
    }
}
