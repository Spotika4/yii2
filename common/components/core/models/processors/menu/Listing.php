<?php

namespace common\components\core\models\processors\menu;


class Listing extends \common\components\core\models\base\Processor {


	const SCENARIO_FOR_SELECT = 'select';

	public $lexicon;
	public $context_key;


	public function scenarios(){
		return [
			self::SCENARIO_FOR_SELECT => ['context_key', 'lexicon'],
		];
	}

	public function rules(){
		return [
			[['context_key', 'lexicon'], 'required'],
		];
	}

	public function select(){
		$result = (new \yii\db\Query())->from('{{%menu}}')->select(['id', 'context_key', 'key', 'name'])->where(['context_key' => $this->context_key])->all();
		foreach($result as $k => $menu){
			$menus[$menu['key']] = \Yii::t($this->lexicon, $menu['name']);
		}
		return (isset($menus)) ? $menus : [];
	}
}