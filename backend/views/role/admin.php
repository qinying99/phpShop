<h1>角色添加</h1><br/>
<a href="<?=\yii\helpers\Url::to(["role/index"])?>" class="btn btn-success">返回</a>
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($ass,'item_name')->dropDownList($roleArr);
echo $form->field($ass,'user_id')->dropDownList($adminArr);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

