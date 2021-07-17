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
		return \Yii::$app->view->renderFile($viewFile, [
			'id' => $this->id,
			'menu' => $this->getMenuTree()
		]);
	}

	public function getMenuTree(){
		return $this->_getTree(0, 2);
	}

	protected function _getTree($parent, $depth = 0, $_depth = 0){
		$_depth = $_depth + 1;
		$nodes = \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_id', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_id' => $this->id, 'parent' => $parent])
			->indexBy('id')->asArray()->all();
		if($depth == 0 || ($_depth < $depth)){
			foreach($nodes as $k => $node){
				$nodes[$k]['childs'] = $this->_getTree($node['id'], $depth, $_depth);
			}
		}
		return $nodes;
	}
}