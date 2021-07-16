<?php

namespace common\components\core\models\ar;


class Context extends \common\components\core\models\base\ActiveRecord {


	public static function tableName(){
		return '{{%context}}';
	}

	public function rules(){
		return [
			[['key', 'name'], 'required'],
			[['key'], 'string', 'min' => 3, 'max' => 50],
			[['name'], 'string', 'min' => 3, 'max' => 255],
		];
	}
}
