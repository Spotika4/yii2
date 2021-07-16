<?php

$config = [
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm' => '@vendor/npm-asset',
	],
	'bootstrap' => ['log', 'core'],
	'language' => 'ru-RU',
	'sourceLanguage' => 'aa-AA',
	'defaultRoute' => 'default/index',
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'core' => [
			'class' => '\common\components\core\Component',
			'runtimes' => [
				'backend' => [
					'cache' => '@backend/runtime/cache',
					'debug' => '@backend/runtime/debug',
					'logs' => '@backend/runtime/logs',
					'HTML' => '@backend/runtime/HTML',
					'assets' => '@backend/web/assets',
				],
				'frontend' => [
					'cache' => '@frontend/runtime/cache',
					'debug' => '@frontend/runtime/debug',
					'logs' => '@frontend/runtime/logs',
					'HTML' => '@frontend/runtime/HTML',
					'assets' => '@frontend/web/assets',
				],
			],
			'rbacPath' => [
				'@core/config/rbac/',
			],
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'logVars' => [],
					'enabled' => true,
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
					//'except' => ['yii\db\*', 'yii\web\*', 'yii\base\*'],
				],
			]
		],
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => '',
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => '',
			'enableSchemaCache' => true,
			'schemaCacheDuration' => 36000,
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => '',
				'username' => '',
				'password' => '',
				'port' => '465',
				'encryption' => 'ssl',
			],
		],
		'user' => [
			'loginUrl' => ['login/'],
			'enableAutoLogin' => true,
			'class' => 'yii\web\User',
			'identityClass' => 'common\components\core\models\ar\User',
			'identityCookie' => ['name' => '_identity-common', 'httpOnly' => true],
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager'
		],
	],
];
if(YII_DEBUG){
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
	];
}
return $config;