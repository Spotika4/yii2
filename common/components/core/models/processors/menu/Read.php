<?php

namespace common\components\core\models\processors\menu;


class Read extends \common\components\core\models\base\ReadProcessor{


	public $id;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['id']
		];
	}

	public function rules(){
		return [
			[['id'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\Menu::find()
			->select(['id', 'context_id', 'name'])
			->where(['id' => $this->id]);
	}
}