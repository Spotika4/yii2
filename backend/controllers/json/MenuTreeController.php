<?php

namespace backend\controllers\json;


class MenuTreeController extends \backend\models\base\JsonController{


	public function actionCreate(){
		$create = new \common\components\core\models\processors\menu\tree\Create();
		$create->load(\Yii::$app->request->post());
		return $this->render($create->process()->response());
	}

	public function actionUpdate(){
		$update = new \common\components\core\models\processors\menu\tree\Update();
		$update->load(\Yii::$app->request->post());
		return $this->render($update->process()->response());
	}

	public function actionDelete(){
		$delete = new \common\components\core\models\processors\menu\tree\Delete();
		$delete->load(\Yii::$app->request->post());
		return $this->render($delete->process()->response());
	}

	public function actionListing(){
		$listing = new \common\components\core\models\processors\menu\tree\Listing();
		$listing->load(\Yii::$app->request->post());
		return $this->render($listing->process()->response());
	}

	public function actionTree(){
		$tree = new \common\components\core\models\processors\menu\tree\Tree();
		$tree->load(\Yii::$app->request->post());
		return $this->render($tree->process()->response());
	}
}