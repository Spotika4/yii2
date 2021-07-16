<?php

namespace backend\assets;


class AppAsset extends \yii\web\AssetBundle{

	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $js = [
		'js/app.js'
	];
	public $css = [
		'css/app.css'
	];
	public $depends = [
		'common\assets\Backtemplate',
	];

	public $jsOptions = array(
		'position' => \yii\web\View::POS_HEAD
	);
}
