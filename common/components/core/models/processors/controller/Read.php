<?php

namespace common\components\core\models\processors\controller;


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
		return \common\components\core\models\ar\Controller::find()
			->select(['id', 'context_id', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['id' => $this->id]);
	}
}