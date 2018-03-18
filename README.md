<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
"# phpShop" 
"# 实现逻辑删除"

```

```
# 实战项目
## 项目描述简介
```
类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存 CRM客户关系管理)
电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。
为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。
为了让大家掌握公司协同开发要点，我们使用git管理代码。
在项目中会使用很多前面的知识，比如架构、维护等等。

```
## 主要功能模块
```
系统包括：
后台：品牌管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
前台：首页、商品展示、商品购买、订单管理、在线支付等。

```

## 商城项目实战第一天
```

```

### 商品品牌的实现
```
第一步：分析商城品牌所要用到的属性和字段，然后进行建表操作
第二步：实现对数据的增删改查操作
PS：做品牌的实现时需要考虑到用户的体验，从而考虑到一些细节上的东西；从思维上去实现用户具体想要的
```

## #商城项目实战第二天
### 商品文章、分类、内容的实现
```
1：通过分析得出需要建立三张表，分别是文章表、分类表、内容表；然后具体得出文章表和分类表内容表之间的关系，实现查看文章的同时能得出该篇文章的分类和具体的内容
2：实现增删改查
PS：在将三张表联系起来的时候，需要对他们之间的关系（一对一或者一对多 多对多）进行仔细的分析从而得出想要的数据
```
## #商城项目实战第三天
### 商品分类的实现
```
#	需求
1.	商品分类的增删改查
2.	商品分类支持无限级分类
3.	方便直观的显示分类层级
4.	分类层级允许修改
#   难点
1.  实现分类的修改时获取id有问题
    解决方案：进入yii\grid\ActionColumn，在renderDataCellContent方法中添加$key=$model->id即可使获取id正常
2.  在修改时出现的节点问题尚未解决
3.  进行删除时不能删除带有子节点的数据不能正确实现
```
