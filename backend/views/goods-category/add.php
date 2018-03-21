<a href="<?=\yii\helpers\Url::to(["goods-category/index"])?>" class="btn btn-info">返回</a>
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
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

//设置默认展开ztree
$js = <<<js
//得到ztree对象
    var treeObj = $.fn.zTree.getZTreeObj("w1");
    //得到当前的节点
    var node = treeObj.getNodeByParam("id","$cates->parent_id",null)
    //选中当前节点
    treeObj.selectNode(node);
    //设置parent_id的值
    $("#goodscategory-parent_id").val($cates->parent_id);    
//展开
    treeObj.expandAll(true);
js;
//注册js
$this->registerJs($js);
?>
<script>
    function onClick(e,treeId, treeNode) {
        console.debug(treeNode.id);
        //找到父id框
        $("#goodscategory-parent_id").val(treeNode.id);
    }
</script>



