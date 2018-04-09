<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/31 0031
 * Time: 下午 2:36
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Deliveryid;
use frontend\models\Order;
use frontend\models\OrderDetails;
use frontend\models\Pay;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;
use Endroid\QrCode\QrCode;

class OrderController extends Controller
{
    public $enableCsrfValidation=false;
    /**
     * 显示页面数据
     * @return string|\yii\web\Response
     */
    public function actionIndex(){
        //判断用户是否登录
        if(\Yii::$app->user->isGuest){
            //未登录 跳转到登录页面进行登录
            return $this->redirect(['user/login','url'=>'/order/index']);
        }else{
            //获取当前user_id
            $user_id = \Yii::$app->user->id;
            //获取收货人地址详情
            $addresss = Address::find()->where(['user_id'=>$user_id])->all();
            //获取购物车信息
            $carts = Cart::find()->where(['user_id'=>$user_id])->all();
            //获取当前用户购物车中总共有多少件商品
            $count = count($carts);
            $cart = ArrayHelper::map($carts,'goods_id','amount');
            //获取商品id
            $goodId = array_keys($cart);
            //取出商品表的所有数据
            $goods = Goods::find()->where(['in','id',$goodId])->all();
            //支付方式
            $pays = Pay::find()->all();
            //配送方式
            $deliveryids = Deliveryid::find()->all();
            return $this->render('index',compact('addresss','cart','goods','count','pays','deliveryids'));
        }

    }
    /**
     * 添加订单
     */
    public function actionAdd(){
        //判断post
        $request=\Yii::$app->request;
        if($request->isPost){
            //开启事务
            $db = \Yii::$app->db;
            $transaction  = $db->beginTransaction();
            try{
                //创建表单对象
                $order = new Order();
                //获取当前user_id
                $user_id = \Yii::$app->user->id;
                //获取购物车信息
                $carts = Cart::find()->where(['user_id'=>$user_id])->all();
                //获取当前用户购物车中总共有多少件商品
                $cart = ArrayHelper::map($carts,'goods_id','amount');
                //获取商品id
                $goodId = array_keys($cart);
                //取出商品表的所有数据
                $goods = Goods::find()->where(['in','id',$goodId])->all();
                //商品总价
                $price = 0;
                foreach ($goods as $good){
                    $price += $good->goods_price*$cart[$good->id];
                }

                //根据ajax传来的数据取出数据
                //取出收货人姓名
                $addressId = $request->post('address_id');
                //通过地址id取出地址数据表嘚数据
                $address = Address::findOne($addressId);

                //取出付款方式
                $pay = Pay::findOne($request->post('pay'));

                //取出配送方式
                $deliveryid = Deliveryid::findOne($request->post('delivery'));

                //取出user_id
                $user_id = \Yii::$app->user->id;
                //给order绑定数据
                $order->order_id =date("ymdHis").rand(1000,9999);  //订单号
                $order->user_id = $user_id;  //用户id
                $order->name=$address->name;    //收货人
                $order->province=$address->province; //省份
                $order->city=$address->city; //市
                $order->county=$address->county;  //区
                $order->add=$address->address; //详细地址
                $order->phone=$address->phone; //收货人电话

                $order->delivery_id=$deliveryid->id; //配送方式id
                $order->delivery_name=$deliveryid->name; //配送方式名
                $order->delivery_price=$deliveryid->freight; //运费

                $order->pay_id = $pay->id; //支付id
                $order->pay_name = $pay->name; //支付名称

                $order->create_time = time();  //创建订单时间

                //获取商品总价
                $order->price =$price;

                //保存数据
                if($order->save()){

                    //循环商品  入商品详情表
                    foreach ($goods as $good){
                        //找到当前商品
                        $curGood = Goods::findOne($good->id);
                        //判断库存是否足够
                        if($cart[$good->id]>$curGood->stock){
                            //抛出异常
                            throw new Exception("库存不足");
                        }
                        //绑定数据到商品详情表 order_tetails
                        $order_tetails = new OrderDetails();
                        $order_tetails->order_id = $order->id;  //订单id
                        $order_tetails->goods_id =$good->id;  //商品id
                        $order_tetails->goods_name =$good->goods_name;  //商品名称
                        $order_tetails->price =$good->goods_price;  //商品价格
                        $order_tetails->amount =$cart[$good->id];  //商品数量
                        if($order_tetails->save()){
                            //把当前商品库存减掉
                            $curGood->stock = $curGood->stock-$cart[$good->id];
                            $curGood->save(false);
                        }
                    }
                }
                        //根据登录用户的id清空购物车
                        Cart::deleteAll(["user_id"=>$user_id]);
                        $transaction->commit();//提交事务
                        return Json::encode([
                            'status'=>1,
                            'id'=>$order->id,
                            'msg'=>'提交订单成功'
                        ]);
            }catch (Exception $e){
                //事务回滚
                $transaction->rollBack();
                return Json::encode([
                    'status'=>0,
                    'msg'=>$e->getMessage()
                ]);
            }
        }
    }
    public function actionList($id){
        //查出当前id的订单
        $order = Order::findOne($id);
        return $this->render('list',compact('order'));
    }
    /*
     * 微信支付
     *
     */
    public function actionWx($id){

        $order = Order::findOne($id);
        //调用配置
        $options = \Yii::$app->params['wx'];

        //创建微信操作对象
        $app = new Application($options);
        //通过app得到支付对象
        $payment = $app->payment;
        //订单信息
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI 公众号支付，NATIVE 扫码支付，APP APP支付     交易类型
            'body'             =>"源码商城" ,   //标题
            'detail'           => 'iPad mini 16G 白色',   //内容
            'out_trade_no'     =>$order->order_id,  //订单标号
            'total_fee'        => $order->price*100, // 单位：分
            'notify_url'       => Url::to(['order/notify'], true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
           // 'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        //订单详情
        $order = new \EasyWeChat\Payment\Order($attributes);
        //统一下单
        $result = $payment->prepare($order);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){

            $qrCode = new QrCode($result->code_url);

            header('Content-Type: '.$qrCode->getContentType());
            echo $qrCode->writeString();
        }

    }
    /*
     * 成功提交订单页面
     *
     */

