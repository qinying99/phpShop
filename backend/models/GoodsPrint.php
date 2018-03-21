<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/20 0020
 * Time: 下午 3:06
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsPrint extends ActiveRecord
{
    public function rules()
    {
        return [
            [['path','goods_id'],'safe']
        ];
    }
}