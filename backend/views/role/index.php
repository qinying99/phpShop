<h1>角色列表</h1><br/>
<a href="<?=\yii\helpers\Url::to(["role/admin"])?>" class="btn btn-success">给用户指派角色</a>
<table class="table">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($roles as $role):?>
        <tr>
            <td><?=strpos($role->name,'/')!==false?'&ensp;&ensp;&ensp;&ensp;':""?><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td><?php
               //得到当前对象嘚所有权限
                $auth = Yii::$app->authManager;
                $pers = $auth->getPermissionsByRole($role->name);
                $html='';
                foreach ($pers as $per){
                    $html.=$per->name.'，';
                }
                    //去掉最后面的,号
                $html = trim($html,'，');
                echo $html;
                ?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(["role/edit","name"=>$role->name])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(["role/del","name"=>$role->name])?>" class="btn btn-danger"> 删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

