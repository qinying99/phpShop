<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property string $url
 * @property int $parent_id
 */
class Catalog extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
            'url' => 'Url',
            'parent_id' => 'Parent ID',
        ];
    }
    //声明一个静态方法
    public static function menu(){
        $menu = [];
        //找到数据库parent_id=0的所有数据
        $menuOnes = Catalog::find()->where(['parent_id'=>0])->all();
        foreach ($menuOnes as $menuOne){
            //定义一个空数组来存菜单
            $menuArr = [];
            $menuArr['label'] = $menuOne->name;
            $menuArr['icon'] = $menuOne->icon;
            $menuArr['url'] = $menuOne->url;
            //通过一级菜单嘚id找到他的二级菜单
            $menuTows = Catalog::find()->where(['parent_id'=>$menuOne->id])->all();
            foreach ($menuTows as $menuTow){
                //定义空数组存放菜单
                $menuArrSon = [];
                $menuArrSon['label'] = $menuTow->name;
                $menuArrSon['icon'] = $menuTow->icon;
                $menuArrSon['url'] = $menuTow->url;
                $menuArr['items'][]=$menuArrSon;

            }
            $menu[]=$menuArr;
        }

        return $menu;
    }
}
