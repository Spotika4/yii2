<?php

namespace common\components\core\models\processors\menu\tree;


class Update extends \common\components\core\models\base\processors\UpdateProcessor {


	public $id;
	public $menu_key;
	public $parent;
	public $title;
	public $url;
	public $icon;
	public $sort;
	protected $class  ='common\components\core\models\ar\MenuTree';


	public function rules(){
		return [
			[['id', 'menu_key', 'parent', 'title', 'url'], 'required'],
			[['menu_key', 'parent', 'title', 'url', 'icon'], 'trim'],

			['title', 'string', 'min' => 1, 'max' => 255],

			['url', 'string', 'min' => 1, 'max' => 255],

			['icon', 'string', 'max' => 255],
			['icon', 'default', 'value' => 'fas fa-file'],

			['sort', 'default', 'value' => 0],
		];
	}

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
			self::SCENARIO_DEFAULT => ['id', 'menu_key', 'parent', 'title', 'url', 'icon', 'sort'],
		];
	}
}