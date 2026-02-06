<?php

namespace common\actions\rbac;


class Initialize extends \common\models\base\Action {


	public function run(){
		$auth = \Yii::$app->authManager;
		$auth->removeAll();

		// правила
		$rules = [];
		foreach(\Yii::$app->params['rbac']['rules'] as $name => $data){
			if(isset($data['class']) && !isset($rules[$name])){
				$rule = new $data['class'];
				$rule->name = $name;
				$auth->add($rule);
				$rules[$name] = $rule;
			}
		}

		// разрешения
		$permissions = [];
		foreach(\Yii::$app->params['rbac']['permissions'] as $name => $data){
			$permissions[$name] = $auth->createPermission($name);
			if(isset($rules[$name])){
				$permissions[$name]->ruleName = $rules[$name]->name;
			}
			$permissions[$name]->data = $data['data'];
			$permissions[$name]->description = $data['description'];
			$auth->add($permissions[$name]);
		}

		// роли
		$roles = [];
		foreach(\Yii::$app->params['rbac']['roles'] as $name => $data){
			$roles[$name] = $auth->createRole($name);
			$roles[$name]->data = $data['data'];
			$roles[$name]->description = $data['description'];
			$auth->add($roles[$name]);
			if(isset($preview)){
				$auth->addChild($roles[$name], $preview);
			}
			foreach($data['permissions'] as $k => $permission){
				if(isset($permissions[$permission])){
					if(!$auth->hasChild($roles[$name], $permissions[$permission])){
						$auth->addChild($roles[$name], $permissions[$permission]);
					}
				}
			}
			$preview = $roles[$name];
		}
		return true;
	}
}