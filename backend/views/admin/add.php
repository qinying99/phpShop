<font size="6" color="red">添加管理员</font>
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,"name");
echo $form->field($admin,"password");
echo $form->field($admin,"age");
echo $form->field($admin,"sex")->inline()->radioList(["0"=>"保密","1"=>"女","2"=>"男"]);
echo $form->field($admin,"add");
echo \yii\helpers\Html::submitButton("添加",["class"=>"btn btn-info"]);
\yii\bootstrap\ActiveForm::end();