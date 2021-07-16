<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\profile\Update;


class ProfileController extends \backend\models\base\JsonController{


	public function actionEmailUpdate(){
		$model = new Update(['scenario' => Update::SCENARIO_EMAIL_UPDATE]);
		$model->load(Yii::$app->request->post());
		return $this->render($model->process()->response());
	}

	public function actionPasswordUpdate(){
		$model = new Update(['scenario' => Update::SCENARIO_PASSWORD_UPDATE]);
		$model->load(Yii::$app->request->post());
		return $this->render($model->process()->response());
	}
}
