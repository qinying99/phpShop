<a href="<?=\yii\helpers\Url::to(["article-category/add"])?>" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>编号</th>
        <th>分类名称</th>
        <th>文章id</th>
        <th>操作</th>
    </tr>
    <?php foreach ($cates as $cate):?>
        <tr>
            <td><?=$cate->id?></td>
            <td><?=$cate->name?></td>
            <td><?=$cate->article_id?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(["article-category/edit","id"=>$cate->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(["article-category/del","id"=>$cate->id])?>" class="btn btn-danger"> 删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination' => $page,
]);
?>
