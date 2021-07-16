<?php

namespace common\components\core\models\processors\user;


class Read extends \common\components\core\models\base\processors\ReadProcessor{


	public $id;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['id']
		];
	}

	public function rules(){
		return [
			[['id'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\User::find()
			->select(['user.id', 'user.username', 'user.email', 'user.status', 'aa.item_name as role'])
			->leftJoin('{{%auth_assignment}} aa', 'aa.user_id = user.id')
			->leftJoin('{{%auth_item}} ai', 'ai.name = aa.item_name')
			->where(['ai.type' => \yii\rbac\Role::TYPE_ROLE, 'user.id' => $this->id]);
	}
}