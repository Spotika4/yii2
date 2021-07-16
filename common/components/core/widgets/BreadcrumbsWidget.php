<?php

namespace common\components\core\widgets;


class BreadcrumbsWidget extends \yii\base\Widget{


	public $module = false;
 

	public function init(){
		parent::init();
		if(!$this->module){
			$this->module = \Yii::$app->controller->module;
		}
	}

	public function run(){
		if($core = $this->module->get('core', false)){
			$breadcrumbs = [];
			$resource_id = $core->resource->id;
			$home = $core->getHomeResource();
			if($home->id == $resource_id){
				return false;
			}
			while($parent = $this->getResource($resource_id)){
				$breadcrumb = $parent;
				array_unshift($breadcrumbs, $breadcrumb);
				$resource_id = $parent['parent'];
			}
			array_unshift($breadcrumbs, $core->getHomeResource());
			$viewFile = $this->module->getViewPath() . '/nav/breadcrumbs.php';
			return \Yii::$app->view->renderFile($viewFile, [
				'breadcrumbs' => $breadcrumbs,
			]);
		}
	}

	public function getResource($id){
		return \common\components\core\models\ar\Resource::find()
			->select(['id', 'context_id', 'parent', 'title', 'url', 'icon'])->where(['id' => $id])->asArray()->one();
	}
}