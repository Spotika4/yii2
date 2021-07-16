<?php

namespace backend\controllers\html;

use Yii;
use common\components\core\models\ar\User;
use common\components\core\models\processors\role\Listing;


class UsersController extends \backend\models\base\HtmlController{


	public function actionIndex(){
		return $this->render('index');
	}

	public function actionCreate(){
		return $this->render('create', [
			'user' => [],
			'statuses' => User::getStatuses(),
			'roles' => (new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]))->process()->getData()
		]);
	}

	public function actionUpdate($id){
		$read = new \common\components\core\models\processors\user\Read();
		if(($read->load(['id' => $id])) && ($read->process()->getSuccess())){
			return $this->render('update',
				[
					'user' => $read->getData(),
					'statuses' => User::getStatuses(),
					'roles' => (new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]))->process()->getData()
				]);
		}
		throw new \yii\web\NotFoundHttpException(Yii::t('core', 'error_not_found_message'));
	}
}