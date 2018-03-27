<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27 0027
 * Time: 下午 5:33
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;
    public $Code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password','Code'], 'required'],
            [['rememberMe'],'safe'],
            [['Code'],'captcha','captchaAction' => 'user/code']
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'用户密码',
            'rememberMe'=>'记住密码'
        ];
    }
}