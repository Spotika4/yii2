<?php

namespace common\components\core\models\processors\menu\tree;


class Tree extends \common\components\core\models\base\processors\TreeProcessor{


	public $lexicon;
	public $menu_key;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['menu_key', 'lexicon']
		];
	}

	public function rules(){
		return [
			[['menu_key', 'lexicon'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_key', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_key' => $this->menu_key])
			->orderBy(['sort' => 'ASC']);
	}
}