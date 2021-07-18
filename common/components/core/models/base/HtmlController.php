<?php

namespace common\components\core\models\base;


class HtmlController extends Controller {


	public function beforeAction($action){
		if($beforeAction = parent::beforeAction($action)){
			if($core = $this->module->get('core', false)){
				$controller_url = $this->id . '/' . $this->action->id;
				if($core->controller = $core->getController($controller_url)){
					\Yii::$app->view->params['resource'] = $core->controller->toArray();
					$this->module->view->title = \Yii::t($core->context->key, $core->controller->title);
				}
			}
		}
		return $beforeAction;
	}


	public function ___beforeAction($action){
		if($beforeAction = parent::beforeAction($action)){
			$controller_id = $this->id . '_' . $this->action->id;
			$this->module->view->params['controller_id'] = $controller_id;
			if($yiicore = $this->module->get('yiicore', false)){
				$yiicore->controller_id = $controller_id;
			}
			if($yiinav = $this->module->get('yiinav', false)){
				$element = $yiinav->getElementMap($controller_id);
				$this->module->view->title = \Yii::t('yiinav/map', $element['title']);
			}
		}
		return $beforeAction;
	}
}