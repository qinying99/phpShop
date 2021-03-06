<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,"name");
echo $form->field($brand,"intro");

echo '<label class="control-label">LOGO</label>';
echo \manks\FileInput::widget([
    'model' => $brand,
    'attribute' => 'logo',
]);

echo $form->field($brand,"sort")->textInput(["value"=>100]);
echo $form->field($brand,"status")->inline()->radioList(\backend\models\Brand::$status,["value"=>0]);
echo \yii\helpers\Html::submitButton("添加",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();