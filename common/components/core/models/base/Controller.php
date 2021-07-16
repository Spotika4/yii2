<?php

namespace common\components\core\models\base;


class Controller extends \yii\web\Controller {


	public $layout = 'main';


	public function behaviors(){
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['?', '@'],
					]
				]
			]
		];
	}

	public function actions(){
		return [
			'error' => ['class' => 'common\components\core\actions\Error'],
		];
	}
}