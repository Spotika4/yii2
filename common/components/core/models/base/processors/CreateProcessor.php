<?php

namespace common\components\core\models\base\processors;


abstract class CreateProcessor extends ObjectProcessor {


	const EVENT_AFTER_CREATE_PROCESS = 'afterCreateProcess';
	const EVENT_BEFORE_CREATE_PROCESS = 'beforeCreateProcess';


	public function default(){
		$transaction = \Yii::$app->db->beginTransaction();
		try{
			if($this->object = $this->query()){
				if($this->beforeSave()){
					if($this->object->save()){
						if($this->afterSave()){
							if(!$this->hasMessage()){
								$this->addMessage(\Yii::t('core', 'object_create_success'));
							}
							$transaction->commit();
							return $this->object->toArray();
						}
					}
				}
			}
		}catch(\yii\db\Exception $e){
			$transaction->rollback();
		}
		if(!$this->hasMessage()){
			$this->addMessage(\Yii::t('core', 'object_create_error'));
		}
		return false;
	}

	public function query(){
		return new $this->class;
	}

	public function beforeSave(){
		$this->object->setAttributes($this->toArray());
		$this->trigger(self::EVENT_BEFORE_CREATE_PROCESS);
		return true;
	}

	public function afterSave(){
		$this->trigger(self::EVENT_AFTER_CREATE_PROCESS);
		return true;
	}
}