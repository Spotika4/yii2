<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'api',
    'name' => 'Api',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'modules' => [],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'loginUrl' => null,
            'enableSession' => false,
            'enableAutoLogin' => false,
            'identityClass' => 'common\models\User',
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pluralize' => false,
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'extraPatterns' => [
                        'POST token' => 'token',
                    ],
                    'except' => ['delete']
                ],
                [
                    'pluralize' => false,
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'role',
                    'except' => ['delete'],
                    'tokens' => [
                        '{name}' => '<id:\\w[\\w,]*>'
                    ],
                    'patterns' => [
                        'PUT,PATCH {name}' => 'update',
                        'DELETE {name}' => 'delete',
                        'GET,HEAD {name}' => 'view',
                        'POST' => 'create',
                        'GET,HEAD' => 'index',
                        '{name}' => 'options',
                        '' => 'options',
                    ]
                ],
            ],
        ]
    ],
    'params' => $params,
];
