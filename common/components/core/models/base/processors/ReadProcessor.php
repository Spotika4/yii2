<?php

namespace common\components\core\models\base\processors;


abstract class ReadProcessor extends ObjectProcessor {


	public function default(){
		$transaction = \Yii::$app->db->beginTransaction();
		try{
			if($this->object = $this->query()->asArray()->one()){
				$transaction->commit();
				if(!$this->hasMessage()){
					$this->addMessage(\Yii::t('core', 'object_found_success'));
				}
				return (is_array($this->object)) ? $this->object : $this->object->toArray();
			}else{
				$this->addMessage(\Yii::t('core', 'object_no_found'));
			}
		}catch(\yii\db\Exception $e){
			$transaction->rollback();
		}
		if(!$this->hasMessage()){
			$this->addMessage(\Yii::t('core', 'object_found_error'));
		}
		return false;
	}
}