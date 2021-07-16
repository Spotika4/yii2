<?php

namespace common\components\core\models\processors\user;


class Reset extends \common\components\core\models\base\processors\UpdateProcessor {


	public $token;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['token'],
		];
	}

	public function rules(){
		return [
			[['token'], 'required'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\User::findByToken('verification_token', $this->token, false);
	}

	public function beforeSave(){
		$password = $this->object->setPassword();
		if($this->object->save(false)){
			$this->object->deleteOption('verification_token');
			$this->addMessage(\Yii::t('core/user', 'user_reset_success'));
			$params = ['user' => $this->object, 'password' => $password];
			$subject = \Yii::t('core/user', 'user_reset_title');
			if($this->object->send('passwordInfo', $params, $subject)){
				$this->addMessage(\Yii::t('core/user', 'user_send_reset_info_success'));
				return true;
			}
			$this->addMessage(\Yii::t('core', 'mail_send_error'));
		}
		return false;
	}
}
