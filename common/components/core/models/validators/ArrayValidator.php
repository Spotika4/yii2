<?php

namespace common\components\core\models\validators;

use yii\validators\Validator;


class ArrayValidator extends Validator {


	public function validateAttribute($model, $attribute){
		if(!is_array($model->$attribute)){
			$this->addError($model, $attribute, 'need_array');
		}
	}
}