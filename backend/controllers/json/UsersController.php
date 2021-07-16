<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\user\Datatables;


class UsersController extends \backend\models\base\JsonController{


	public function actionGet(){
		$model = new Datatables(['allows' => ['id' => 'id', 'username' => 'username']]);
		$model->load(Yii::$app->request->post());
		return $this->render($model->process()->response());
	}
}
