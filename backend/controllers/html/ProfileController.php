<?php

namespace backend\controllers\html;


class ProfileController extends \backend\models\base\HtmlController {


	public function actionIndex(){
		return $this->render('index', [
			'profile' => (new \common\components\core\models\processors\profile\Read())->process()->getData()
		]);
	}
}
