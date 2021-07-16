<?php

namespace common\components\core\models\processors\cache;


class Clear extends \common\components\core\models\base\Processor{


	public $context;
	public $runtimes;


	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['context', 'runtimes'],
		];
	}

	public function rules(){
		return [
			[['context', 'runtimes'], 'required'],
			[['runtimes'], \common\components\core\models\validators\ArrayValidator::class],
		];
	}

	public function default(){
		if(\Yii::$app->cache->flush()){
			if($runtimes = \Yii::$app->get('core')->getRuntimes($this->context)){
				foreach($this->runtimes as $k => $key){
					if(isset($runtimes[$key])){
						$directory = \Yii::getAlias($runtimes[$key]);
						\yii\helpers\FileHelper::removeDirectory($directory);
						\yii\helpers\FileHelper::createDirectory($directory);
					}
				}
				$this->addMessage(\Yii::t('core', 'cache_clear_success'));
				return true;
			}
		}
		$this->addMessage(\Yii::t('core', 'cache_clear_error'));
		return false;
	}
}