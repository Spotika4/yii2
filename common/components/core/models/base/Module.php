<?php

namespace common\components\core\models\base;


class Module extends \yii\base\Module{


	public $errorHandler;


	public function init(){
		parent::init();
		if($this->errorHandler){
			$this->setErrorHandler();
		}
		$this->controllerNamespace .= '\\' . \Yii::$app->response->format;
	}

	public function setErrorHandler(){
		\Yii::$app->getErrorHandler()->unregister();
		\Yii::$app->set('errorHandler', new \yii\web\ErrorHandler($this->errorHandler));
		\Yii::$app->getErrorHandler()->register();
	}
}