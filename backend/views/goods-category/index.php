<a href="<?=\yii\helpers\Url::to(["goods-category/add"])?>" class="btn btn-info">添加</a>
<?php
use leandrogehlen\treegrid\TreeGrid;
echo TreeGrid::widget([
    'dataProvider' => $dataProvider,
    'keyColumnName' => 'id',
    'parentColumnName' => 'parent_id',
    'parentRootValue' => '0', //first parentId value
    'pluginOptions' => [
        'initialState' => 'collapsed',
    ],
    'columns' => [
        'name',
        'id',
        'parent_id',
        'intro',
        ['class' => 'yii\grid\ActionColumn']
    ]
]);
