<?php

namespace backend\controllers\html;

use Yii;
use common\components\core\models\processors\menu\Listing;


class ContextsController extends \backend\models\base\HtmlController{


	public function actionIndex(){
		return $this->render('index');
	}

	public function actionCreate(){
		return $this->render('create', [
			'context' => [],
			'menus' => []
		]);
	}

	public function actionUpdate($id){
		$listing = new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]);
		$listing->load(['context_id' => $id, 'lexicon' => 'backend']);
		$menus = $listing->process()->getData();
		$read = new \common\components\core\models\processors\context\Read();
		if(($read->load(['id' => $id])) && ($read->process()->getSuccess())){
			return $this->render('update',
				[
					'menus' => $menus,
					'context' => $read->getData(),
				]);
		}
		throw new \yii\web\NotFoundHttpException(Yii::t('core', 'error_not_found_message'));
	}
}