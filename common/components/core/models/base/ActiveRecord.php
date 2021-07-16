<?php

namespace common\components\core\models\base;


class ActiveRecord extends \yii\db\ActiveRecord{


	public $formName = null;


	public function formName($formName = null){
		$this->formName = $formName;
		if(empty($this->formName)){
			return '';
		}
		return $this->formName;
	}

	public function getId(){
		return $this->getPrimaryKey();
	}

	public function getRelatedRecords($name = false, $load = false){
		if(!$name){
			return parent::getRelatedRecords();
		}else{
			if(!$this->isRelationPopulated($name)){
				if(!$relation = $this->getRelation($name)->one()){
					return false;
				}
				$this->populateRelation($name, $relation);
			}
			$related = parent::getRelatedRecords();
			return (isset($related[$name])) ? $related[$name] : false;
		}
	}
}
