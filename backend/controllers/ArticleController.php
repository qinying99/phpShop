<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16 0016
 * Time: 下午 3:43
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\Content;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
    //显示所有的文章信息
    /**
     * @return string
     */
    public function actionIndex(){
        $query = Article::find();
        $count = $query->count();
        $page =new Pagination([
            'totalCount' => $count,
            "pageSize" => 3
        ]);
        // 使用分页对象来填充 limit 子句并取得文章数据
        $articles = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render("index",compact("articles","page"));
    }
    //添加文章信息
    public function actionAdd(){
        //创建文章管理模型对象
        $article=new Article();
        //创建文章内容模型对象
        $content = new Content();
        //获取所有的分类信息
        $cate = ArticleCategory::find()->asArray()->all();
        //将$cate转换成成一维数组
        $cateArr = ArrayHelper::map($cate,"id","name");
        //创建request对象
        $request = new Request();
        //判断提交方式
        if($request->isPost){
            //绑定数据
            $article->load($request->post());
            //后台验证
            if($article->validate()){
                if ($article->save()) {
                    //保存文章内容
                    $content->load($request->post());
                        //给文章id赋值
                        $content->article_id=$article->id;
                        //保存文章内容
                        if($content->save()){
                            \Yii::$app->session->setFlash("success","添加文章成功");
                            return $this->redirect(["index"]);
                        }
                    }
            }
        }
        return $this->render("add",compact("article","cateArr","content"));
    }
    //修改文章信息
    public function actionEdit($id){
        //创建文章管理模型对象
        $article=Article::findOne($id);
        //创建文章内容模型对象
        $content = Content::findOne($id);
        //获取所有的分类信息
        $cate = ArticleCategory::find()->asArray()->all();
        //将$cate转换成成一维数组
        $cateArr = ArrayHelper::map($cate,"id","name");
        //创建request对象
        $request = new Request();
        //判断提交方式
        if($request->isPost){
            //绑定数据
            $article->load($request->post());
            //后台验证
            if($article->validate()){
                if ($article->save()) {
                    //保存文章内容
                    $content->load($request->post());
                    //给文章id赋值
                    $content->article_id=$article->id;
                    //保存文章内容
                    if($content->save()){
                        \Yii::$app->session->setFlash("success","添加文章成功");
                        return $this->redirect(["index"]);
                    }
                }
            }
        }
        return $this->render("add",compact("article","cateArr","content"));
    }
    //删除文章信息
    public function actionDel($id){
        if(Article::findOne($id)->delete()){
            \Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }
}