<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsContent;
use backend\models\GoodsPrint;
use crazyfd\qiniu\Qiniu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class GoodsController extends \yii\web\Controller
{

    //富文本框
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://admin.yiishop.com",//图片访问路径前缀
            ],
            ]
        ];
    }
    //显示所有的商品信息
    public function actionIndex()
    {
        $query = Goods::find();
        $minPrice = \Yii::$app->request->get('minPrice');
        $maxPrice = \Yii::$app->request->get('maxPrice');
        $keyword = \Yii::$app->request->get('keyword');
        //根据搜索来查看数据
        if($minPrice){
            $query->andWhere("goods_price>={$minPrice}");
        }
        if($maxPrice){
            $query->andWhere("goods_price<={$maxPrice}");
        }
        if($keyword){
            $query->andWhere("goods_name like '%{$keyword}%' or goods_sn like '%{$keyword}%'");
        }


        $count = $query->count();
        $page =new Pagination([
            'totalCount' => $count,
            "pageSize" => 3
        ]);
        // 使用分页对象来填充 limit 子句并取得文章数据
        $goods = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render("index",compact("goods","page"));
    }
    //添加商品信息
    public function actionAdd(){
        //创建一个模型对象
        $goods = new Goods();
        //创建一个内容对象
        $content = new GoodsContent();

        //获取品牌信息
        $brand = Brand::find()->asArray()->all();
        $brandArr = ArrayHelper::map($brand,"id","name");

        //获取分类信息
        $cates = GoodsCategory::find()->orderBy("tree,left")->all();
       foreach ($cates as $cate){
            $cateArr = str_repeat("**",$cate->depth*4);
                $cate->name=$cateArr.$cate->name;
       }
        $cateArr =ArrayHelper::map($cates,"id","name");
        $request = new Request();
        //判断提交方式
        if($request->isPost){
            //绑定goods的数据
            $goods->load($request->post());
            //保存文章内容
            $content->load($request->post());
            //后台验证
            if($goods->validate()){
                //判断sn顾客是否输入，如果没有输入则自动生成
                if(!$goods->goods_sn){
                    //自动生成  sn=当前年月日  +  商品数量
                    //获取当天的时间戳
                    $time = strtotime(date('Ymd'));
                    //找出当天创建的商品数量
                   $count =  Goods::find()->where(['>','create_time',$time])->count();
                   $count=$count+1;
                   $countStr = "0000".$count;
                   //取后5位
                    $countStr = substr($countStr,-5);
                    $goods->goods_sn=date("Ymd").$countStr;
                }
                //保存
                if($goods->save()){
                    //给文章id赋值
                    $content->goods_id=$goods->id;
                    //保存多图上传的图片路径到图片表中
                    foreach ($goods->images as $image){
                        $print = new GoodsPrint();
                        $print->goods_id = $goods->id;
                        $print->path = $image;
                        $print->save();
                    }
                    if($content->save()){
                        //显示添加数据成功信息
                        \Yii::$app->session->setFlash("success","添加商品成功");
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        return $this->render("add",compact("goods","brandArr","cateArr","content"));
    }
    //修改商品信息
   public function actionEdit($id){
        //创建一个模型对象
        $goods = Goods::findOne($id);
        //创建一个内容对象
        $content = GoodsContent::findOne(['goods_id'=>$id]);

        //获取品牌信息
        $brand = Brand::find()->asArray()->all();
        $brandArr = ArrayHelper::map($brand,"id","name");

        //获取分类信息
        $cates = GoodsCategory::find()->orderBy("tree,left")->all();
        foreach ($cates as $cate){
            $cateArr = str_repeat("**",$cate->depth*4);
            $cate->name=$cateArr.$cate->name;
        }
        $cateArr =ArrayHelper::map($cates,"id","name");
        $request = new Request();
        //判断提交方式
        if($request->isPost){
            //绑定goods的数据
            $goods->load($request->post());
            //保存文章内容
            $content->load($request->post());
            //后台验证
            if($goods->validate()){
                //判断sn顾客是否输入，如果没有输入则自动生成
                if(!$goods->goods_sn){
                    //自动生成  sn=当前年月日  +  商品数量
                    //获取当天的时间戳
                    $time = strtotime(date('Ymd'));
                    //找出当天创建的商品数量
                    $count =  Goods::find()->where(['>','create_time',$time])->count();
                    $count=$count+1;
                    $countStr = "0000".$count;
                    //取后5位
                    $countStr = substr($countStr,-5);
                    $goods->goods_sn=date("Ymd").$countStr;
                }
                //保存
                if($goods->save()){
                    //给文章id赋值
                    $content->goods_id=$goods->id;
                    //在编辑图片前删除图片
                    GoodsPrint::deleteAll(['goods_id'=>$id]);
                    //保存多图上传的图片路径到图片表中
                    foreach ($goods->images as $image){
                        $print = new GoodsPrint();
                        $print->goods_id = $goods->id;
                        $print->path = $image;
                        $print->save();
                    }
                    if($content->save()){
                        //显示添加数据成功信息
                        \Yii::$app->session->setFlash("success","添加商品成功");
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        //找到所有的商品图片
        $images = GoodsPrint::find()->where(['goods_id'=>$id])->asArray()->all();
        //转成一维数组
       $images = array_column($images,'path');
       $goods->images=$images;
        return $this->render("add",compact("goods","brandArr","cateArr","content"));
    }
    //删除商品
    public function actionDel($id){
       //删除商品表中的数据
       if(Goods::findOne($id)->delete() && GoodsPrint::deleteAll(['goods_id'=>$id]) && GoodsContent::findOne(['goods_id'=>$id])->delete()){
           \Yii::$app->session->setFlash("danger","删除成功");
           return $this->redirect(['index']);
       }
        \Yii::$app->session->setFlash("danger","删除成功");
       return $this->redirect(["index"]);
    }
}
