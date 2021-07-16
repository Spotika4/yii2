<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\menu\tree\Create;
use common\components\core\models\processors\menu\tree\Update;
use common\components\core\models\processors\menu\tree\Delete;
use common\components\core\models\processors\menu\tree\Listing;
use common\components\core\models\processors\menu\tree\Tree;


class MenuTreeController extends \backend\models\base\JsonController{


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

	public function actionListing(){
		$update = new Listing();
		$update->load(Yii::$app->request->post());
		return $this->render($update->process()->response());
	}

	public function actionTree(){
		$tree = new Tree();
		$tree->load(Yii::$app->request->post());
		return $this->render($tree->process()->response());
	}
}