<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($cates,'name');
echo $form->field($cates,'parent_id')->textInput(['value'=>0]);
echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
           
           callback: {
				onClick: onClick
			},
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id"
				}
			}
		}',
    'nodes' => $cate
]);
echo $form->field($cates,'intro')->widget('kucha\ueditor\UEditor',[]);
echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();?>
<script>
    function onClick(e,treeId, treeNode) {
        console.debug(treeNode.id);
        //找到父id框
        $("#goodscategory-parent_id").val(treeNode.id);
    }
</script>


