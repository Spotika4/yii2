<?php

namespace common\components\core\models\ar;

use Yii;
use yii\web\Cookie;


class User extends \common\components\core\models\base\ActiveRecord implements \yii\web\IdentityInterface {


	const STATUS_DELETED = 0;
	const STATUS_INACTIVE = 9;
	const STATUS_ACTIVE = 10;


	public static function tableName(){
		return '{{%user}}';
	}

	public static function findIdentity($id){
		return static::find()
			->select(['id', 'username', 'password_hash', 'status', 'auth_key'])
			->where(['id' => $id, 'status' => self::STATUS_ACTIVE])->one();
	}

	public static function findIdentityByAccessToken($token, $type = null){
		throw new \yii\base\NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	public static function findByToken($key, $token, $validate = true){
		if($validate){
			if(!static::isTokenValid($token)){
				return null;
			}
		}
		return User::find()->from('{{%user}} u')->select(['u.*', 'o.value'])
			->leftJoin('{{%user_option}} o', 'o.user_id = u.id')
			->where(['o.key' => $key, 'o.value' => $token,])->one();
	}

	public static function isTokenValid($token){
		if(empty($token)){
			return false;
		}
		$timestamp = (int)substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.tokenExpire'];
		return $timestamp + $expire >= time();
	}

	public static function getStatuses(){
		return [
			User::STATUS_ACTIVE => Yii::t('core', 'active'),
			User::STATUS_INACTIVE => Yii::t('core', 'inactive'),
			User::STATUS_DELETED => Yii::t('core', 'deleted')
		];
	}

	public function behaviors(){
		return [
			[
				'class' => \yii\behaviors\TimestampBehavior::class,
				'attributes' => [
					self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					self::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
	}

	public function rules(){
		return [
			['auth_key', 'default', 'value' => Yii::$app->security->generateRandomString()],
			['status', 'default', 'value' => self::STATUS_INACTIVE],
		];
	}

	public static function find(){
		return new \common\components\core\models\query\UserQuery(get_called_class());
	}

	public function getAuthKey(){
		return $this->auth_key;
	}

	public function validateAuthKey($authKey){
		return $this->getAuthKey() === $authKey;
	}

	public function validatePassword($password){
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	public function setPassword($password = false){
		if($password == false){
			$password = (new \yii\base\Security())->generateRandomString(10);
		}
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
		return $password;
	}

	public function generateToken($key){
		$token = Yii::$app->security->generateRandomString() . '_' . time();
		if(!$this->setOption($key, $token)){
			return false;
		}
		return $token;
	}

	public function existOption($key){
		return User::find()->alias('u')->select(['o.value'])
			->leftJoin('{{%user_option}} o', 'o.user_id = u.id')
			->where(['o.key' => $key, 'u.id' => $this->getId()])->exists();
	}

	public function setOption($key, $value){
		if(!$option = $this->existOption($key)){
			$option = new UserOption(['user_id' => $this->getId(), 'key' => $key, 'value' => $value]);
			return $option->save();
		}
		return $this->updateOption($key, $value);
	}

	public function getOption($key){
		return $this->hasOne(UserOption::class, ['user_id' => $this->getId()])->where(['key' => $key]);
	}

	public function updateOption($key, $value){
		return UserOption::updateAll(['value' => $value], ['user_id' => $this->getId(), 'key' => $key]);
	}

	public function deleteOption($key){
		return UserOption::deleteAll(['user_id' => $this->getId(), 'key' => $key]);
	}

	public function deleteOptions($keys){
		return UserOption::deleteAll(['user_id' => $this->getId(), 'key' => $keys]);
	}

	public function setCookie($key, $value){
		Yii::$app->response->cookies->add(new Cookie([
			'httpOnly' => false, 'name' => $key, 'value' => $value
		]));
	}

	public function getCookie($key, $default = false){
		if(Yii::$app->request->cookies->has($key)){
			$default = Yii::$app->request->cookies->get($key)->value;
		}
		return $default;
	}
}