<?php

namespace common\components\core\models\base;


class HtmlController extends Controller {


	public function beforeAction($action){
		if($beforeAction = parent::beforeAction($action)){
			if($core = $this->module->get('core', false)){
				$controller_url  = ($this->id == 'default') ? '/' : $this->id . '/';
				$controller_url .= ($this->action->id == 'index') ? '' : $this->action->id;
				if($core->controller = $core->getController($controller_url)){
					\Yii::$app->view->params['controller'] = $core->controller->toArray();
					$this->module->view->title = \Yii::t($core->context->key, $core->controller->title);
				}
			}
		}
		return $beforeAction;
	}
}