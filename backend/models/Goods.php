<?php

namespace backend\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


class Goods extends ActiveRecord
{
    //添加创建时间
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['create_time'],
                ],
            ],
        ];
    }
    //添加多图上传的属性
    public $images;
    public static $status=["0"=>"上架","1"=>"下架"];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_name','sort'], 'required'],
            [[ 'market_price', 'goods_price'],'number'],
            [['sort','stock'],'integer'],
            [['goods_category_id','goods_print_id','goods_brand_id','status','create_time','images','logo'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_name' => '商品名称',
            'logo' => '商品logo',
            'goods_print_id' => '商品图片',
            'goods_category_id' => '商品分类',
            'goods_brand_id' => '商品品牌',
            'goods_intro_id' => '商品详情',
            'market_price' => '市场价格',
            'goods_price' => '本店价格',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '创建时间',
            'goods_sn' => '商品货号',
            'stock' => '商品库存'
        ];
    }
    //添加商品内容到goods_content中
    public function getContent(){
        return $this->hasOne(GoodsContent::className(),['goods_id'=>'id']);
    }
    //建立商品表与分类表的关系
    public function getCate(){
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
    //建立品牌表与商品表的关系
    public function getBrand(){
        return $this->hasOne(Brand::className(),['id'=>'goods_brand_id']);
    }
    //添加多图片到goods_print中
    public function getPrint(){
        return $this->hasMany(GoodsPrint::className(),['goods_id'=>'id']);
    }
}
