<?php

namespace common\models\base\rest;


class ActiveController extends \yii\rest\ActiveController {


	public $createScenario = \common\models\base\ActiveRecord::SCENARIO_CREATE;
	public $updateScenario = \common\models\base\ActiveRecord::SCENARIO_UPDATE;


	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => \yii\filters\auth\CompositeAuth::class,
			'authMethods' => [
				\yii\filters\auth\HttpBasicAuth::class,
				\yii\filters\auth\HttpBearerAuth::class,
				\yii\filters\auth\QueryParamAuth::class,
			]
		];

		return $behaviors;
	}

	public function actions(){
		$actions = parent::actions();
		$actions['index']['dataFilter'] = [
			'searchModel' => $this->modelClass,
			'class' => \yii\data\ActiveDataFilter::class,
		];
		return $actions;
	}
}
