
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,"name");
echo $form->field($admin,"password")->passwordInput();
echo $form->field($admin,"age");
echo $form->field($admin,"sex")->inline()->radioList(["0"=>"保密","1"=>"女","2"=>"男"]);
echo $form->field($admin,"add");
echo $form->field($admin,"status")->inline()->radioList(\backend\models\Admin::$status);
echo \yii\helpers\Html::submitButton("添加",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();