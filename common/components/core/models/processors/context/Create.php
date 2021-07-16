<?php

namespace common\components\core\models\processors\context;

use Yii;


class Create extends \common\components\core\models\base\processors\CreateProcessor {


	public $key;
	public $name;
	protected $class  ='common\components\core\models\ar\Context';


	public function attributeLabels(){
		return [
			'key' => Yii::t('core/context', 'context_lbl_key'),
			'name' => Yii::t('core/context', 'context_lbl_name'),
		];
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['key', 'name'],
		];
	}

	public function rules(){
		return [
			[['key', 'name'], 'required'],
			[['key', 'name'], 'trim'],

			['key', 'string', 'min' => 3, 'max' => 50],
			['key', 'unique', 'targetClass' => 'common\components\core\models\ar\Context'],

			['name', 'string', 'min' => 3, 'max' => 255],
			['name', 'unique', 'targetClass' => 'common\components\core\models\ar\Context'],
		];
	}

	public function afterSave(){
		$create = new \common\components\core\models\processors\context\map\Create();
		$create->load([
			'context_id' => $this->object->id,
			'key' => 'index_default',
			'parent' => '#',
			'icon' => 'fas fa-file',
			'url' => '#',
			'title' => 'Home'
		]);
		return $create->process()->getSuccess();
	}
}
