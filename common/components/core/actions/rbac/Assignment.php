<?php

namespace common\components\core\actions\rbac;


class Assignment extends \common\components\core\models\base\Action {


	public function run(){
		$yiicore = \Yii::$app->get('core');
		$path = $yiicore->getConfigPath() . '/rbac/';
		$config['users'] = (require $path . 'users.php');
		$auth = \Yii::$app->authManager;
		foreach($config['users'] as $key => $data){
			if($user = \common\components\core\models\ar\User::findOne(['username' => $data['username']])){
				$auth->revokeAll($user->getId());
			}else{
				$user = new \common\components\core\models\ar\User();
				$user->setAttributes($data);
				$user->setPassword($data['password']);
				$user->setAttribute('username', $data['username']);
				$user->setAttribute('email', $data['email']);
				$user->save();
			}
			foreach($data['roles'] as $k => $roleName){
				if($role = $auth->getRole($roleName)){
					$auth->assign($role, $user->getId());
				}
			}
		}
		return true;
	}
}