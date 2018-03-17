<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16 0016
 * Time: 下午 5:30
 */

namespace backend\models;


use yii\db\ActiveRecord;

class ArticleCategory extends ActiveRecord
{
    //设置属性
    //设置规则
    public function rules()
    {
        return [
            [["name","article_id"],"required"],
            [["name","article_id"],"unique"]
        ];
    }
    //设置lables
    public function attributeLabels()
    {
        return [
            "name"=>"分类名称",
            "article_id"=>"文章id"
        ];
    }
}