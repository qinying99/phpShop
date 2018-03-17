<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16 0016
 * Time: 下午 3:46
 */

namespace backend\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }
    //设置属性
    public static $status=["0"=>"下架","1"=>"上架"];  //用来设置状态
    //设置规则
    public function rules()
    {
        return [
            [['name','category_id','sort','status',],'required'],
            [['name'],'unique'],
            [['create_time','update_time','intro'],'safe']
        ];
    }
    //设置lables
    public function attributeLabels()
    {
        return [
            'name'=>'标题',
            'category_id'=>'分类',
            'sort'=>'排序',
            'status'=>'是否上架',
            'intro'=>'简介'
        ];
    }
    //获取分类信息
    public function getCate(){
        return $this->hasone(ArticleCategory::className(),["id"=>"category_id"]);
    }
    //获取文章内容信息
    public function getContent(){
        return $this->hasOne(Content::className(),["article_id"=>"id"]);
    }
}