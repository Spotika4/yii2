<?php

namespace frontend\models\base;


class JsonController extends \common\components\core\models\base\JsonController {


	public function behaviors(){
		$behaviors = parent::behaviors();
		$behaviors['access'] = [
			'class' => \yii\filters\AccessControl::class,
			'rules' => [
				[
					'allow' => true,
					'roles' => $this->module->params['allow_access']
				]
			]
		];
		return $behaviors;
	}
}