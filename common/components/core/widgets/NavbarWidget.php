<?php

namespace common\components\core\widgets;


class NavbarWidget extends \yii\base\Widget{


	public $key;
	public $depth = 2;
	public $lexicon = 'core';
	public $module = false;


	public function init(){
		parent::init();
		if(!$this->module){
			$this->module = \Yii::$app->controller->module;
		}
	}

	public function run(){
		$viewFile = $this->module->getViewPath() . '/nav/navbar.php';
		return \Yii::$app->view->renderFile($viewFile, [
			'key' => $this->key,
			'menu' => $this->getMenuTree()
		]);
	}

	public function getMenuTree(){
		return $this->_getTree(0, $this->depth);
	}

	protected function _getTree($parent, $depth = 0, $_depth = 0){
		$_depth = $_depth + 1;
		$nodes = \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_key', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_key' => $this->key, 'parent' => $parent])
			->indexBy('id')->asArray()->all();
		foreach($nodes as $k => $node){
			$nodes[$k]['display'] = \Yii::t($this->lexicon, $node['title']);
			if($depth == 0 || ($_depth < $depth)){
				$nodes[$k]['childs'] = $this->_getTree($node['id'], $depth, $_depth);
			}
		}
		return $nodes;
	}
}