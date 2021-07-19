<?php

namespace common\components\core\models\processors\menu;


class Select extends \common\components\core\models\base\processors\SelectProcessor {


	const SCENARIO_FOR_SELECT = 'select';

	public $context_key;


	public function scenarios(){
		return [
			self::SCENARIO_FOR_SELECT => ['context_key'],
		];
	}

	public function select(){
		$result = (new \yii\db\Query())->from('{{%menu}}')->select(['id', 'context_key', 'name', 'key'])->where(['context_key' => $this->context_key])->all();
		foreach($result as $k => $menu){
			$menus[$menu['key']] = $menu['name'];
		}
		return (isset($menus)) ? $menus : [];
	}
}