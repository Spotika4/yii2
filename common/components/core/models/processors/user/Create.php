<?php

namespace common\components\core\models\processors\user;

use Yii;
use common\components\core\models\ar\User;
use common\components\core\models\processors\role\Listing;


class Create extends \common\components\core\models\base\processors\CreateProcessor {


	const SCENARIO_ACCOUNT_ACTIVATE = 'activate';

	public $username;
	public $email;
	public $password;
	public $passwordr;
	public $role;
	public $status;
	protected $class  ='common\components\core\models\ar\User';


	public function attributeLabels(){
		return [
			'username' => Yii::t('core', 'user_lbl_username'),
			'email' => Yii::t('core', 'user_lbl_email'),
			'password' => Yii::t('core', 'user_lbl_password'),
			'passwordr' => Yii::t('core', 'user_lbl_passwordr'),
			'role' => Yii::t('core', 'user_lbl_role'),
			'status' => Yii::t('core', 'user_lbl_status'),
		];
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['username', 'email', 'password', 'passwordr', 'role', 'status'],
		];
	}

	public function rules(){
		return [
			[['username', 'email', 'password', 'passwordr', 'role', 'status', 'token'], 'required'],
			[['username', 'email', 'token'], 'trim'],
			[['status'], 'integer'],

			['username', 'string', 'min' => 3, 'max' => 255],
			['username', 'unique', 'targetClass' => 'common\components\core\models\ar\User'],

			['email', 'email'],
			['email', 'string', 'min' => 6, 'max' => 255],
			['email', 'unique', 'targetClass' => 'common\components\core\models\ar\User'],

			['password', 'string', 'min' => 6],
			['passwordr', 'compare', 'compareAttribute' => 'password'],

			['role', 'in', 'range' => array_keys((new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]))->process()->getData())],

			['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_DELETED]],
		];
	}

	public function beforeSave(){
		$this->object->setAttributes($this->getAttributes(['username', 'email', 'status']), false);
		$this->object->setPassword($this->password);
		return true;
	}

	public function afterSave(){
		$auth = \Yii::$app->authManager;
		if($role = $auth->getRole($this->role)){
			return $auth->assign($role, $this->object->getId());
		}
	}
}
