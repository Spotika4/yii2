<?php

namespace common\components\core\models\processors\controller;


class Delete extends \common\components\core\models\base\processors\DeleteNodeTreeProcessor {


	public $id;
	protected $class  = 'common\components\core\models\ar\Controller';


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
}