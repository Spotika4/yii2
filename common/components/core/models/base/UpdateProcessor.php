<?php

namespace common\components\core\models\base;


abstract class UpdateProcessor extends ObjectProcessor {


	const EVENT_AFTER_UPDATE_PROCESS = 'afterUpdateProcess';
	const EVENT_BEFORE_UPDATE_PROCESS = 'beforeUpdateProcess';


	public function default(){
		$transaction = \Yii::$app->db->beginTransaction();
		try{
			if($this->object = $this->query()->one()){
				if($this->beforeSave()){
					if($this->object->save()){
						if($this->afterSave()){
							if(!$this->hasMessage()){
								$this->addMessage(\Yii::t('core', 'object_update_success'));
							}
							$transaction->commit();
							return $this->object->toArray();
						}
					}
				}
			}else{
				$this->addMessage(\Yii::t('core', 'object_no_found'));
			}
		}catch(\yii\db\Exception $e){
			$transaction->rollback();
		}
		if(!$this->hasMessage()){
			$this->addMessage(\Yii::t('core', 'object_update_error'));
		}
		return false;
	}

	public function beforeSave(){
		$this->object->setAttributes($this->toArray());
		$this->trigger(self::EVENT_BEFORE_UPDATE_PROCESS);
		return true;
	}

	public function afterSave(){
		$this->trigger(self::EVENT_AFTER_UPDATE_PROCESS);
		return true;
	}
}