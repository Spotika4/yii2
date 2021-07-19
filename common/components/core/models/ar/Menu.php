<?php

namespace common\components\core\models\ar;


class Menu extends \common\components\core\models\base\ActiveRecord {


	public static function tableName(){
		return '{{%menu}}';
	}

	public function rules(){
		return [
			[['context_key', 'key', 'name'], 'required'],
			[['name', 'key'], 'string', 'min' => 3, 'max' => 255],
		];
	}
}
