<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29 0029
 * Time: 下午 2:29
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\components\ShopCart;
use frontend\models\Cart;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Request;

class GoodsController extends Controller
{
    /**
     * 商品列表
     * @param $id 分类id
     * @return string
     */
    public  function actionIndex($id){
        //根据id找到当前分类对象
        $cate = GoodsCategory::findOne($id);
        //根据tree、left、right找到$cate 下嘚所有子孙分类
        $cateSon = GoodsCategory::find()->where(['tree'=>$cate->tree])->andWhere(['>=','left',$cate->left])->andWhere(['<=','right',$cate->right])->all();
        $cateSonID = array_column($cateSon,'id');
        //根据id找到所属分类下嘚所有商品
        $goods = Goods::find()->where(['in','goods_category_id',$cateSonID])->all();
        return $this->render('index',compact('goods'));
    }

    /**
     * 显示商品详情
     * @param $id 商品id
     * @return string
     */
    public function actionList($id){
        //根据id找到商品
        $good = Goods::findOne($id);
        return  $this->render('list',compact('good'));
    }

    /**
     * 加入购物车
     * @param $id  商品id
     * @param $amount 商品数量
     */
    public function actionAddCart($id,$amount){
        if(\Yii::$app->user->isGuest){
            //未登录 保存到cookie
//            //得到cookie对象
//            $getCookie = \Yii::$app->request->cookies;
//            //得到购物车原来嘚数据
//            $cart = $getCookie->getValue('cart',[]  );
//
//            //判断当前添加嘚商品id是否存在购物车中 如果在 便继续添加 不在就新增
//           if(array_key_exists($id,$cart)){
//                //存在  在原本嘚cookie上添加$amount
//               $cart[$id]+=$amount;
//           }else{
//               //如果不存在 便新增cookie
//               $cart[$id]=(int)$amount;
//           }
//            //创建设置cookie对象
//            $setCookie = \Yii::$app->response->cookies;  //response 设置  request  得到
//            //创建一个cookie对象
//            $cookie = new Cookie([
//                    'name'=>'cart',
//                    'value' => $cart
//                ]
//            );
//            //通过设置cookie对象来添加cookie
//            $setCookie->add($cookie);
            //通过封装shopcart
            (new ShopCart())->Add($id,$amount)->save();
            return $this->redirect(['cart/index']);
        }else{
            //已登录保存到数据库
            //获取当前登录用户嘚id
            $user_id = \Yii::$app->user->id;
            //根据当前嘚用户id和商品id到数据库查找是否存在该数据 如果不存在  便在新增数据 存在原本嘚基础上新增商品数量
            $cart = Cart::find()->where(['user_id'=>$user_id,'goods_id'=>$id])->one();
            if($cart){
                //存在 在商品数量上新增
                $cart->amount+=$amount;
                $cart->save();
            }else{
                //不存在  将数据保存到数据库
                $cart=new Cart();
                $cart->amount=$amount;
                $cart->goods_id= $id;
                $cart->user_id=$user_id;
                $cart->save();
            }
            return $this->redirect(['cart/index']);
        }
    }


}