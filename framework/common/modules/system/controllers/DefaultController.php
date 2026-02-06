<?php

namespace common\modules\system\controllers;

use yii\filters\AccessControl;


class DefaultController extends \common\models\base\Controller {


	public function init(){
		parent::init();
		$this->layout = null;
	}

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionIndex() {
		return $this->render('index');
	}
}
