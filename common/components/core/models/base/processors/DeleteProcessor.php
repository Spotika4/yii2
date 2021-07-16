<?php

namespace common\components\core\models\base\processors;


abstract class DeleteProcessor extends ObjectProcessor {


	const EVENT_AFTER_DELETE_PROCESS = 'afterDeleteProcess';
	const EVENT_BEFORE_DELETE_PROCESS = 'beforeDeleteProcess';


	public function default(){
		$transaction = \Yii::$app->db->beginTransaction();
		try{
			if($this->object = $this->query()->one()){
				if($this->beforeDelete()){
					if($this->object->delete()){
						if(!$this->hasMessage()){
							$this->addMessage(\Yii::t('core', 'object_delete_success'));
						}
						if($this->afterDelete()){
							if(!$this->hasMessage()){
								$this->addMessage(\Yii::t('core', 'object_delete_success'));
							}
							$transaction->commit();
							return true;
						}
						return true;
					}
				}
			}
		}catch(\yii\db\Exception $e){
			$transaction->rollback();
		}
		if(!$this->hasMessage()){
			$this->addMessage(\Yii::t('core', 'object_delete_error'));
		}
		return false;
	}

	public function beforeDelete(){
		$this->trigger(self::EVENT_BEFORE_DELETE_PROCESS);
		return true;
	}

	public function afterDelete(){
		$this->trigger(self::EVENT_AFTER_DELETE_PROCESS);
		return true;
	}
}
