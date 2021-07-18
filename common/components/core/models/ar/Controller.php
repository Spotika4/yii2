<?php

namespace common\components\core\models\ar;


class Controller extends \common\components\core\models\base\ActiveRecord {


	public static function tableName(){
		return '{{%controller}}';
	}

	public function rules(){
		return [
			[['context_id', 'parent', 'title', 'url'], 'required'],
			[['title', 'url'], 'string', 'min' => 1, 'max' => 255],
			['icon', 'default', 'value' => null],
			['sort', 'default', 'value' => 0],
		];
	}
}