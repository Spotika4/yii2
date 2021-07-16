<?php

namespace common\components\core\models\processors\user;


class Register extends \common\components\core\models\base\processors\CreateProcessor {


	public $username;
	public $email;
	protected $password;
	protected $class  ='common\components\core\models\ar\User';


	public function attributeLabels(){
		return [
			'username' => \Yii::t('core', 'user_lbl_username'),
			'email' => \Yii::t('core', 'user_lbl_email')
		];
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['username', 'email'],
		];
	}

	public function rules(){
		return [
			[['username', 'email'], 'required'],
			[['username', 'email'], 'trim'],

			['username', 'string', 'min' => 3, 'max' => 255],
			['username', 'unique', 'targetClass' => 'common\components\core\models\ar\User'],

			['email', 'email'],
			['email', 'string', 'min' => 6, 'max' => 255],
			['email', 'unique', 'targetClass' => 'common\components\core\models\ar\User'],
		];
	}

	public function beforeSave(){
		if($beforeSave = parent::beforeSave()){
			$this->object->setAttribute('username', $this->username);
			$this->object->setAttribute('email', $this->email);
			$this->password = $this->object->setPassword();
		}
		return $beforeSave;
	}

	public function afterSave(){
		if($role = \Yii::$app->authManager->getRole(\Yii::$app->params['default_role'])){
			\Yii::$app->authManager->assign($role, $this->object->getId());
		}
		$this->setAttributes(['username' => '', 'email' => '']);
		$this->addMessage(\Yii::t('core', 'user_register_success'));
		$params = ['user' => $this->object, 'password' => $this->password, 'token' => $this->object->generateToken('verification_token')];
		if($this->object->send('accountActivate', $params, \Yii::t('core', 'user_register_title'))){
			$this->addMessage(\Yii::t('core', 'user_send_register_info_success'));
			return true;
		}
		$this->addMessage(\Yii::t('core', 'mail_send_error'));
		return false;
	}
}
