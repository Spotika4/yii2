<?php

$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/../../common/config/params-local.php',
	require __DIR__ . '/params.php',
	require __DIR__ . '/params-local.php'
);

return [
	'id' => 'backend',
	'name' => 'Backend',
	'homeUrl' => '/backend/',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'backend\controllers',
	'components' => [
		'request' => [
			'baseUrl' => '/backend',
			'csrfParam' => '_csrf-backend',
			'enableCsrfValidation' => true,
			'cookieValidationKey' => '',
		],
		'errorHandler' => [
			'errorAction' => 'default/error',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
			'cachePath' => '@backend/runtime/cache',
		],
		'session' => [
			'name' => 'backend',
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager'
		],
		'user' => [
			'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
		],
		'urlManager' => [
			'baseUrl' => '/backend/',
			'suffix' => '/',
			'enablePrettyUrl' => true,
			'enableStrictParsing' => false,
			'showScriptName' => false,
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
				],
				'<a:(index|login|recovery|reset)>' => 'default/<a>',
				'<c:[\w\-]+>/' => '<c>/',
				'<c:[\w\-]+>/<a:[\w\-]+>' => '<c>/<a>',
			],
		],
	],
	'params' => $params,
];