<?php

namespace common\models\base;


class ActiveRecord extends \yii\db\ActiveRecord {


	const SCENARIO_CREATE = 'create';
	const SCENARIO_UPDATE = 'update';


	public function scenarios(){
		return \yii\helpers\ArrayHelper::merge(parent::scenarios(), [
			self::SCENARIO_DEFAULT => [],
			self::SCENARIO_CREATE => [],
			self::SCENARIO_UPDATE => [],
		]);
	}
}
