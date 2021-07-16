<?php

namespace common\components\core\models\processors\menu\tree;


class Listing extends \common\components\core\models\base\processors\ListingProcessor{


	public $menu_id;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['menu_id']
		];
	}

	public function rules(){
		return [
			[['menu_id'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_id', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['menu_id' => $this->menu_id])
			->orderBy(['sort' => 'ASC']);
	}
}