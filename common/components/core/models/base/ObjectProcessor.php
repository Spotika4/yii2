<?php

namespace common\components\core\models\base;


class ObjectProcessor extends Processor {


	protected $class;
	protected $pk = 'id';
	protected $object;


	public function query(){
		$condition = $this->getAttributes([$this->pk]);
		return $this->class::find()->where($condition);
	}
}