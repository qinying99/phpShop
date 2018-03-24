<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($authItem,'name')->textInput(['disabled'=>'']);
echo $form->field($authItem,'description')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
