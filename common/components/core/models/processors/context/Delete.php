<?php

namespace common\components\core\models\processors\context;


class Delete extends \common\components\core\models\base\DeleteProcessor {


	public $id;
	protected $class  ='common\components\core\models\ar\Context';


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