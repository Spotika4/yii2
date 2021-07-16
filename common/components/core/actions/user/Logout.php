<?php

namespace common\components\core\actions\user;


class Logout extends \common\components\core\models\base\Action {


	public function run(){
		return \Yii::$app->user->logout();
	}
}