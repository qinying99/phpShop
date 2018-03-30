<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/30 0030
 * Time: 下午 5:22
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Cart;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;

class CartController extends Controller
{
    /**
     * 购物车列表
     * @return string
     */
    public function actionIndex(){
        //判断是否登录
        if(\Yii::$app->user->isGuest){
            //从cookie中取数据
            $cart = \Yii::$app->request->cookies->getValue('cart',[]);
            //取出$cart中嘚所有key值==商品id
            $goodId = array_keys($cart);
            //取出购物车嘚所有数据
            $goods = Goods::find()->where(['in','id',$goodId])->all();

        }else{
            //已登录  从数据库取数据
            $user_id =\Yii::$app->user->id;
            $cart = Cart::find()->where(['user_id'=>$user_id])->all();
            $cart = ArrayHelper::map($cart,'goods_id','amount');
            //获取商品id
            $goodId = array_keys($cart);
            //取出数据库嘚所有数据
            $goods = Goods::find()->where(['in','id',$goodId])->all();
        }
        return $this->render('index',compact('goods','cart'));
    }

    /**
     * 修改购物车
     * @param $id  商品id
     * @param $amount  商品数量
     */
    public function actionEditCart($id,$amount){

        //判断用户是否登录
        if(\Yii::$app->user->isGuest){
            //未登录
            //获取cookie嘚数据
            $cart = \Yii::$app->request->cookies->getValue('cart',[]);
            //修改对应的数据
            $cart[$id]=$amount;
            //再将数据保存到购物车
            //创建设置cookie对象
            $setCookie = \Yii::$app->response->cookies;
            //创建一个cookie对象
            $cookie = new Cookie([
                'name' => 'cart',
                'value' => $cart
            ]);
            //通过设置cookie对象来添加一个cookie对象
            $setCookie->add($cookie);
        }else{
            //已登录
            $user_id =\Yii::$app->user->id;
            $cart = Cart::find()->where(['user_id'=>$user_id,'goods_id'=>$id])->one();
            $cart->amount = $amount;
            $cart->save();
        }
    }
    /**删除购物车
     * @param $id
     */
    public function actionDelCart($id){
        //判断是否登录
        if(\Yii::$app->user->isGuest){
            //未登录删除cookie
            //获取cookie数据
            $cart = \Yii::$app->request->cookies->getValue('cart',[]);
            //删除数据
            unset($cart[$id]);
            //再将数据保存到购物车
            //创建设置cookie对象
            $setCookie = \Yii::$app->response->cookies;
            //创建一个cookie对象
            $cookie = new Cookie([
                'name' => 'cart',
                'value' => $cart
            ]);
            //通过设置cookie对象来添加一个cookie对象
            $setCookie->add($cookie);
        }else{
            //已登录删除数据嘚数据
            $user_id =\Yii::$app->user->id;
            Cart::find()->where(['user_id'=>$user_id,'goods_id'=>$id])->one()->delete();
        }
    }
}