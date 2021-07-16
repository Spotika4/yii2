<?php

namespace common\components\core\actions\user;


class Login extends \common\components\core\models\base\Action {


	public function run(){
		if(\Yii::$app->request->isAjax){
			$login = new \common\components\core\models\processors\user\Login;
			$login->load(\Yii::$app->request->post());
			return $login->process()->response();
		}
		if(!\Yii::$app->user->isGuest){
			return $this->controller->goHome();
		}
		return $this->controller->render('login');
	}
}