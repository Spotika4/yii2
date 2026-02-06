<?php

namespace common\actions\rbac;


class Assignment extends \common\models\base\Action {


	public function run(){
		$auth = \Yii::$app->authManager;
		foreach(\Yii::$app->params['rbac']['users'] as $key => $data){
			if($user = \common\models\User::findOne(['username' => $data['username']])){
				$auth->revokeAll($user->getId());
			}else{
				$user = new \common\models\User();
				$user->setAttributes($data);
				$user->setPassword($data['password']);
				$user->setAttribute('username', $data['username']);
				$user->setAttribute('email', $data['email']);
				$user->generateAuthKey();
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
