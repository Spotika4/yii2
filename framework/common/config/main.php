<?php
return [
    'language'=> 'ru-RU',
    'sourceLanguage' => 'aa-AA',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
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
	    /*'urlManager' => [
		    'baseUrl' => '/',
		    'suffix' => '/',
		    'showScriptName' => false,
		    'enablePrettyUrl' => true,
		    'enableStrictParsing' => false,
		    'normalizer' => [
			    'class' => 'yii\web\UrlNormalizer',
			    'collapseSlashes' => true,
			    'normalizeTrailingSlash' => true,
		    ],
		    'rules' => [
			    [
				    'pattern' => '/',
				    'suffix' => '',
				    'route' => 'default/index',
			    ]
		    ]
	    ],*/
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php'
                    ],
                ],
            ]
        ]
    ],
];
