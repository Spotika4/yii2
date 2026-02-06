<?php

namespace backend\assets;

use yii\web\AssetBundle;


class DataTablesButtonsAsset extends AssetBundle{


    public $sourcePath = '@bower';
    public $css = [
        //'datatables.net-buttons-bs4/css/buttons.bootstrap4.css',
    ];
    public $js = [
	    'datatables.net-buttons/js/dataTables.buttons.js',
    ];
	public $depends = [
		'backend\assets\DatatablesAsset',
	];
}
