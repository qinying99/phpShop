<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $order_id 订单号
 * @property int $user_id 用户id
 * @property string $name 收货人
 * @property string $province 省
 * @property string $city 市
 * @property string $county 区
 * @property string $add 详细地址
 * @property string $phone 收货人电话
 * @property int $delivery_id 配送id
 * @property int $pay_id 支付id
 * @property int $status 状态（取消、待发货、待收货、待付款、完成）
 * @property int $create_time 创建时间
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'delivery_id', 'pay_id', 'status', 'create_time'], 'integer'],
            [['order_id', 'name', 'add'], 'string', 'max' => 255],
            [['province', 'city', 'county', 'phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单号',
            'user_id' => '用户id',
            'name' => '收货人',
            'province' => '省',
            'city' => '市',
            'county' => '区',
            'add' => '详细地址',
            'phone' => '收货人电话',
            'delivery_id' => '配送id',
            'pay_id' => '支付id',
            'status' => '状态（取消、待发货、待收货、待付款、完成）',
            'create_time' => '创建时间',
        ];
    }
}
