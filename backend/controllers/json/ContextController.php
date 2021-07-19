<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\context\Datatables;


class ContextController extends \backend\models\base\JsonController{


	public function actionCreate(){
		$create = new \common\components\core\models\processors\context\Create();
		$create->load(Yii::$app->request->post());
		return $this->render($create->process()->response());
	}

	public function actionUpdate(){
		$update = new \common\components\core\models\processors\context\Update();
		$update->load(Yii::$app->request->post());
		return $this->render($update->process()->response());
	}

	public function actionDelete(){
		$delete = new \common\components\core\models\processors\context\Delete();
		$delete->load(Yii::$app->request->post());
		return $this->render($delete->process()->response());
	}

	public function actionDatatable(){
		$model = new Datatables(['allows' => ['id' => 'id', 'key' => 'key', 'name' => 'name']]);
		$model->load(Yii::$app->request->post());
		return $this->render($model->process()->response());
	}
}