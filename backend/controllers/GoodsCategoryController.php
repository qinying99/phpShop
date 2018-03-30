<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/18 0018
 * Time: 上午 11:45
 */

namespace backend\controllers;


use backend\models\ArticleCategory;
use backend\models\GoodsCategory;
use tests\models\Tree;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class GoodsCategoryController extends Controller
{
    //富文本框
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',

            ]
        ];
    }
    //分类添加
    public function actionAdd(){
        $cates = new GoodsCategory();
        //查找出所有的分类信息
        $cate = GoodsCategory::find()->asArray()->all();
        $cate[]=["id"=>0,"name"=>"一级分类","parent_id"=>0];
        $cate = json_encode($cate);
        $request = \Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $cates->load($request->post());
            if($cates->validate()){
                //判断parent_id的值  分辨出是一级分类还是子分类
                if($cates->parent_id==0){
                    //当parent_id = 0时为一级分类
                    $cates->makeRoot();
                    \Yii::$app->session->setFlash("success","创建一级分类:".$cates->name."成功");
                    //为了便于管理员的操作  应直接刷新页面 而不是跳转到列表页
                    return $this->refresh();
                }else{
                    //当parent_id != 0时为子分类
                    //首先找到父级分类
                    $parent = GoodsCategory::findOne($cates->parent_id);
                    $cates->prependTo($parent);
                    \Yii::$app->session->setFlash("success","创建{$parent->name}分类的子分类".$cates->name."成功");
                    return $this->refresh();
                }
            }else{
                var_dump($cates->errors);exit;
            }
        }
        return $this->render('add',compact('cates','cate'));
    }
    //列表页
    public function actionIndex()
    {
        $query = GoodsCategory::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render('index', compact('dataProvider'));
    }
    //修改
//    public function actionUpdate($id){
//        $cates = GoodsCategory::findOne($id);
//        $request = \Yii::$app->request;
//        if($request->isPost) {
//            //绑定数据
//            $cates->load($request->post());
//            if ($cates->validate()) {
//                if ($cates->save()){
//                    \Yii::$app->session->setFlash("success","修改成功");
//                    return $this->redirect(["index"]);
//                }
//            }
//        }
//        return $this->render('edit',compact('cates'));
//    }

    public function actionUpdate($id){
        $cates = GoodsCategory::findOne($id);
        //查找出所有的分类信息
        $cate = GoodsCategory::find()->asArray()->all();
        $cate[]=["id"=>0,"name"=>"一级分类","parent_id"=>0];
        $cate = json_encode($cate);
        $request = \Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $cates->load($request->post());
            if($cates->validate()){
                //判断parent_id的值  分辨出是一级分类还是子分类
                if($cates->parent_id==0){
                    //保存
                    $cates->save();
                    \Yii::$app->session->setFlash("success","修改成功");
                    //为了便于管理员的操作  应直接刷新页面 而不是跳转到列表页
                    return $this->redirect(["index"]);
                }else{
                    //当parent_id != 0时为子分类
                    //首先找到父级分类
                    $parent = GoodsCategory::findOne($cates->parent_id);
                    $cates->prependTo($parent);
                    \Yii::$app->session->setFlash("success","修改成功");
                    return $this->redirect(["index"]);
                }
            }else{
                var_dump($cates->errors);exit;
            }
        }
        return $this->render('add',compact('cates','cate'));
    }

    //删除
    public function actionDelete($id){
        $cate = GoodsCategory::findOne($id);
        //判断该条数据下是否还存在子类  如果存在则不能删除  不存在则删除
        if($cate->deleteWithChildren()){
            \Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }
}