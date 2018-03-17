<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($cate,"name");
echo $form->field($cate,"article_id");
echo \yii\helpers\Html::submitButton("添加",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();