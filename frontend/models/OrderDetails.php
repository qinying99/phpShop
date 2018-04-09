<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $goods_id 商品id
 * @property string $goods_name 商品名称
 * @property string $price 商品价格
 * @property int $amount 商品数量
 */
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'amount'], 'integer'],
            [['price'], 'number'],
            [['goods_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'goods_id' => '商品id',
            'goods_name' => '商品名称',
            'price' => '商品价格',
            'amount' => '商品数量',
        ];
    }
}
