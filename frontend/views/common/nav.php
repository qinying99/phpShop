<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li><?=Yii::$app->user->isGuest?'您好，欢迎来到京西！[<a href="/user/login">登录</a>] [<a href="/user/reg">免费注册</a>]':'欢迎您：'.Yii::$app->user->identity->username.'[<a href="/user/logout">注销</a>]'?> </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>
            </ul>
        </div>
    </div>
</div>