    /*
     * 微信异步通信地址
     */
    public function actionNotify(){
        //配置
        $options = \Yii::$app->params['wx'];
        //创建微信操作对象
        $app = new Application($options);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = Order::findOne(['order_id'=>$notify->out_trade_no]);

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!=1) {
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态

                $order->status = 2;   //将订单的当前状态改成2   1=》未付款  2 =》等待发货  3 =》等待收货   4  =》已完成
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;
    }
    /**
     * 获取当前订单id的状态  当状态为2时订单支付成功
     * $id  当前订单id
     */
    public function actionStatus($id){
        $order = Order::findOne($id);
        return Json::encode($order);
    }
    /**
     * 定时清理超时未支付订单
     */
    public function actionClean(){
        //找出超时半小时状态为1的未支付订单
        $orders = Order::find()->where(['status'=>1])->andWhere(['<=','create_time',time()-1])->asArray()->all();
        //取出超时订单的id
        $ordersId = array_column($orders,'id');
        //将所有超时订单的状态改为0   0=》已取消
        Order::updateAll(['status'=>0],["in","id",$ordersId]);
        //循环订单  并把所有对应的超时订单的商品数量还原到库存
        foreach ($orders as $order){
            //拿到每个订单对应的商品详情
            $orderDetails =OrderDetails::find()->where(['order_id'=>$order['id']])->all();
            //循环商品详情
            foreach ($orderDetails as $orderDetail){
                //还原库存
                Goods::updateAllCounters(['stock'=>$orderDetail->amount],['id'=>$orderDetail->goods_id]);
            }
        }
    }
}