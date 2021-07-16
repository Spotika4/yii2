<?php

namespace common\components\core\models\processors\context;


class Datatables extends \common\components\core\models\base\DatatablesProcessor {


	public function getTableName(){
		return \common\components\core\models\ar\Context::tableName();
	}
}