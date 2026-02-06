<?php

namespace common\models\validators;

use yii\validators\Validator;


class ArrayValidator extends Validator {


	public function validateAttribute($model, $attribute){
		if(!empty($model->$attribute) && !is_array($model->$attribute)){
			$this->addError($model, $attribute, 'need_array');
		}
	}
}
