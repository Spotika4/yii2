<?php

namespace backend\controllers\json;


class ControllerController extends \backend\models\base\JsonController{


	public function actionCreate(){
		$create = new \common\components\core\models\processors\controller\Create();
		$create->load(\Yii::$app->request->post());
		return $this->render($create->process()->response());
	}

	public function actionUpdate(){
		$update = new \common\components\core\models\processors\controller\Update();
		$update->load(\Yii::$app->request->post());
		return $this->render($update->process()->response());
	}

	public function actionDelete(){
		$delete = new \common\components\core\models\processors\controller\Delete();
		$delete->load(\Yii::$app->request->post());
		return $this->render($delete->process()->response());
	}

	public function actionTree(){
		$tree = new \common\components\core\models\processors\controller\Tree();
		$tree->load(\Yii::$app->request->post());
		return $this->render($tree->process()->response());
	}
}