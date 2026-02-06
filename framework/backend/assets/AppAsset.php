<?php

namespace backend\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle {
	
	
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	
	public $css = [
		'css/main.css',
	];
	
	public $js = [
		'js/main.js',
	];
	
	public $depends = [
		'yii\web\JqueryAsset',
		'backend\assets\JSTreeAsset',
		'backend\assets\IconicAsset',
		'backend\assets\JQueryValidate',
		'yii\bootstrap5\BootstrapAsset',
		//'backend\assets\FontAwesome',
		//'yii\bootstrap4\BootstrapPluginAsset',
		'backend\assets\DataTablesAsset',
		'backend\assets\DataTablesButtonsAsset',
	];
	
	public $jsOptions = [
		'position' => \yii\web\View::POS_HEAD
	];
}
