<?php

namespace common\actions;


class Error extends \common\models\base\Action {


	public function run(){
		$this->controller->layout = 'main';
		$exception = \Yii::$app->errorHandler->exception;
		\Yii::$app->response->setStatusCode($exception->statusCode);
		return $this->controller->render('error',
			[
				'statusCode' => $exception->statusCode,
				'name' => \Yii::t('app', 'Error ' . $exception->statusCode),
				'message' => \Yii::t('app', $exception->getMessage()),
			]);
	}
}
