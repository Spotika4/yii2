<?php

namespace common\components\core\widgets;


class ListWidget extends \yii\base\Widget{


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
		$viewFile = $this->module->getViewPath() . '/nav/list.php';
		return \Yii::$app->view->renderFile($viewFile, [
			'key' => $this->key,
			'menu' => $this->getMenuTree(),
			'path' => $this->getNodesPath()
		]);
	}

	public function getMenuTree(){
		return $this->_getTree(0);
	}

	protected function _getTree($parent, $_depth = 0){
		$_depth = $_depth + 1;
		$nodes = \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_key', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_key' => $this->key, 'parent' => $parent])
			->indexBy('id')->asArray()->all();
		foreach($nodes as $k => $node){
			$nodes[$k]['display'] = \Yii::t($this->lexicon, $node['title']);
			if($this->depth == 0 || ($_depth < $this->depth)){
				$nodes[$k]['childs'] = $this->_getTree($node['id'], $_depth);
			}
		}
		return $nodes;
	}

	public function getNodesPath(){
		$path = [];
		$core = $this->module->get('core', false);
		if($current_node = $this->getNodeByUrl($core->controller->url)){
			$path[$current_node['id']] = $current_node;
			$resource_id = $current_node['parent'];
			while($node = $this->getNodeById($resource_id)){
				$path[$node['id']] = $node;
				$resource_id = $node['parent'];
				if($resource_id == 0) break;
			}
		}
		return $path;
	}

	public function getNodeByUrl($url){
		return \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'parent'])->where(['url' => $url, 'menu_key' => $this->key])
			->indexBy('id')->asArray()->one();
	}

	public function getNodeById($id){
		return \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'parent'])->where(['id' => $id])
			->indexBy('id')->asArray()->one();
	}
}