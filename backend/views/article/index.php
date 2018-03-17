<a href="<?=\yii\helpers\Url::to(["article/add"])?>" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>编号</th>
        <th>文章名称</th>
        <th>分类</th>
        <th>排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>文章简介</th>
        <th>文章内容</th>
        <th>操作</th>
    </tr>
    <?php foreach ($articles as $article):?>
        <tr>
            <td><?=$article->id?></td>
            <td><?=$article->name?></td>
            <td><?=$article->cate->name?></td>
            <td><?=$article->sort?></td>
            <td><?=\backend\models\Article::$status[$article->status]?></td>
            <td><?=date("Ymd H:i:s",$article->create_time)?></td>
            <td><?=$article->intro?></td>
            <td><?=$article->content->content?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(["article/edit","id"=>$article->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(["article/del","id"=>$article->id])?>" class="btn btn-danger"> 删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $page
])?>

