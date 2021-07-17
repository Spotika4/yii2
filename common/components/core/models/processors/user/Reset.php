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
		return \common\components\core\models\ar\User::find()->from('{{%user}} u')->select(['u.*', 'o.value'])
			->leftJoin('{{%user_option}} o', 'o.user_id = u.id')->where(['o.key' => 'verification_token', 'o.value' => $this->token]);
	}

	public function beforeSave(){
		$password = $this->object->setPassword();
		$this->object->setAttribute('status', \common\components\core\models\ar\User::STATUS_ACTIVE);
		$this->object->deleteOption('verification_token');
		if($this->object->save(false)){
			$this->addMessage(\Yii::t('core', 'user_reset_success'));

			$params = ['user' => $this->object, 'password' => $password];
			$subject = \Yii::t('core', 'user_reset_title');
			if(\Yii::$app->get('core')->sendMail($this->object->email, $subject, 'passwordInfo', $params)){
				$this->addMessage(\Yii::t('core', 'user_send_reset_info_success'));
				return true;
			}
			$this->addMessage(\Yii::t('core', 'mail_send_error'));
		}
		return false;
	}
}
