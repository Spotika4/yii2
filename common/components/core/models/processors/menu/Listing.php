<?php

namespace common\components\core\models\processors\menu;


class Listing extends \common\components\core\models\base\Processor {


	const SCENARIO_FOR_SELECT = 'select';

	public $lexicon;
	public $context_id;


	public function scenarios(){
		return [
			self::SCENARIO_FOR_SELECT => ['context_id', 'lexicon'],
		];
	}

	public function rules(){
		return [
			[['context_id', 'lexicon'], 'required'],
		];
	}

	public function select(){
		$result = (new \yii\db\Query())->from('{{%menu}}')->select(['id', 'context_id', 'name'])->where(['context_id' => $this->context_id])->all();
		foreach($result as $k => $menu){
			$menus[$menu['id']] = \Yii::t($this->lexicon, $menu['name']);
		}
		return (isset($menus)) ? $menus : [];
	}
}