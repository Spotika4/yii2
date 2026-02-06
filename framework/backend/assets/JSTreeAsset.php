<?php

namespace backend\assets;

use yii\web\AssetBundle;


class JSTreeAsset extends AssetBundle {


	public $sourcePath = '@bower/jstree/dist';
    public $css = [
	    'themes/default/style.min.css'
    ];
    public $js = [
	    'jstree.js'
    ];
}
