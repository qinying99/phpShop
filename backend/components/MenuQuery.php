<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/18 0018
 * Time: 下午 4:12
 */

namespace backend\components;


use creocoder\nestedsets\NestedSetsQueryBehavior;

class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}


