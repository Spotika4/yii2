<?php

namespace common\components\core\actions;


class Error extends \common\components\core\models\base\Action {


	public function run(){
		$this->controller->layout = 'main';
		$exception = \Yii::$app->errorHandler->exception;
		\Yii::$app->response->setStatusCode($exception->statusCode);
		return $this->controller->render('error',
			[
				'statusCode' => $exception->statusCode,
				'name' => \Yii::t('core', 'Error ' . $exception->statusCode),
				'message' => \Yii::t('core', $exception->getMessage()),
			]);
	}
}