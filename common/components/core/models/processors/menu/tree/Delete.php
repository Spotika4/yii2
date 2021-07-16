<?php

namespace common\components\core\models\processors\menu\tree;


class Delete extends \common\components\core\models\base\DeleteNodeTreeProcessor {


	public $id;
	protected $class  ='common\components\core\models\ar\MenuTree';


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