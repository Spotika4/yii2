<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\resource\Create;
use common\components\core\models\processors\resource\Update;
use common\components\core\models\processors\resource\Delete;
use common\components\core\models\processors\resource\Listing;
use common\components\core\models\processors\resource\Tree;


class ResourceController extends \backend\models\base\JsonController{


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
		$delete = new Delete();
		$delete->load(Yii::$app->request->post());
		return $this->render($delete->process()->response());
	}

	public function actionListing(){
		$listing = new Listing();
		$listing->load(Yii::$app->request->post());
		return $this->render($listing->process()->response());
	}

	public function actionTree(){
		$listing = new Tree();
		$listing->load(Yii::$app->request->post());
		return $this->render($listing->process()->response());
	}
}