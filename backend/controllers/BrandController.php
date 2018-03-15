<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15 0015
 * Time: 下午 4:40
 */

namespace backend\controllers;


use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class BrandController extends Controller
{
    //品牌管理列表
    public function actionIndex(){
        $query = Brand::find();
        //获取所有记录的条数
        $count = $query->count();
        //使用总数来创建一个分页对象
        $page = new Pagination(["totalCount" => $count, "pageSize" => 1]);
        $brands = $query->offset($page->offset)
            ->limit($page->limit)
            ->all();
        return $this->render("index",compact("brands","page"));
    }
    //添加品牌管理
    public function actionAdd(){
        $brand = new Brand();
        //判断提交方式
        if (\Yii::$app->request->isPost){
            //绑定数据
            $brand->load(\Yii::$app->request->post());
            //得到上传文件的对象
            $brand->imgFile=UploadedFile::getInstance($brand,"imgFile");
            //设置一个空对象用来存文件上传的路径
            $imgPath = "";
            //判断文件是否上传成功
            if($brand->imgFile!==null){
                //定义上传文件的路径
                $imgPath = "images/".time().".".$brand->imgFile->extension;
                //移动临时文件$imgPath
                $brand->imgFile->saveAs($imgPath,false);
                //后台验证
                if($brand->validate()){
                    //图片上传成功便将$imgPath赋值给logo
                    $brand->logo=$imgPath;
                    //保存数据
                    if($brand->save()){
                        //显示添加品牌成功信息
                        \Yii::$app->session->setFlash("success","添加品牌成功");
                        //跳转到index
                        return $this->redirect(["index"]);
                    }
                }
            }
        }
        return $this->render("add",compact("brand"));
    }
    //修改品牌管理
    public function actionEdit($id){
        $brand = Brand::findOne($id);
        //判断提交方式
        if (\Yii::$app->request->isPost){
            //绑定数据
            $brand->load(\Yii::$app->request->post());
            //得到上传文件的对象
            $brand->imgFile=UploadedFile::getInstance($brand,"imgFile");
            //设置一个空对象用来存文件上传的路径
            $imgPath = "";
            //判断文件是否上传成功
            if($brand->imgFile!==null){
                //定义上传文件的路径
                $imgPath = "images/".time().".".$brand->imgFile->extension;
                //移动临时文件$imgPath
                $brand->imgFile->saveAs($imgPath,false);
                //后台验证
                if($brand->validate()){
                    //图片上传成功便将$imgPath赋值给logo
                    $brand->logo=$imgPath;
                    //保存数据
                    if($brand->save()){
                        //显示添加品牌成功信息
                        \Yii::$app->session->setFlash("success","添加品牌成功");
                        //跳转到index
                        return $this->redirect(["index"]);
                    }
                }
            }
        }
        return $this->render("add",compact("brand"));
    }
    //删除品牌管理
    public function actionDel($id){
        if(Brand::findOne($id)->delete()){
            \Yii::$app->session->setFlash("danger","删除品牌成功");
            return $this->redirect(["index"]);
        }
    }
}