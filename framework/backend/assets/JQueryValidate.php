<?php

namespace backend\assets;

use yii\web\AssetBundle;


class JQueryValidate extends AssetBundle {


	public $sourcePath = '@bower/jquery-validation/dist';
    public $js = [
	    'jquery.validate.min.js'
    ];
}
