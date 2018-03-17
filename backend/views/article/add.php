<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($article,"name");
echo $form->field($article,"intro");
echo $form->field($article,"category_id")->dropDownList($cateArr);
echo $form->field($article,"sort")->textInput(["value"=>100]);
echo $form->field($article,"status")->inline()->radioList(\backend\models\Article::$status);
echo $form->field($content,'content')->widget('kucha\ueditor\UEditor',[]);

echo \yii\helpers\Html::submitButton("添加",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();