<?php

namespace spotika4\yiinav\widgets;


class ListWidget extends \yii\base\Widget{


	public $id;
	public $module;


	public function init(){
		parent::init();
		if(!$this->module){
			$this->module = \Yii::$app->controller->module;
		}
	}

	public function run(){
		$component = $this->module->get('yiinav');
		return $this->module->view->renderFile($this->module->getViewPath() . '/yiinav/' . $this->id . '.php', [
			'map' => $component->getMap(),
			'menu' => $component->getMenu($this->id)
		]);
	}
}