<h1>角色修改</h1><br/>
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($authItem,'name')->textInput(['disabled'=>'']);
echo $form->field($authItem,'description')->textarea();
echo $form->field($authItem,'permissions')->inline()->checkboxList($persArr);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
