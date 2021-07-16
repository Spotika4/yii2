<?php

namespace common\components\core\models\processors\menu;


class Select extends \common\components\core\models\base\SelectProcessor {


	const SCENARIO_FOR_SELECT = 'select';

	public $context_id;


	public function scenarios(){
		return [
			self::SCENARIO_FOR_SELECT => ['context_id'],
		];
	}

	public function select(){
		$result = (new \yii\db\Query())->from('{{%menu}}')->select(['id', 'context_id', 'name'])->where(['context_id' => $this->context_id])->all();
		foreach($result as $k => $menu){
			$menus[$menu['id']] = $menu['name'];
		}
		return (isset($menus)) ? $menus : [];
	}
}