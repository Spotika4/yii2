<?php

namespace common\components\core\models\processors\user;


class Login extends \common\components\core\models\base\Processor {


	public $username;
	public $password;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['username', 'password']
		];
	}

	public function rules(){
		return [
			[['username', 'password'], 'required'],
			[['username', 'password'], 'string'],
		];
	}

	public function attributeLabels(){
		return [
			'username' => \Yii::t('core', 'user_lbl_username'),
			'password' => \Yii::t('core', 'user_lbl_password'),
		];
	}

	public function default(){
		$condition = ['username' => $this->username, 'status' => \common\components\core\models\ar\User::STATUS_ACTIVE];
		$user = \common\components\core\models\ar\User::find()->where($condition)->one();
		if($user && $user->validatePassword($this->password)){
			return \Yii::$app->user->login($user, 0);
		}
		$this->addMessage(\Yii::t('core', 'user_login_error'));
		return false;
	}
}