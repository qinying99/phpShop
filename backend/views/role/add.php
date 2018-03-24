<h1>角色添加</h1><br/>
<a href="<?=\yii\helpers\Url::to(["role/index"])?>" class="btn btn-success">返回</a>
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($authItem,'name');
echo $form->field($authItem,'description')->textarea();
echo $form->field($authItem,'permissions')->inline()->checkboxList($persArr);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

