<?php

namespace common\assets;

use yii\web\AssetBundle;


class Backtemplate extends AssetBundle{


    public $sourcePath = '@vendor/spotika4/backtemplate/assets/dist';
    public $css = [
	    'css/main.min.css',
    ];
    public $js = [
	    'js/main.min.js',
    ];
	public $depends = [
		'yii\web\JqueryAsset',
		'common\assets\JSTreeAsset',
	];
}
