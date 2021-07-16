<?php

namespace common\components\core\models\processors\menu;

use Yii;


class Update extends \common\components\core\models\base\processors\UpdateProcessor {


	public $id;
	public $context_id;
	public $name;
	protected $class  ='common\components\core\models\ar\Menu';


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['id', 'context_id', 'name'],
		];
	}

	public function rules(){
		return [
			[['id', 'context_id', 'name'], 'required'],
			[['id', 'context_id', 'name'], 'trim'],

			['name', 'string', 'min' => 3, 'max' => 255],
			['name', 'unique', 'targetClass' => 'common\components\core\models\ar\Menu', 'filter' => ['!=', 'id', $this->id]],
		];
	}

	public function attributeLabels(){
		return [
			'name' => Yii::t('core', 'title'),
		];
	}
}