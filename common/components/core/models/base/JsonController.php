<?php

namespace common\components\core\models\base;


class JsonController extends Controller {


	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['verbs'] = [
			'class' => \yii\filters\VerbFilter::class, 'actions' => ['*' => ['POST']]
		];
		return $behaviors;
	}

	public function render($data = [], $params = []){
		if(is_object($data)){
			$data->toArray();
		}
		if(!empty($params)){
			$data = \yii\helpers\ArrayHelper::merge($params, ['data' => $data]);
		}
		return $data;
	}

	public function actionError(){
		$exception = \Yii::$app->errorHandler->exception;
		\Yii::$app->response->setStatusCode($exception->statusCode);
		return $this->render([
			'success' => false,
			'errors' => false,
			'message' => \Yii::t('core', 'error_not_found_message')
		]);
	}
}