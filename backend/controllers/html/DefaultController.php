<?php

namespace backend\controllers\html;


class DefaultController extends \backend\models\base\HtmlController {


	public $layout = 'clear';


	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => [
				'error', 'login', 'recovery', 'reset'
			]
		];
		return $behaviors;
	}

	public function actions(){
		return [
			'error' => \common\components\core\actions\Error::class,
			'login' => \common\components\core\actions\user\Login::class,
			'recovery' => \common\components\core\actions\user\Recovery::class,
			'reset' => \common\components\core\actions\user\Reset::class,
		];
	}

	public function actionIndex(){
		$this->layout = 'main';
		return $this->render('index');
	}
}
