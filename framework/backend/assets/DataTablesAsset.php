<?php

namespace backend\assets;

use yii\web\AssetBundle;


class DataTablesAsset extends AssetBundle{


	public $sourcePath = '@bower';
	public $css = [
		'datatables.net-bs/css/dataTables.bootstrap.css',
	];
	public $js = [
		'datatables.net/js/dataTables.js',
		'datatables.net-bs/js/dataTables.bootstrap.js',
	];
}
