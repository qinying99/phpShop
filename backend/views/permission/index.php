
<table class="table">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($pers as $per):?>
        <tr>
            <td><?=strpos($per->name,'/')!==false?'&ensp;&ensp;&ensp;&ensp;':""?><?=$per->name?></td>
            <td><?=$per->description?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(["permission/edit","name"=>$per->name])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(["permission/del","name"=>$per->name])?>" class="btn btn-danger"> 删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

