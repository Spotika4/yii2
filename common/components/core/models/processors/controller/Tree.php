<?php

namespace common\components\core\models\processors\controller;


class Tree extends \common\components\core\models\base\processors\TreeProcessor{


	public $lexicon;
	public $context_id;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['context_id', 'lexicon']
		];
	}

	public function rules(){
		return [
			[['context_id', 'lexicon'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\Controller::find()
			->select(['id', 'context_id', 'parent', 'title', 'url', 'icon', 'sort'])
			->where(['context_id' => $this->context_id])
			->orderBy(['sort' => 'ASC']);
	}
}