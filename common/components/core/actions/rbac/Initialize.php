<?php

namespace common\components\core\actions\rbac;


class Initialize extends \common\components\core\models\base\Action {


	public function run(){
		$auth = \Yii::$app->authManager;
		$auth->removeAll();
		$config = $this->getConfig();

		// правила
		foreach($config['rules'] as $name => $data){
			if(!isset($rules)) $rules = [];
			if(isset($data['class']) && !isset($rules[$name])){
				$rule = new $data['class'];
				$rule->name = $name;
				$auth->add($rule);
				$rules[$name] = $rule;
			}
		}

		// разрешения
		foreach($config['permissions'] as $name => $data){
			if(!isset($permissions)) $permissions = [];
			$permissions[$name] = $auth->createPermission($name);
			if(isset($rules[$name])){
				$permissions[$name]->ruleName = $rules[$name]->name;
			}
			$permissions[$name]->data = $data['data'];
			$permissions[$name]->description = $data['description'];
			$auth->add($permissions[$name]);
		}

		// роли
		foreach($config['roles'] as $name => $data){
			if(!isset($roles)) $roles = [];
			$roles[$name] = $auth->createRole($name);
			$roles[$name]->data = $data['data'];
			$roles[$name]->description = $data['description'];
			$auth->add($roles[$name]);
			if(isset($preview)){
				$auth->addChild($roles[$name], $preview);
			}
			foreach($data['permissions'] as $k => $permission){
				if(isset($permissions[$permission])){
					$auth->addChild($roles[$name], $permissions[$permission]);
				}
				$preview = $roles[$name];
			}
		}
		return true;
	}

	private function getConfig(){
		$core = \Yii::$app->get('core');
		$path = $core->getConfigPath() . '/rbac/';
		$config = ['roles' => [], 'rules' => [], 'permissions' => []];
		if($rbacPath = $core->getRbacPath()){
			if(is_array($rbacPath)){
				foreach($rbacPath as $key => $path){
					$path = \Yii::getAlias($path);
					foreach($config as $k => $array){
						$config[$k] = \yii\helpers\ArrayHelper::merge($config[$k], (require $path . $k . '.php'));
					}
				}
				return $config;
			}
			$path = \Yii::getAlias($rbacPath);
		}
		foreach($config as $k => $array){
			$config[$k] = (require $path . $k . '.php');
		}
		return $config;
	}
}