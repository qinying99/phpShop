<font size="6" color="red">管理员列表</font>
<table class="table">
    <tr>
        <th>用户名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>地址</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>最后登录ip</th>
        <th>最后登录时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($admins as $admin):?>
        <tr>
            <td><?=$admin->name?></td>
            <td><?=$admin->age?></td>
            <td><?=\backend\models\Admin::$sex[$admin->sex]?></td>
            <td><?=$admin->add?></td>
            <td><?=\backend\models\Admin::$status[$admin->status]?></td>
            <td><?=date("Ymd H:i:s",$admin->create_time)?></td>
            <td><?=$admin->ip?></td>
            <td><?=date("Ymd H:i:s",$admin->last_time)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(["admin/edit","id"=>$admin->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(["admin/del","id"=>$admin->id])?>" class="btn btn-danger"> 删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

