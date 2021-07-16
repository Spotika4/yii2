<?php

namespace common\components\core\models\base\processors;


class ObjectProcessor extends \common\components\core\models\base\Processor {


	protected $class;
	protected $pk = 'id';
	protected $object;


	public function query(){
		$condition = $this->getAttributes([$this->pk]);
		return $this->class::find()->where($condition);
	}
}