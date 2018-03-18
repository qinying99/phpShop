<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($cates,'name');

echo $form->field($cates,'intro')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();



