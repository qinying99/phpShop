<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16 0016
 * Time: 下午 5:30
 */

namespace backend\controllers;


use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleCategoryController extends Controller
{
    //显示所有的分类信息
    public function actionIndex(){
        $query = ArticleCategory::find();
        //获取所有记录的条数
        $count = $query->count();
        //使用总数来创建一个分页对象
        $page = new Pagination(["totalCount" => $count, "pageSize" => 2]);
        $cates = $query->offset($page->offset)
            ->limit($page->limit)
            ->all();
        return $this->render("index",compact("cates","page"));
    }
    //添加分类信息
    public function actionAdd(){
        $cate = new ArticleCategory();
        //判断POST
        if(\Yii::$app->request->isPost){
            //绑定数据
            $cate->load(\Yii::$app->request->post());
            //后台验证
            if($cate->validate()){
                if($cate->save()){
                    //提示信息
                    \Yii::$app->session->setFlash("success","添加分类成功");
                    return $this->redirect(["index"]);
                }
            }
        }
        return $this->render("add",compact("cate"));
    }
    //修改分类信息
    public function actionEdit($id){
        $cate = ArticleCategory::findOne($id);
        //判断POST
        if(\Yii::$app->request->isPost){
            //绑定数据
            $cate->load(\Yii::$app->request->post());
            //后台验证
            if($cate->validate()){
                if($cate->save()){
                    //提示信息
                    \Yii::$app->session->setFlash("success","添加分类成功");
                    return $this->redirect(["index"]);
                }
            }
        }
        return $this->render("add",compact("cate"));
    }
    //删除分类信息
    public function actionDel($id){
        if(ArticleCategory::findOne($id)->delete()){
            \Yii::$app->session->setFlash("danger","删除分类成功");
            return $this->redirect(["index"]);
        }
    }
}