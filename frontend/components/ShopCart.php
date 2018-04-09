<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/31 0031
 * Time: 上午 11:32
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
    //声明一个私有属性来存数据
    private $cart;
    //创建对象时自动调用执行
    public function __construct(array $config = [])
    {
        //得到cookie对象
        $getCookie = \Yii::$app->request->cookies;
        //得到购物车原来嘚数据
        $this->cart = $getCookie->getValue('cart',[]  );
        parent::__construct($config);
    }
    //添加购物车
    public function Add($id,$amount){
        //判断当前添加嘚商品id是否存在购物车中 如果在 便继续添加 不在就新增
        if(array_key_exists($id,$this->cart)){
            //存在  在原本嘚cookie上添加$amount
            $this->cart[$id]+=$amount;
        }else{
            //如果不存在 便新增cookie
            $this->cart[$id]=(int)$amount;
        }
        return $this;
    }
    //修改购物车
    public function Edit($id,$amount){
        //修改
        $this->cart[$id]=$amount;
        return $this;
    }
    //删除购物车
    public function Del($id){
        //删除数据
        unset($this->cart[$id]);
        return $this;
    }
    //清空本地购物车
    public function Flush(){
        $this->cart=[];
        return $this;
    }
    //将本地cookie保存到数据库
    public function Dnsyn(){
        //获取当前嘚用户id
        $user_id = \Yii::$app->user->id;
        //循环cookie 取出商品id和商品数量
        foreach ($this->cart as $goods_id=>$amount){
            //根据用户id和商品id到数据库查找是否有该条数据  如果没有新增  如果有累加
            $DbCart = Cart::find()->where(['goods_id'=>$goods_id,'user_id'=>$user_id])->one();
            if ($DbCart){
                //累加
                $DbCart->amount+=$amount;
            }else{
                //新增
                $DbCart = new Cart();
                $DbCart->user_id= $user_id;
                $DbCart->goods_id=$goods_id;
                $DbCart->amount = $amount;
            }
            $DbCart->save();
        }
        return $this;
    }
    //保存
    public function save(){
        //1.创建设置COokie对象
        $setCookie = \Yii::$app->response->cookies;
        //2.创建一个COokie对象
        $cookie = new Cookie([
            'name' => 'cart',
            'value' => $this->cart,
            'expire' => time()+3600*24*30*12
        ]);
        //2.通过设置COokie对象来添加一个COokie
        $setCookie->add($cookie);
    }
}