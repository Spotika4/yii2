<?php

namespace common\components\core\actions\user;


class Register extends \common\components\core\models\base\Action {


	public function run(){
		if(!\Yii::$app->user->isGuest){
			return $this->goHome();
		}
		if(\Yii::$app->request->isAjax){
			$create = new \common\components\core\models\processors\user\Register;
			$create->load(\Yii::$app->request->post());
			return $create->process()->response();
		}
		return $this->controller->render('register');
	}
}