<?php

namespace common\components\core\models\processors\menu;

use Yii;


class Create extends \common\components\core\models\base\CreateProcessor {


	public $context_id;
	public $name;
	protected $class  ='common\components\core\models\ar\Menu';


	public function attributeLabels(){
		return [
			'name' => Yii::t('core', 'ешеду'),
		];
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['context_id', 'name'],
		];
	}

	public function rules(){
		return [
			[['context_id', 'name'], 'required'],
			[['context_id', 'name'], 'trim'],

			['name', 'string', 'min' => 3, 'max' => 255],
			['name', 'unique', 'targetClass' => 'common\components\core\models\ar\Menu'],
		];
	}
}
