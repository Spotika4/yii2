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
		$read = new \common\components\core\models\processors\context\Read();
		if(($read->load(['id' => $id])) && ($read->process()->getSuccess())){
			$context = $read->getData();
			$listing = new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]);
			$listing->load(['context_key' => $context['key'], 'lexicon' => 'backend']);
			$menus = $listing->process()->getData();
			return $this->render('update',
				[
					'menus' => $menus,
					'context' => $context,
				]);
		}
		throw new \yii\web\NotFoundHttpException(Yii::t('core', 'error_not_found_message'));
	}
}