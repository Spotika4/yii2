<?php

namespace common\components\core\models\processors\menu\tree;


class Read extends \common\components\core\models\base\processors\ReadProcessor{


	public $id;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['id']
		];
	}

	public function rules(){
		return [
			[['id'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\MenuTree::find()
			->select(['id', 'menu_key', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['id' => $this->id]);
	}
}