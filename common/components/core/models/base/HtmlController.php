<?php

namespace common\components\core\models\base;


class HtmlController extends Controller {


	public function beforeAction($action){
		if($beforeAction = parent::beforeAction($action)){
			if($core = $this->module->get('core', false)){
				if($core->resource){
					$this->module->view->title = \Yii::t($core->context->key, $core->resource->title);
				}
			}
		}
		return $beforeAction;
	}
}