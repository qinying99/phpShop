<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>填写核对订单信息</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/fillin.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">

    <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/js/cart2.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php include Yii::getAlias('@app')."/views/common/nav.php"?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="/index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<form id="form">
    <input name="_csrf-frontend" type="hidden" id="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="fillin w990 bc mt15">
        <div class="fillin_hd">
            <h2>填写并核对订单信息</h2>
        </div>

        <div class="fillin_bd">
            <!-- 收货人信息  start-->
            <div class="address">
                <h3>收货人信息 </h3>
                <div class="address_info">
                    <?php foreach ($addresss as $address):?>
                        <p>
                            <input type="radio" value="<?=$address->id?>" name="address_id"
                                <?php
                                if ($address->status==1){
                                    echo "checked='checked'";
                                }
                                ?>/>
                            <?=$address->name?>  <?=$address->phone?>   <?=$address->province?>  <?=$address->city?>  <?=$address->county?>  <?=$address->address?>
                        </p>
                    <?php endforeach;?>
                </div>

            </div>
            <!-- 收货人信息  end-->

            <!-- 配送方式 start -->
            <div class="delivery">
                <div class="delivery_select">
                    <h3>付款方式</h3>
                    <table>
                        <thead>
                        <tr>
                            <th class="col1">付款方式</th>
                            <th class="col2">说明</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pays as $k=>$pay):?>
                            <tr class="<?=$k==0?'cur':''?>">
                                <td>
                                    <input type="radio" name="pay" <?=$pay->id==1?'checked':''?> value="<?=$pay->id?>"/><?=$pay->name?>
                                </td>
                                <td><?=$pay->explain?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- 配送方式 end -->

            <!-- 支付方式  start-->
            <div class="pay">
                <div class="pay_select ">
                    <h3>送货方式</h3>
                    <table>
                        <tr>
                            <th class="col1">送货方式</th>
                            <th class="col2">运费</th>
                        </tr>
                        <?php foreach ($deliveryids as $k=>$deliveryid):?>
                            <tr class="<?=$k==0?'cur':''?>">
                                <td class="col1" ><input type="radio" name="delivery" <?=$deliveryid->id==1?'checked':''?> value="<?=$deliveryid->id?>"/><?=$deliveryid->name?></td>
                                <td class="col2"><?=$deliveryid->freight?></td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                </div>
            </div>
            <!-- 支付方式  end-->

            <!-- 商品清单 start -->
            <div class="goods">
                <h3>商品清单</h3>
                <table>
                    <thead>
                    <tr>
                        <th class="col1">商品</th>
                        <th class="col3">价格</th>
                        <th class="col4">数量</th>
                        <th class="col5">小计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total ="";
                    foreach ($goods as $good):
                        $total+=$good->goods_price*$cart[$good->id];
                        ?>
                        <tr>
                            <td class="col1"><a href="/"><img src="<?=$good->logo?>" alt="" /></a>
                                <strong><a href="/"><?=$good->goods_name?></a></strong>
                            </td>

                            <td class="col3">￥<?=$good->goods_price?></td>
                            <td class="col4"> <?=$cart[$good->id]?></td>
                            <td class="col5"><span>￥<?=$good->goods_price*$cart[$good->id]?></span></td>

                        </tr>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul>
                                <li>
                                    <span> <?=$count?> 件商品，总商品金额：</span>
                                    <em>￥<span id="goods_price"><?=number_format($total,2,".","")?></span></em>
                                </li>
                                <li>
                                    <span>运费：</span>
                                    <em>￥<span id="price"><?=number_format($deliveryids[0]->freight,2)?></span></em>
                                </li>
                                <li>
                                    <span>应付总额：</span>
                                    <em>￥<span class="all_price" ><?=number_format($total+$deliveryids[0]->freight,2)?></span></em>

                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- 商品清单 end -->

        </div>

        <div class="fillin_ft">
            <a href="javascript:(0);" id="btn-sub"><span>提交订单</span></a>
            <p>应付总额：<strong class="all_price" >￥<?= number_format($total+$deliveryids[0]->freight,2)?></strong></p>
        </div>
    </div>
</form>
<!-- 主体部分 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="/">关于我们</a> |
        <a href="/">联系我们</a> |
        <a href="/">人才招聘</a> |
        <a href="/">商家入驻</a> |
        <a href="/">千寻网</a> |
        <a href="/">奢侈品网</a> |
        <a href="/">广告服务</a> |
        <a href="/">移动终端</a> |
        <a href="/">友情链接</a> |
        <a href="/">销售联盟</a> |
        <a href="/">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href="/"><img src="/images/xin.png" alt="" /></a>
        <a href="/"><img src="/images/kexin.jpg" alt="" /></a>
        <a href="/"><img src="/images/police.jpg" alt="" /></a>
        <a href="/"><img src="/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->
<script type="text/javascript" src="/layer/layer.js"></script>
<script type="text/javascript">
    $(function () {
        //监听配送方式
        $("input[name='delivery']").change(function () {
            //得到当前的运费
            var price=$(this).parent().next().text();
            //更改运费
            $("#price").text(price);
            console.dir($("#goods_price").text());
            console.dir(parseFloat(price)+parseFloat($("#goods_price").text()));
            //得到当前的总价
            $(".all_price").text((parseFloat(price)+parseFloat($("#goods_price").text())).toFixed(2))
        })
        //提交数据
        $("#btn-sub").click(function () {
            $.post('/order/add',$("#form").serialize(),function (data) {
                if(data.status){
                    alert(data.msg);
                    window.location.href="/order/list?id="+data.id;
                }else{
                    alert(data.msg);
                }
            },'json')
        })
    })
</script>
</body>
</html>
