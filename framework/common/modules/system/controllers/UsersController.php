<?php

namespace common\modules\system\controllers;

use yii\filters\AccessControl;


class UsersController extends \common\models\base\Controller {


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

	public function actionCreate() {
		return $this->render('create', [
			'user' => [],
			'roles' => [],
			'statuses' => []
		]);
	}

	public function actionUpdate() {
        $user_id = \Yii::$app->request->get('id');
		return $this->render('update', [
            'user' => [
                'id' => $user_id
            ],
            'roles' => [],
            'statuses' => []
        ]);
	}
}
