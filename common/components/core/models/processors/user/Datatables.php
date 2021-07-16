<?php

namespace common\components\core\models\processors\user;


class Datatables extends \common\components\core\models\base\processors\DatatablesProcessor {


	public function getTableName(){
		return \common\components\core\models\ar\User::tableName();
	}
}