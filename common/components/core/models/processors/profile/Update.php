<?php

namespace common\components\core\models\processors\profile;

use Yii;
use common\components\core\models\ar\User;


class Update extends \common\components\core\models\base\Processor {


	const SCENARIO_PASSWORD_UPDATE = 'password';
	const SCENARIO_EMAIL_UPDATE = 'email';
	const SCENARIO_EMAIL_ACTIVATE = 'emailActivate';

	public $email;
	public $password;
	public $passwordr;
	public $token;


	public function scenarios(){
		return [
			self::SCENARIO_PASSWORD_UPDATE => ['password', 'passwordr'],
			self::SCENARIO_EMAIL_UPDATE => ['email'],
			self::SCENARIO_EMAIL_ACTIVATE => ['token'],
		];
	}

	public function rules(){
		return [
			[['email'], 'required'],
			['email', 'email'],
			['email', 'string', 'min' => 6, 'max' => 255],
			['email', 'unique', 'targetClass' => 'common\components\core\models\ar\User', 'filter' => ['!=', 'id', Yii::$app->user->identity->getId()]],
			['email', 'unique', 'targetClass' => 'common\components\core\models\ar\User',
				'filter' => ['=', 'id', Yii::$app->user->identity->getId()],
				'message' => Yii::t('core/user', 'user_email_need_new'),
			],

			[['password', 'passwordr'], 'required'],
			['password', 'string', 'min' => 6, 'max' => 255],
			['passwordr', 'string', 'min' => 6, 'max' => 255],
			['passwordr', 'compare', 'compareAttribute' => 'password'],

			[['token'], 'required'],
			[['token'], 'string'],
		];
	}

	public function attributeLabels(){
		return [
			'email' => Yii::t('core/user', 'user_lbl_email'),
			'password' => Yii::t('core/user', 'user_lbl_password'),
			'passwordr' => Yii::t('core/user', 'user_lbl_passwordr'),
		];
	}

	public function email(){
		if($user = User::findOne(['id' => Yii::$app->user->identity->getId()])){
			$user->setOption('email_reset', $this->email);
			$token = $user->generateToken('email_reset_token');
			$params = ['user' => $user, 'token' => $token];
			$subject = Yii::t('core/user', 'user_email_update_info_subject');
			if($user->send('emailUpdate', $params, $subject)){
				$this->addMessage(Yii::t('core/user', 'user_email_check_send_success'));
				return true;
			}
			$this->addMessage(\Yii::t('core', 'mail_send_error'));
		}
		return false;
	}

	public function emailActivate(){
		if($user = User::findByToken('email_reset_token', $this->token, false)){
			$option = $user->getOption('email_reset')->asArray()->one();
			$user->setAttribute('email', $option['value']);
			if($user->save(false)){
				$user->deleteOption('email_reset');
				$user->deleteOption('email_reset_token');
				$this->addMessage(Yii::t('core/user', 'user_email_activation_success'));
				return true;
			}
		}
		return false;
	}

	public function password(){
		if($user = User::findOne(['id' => Yii::$app->user->identity->getId()])){
			$user->setPassword($this->password);
			if($user->save(false)){
				$this->addMessage(Yii::t('core/user', 'user_change_pass_success'));
				return true;
			}
		}
		return false;
	}
}