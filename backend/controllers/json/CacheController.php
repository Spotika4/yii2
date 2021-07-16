<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\cache\Clear;
use common\components\core\models\processors\cache\Option;


class CacheController extends \backend\models\base\JsonController{


	public function actionClear(){
		$clear = new Clear();
		$clear->load(Yii::$app->request->post());
		return $this->render($clear->process()->response());
	}

	public function actionRuntimes(){
		$clear = new Option(['scenario' => Option::SCENARIO_RUNTIMES]);
		$clear->load(Yii::$app->request->post());
		return $this->render($clear->process()->response());
	}
}