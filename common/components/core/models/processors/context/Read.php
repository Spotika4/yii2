<?php

namespace common\components\core\models\processors\context;


class Read extends \common\components\core\models\base\processors\ReadProcessor{


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
		return \common\components\core\models\ar\Context::find()
			->select(['id', 'key', 'name'])
			->where(['id' => $this->id]);
	}
}