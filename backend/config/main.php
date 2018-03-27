<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
        ]
    ],
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'i18n'=>[
            'translations'=>[
                '*'=>[
                    'class'=>'yii\i18n\PhpMessageSource',
                    'fileMap'=>[
                        'common'=>'common.php',
                    ],
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl'=>array('/admin/login')
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ""=>"/admin/login"],
        ],

    ],
    'params' => $params,
    'aliases' => [
        '@mdm/admin' => 'path/to/your/extracted',
        // for example: '@mdm/admin' => '@app/extensions/mdm/yii2-admin-2.0.0',
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'admin/login',
            'admin/logout'
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];
