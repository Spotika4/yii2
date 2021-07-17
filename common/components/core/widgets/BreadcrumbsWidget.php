<?php

namespace common\components\core\widgets;


class BreadcrumbsWidget extends \yii\base\Widget{


	public $lexicon = 'core';
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
			$home = $core->getHomeResource();
			$home['display'] = \Yii::t($this->lexicon, $home['title']);

			$current = $core->resource->toArray();
			$current['display'] = \Yii::t($this->lexicon, $current['title']);
			array_unshift($breadcrumbs, $current);

			if($home['id'] == $current['id']){
				return false;
			}

			$resource_id = $current['parent'];
			while($parent = $this->getResource($resource_id)){
				$breadcrumb = $parent;
				$breadcrumb['display'] = \Yii::t($this->lexicon, $breadcrumb['title']);
				array_unshift($breadcrumbs, $breadcrumb);
				$resource_id = $parent['parent'];
			}

			array_unshift($breadcrumbs, $home);

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