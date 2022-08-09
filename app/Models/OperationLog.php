<?php

namespace App\Models;


use Encore\Admin\Facades\Admin;

class OperationLog extends Model
{
    const RELATION_TYPE_GOODS = 'goods';
    public static $relationTypeMaps = [
        self::RELATION_TYPE_GOODS => '商品',
    ];

    const OPERATION_TYPE_GOODS_CREATE = 'goods.create';
    const OPERATION_TYPE_GOODS_UPDATE = 'goods.update';
    const OPERATION_TYPE_GOODS_PUTON = 'goods.puton';
    const OPERATION_TYPE_GOODS_PUTOFF = 'goods.putoff';
    public static $operationTypeMaps = [
        self::OPERATION_TYPE_GOODS_CREATE => '商品新增',
        self::OPERATION_TYPE_GOODS_UPDATE => '商品更新',
        self::OPERATION_TYPE_GOODS_PUTON => '商品上架',
        self::OPERATION_TYPE_GOODS_PUTOFF => '商品下架',
    ];

    protected $fillable = [
        'relation_type',
        'relation_id',
        'relation_name',
        'operation_type',
        'input',
        'operation_by',
    ];

    protected $casts = [
        'input' => 'array'
    ];

    protected $appends = [
        'relation_url'
    ];

    public static function record($relation, $operationType)
    {
        $relationType = $relation->getTable();
        $relationName = '';
        switch ($relationType) {
            case self::RELATION_TYPE_GOODS:
                $relationName =$relation->no;
        }

        $model = new self();
        $model->relation_type = $relationType;
        $model->relation_id = $relation->getKey();
        $model->relation_name = $relationName;
        $model->input = request()->input();
        $model->operation_type = $operationType;
        $model->operation_by = Admin::user()->name ?? '';
        $model->save();
    }

    public function getRelationUrlAttribute()
    {
        $url = "";
        switch ($this->relation_type) {
            case self::RELATION_TYPE_GOODS:
                $goods = Goods::query()->find($this->relation_id);
                if ($goods) {
                    $url = "/store/detail?id={$this->relation_id}";
                }
        }

        return $url;
    }
}
