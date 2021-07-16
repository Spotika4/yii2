<?php

namespace common\components\core\models\processors\menu;


class Datatables extends \common\components\core\models\base\processors\DatatablesProcessor {


	public function getTableName(){
		return \common\components\core\models\ar\Menu::tableName();
	}
}