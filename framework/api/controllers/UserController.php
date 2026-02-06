<?php

namespace api\controllers;


class UserController extends \common\models\base\rest\ActiveController {


	public $modelClass = 'common\models\User';

	public $serializer = [
		'class' => 'yii\rest\Serializer',
		'collectionEnvelope' => 'items',
	];


	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['authenticator']['optional'] = ['token'];
		return $behaviors;
	}

	public function actions(){
		$actions = parent::actions();
		unset($actions['index']['dataFilter']);
		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
		return $actions;
	}

	public function prepareDataProvider(){
		$search = new \common\models\user\Search();
		$search->setScenario($search::SCENARIO_DATATABLE);
		$search->load(\Yii::$app->request->getQueryParams(), '');
		return $search->search();
	}

	public function actionToken(){
		$model = new \common\models\user\Login();
		if($model->load(\Yii::$app->getRequest()->getBodyParams(), '')){
			if($auth_key = $model->authKey()){
				return [
					'success' => true,
					'message' => false,
					'data' => [
						'token' => $auth_key
					]
				];
			}
		}

		return [
			'success' => false,
			'message' => 'Указанная пара логина и пароля не найдена',
			'data' => false
		];
	}
}
