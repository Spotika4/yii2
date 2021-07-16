<?php

namespace common\components\core\models\processors\user;

use Yii;
use common\components\core\models\ar\User;
use common\components\core\models\processors\role\Listing;


class Update extends \common\components\core\models\base\UpdateProcessor {


	public $id;
	public $username;
	public $email;
	public $password;
	public $passwordr;
	public $role;
	public $status;
	protected $class  ='common\components\core\models\ar\User';


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['id', 'username', 'email', 'password', 'passwordr', 'role', 'status'],
		];
	}

	public function rules(){
		return [
			[['id', 'username', 'email', 'role', 'status'], 'required'],

			['password', 'string', 'max' => 255],
			['passwordr', 'string', 'max' => 255],
			['passwordr', 'compare', 'compareAttribute' => 'password'],

			['email', 'email'],
			['email', 'string', 'min' => 6, 'max' => 255],
			['email', 'unique', 'targetClass' => 'common\components\core\models\ar\User', 'filter' => ['!=', 'id', $this->id]],

			['role', 'in', 'range' => array_keys((new Listing(['scenario' => Listing::SCENARIO_FOR_SELECT]))->process()->getData())],

			['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_DELETED]],
		];
	}

	public function attributeLabels(){
		return [
			'id' => Yii::t('core', 'user_lbl_id'),
			'email' => Yii::t('core', 'user_lbl_email'),
			'password' => Yii::t('core', 'user_lbl_password'),
			'passwordr' => Yii::t('core', 'user_lbl_passwordr'),
			'role' => Yii::t('core', 'user_lbl_role'),
			'status' => Yii::t('core', 'user_lbl_status'),
		];
	}

	public function beforeSave(){
		$this->object->load($this->getAttributes(['username', 'email', 'status']));
		if(!empty($this->password)){
			$this->object->setPassword($this->password);
		}
		return true;
	}

	public function afterSave(){
		$auth = Yii::$app->authManager;
		$auth->revokeAll($this->object->getId());
		if($role = $auth->getRole($this->role)){
			return $auth->assign($role, $this->object->getId());
		}
	}
}