<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21 0021
 * Time: 下午 2:07
 */

namespace backend\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Admin extends ActiveRecord implements IdentityInterface
{
    //设置属性
    public static $sex=["0"=>"保密","1"=>"女","2"=>"男"];
    public static $status=["0"=>"禁用","1"=>"激活"];

    //添加创建时间
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time']
                ],
            ],
        ];
    }
    //创建场景
    public function scenarios()
    {
        $parent =  parent::scenarios();
        $parent['add'] = ['name','password',"sex","add","age","status"];
        $parent['edit']= ["name","password","sex","add","age","status"];
        return $parent;
    }
    //设置规则
    public function rules()
    {
        return [
            [["sex","add","name","age","status"],"required"],
            [["password"],"required","on" => "add"], //在add场景必须添加密码
            [["password"],"safe","on" => "edit"],//在edit场景中可以不修改密码
            [["name"],"unique"],
            [["age"],"integer"],
            [['create_time','ip','auth_key'],'safe']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'用户名',
            'password'=>'用户密码',
            'age'=>'年龄',
            'sex'=>'性别',
            'add'=>'地址',
            'status'=>'状态'
        ];
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
        //验证令牌
        return $this->auth_key===$authKey;
    }
}