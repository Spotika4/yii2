<?php

namespace common\components\core\models\processors\cache;


class Option extends \common\components\core\models\base\Processor{


	const SCENARIO_RUNTIMES = 'runtimes';

	public $context;


	public function default(){
		$this->addMessage(\Yii::t('core', 'success'));
		return true;
	}

	public function scenarios(){
		return [
			self::SCENARIO_RUNTIMES => ['context'],
		];
	}

	public function rules(){
		return [
			[['context'], 'required'],
		];
	}

	public function runtimes(){
		if($runtimes = \Yii::$app->get('core')->getRuntimes($this->context)){
			foreach($runtimes as $key => $alias){
				$runtimes[$key] = \Yii::t('core', 'runtime_' . $key . '_title');
			}
			return $runtimes;
		}
		$this->addMessage(\Yii::t('core', 'object_no_found'));
		return false;
	}
}