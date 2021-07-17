<?php

namespace common\components\core;


class Component extends \yii\base\Component {


	public $configPath;
	public $rbacPath;
	public $mailPath;
	public $messagesPath;
	public $runtimes = [];
	public $context;
	public $resource;


	public function init(){
		\Yii::setAlias('@core', dirname(__FILE__));
		\Yii::$app->i18n->translations['core*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'basePath' => '@core/messages'
		];
		if(!\Yii::$app->request->isConsoleRequest){
			if($this->context = $this->getCurrentContext()){
				if(\Yii::$app->request->isAjax){
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				}else if($this->resource = $this->getCurrentResource()){
					\Yii::$app->view->params['context'] = $this->context->toArray();
					\Yii::$app->view->params['resource'] = $this->resource->toArray();
				}
				\Yii::$app->i18n->translations[\Yii::$app->id . '*'] = [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => \Yii::$app->getBasePath() . '/messages'
				];
				\Yii::$app->controllerNamespace .= '\\' . \Yii::$app->response->format;
			}
		}
	}

	public function getHomeResource(){
		return \common\components\core\models\ar\Resource::find()
			->select(['id', 'context_id', 'parent', 'title', 'url', 'icon'])
			->where(['context_id' => $this->context->id, 'url' => '/'])->asArray()->one();
	}

	public function getCurrentResource(){
		if(!$url = \Yii::$app->request->getPathInfo()) $url = '/';
		return \common\components\core\models\ar\Resource::find()
			->select(['id', 'context_id', 'parent', 'title', 'url', 'icon'])
			->where(['context_id' => $this->context->id, 'url' => $url])->one();
	}

	public function getCurrentContext(){
		return $this->context = \common\components\core\models\ar\Context::find()
			->select(['id', 'key', 'name'])->where(['key' => \Yii::$app->id])->one();
	}

	public function getRuntimes($context){
		if(isset($this->runtimes[$context])){
			return $this->runtimes[$context];
		}
		return false;
	}

	public function getMailPath(){
		if(!$this->mailPath){
			$this->mailPath = '@core/mail';
		}
		return \Yii::getAlias($this->mailPath);
	}

	public function getMessagesPath(){
		if(!$this->messagesPath){
			$this->messagesPath = '@core/messages';
		}
		return \Yii::getAlias($this->messagesPath);
	}

	public function getConfigPath(){
		if(!$this->configPath){
			$this->configPath = '@core/config';
		}
		return \Yii::getAlias($this->configPath);
	}

	public function getRbacPath(){
		return $this->rbacPath;
	}

	public function sendMail($email, $subject = '', $view = '', $params = []){
		$mailer = \Yii::$app->mailer;
		$viewPath = $this->getMailPath() . '/' . \Yii::$app->language . '/';
		$mailer->setViewPath($viewPath);
		$mailer->view->params['title'] = $subject;
		$message = $mailer->compose($view, $params);
		$message->setSubject($subject)->setTo($email)
			->setFrom([\Yii::$app->params['senderEmail'] => \Yii::$app->name]);
		return $message->send();
	}
}