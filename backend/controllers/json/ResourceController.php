<?php

namespace backend\controllers\json;


class ResourceController extends \backend\models\base\JsonController{


	public function actionCreate(){
		$create = new \common\components\core\models\processors\resource\Create();
		$create->load(\Yii::$app->request->post());
		return $this->render($create->process()->response());
	}

	public function actionUpdate(){
		$update = new \common\components\core\models\processors\resource\Update();
		$update->load(\Yii::$app->request->post());
		return $this->render($update->process()->response());
	}

	public function actionDelete(){
		$delete = new \common\components\core\models\processors\resource\Delete();
		$delete->load(\Yii::$app->request->post());
		return $this->render($delete->process()->response());
	}

	public function actionTree(){
		$tree = new \common\components\core\models\processors\resource\Tree();
		$tree->load(\Yii::$app->request->post());
		return $this->render($tree->process()->response());
	}
}