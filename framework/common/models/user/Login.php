<?php

namespace common\models\user;


class Login extends \common\models\base\Model {


	public $username;
	public $password;


	public function rules(){
		return [
			[['username', 'password'], 'required'],
			[['username', 'password'], 'string']
		];
	}

	public function attributeLabels(){
		return [
			'username' => \Yii::t('app', 'username'),
			'password' => \Yii::t('app', 'password'),
		];
	}

	public function authKey(){
		if ($this->validate()) {
			$user = \common\models\User::findByUsername($this->username);
			if($user && $user->validatePassword($this->password)){
				return $user->getAttribute('auth_key');
			}
		}
		return false;
	}

	public function login() {
		if ($this->validate()) {
			$user = \common\models\User::findByUsername($this->username);
			if($user && $user->validatePassword($this->password)){
				return \Yii::$app->user->login($user);
			}
		}
		return false;
	}
}
