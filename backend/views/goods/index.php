<a href="<?=\yii\helpers\Url::to(["goods/add"])?>" class="btn btn-info pull-left">添加</a>
<form class="form-inline pull-right">
    <div class="form-group">
        <input type="text" class="form-control" id="minPrice" placeholder="最低价格" size="5" name="minPrice">
    </div>---
    <div class="form-group">
        <input type="text" class="form-control" id="maxPrice" placeholder="最高价格" size="5" name="maxPrice">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="goods" placeholder="名称或货号" size="8" name="keyword">
    </div>
    <button type="submit" class="btn btn-default">搜索</button>
</form>
<table class="table">
    <tr>
        <th>商品名称</th>
        <th>商品分类</th>
        <th>商品品牌</th>
        <th>商品货号</th>
        <th>商品详情</th>
        <th>商品logo</th>
        <th>商品库存</th>
        <th>市场价格</th>
        <th>本店价格</th>
        <th>状态</th>
        <th>排序</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($goods as $good):?>
        <tr>
            <td><?=$good->goods_name?></td>
            <td><?=$good->cate->name?></td>
            <td><?=$good->brand->name?></td>
            <td><?=$good->goods_sn?></td>
            <td><?=$good->content->content?></td>
            <td><img src="<?=$good->logo?>" height="30"></td>
            <td><?=$good->stock?></td>
            <td><?=$good->market_price?></td>
            <td><?=$good->goods_price?></td>
            <td><?=\backend\models\Goods::$status[$good->status]?></td>
            <td><?=$good->sort?></td>
            <td><?=date("Ymd H:i:s",$good->create_time)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(["goods/edit","id"=>$good->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(["goods/del","id"=>$good->id])?>" class="btn btn-danger"> 删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $page
])?>


