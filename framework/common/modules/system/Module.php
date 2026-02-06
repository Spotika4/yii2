<?php

namespace common\modules\system;


class Module extends \common\models\base\Module {


	public function init() {
		parent::init();
		\Yii::configure($this, require __DIR__ . '/config.php');
	}
}
