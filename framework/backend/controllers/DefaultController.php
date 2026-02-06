<?php

namespace backend\controllers;


class DefaultController extends \common\models\base\Controller {


	public function behaviors() {
		return [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::class,
				'actions' => [
					'logout' => ['post'],
					'token' => ['post'],
				],
			],
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'rules' => [
					[
						'actions' => ['login', 'error'],
						'allow' => true,
					],
					[
						'actions' => ['logout', 'index', 'token'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actions() {
		return [
			'error' => \common\actions\Error::class,
		];
	}

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionToken() {
		if (\Yii::$app->user->isGuest){
			throw new \yii\web\ForbiddenHttpException();
		}

		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return [
			'data' => [
				'token' => \Yii::$app->getUser()->getIdentity()->getAttribute('auth_key')
			],
			'success' => true,
			'message' => false,
		];
	}

	public function actionLogin() {
		$this->layout = 'blank';
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		if (\Yii::$app->request->isAjax) {
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			$success = false;
			$model = new \common\models\user\Login();

			if ($model->load(\Yii::$app->request->post(), '')) {
				$success = $model->login();
			}

			return [
				'data' => false,
				'success' => $success,
				'message' => ($success == false) ? 'Указанная пара логина и пароля не найдена' : false,
			];
		}

		return $this->render('login');
	}

	public function actionLogout() {
		\Yii::$app->user->logout();
		return $this->goHome();
	}
}
