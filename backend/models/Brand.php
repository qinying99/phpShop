<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name 品牌名称
 * @property string $intro 简介
 * @property string $logo LOGO
 * @property int $sort 排序
 * @property int $status 状态
 */
class Brand extends \yii\db\ActiveRecord
{
    //设置属性
    public $imgFile; //用于图片上传
    public static $status=["0"=>"是","1"=>"否"];
    /**
     * @inheritdoc
     */
    //设置规则
    public function rules()
    {
        return [
            [['name', 'imgFile','sort','status'], 'required'],
            [['intro',],'safe'],
            [['sort'],'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    //设置lable
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'name' => '品牌名称',
            'intro' => '简介',
            'imgFile' => 'LOGO',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
}
