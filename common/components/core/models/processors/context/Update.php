<?php

namespace common\components\core\models\processors\context;

use Yii;


class Update extends \common\components\core\models\base\UpdateProcessor {


	public $id;
	public $key;
	public $name;
	protected $class  ='common\components\core\models\ar\Context';


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['id', 'key', 'name'],
		];
	}

	public function rules(){
		return [
			[['id', 'key', 'name'], 'required'],
			[['id', 'key', 'name'], 'trim'],

			['key', 'string', 'min' => 3, 'max' => 50],
			['key', 'unique', 'targetClass' => 'common\components\core\models\ar\Context', 'filter' => ['!=', 'id', $this->id]],

			['name', 'string', 'min' => 3, 'max' => 255],
			['name', 'unique', 'targetClass' => 'common\components\core\models\ar\Context', 'filter' => ['!=', 'id', $this->id]],
		];
	}

	public function attributeLabels(){
		return [
			'key' => Yii::t('core/context', 'context_lbl_key'),
			'name' => Yii::t('core/context', 'context_lbl_name'),
		];
	}
}