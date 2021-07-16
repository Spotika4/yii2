<?php

namespace console\controllers;

use yii\console\Controller;


class RbacController extends Controller{


	public function actions(){
		return [
			'initialize' => \common\components\core\actions\rbac\Initialize::class,
			'assignment' => \common\components\core\actions\rbac\Assignment::class
		];
	}
}