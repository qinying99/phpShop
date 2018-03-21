<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19 0019
 * Time: 下午 6:46
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsContent extends ActiveRecord
{
    //设置属性
    //设置规则
    public function rules()
    {
        return [
            [['content'],'required']
        ];
    }
    //设置lables
    public function attributeLabels()
    {
        return [
            'content'=>"文章内容"
        ];
    }

}