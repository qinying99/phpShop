<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'goods_name');
echo $form->field($goods,'goods_category_id')->dropDownList($cateArr,['prompt'=>"请选择分类"]);
echo $form->field($goods,'goods_brand_id')->dropDownList($brandArr,['prompt'=>"请选择品牌"]);
echo $form->field($goods,'goods_sn');
echo $form->field($goods,'stock');
echo $form->field($goods, 'logo')->widget(\manks\FileInput::className(),[]);
echo $form->field($goods, 'images')->widget(\manks\FileInput::className(),[
    'clientOptions' => [
        'pick' => [
            'multiple' => true,
        ],
        // 'server' => Url::to('upload/u2'),
        // 'accept' => [
        // 	'extensions' => 'png',
        // ],
    ]
]);
echo $form->field($goods,'market_price');
echo $form->field($goods,'goods_price');
echo $form->field($goods,'status')->inline()->radioList(["0"=>"上架","1"=>"下架"],["value"=>0]);
echo $form->field($goods,'sort')->textInput(["value"=>100]);
echo $form->field($content,'content')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-info"]);

\yii\bootstrap\ActiveForm::end();