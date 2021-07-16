<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\context\Datatables;


class ContextsController extends \backend\models\base\JsonController{


	public function actionGet(){
		$model = new Datatables(['allows' => ['id' => 'id', 'key' => 'key', 'name' => 'name']]);
		$model->load(Yii::$app->request->post());
		return $this->render($model->process()->response());
	}
}
