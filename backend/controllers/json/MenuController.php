<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\menu\Create;
use common\components\core\models\processors\menu\Read;
use common\components\core\models\processors\menu\Update;
use common\components\core\models\processors\menu\Delete;
use common\components\core\models\processors\menu\Listing;
use common\components\core\models\processors\menu\Select;


class MenuController extends \backend\models\base\JsonController{


	public function actionCreate(){
		$create = new Create();
		$create->load(Yii::$app->request->post());
		return $this->render($create->process()->response());
	}

	public function actionRead(){
		$read = new Read();
		$read->load(Yii::$app->request->post());
		return $this->render($read->process()->response());
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
		$listing = new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]);
		$listing->load(Yii::$app->request->post());
		return $this->render($listing->process()->response());
	}
}