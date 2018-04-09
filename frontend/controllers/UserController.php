<?php

namespace frontend\controllers;

use common\models\LoginForm;
use frontend\components\ShopCart;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    //验证码注入
    public function actions()
    {
        return [
            'code' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 3,
                'maxLength' => 3
            ],
        ];
    }
    /**
     * 用户登录
     */
    public function actionLogin()
    {
        $request = new Request();
        if($request->isPost){
           $model = new \frontend\models\LoginForm();
            $model->load($request->post());
//            var_dump($model);exit;
            if ($model->validate()){
                //通过输入嘚用户名在数据库里查询出是否有该条数据  如果没有报错  如果有再进行验证密码
                $user = User::find()->where(["username"=>$model->username])->one();
                if($user){
                    //判断密码
                    if(\Yii::$app->security->validatePassword($model->password,$user->password_hash)){
                        $user->login_ip=ip2long($_SERVER["REMOTE_ADDR"]);
                        $user->login_time=time();
                        if($user->save(false)){
                            //如果正确  通过组件登录
                            \Yii::$app->user->login($user,$model->rememberMe?3600*24:0);
                            //查看cookie中是否有数据 如果有将其保存到数据库并清除cookie
                            (new ShopCart())->Dnsyn()->Flush()->save();
                            //如果成功
                            $result = [
                                'status'=>1,
                                'msg'=>'登录成功',
                                'data'=>''
                            ];
                            return json_encode($result);
                        }
                    }else{
                        $result = [
                            'status'=>-1,
                            'msg'=>'密码错误',
                            'data'=>$model->errors,
                        ];
                        return json_encode($result);
                    }
                }else{
                    $result = [
                        'status'=>-2,
                        'msg'=>'用户名不存在',
                        'data'=>$model->errors,
                    ];
                    return json_encode($result);
                }
            }else{
                $result = [
                    'status'=>-3,
                    'msg'=>'验证错误',
                    'data'=>$model->errors,
                ];
                return Json::encode($result);
            }
        }
        return $this->render('login');
    }
    /**
     * 退出登录
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['index/index']);
    }
    /**
     * 用户注册
     */
    public function actionReg(){
       if(\Yii::$app->request->isPost){
           $user = new User();
           $user->load(\Yii::$app->request->post());
           if ($user->validate()){
               $user->password_hash = \Yii::$app->security->generatePasswordHash($user->password);
               $user->auth_key = \Yii::$app->security->generateRandomString();
                if($user->save(false)){
                    //如果成功
                    $result = [
                        'status'=>1,
                        'msg'=>'注册成功',
                        'data'=>''
                    ];
                    return json_encode($result);
                }
           }else{
               $result = [
                   'status'=>0,
                   'msg'=>'注册失败',
                   'data'=>$user->errors
               ];
               return json_encode($result);

           }
       }
        //视图
        return $this->render('reg');
    }
    //发送手机验证码
    public function actionGetcode($phone){
        //生成验证码
        $code = rand(1000,9999);
        //发送验证码
        $config = [
            'access_key' => 'LTAIazzG1tHepYxm',
            'access_secret' => 'T3ZSGO1CYOVc0o0c0Wdf387FTrtyt4',
            'sign_name' => '怂bibi',
        ];

        $aliSms = new AliSms();
        $response = $aliSms->sendSms($phone, 'SMS_128646095', ['code'=> $code], $config);
        if($response->Message=="OK"){
            //将验证码保存到session
            $session  = \Yii::$app->session;
            $session->set("Tel_".$phone,$code);
        }
    }
    //验证验证码
    public function actionCheckCode($phone,$code){
        //获取用户输入嘚手机号和验证码  然后对比在session里保存嘚$code
        $session  = \Yii::$app->session;
        $codeOld = $session->get("Tel_".$phone);
        //对比验证码
        if($code==$codeOld){
            echo 'ok';
        }else{
            echo 'funk';
        }
    }
    /**
     *首页
     */
    public function actionIndex(){
        return $this->render('index');
    }
}
