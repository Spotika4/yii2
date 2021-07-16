<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\menu\Listing;


class MenuController extends \backend\models\base\JsonController{


	public function actionCreate(){
		$create = new \common\components\core\models\processors\menu\Create();
		$create->load(Yii::$app->request->post());
		return $this->render($create->process()->response());
	}

	public function actionRead(){
		$read = new \common\components\core\models\processors\menu\Read();
		$read->load(Yii::$app->request->post());
		return $this->render($read->process()->response());
	}

	public function actionUpdate(){
		$update = new \common\components\core\models\processors\menu\Update();
		$update->load(Yii::$app->request->post());
		return $this->render($update->process()->response());
	}

	public function actionDelete(){
		$delete = new \common\components\core\models\processors\menu\Delete();
		$delete->load(Yii::$app->request->post());
		return $this->render($delete->process()->response());
	}

	public function actionListing(){
		$listing = new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]);
		$listing->load(Yii::$app->request->post());
		return $this->render($listing->process()->response());
	}
}