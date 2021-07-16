<?php

namespace common\components\core\models\processors\resource;


class Delete extends \common\components\core\models\base\processors\DeleteNodeTreeProcessor {


	public $id;
	protected $class  ='common\components\core\models\ar\Resource';


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