<?php

namespace backend\controllers\json;


class DefaultController extends \backend\models\base\JsonController {


	public function actions(){
		return [
			'error' => ['class' => 'components\core\actions\Error'],
		];
	}
}