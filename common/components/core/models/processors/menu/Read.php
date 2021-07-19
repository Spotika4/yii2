<?php

namespace common\components\core\models\processors\menu;


class Read extends \common\components\core\models\base\processors\ReadProcessor{


	public $key;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['key']
		];
	}

	public function rules(){
		return [
			[['key'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\Menu::find()
			->select(['id', 'context_key', 'key', 'name'])
			->where(['key' => $this->key]);
	}
}