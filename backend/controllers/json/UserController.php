<?php

namespace backend\controllers\json;

use Yii;
use common\components\core\models\processors\user\Login;
use common\components\core\models\processors\user\Create;
use common\components\core\models\processors\user\Recovery;
use common\components\core\models\processors\user\Update;
use common\components\core\models\processors\user\Delete;


class UserController extends \backend\models\base\JsonController{



	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'][] = [
			'allow' => true,
			'actions' => ['login', 'recovery', 'register', 'logout'],
		];
		return $behaviors;
	}

	public function actions(){
		return [
			'login' => \common\components\core\actions\user\Login::class,
			'recovery' => \common\components\core\actions\user\Recovery::class,
			'register' => \common\components\core\actions\user\Register::class,
			'logout' => \common\components\core\actions\user\Logout::class,
		];
	}

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
}