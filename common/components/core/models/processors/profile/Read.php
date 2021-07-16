<?php

namespace common\components\core\models\processors\profile;


class Read extends \common\components\core\models\base\ReadProcessor {


	public function query(){
		return \common\components\core\models\ar\User::find()
			->select(['id', 'username', 'email'])
			->where(['id' => \Yii::$app->user->identity->getId()]);
	}
}