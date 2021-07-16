<?php

namespace common\components\core\models\processors\role;


class Listing extends \common\components\core\models\base\Processor {


	const SCENARIO_FOR_SELECT = 'select';


	public function scenarios(){
		return [
			self::SCENARIO_FOR_SELECT => [],
		];
	}

	public function select(){
		$result = (new \yii\db\Query())->from('{{%auth_item}}')->select(['name', 'data'])->where(['type' => 1])->all();
		foreach($result as $k => $role){
			$data = unserialize($role['data']);
			$roles[$role['name']] = \Yii::t('core/roles', $data['label']);
		}
		return (isset($roles)) ? $roles : [];
	}
}