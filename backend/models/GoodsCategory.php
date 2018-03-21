<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "goods_category".
 *
 * @property int $id
 * @property int $tree
 * @property int $left
 * @property int $right
 * @property int $depth 深度
 * @property string $name 分类名称
 * @property string $intro 简介
 * @property int $parent_id 父类id
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    //树形结构
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'left',
                'rightAttribute' => 'right',
                'depthAttribute' => 'depth',
            ],
        ];
    }
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','parent_id'], 'required'],
            [['intro'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '分类名称',
            'intro' => '简介',
            'parent_id' => '父类id',
        ];
    }
}
