<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
	'id' => 'frontend',
	'name' => 'Frontend',
	'homeUrl' => '/',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'frontend\controllers',
    'components' => [
	    'request' => [
		    'baseUrl' => '/',
		    'csrfParam' => '_csrf-frontend',
		    'enableCsrfValidation' => true,
		    'cookieValidationKey' => '',
	    ],
	    'errorHandler' => [
		    'errorAction' => 'default/error',
	    ],
	    'cache' => [
		    'class' => 'yii\caching\FileCache',
		    'cachePath' => '@frontend/runtime/cache',
	    ],
	    'session' => [
		    'name' => 'frontend',
	    ],
	    'authManager' => [
		    'class' => 'yii\rbac\DbManager'
	    ],
	    'user' => [
		    'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
	    ],
	    'urlManager' => [
		    'baseUrl' => '/',
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
			    '<a:(index)>' => 'default/<a>',
			    '<c:[\w\-]+>/' => '<c>/',
			    '<c:[\w\-]+>/<a:[\w\-]+>' => '<c>/<a>',
		    ],
	    ],
    ],
    'params' => $params,
];
