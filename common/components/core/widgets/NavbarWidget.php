<?php

namespace common\components\core\widgets;


class NavbarWidget extends \yii\base\Widget{


	public $id;
	public $module = false;


	public function init(){
		parent::init();
		if(!$this->module){
			$this->module = \Yii::$app->controller->module;
		}
	}

	public function run(){
		$viewFile = $this->module->getViewPath() . '/nav/navbar.php';
		$core = $this->module->get('core');
		return \Yii::$app->view->renderFile($viewFile, [
			'id' => $this->id,
			'menu' => $this->getMenuTree()
		]);
	}

	public function getMenuTree(){
		$tree = [];
		$root = \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_id', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_id' => $this->id, 'parent' => 0])->asArray()->all();
		foreach($root as $node){
			$tree[$node['id']] = $node;
			$tree[$node['id']]['childs'] = $this->getChilds($node['id']);
		}
		return $tree;
	}

	public function getChilds($parent){
		$childs = \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_id', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_id' => $this->id, 'parent' => $parent])->asArray()->all();
		return $childs;
	}
}