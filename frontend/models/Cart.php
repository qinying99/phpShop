<?php

namespace frontend\models;

use backend\models\Goods;
use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property int $amount 购买商品数量
 * @property int $goods_id 商品id
 */
class Cart extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'goods_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'amount' => '购买商品数量',
            'goods_id' => '商品id',
        ];
    }

}
