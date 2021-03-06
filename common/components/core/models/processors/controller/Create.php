<?php

namespace common\components\core\models\processors\controller;


class Create extends \common\components\core\models\base\processors\CreateProcessor {


	public $context_id;
	public $parent;
	public $title;
	public $url;
	public $icon;
	public $sort;
	protected $class  = 'common\components\core\models\ar\Controller';


	public function attributeLabels(){
		return [
			'parent' => \Yii::t('core', 'parent'),
			'title' => \Yii::t('core', 'title'),
			'url' => \Yii::t('core', 'url'),
			'icon' => \Yii::t('core', 'icon'),
			'sort' => \Yii::t('core', 'sort'),
		];
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['context_id', 'parent', 'title', 'url', 'icon', 'sort'],
		];
	}

	public function rules(){
		return [
			[['context_id', 'parent', 'title', 'url'], 'required'],

			['title', 'string', 'min' => 1, 'max' => 255],
			['url', 'string', 'min' => 1, 'max' => 255],

			['icon', 'string', 'max' => 255],
			['icon', 'default', 'value' => 'fas fa-file'],

			['sort', 'default', 'value' => 0],
		];
	}
}
