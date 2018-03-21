<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->name;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [

                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => '欢迎来到'.Yii::$app->user->identity->name.'bibi的管理系统', 'options' => ['class' => 'header']],
                    [
                        'label' => '管理员管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '管理员列表', 'icon' => 'list-ul', 'url' => ['/admin/index'],],
                            ['label' => '添加管理员', 'icon' => 'plus-square', 'url' => ['/admin/add'],],
                        ],
                    ],
                    [
                        'label' => '商品管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '商品列表', 'icon' => 'list-ul', 'url' => ['/goods/index'],],
                            ['label' => '添加商品', 'icon' => 'plus-square', 'url' => ['/goods/add'],],
                        ],
                    ],
                    [
                        'label' => '分类管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '分类列表', 'icon' => 'list-ul', 'url' => ['/goods-category/index'],],
                            ['label' => '添加分类', 'icon' => 'plus-square', 'url' => ['/goods-category/add'],]
                        ]
                    ],
                    [
                        'label' => '品牌管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '品牌列表', 'icon' => 'list-ul', 'url' => ['/brand/index'],],
                            ['label' => '添加品牌', 'icon' => 'plus-square', 'url' => ['/brand/add'],],
                        ],
                    ],
                    [
                        'label' => '文章管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章列表', 'icon' => 'list-ul', 'url' => ['/article/index'],],
                            ['label' => '添加文章', 'icon' => 'plus-square', 'url' => ['/article/add'],],
                        ],
                    ],
                    [
                        'label' => '文章分类管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章分类列表', 'icon' => 'list-ul', 'url' => ['/article-category/index'],],
                            ['label' => '添加文章分类', 'icon' => 'plus-square', 'url' => ['/article-category/add'],],
                        ],
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
