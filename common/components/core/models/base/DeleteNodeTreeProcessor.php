<?php

namespace common\components\core\models\base;


abstract class DeleteNodeTreeProcessor extends DeleteProcessor {


	public function beforeDelete(){
		if(parent::beforeDelete()){
			$childs = $this->getDependentChilds([$this->id => ['id' => $this->id]]);
			if(!empty($childs)) $this->class::deleteAll(['id' => $childs]);
			return true;
		}
		return false;
	}

	private function getDependentChilds($parents, $out = []){
		$query = $this->class::find()->select(['id'])->indexBy('id');
		foreach($parents as $row){
			$childs = $query->where(['parent' => $row['id']])->asArray()->all();
			$out = array_merge($out, array_keys($childs));

			// recursive
			if($childs) $out = $this->getDependentChilds($childs, $out);
		}
		return $out;
	}
}
