<?php

namespace api\controllers;


class RoleController extends \common\models\base\rest\ActiveController {


	public $modelClass = 'common\models\Role';


	public function actions(){
		$actions = parent::actions();
		unset($actions['index']['dataFilter']);
		$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
		return $actions;
	}

	public function prepareDataProvider(){
		$search = new \common\models\role\Search();
		$search->load(\Yii::$app->request->getQueryParams(), 'filter');
		return $search->search();
	}
}
