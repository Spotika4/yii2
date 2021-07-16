<?php

namespace common\components\core\models\ar;


class UserOption extends \common\components\core\models\base\ActiveRecord {


	public static function tableName(){
		return '{{%user_option}}';
	}

	public function rules(){
		return [
			[['user_id', 'key', 'value'], 'required'],
			[['user_id', 'key', 'value'], 'trim'],
			[['key', 'value'], 'string', 'min' => 3, 'max' => 255],
		];
	}
}
