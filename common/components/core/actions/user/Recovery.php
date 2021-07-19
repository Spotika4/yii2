<?php

namespace common\components\core\actions\user;


class Recovery extends \common\components\core\models\base\Action {


	public function run(){
		if(!\Yii::$app->user->isGuest){
			return $this->controller->goHome();
		}
		if(\Yii::$app->request->isAjax){
			$recovery = new \common\components\core\models\processors\user\Recovery;
			$recovery->load(\Yii::$app->request->post());
			return $recovery->process()->response();
		}
		return $this->controller->render('recovery');
	}
}