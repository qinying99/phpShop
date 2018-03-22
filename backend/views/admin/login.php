<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '管理员登录';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>登录吧骚年</b</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">请输入您的登录信息</p>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name', $fieldOptions1)->label(false)->textInput(['placeholder' => '用户名']) ?>

        <?= $form->field($model, 'password', $fieldOptions2)->label(false)->passwordInput(['placeholder' => "用户密码"]) ?>

        <div class="row ">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <div class="col-xs-4 pull-right">
                <?= Html::submitButton('登录', ["class"=>"btn btn-info"]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
