<?php

namespace common\components\core\models\processors\menu;

use Yii;


class Create extends \common\components\core\models\base\processors\CreateProcessor {


	public $context_key;
	public $key;
	public $name;
	protected $class  ='common\components\core\models\ar\Menu';


	public function attributeLabels(){
		return [
			'name' => Yii::t('core', 'title'),
			'key' => Yii::t('core', 'key'),
		];
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['context_key', 'name', 'key'],
		];
	}

	public function rules(){
		return [
			[['context_key', 'name'], 'required'],
			[['context_key', 'name'], 'trim'],

			['key', 'string', 'min' => 3, 'max' => 255],
			['key', 'unique', 'targetClass' => 'common\components\core\models\ar\Menu'],

			['name', 'string', 'min' => 3, 'max' => 255],
			['name', 'unique', 'targetClass' => 'common\components\core\models\ar\Menu'],
		];
	}
}
