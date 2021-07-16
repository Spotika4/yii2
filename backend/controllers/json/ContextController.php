<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\context\Create;
use common\components\core\models\processors\context\Update;
use common\components\core\models\processors\context\Delete;


class ContextController extends \backend\models\base\JsonController{


	public function actionCreate(){
		$create = new Create();
		$create->load(Yii::$app->request->post());
		return $this->render($create->process()->response());
	}

	public function actionUpdate(){
		$update = new Update();
		$update->load(Yii::$app->request->post());
		return $this->render($update->process()->response());
	}

	public function actionDelete(){
		$update = new Delete();
		$update->load(Yii::$app->request->post());
		return $this->render($update->process()->response());
	}
}