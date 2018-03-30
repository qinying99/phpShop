<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
class User extends \yii\db\ActiveRecord implements IdentityInterface
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

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key=$authKey;
    }
}
