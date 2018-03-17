<a href="<?=\yii\helpers\Url::to(["brand/add"])?>" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>编号</th>
        <th>品牌名称</th>
        <th>品牌简介</th>
        <th>LOGO</th>
        <th>排序</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach ($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=$brand->intro?></td>
            <td><?php
                $imgPath = strpos($brand->logo,"ttp://")?$brand->logo:"/".$brand->logo;
                echo \yii\bootstrap\Html::img($imgPath,['height'=>30])
                ?></td>
            <td><?=$brand->sort?></td>
            <td><?=\backend\models\Brand::$status[$brand->status]?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(["brand/edit","id"=>$brand->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(["brand/del","id"=>$brand->id])?>" class="btn btn-danger"> 删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php

echo \yii\widgets\LinkPager::widget([
    'pagination' => $page,
]);
?>
