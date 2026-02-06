<?php

namespace console\controllers;

use yii\console\Controller;


class RbacController extends Controller{


	public function actions(){
		return [
			'initialize' => \common\actions\rbac\Initialize::class,
			'assignment' => \common\actions\rbac\Assignment::class
		];
	}
}