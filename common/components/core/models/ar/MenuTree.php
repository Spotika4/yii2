<?php

namespace common\components\core\models\ar;


class MenuTree extends \common\components\core\models\base\ActiveRecord {


	public static function tableName(){
		return '{{%menu_tree}}';
	}

	public function rules(){
		return [
			[['menu_key', 'parent', 'url'], 'required'],
			[['url'], 'string', 'min' => 1, 'max' => 255],
			['title', 'default', 'value' => null],
			['icon', 'default', 'value' => null],
			['sort', 'default', 'value' => 0],
		];
	}
}