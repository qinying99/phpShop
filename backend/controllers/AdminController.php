<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21 0021
 * Time: 下午 2:08
 */

namespace backend\controllers;

use Yii;
use backend\models\Admin;
use common\models\LoginForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;



class AdminController extends Controller
{
    //实现权限管理
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'add', 'edit','del'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],//代表游客只能访问login页面
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'add', 'edit','del'],
                        'roles' => ['@'],//代表登录后才能访问add，edit，del页面
                    ],
                ],
            ],
        ];
    }
    //登录页面
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //通过输入的用户名去查找数据库是否有该条数据，如果有验证密码，如果没有返回登录失败
            $admin = Admin::find()->where(["name"=>$model->name,"status"=>1])->one();
            if($admin){
                //用户名输入正确判断密码是否正确
                if(Yii::$app->security->validatePassword($model->password,$admin->password)){
                    //登录成功，获取当前的ip和登录时间，并将当前登录时间和ip保存到数据库
                    $admin->ip=ip2long($_SERVER["REMOTE_ADDR"]);
                    $admin->last_time=time();
                    $admin->save();
                    //如果正确  通过组件登录
                    Yii::$app->user->login($admin,$model->rememberMe?3600*24:0);
                    Yii::$app->session->setFlash('success','登录成功');
                    return $this->redirect(["index"]);
                }else{
                    $model->addError('password','密码输入错误，请重新输入');
                }
            }else{
                //用户名错误提示错误信息
                $model->addError('name','用户名不存在，请重新输入！！！');
            }
        }
        return $this->render('login', compact('model'));
    }
    //退出登录
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    //管理员列表
    public function actionIndex(){
        $admins = Admin::find()->where(["status"=>1])->all();
        return $this->render("index",compact("admins"));
    }
    //添加管理员
    public function actionAdd(){
        $admin = new Admin();
        $request = new Request();
            if($admin->load($request->post()) && $admin->validate()){
                if($admin->save()){
                    \Yii::$app->session->setFlash("success","添加管理员成功");
                    //跳转到登录页面
                    return $this->redirect(["index"]);
                }
            }
        return $this->render("add",compact("admin"));
    }
    //修改
    public function actionEdit($id){
        $admin = Admin::findOne($id);
        $request = new Request();
        //设置场景
        $admin->setScenario('edit');
        //取出原本的密码
        $password = $admin->password;
        if($request->isPost){
            $admin->load($request->post());
            if($admin->validate()){
                //判断用户是否输入密码，如果没有输入便去原本的密码，如果输入了取输入的密码且加密
                $admin->password=$admin->password?Yii::$app->security->generateRandomString($admin->password):$password;
                if($admin->save()){
                    \Yii::$app->session->setFlash("success","修改管理员成功");
                    //跳转到登录页面
                    return $this->redirect(["index"]);
                }
            }
        }
        $admin->password = null;
        return $this->render("add",compact("admin"));
    }
    //删除
    public function actionDel($id){
        if(Admin::findOne($id)->delete()){
            Yii::$app->session->setFlash("danger","删除成功");
            return $this->redirect(["index"]);
        }
    }
}