<?php

namespace common\components\core\models\processors\menu;

use Yii;


class Update extends \common\components\core\models\base\processors\UpdateProcessor {


	public $key;
	public $name;
	protected $pk = 'key';
	protected $class  ='common\components\core\models\ar\Menu';


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['key', 'name'],
		];
	}

	public function rules(){
		return [
			[['key', 'name'], 'required'],
			[['key', 'name'], 'trim'],

			['name', 'string', 'min' => 3, 'max' => 255],
			['name', 'unique', 'targetClass' => 'common\components\core\models\ar\Menu', 'filter' => ['!=', 'key', $this->key]],
		];
	}

	public function attributeLabels(){
		return [
			'name' => Yii::t('core', 'title'),
		];
	}
}