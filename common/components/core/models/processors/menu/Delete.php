<?php

namespace common\components\core\models\processors\menu;


class Delete extends \common\components\core\models\base\processors\DeleteProcessor {


	public $id;
	protected $class  ='common\components\core\models\ar\Menu';


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