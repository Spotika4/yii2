<?php

namespace common\components\core\models\processors\menu\tree;


class Tree extends \common\components\core\models\base\processors\TreeProcessor{


	public $lexicon;
	public $menu_id;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['menu_id', 'lexicon']
		];
	}

	public function rules(){
		return [
			[['menu_id', 'lexicon'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_id', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_id' => $this->menu_id])
			->orderBy(['sort' => 'ASC']);
	}
}