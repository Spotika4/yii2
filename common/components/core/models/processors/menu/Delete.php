<?php

namespace common\components\core\models\processors\menu;


class Delete extends \common\components\core\models\base\processors\DeleteProcessor {


	public $key;
	protected $pk = 'key';
	protected $class  ='common\components\core\models\ar\Menu';


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
}