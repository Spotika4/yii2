<?php

namespace common\components\core\models\processors\user;


class Recovery extends \common\components\core\models\base\UpdateProcessor {


	public $email;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['email'],
		];
	}

	public function rules(){
		return [
			[['email'], 'required'],
			['email', 'email'],
			['email', 'exist', 'targetClass' => 'common\components\core\models\ar\User'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\User::find()->select(['id', 'email'])
			->where(['email' => $this->email, 'status' => \common\components\core\models\ar\User::STATUS_ACTIVE]);
	}

	public function beforeSave(){
		$token = $this->object->generateToken('verification_token');
		$params = ['user' => $this->object, 'token' => $token];
		$subject = \Yii::t('core', 'user_recovery_title');
		if($this->object->send('passwordRecovery', $params, $subject)){
			$this->addMessage(\Yii::t('core', 'user_send_reset_success'));
			return true;
		}
		$this->addMessage(\Yii::t('core', 'mail_send_error'));
		return false;
	}
}
