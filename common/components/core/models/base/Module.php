<?php

namespace common\components\core\models\base;


class Module extends \yii\base\Module{


	public $homeUrl;
	public $errorHandler;


	public function init(){
		parent::init();
		$core = $this->module->get('core', false);
		if(!$core->loadContext($this->id)){
			\Yii::error('Context "' . $this->id . '"" not found');
			return false;
		}
		\Yii::$app->i18n->translations[$this->id . '*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'basePath' => $this->getBasePath() . '/messages'
		];
		if($this->errorHandler){
			$this->setErrorHandler();
		}
		if($this->homeUrl){
			\Yii::$app->setHomeUrl($this->homeUrl);
		}
		$this->controllerNamespace .= '\\' . \Yii::$app->response->format;
	}

	public function setErrorHandler(){
		\Yii::$app->getErrorHandler()->unregister();
		\Yii::$app->set('errorHandler', new \yii\web\ErrorHandler($this->errorHandler));
		\Yii::$app->getErrorHandler()->register();
	}
}