<?php

namespace frontend\models\base;


class HtmlController extends \common\components\core\models\base\HtmlController{


	public function behaviors(){
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => $this->module->params['allow_access']
					]
				]
			]
		];
	}
}