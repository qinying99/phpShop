<?php

namespace frontend\models;

use Yii;


class Address extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','province','city','county','address','phone'],'required'],
            [['phone'],'match','pattern'=>'/^[1][34578][0-9]{9}$/'],
            [['status'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'user_id' => '用户id',
            'province' => '省',
            'city' => '市',
            'county' => '区',
            'address' => '详情地址',
            'phone' => '手机号',
            'status' => '默认1 非默认0 （设置默认地址时使用）',
        ];
    }
}
