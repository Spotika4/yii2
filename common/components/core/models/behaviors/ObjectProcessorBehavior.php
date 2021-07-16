<?php

namespace common\components\core\models\behaviors;


class ObjectProcessorBehavior extends \yii\base\Behavior{


	public function events(){
		return [
			\common\components\core\models\base\Processor::EVENT_BEFORE_PROCESS => 'beforeProcess',
			\common\components\core\models\base\CreateProcessor::EVENT_BEFORE_SAVE_PROCESS => 'beforeSaveProcess',
			\common\components\core\models\base\CreateProcessor::EVENT_AFTER_SAVE_PROCESS => 'afterSaveProcess',
			\common\components\core\models\base\Processor::EVENT_AFTER_PROCESS => 'afterProcess',
		];
	}
}