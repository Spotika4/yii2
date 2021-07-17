<?php

namespace common\components\core\models\processors\user;


class Activate extends \common\components\core\models\base\processors\UpdateProcessor {


	public $token;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['token'],
		];
	}

	public function query(){
		return \common\components\core\models\ar\User::find()->from('{{%user}} u')->select(['u.*', 'o.value'])
			->leftJoin('{{%user_option}} o', 'o.user_id = u.id')->where(['o.key' => 'verification_token', 'o.value' => $this->token]);
	}

	public function beforeSave(){
		$this->object->setAttribute('status', \common\components\core\models\ar\User::STATUS_ACTIVE);
		$this->object->deleteOption('verification_token');
		if($this->object->save(false)){
			$this->addMessage(\Yii::t('core', 'user_activation_success'));
			return true;
		}
		return false;
	}
}
