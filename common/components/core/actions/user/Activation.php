<?php

namespace common\components\core\actions\user;


class Activation extends \common\components\core\models\base\Action {


	public function run(){
		$processor = new \common\components\core\models\processors\user\Activate();
		if($processor->load(\Yii::$app->request->get()) && $processor->process()->getSuccess()){
			return $this->controller->render('message', [
				'processor' => $processor,
			]);
		}
		throw new \yii\web\NotFoundHttpException(\Yii::t('core', 'error_not_found_message'));
	}
}