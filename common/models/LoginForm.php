<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $name;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'password'], 'required']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'用户名',
            'password'=>'用户密码'
        ];
    }

}
