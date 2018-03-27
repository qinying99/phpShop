<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $phone 电话
 * @property int $login_time
 * @property int $login_ip
 */
class User extends \yii\db\ActiveRecord
{
    //添加创建时间
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    //设置属性
    public $password; // 密码
    public $rePassword; //确认密码
    public $phone; //电话
    public $captcha; //验证短信验证码
    public $checkCode; //验证码
    public $rememberMe; //是否记住我
    /**
     * @inheritdoc
     */
    //设置场景
//    public function scenarios()
//    {
//        $parent =  parent::scenarios();
//        $parent['reg'] = ['username','password',"rePassword",'phone','email','captcha','checkCode'];
//        $parent['login']= ["username","password",'rememberMe'];
//        return $parent;
//    }
    public function rules()
    {
        return [
            [['username','password','checkCode'], 'required'],
            [['rePassword','email','captcha','checkCode','phone'], 'required'],
            [['username'],'unique'],
            [['rePassword'],'compare','compareAttribute' => 'password'],
            [['phone'],'match','pattern'=>'/^[1][34578][0-9]{9}$/'],
            [['captcha'],'validateCaptcha'],
            [['email'],'email'],
            [['checkCode'],'captcha','captchaAction' => 'user/code'],
            [['phone'],'safe'],
            [['username'],'unique'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => '令牌',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'status' => '状态',
            'phone' => '电话',
            'login_time' => '登录时间',
            'login_ip' => '登录ip',
            'password' => '密码',
            'rePassword' => '确认密码',
            'captcha' => '短信验证码',
            'checkCode' => '验证码',
        ];
    }
    public function validateCaptcha($attribute,$params){
        $session  = \Yii::$app->session;
        $codeOld = $session->get("Tel_".$this->phone);
        //对比验证码
        if($this->captcha==$codeOld){

        }else{
            $this->addError($attribute,'验证码输入错误');
        }
    }
}
